<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class C_delivery extends CI_Controller {

  public function __construct()
  {
    parent::__construct();  
		protek_login();
  }

  public function index()
  {
		$this->form_validation->set_rules('delivery_kode', 'Kode Delivery', 'required');
		$this->form_validation->set_rules('delivery_tanggal', 'Tanggal Delivery', 'required');
		$this->form_validation->set_rules(
			'purchaseorder_id', 'Kode Purchase Order', 'required',
			[
				'required' => 'Wajib masukkan kode purchase order'
			]
		);
		$this->form_validation->set_rules('delivery_hasil', 'Hasil Delivery', 'required');
		
		if ($this->form_validation->run() != FALSE) {
			$input = (object) $this->input->post();
			$this->process_delivery_add($input);
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Lengakpi form tambah Delivery", "error", "tutup")</script>');
			redirect('delivery');
		} else {
			$start = $this->input->post('start_order_date');
			$end = $this->input->post('end_order_date');
			$data = [
				'title' => 'Delivery',
				'menu' => $this->M_menu->get_access_menu()->result_array(),
				'user' => $this->M_delivery->editData(['user_id' => $this->session->userdata('admin_id')], 'tb_user')->row(),
				'list_delivery' => $this->M_delivery->get_view($start,$end)->result(),
				'total_delivery' => $this->M_data->getData("tb_delivery")->num_rows(),
			];
			$this->load->view('template/v_head', $data);
			$this->load->view('admin/delivery/v_delivery', $data);
			$this->load->view('template/v_footer');
		}
  }

	private function process_delivery_add($input)
	{
		$data = [
			'delivery_kode' => $this->db->escape_str($input->delivery_kode),
			'delivery_tanggal' => $this->db->escape_str($input->delivery_tanggal),
			'purchaseorder_id' => $this->db->escape_str($input->purchaseorder_id),
			'delivery_hasil' => $this->db->escape_str($input->delivery_hasil),
		];
		$check = $this->M_delivery->insertData($data, 'tb_delivery');
		if ($check["success"] === TRUE) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses menambahkan", "Data Delivery sukses ditambah", "success", "tutup")</script>');
			redirect("delivery");
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal menambahkan", "Query failed", "error", "tutup")</script>');
			redirect("delivery");
		}
	}

	public function search_purchaseorder()
	{
		$keyword = html_escape($this->input->post("keyword"));
		if ($keyword != "") {
			$check = $this->M_delivery->search_purchaseorder($keyword, 10);
			if ($check->success === TRUE) {
				foreach ($check->data as $item) {
					echo "<p onclick=\"addPurchaseorder('$item->purchaseorder_kode', $item->purchaseorder_id)\">$item->purchaseorder_kode : $item->customer_kode, $item->product_kode, $item->model_kode, $item->part_kode, $item->category_nama, $item->tool_kode, $item->hole_nama, $item->colour_nama</p>";
				}
			} else {
				echo "<p>Maaf Delivery tidak ada</p>";
			}
		} else {
			echo "";
		}
	}

  public function view_delivery_edit($id)
  {
    $delivery_id = (int)$this->db->escape_str($id);
    $check = $this->M_delivery->editData(['delivery_id' => $delivery_id],'tb_delivery');
    if ($check) {
      $data = [
        'title' => 'Edit Delivery',
        'menu' => $this->M_menu->get_access_menu()->result_array(),
        'user' => $this->M_delivery->editData(['user_id' => $this->session->userdata('admin_id')],'tb_user')->row(),
        'delivery_item' => $check->row(),
		'list_purchaseorder' => $this->M_delivery->getData('tb_purchaseorder')->result(),
      ];
      $this->load->view('template/v_head', $data);
      $this->load->view('admin/delivery/v_editdelivery', $data);
      $this->load->view('template/v_footer');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query Failed", "error", "tutup")</script>');
      redirect('delivery');
    }
  }

 	 public function process_delivery_edit()
	{
		$this->form_validation->set_rules('delivery_kode', 'Kode Delivery', 'required');
		$this->form_validation->set_rules('delivery_tanggal', 'Tanggal Delivery', 'required');
		$this->form_validation->set_rules(
			'purchaseorder_id', 'Kode Purchase Order', 'required',
			[
				'required' => 'Wajib masukkan kode purchase order'
			]
		);
		$this->form_validation->set_rules('delivery_hasil', 'Hasil Delivery', 'required');

		$delivery_id = $this->input->post('delivery_id');
		
		if ($this->form_validation->run() != FALSE) {
		$this->process_delivery_edit_act($delivery_id);
		} else {
		$this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Masukan data dengan benar dan lengkap!", "error", "tutup")</script>');
		redirect('view_delivery_edit/'. $delivery_id);
		}
	}

  private function process_delivery_edit_act($id)
  {
    $input = (object) $this->input->post();
	$delivery = $this->M_delivery->editData(['delivery_id' => $id], 'tb_delivery')->row();

	$purchaseorder_total = $this->M_delivery->editData(['purchaseorder_id' => $delivery->purchaseorder_id], 'tb_purchaseorder')->result();
	foreach ($purchaseorder_total as $p) {
		if ($input->delivery_hasil != 0) {
			$delivery_remain = $p->purchaseorder_jumlah - $input->delivery_hasil;
		} else {
			$delivery_remain = 0;
		}

		$data = [
			'delivery_kode' => $this->db->escape_str($input->delivery_kode),
			'delivery_tanggal' => $this->db->escape_str($input->delivery_tanggal),
			'purchaseorder_id' => $this->db->escape_str($input->purchaseorder_id),
			'delivery_hasil' => $this->db->escape_str($input->delivery_hasil),
			'delivery_remain' => $this->db->escape_str($delivery_remain),
		];

		$where = ['delivery_id' => $this->db->escape_str($input->delivery_id)];
		$check = $this->M_delivery->updateData($data, $where, 'tb_delivery');
	}

    // $data = [
	// 	'delivery_kode' => $this->db->escape_str($input->delivery_kode),
	// 	'delivery_tanggal' => $this->db->escape_str($input->delivery_tanggal),
	// 	'purchaseorder_id' => $this->db->escape_str($input->purchaseorder_id),
	// 	'delivery_hasil' => $this->db->escape_str($input->delivery_hasil),
	// 	'delivery_remain' => $this->db->escape_str($input->delivery_remain),
	// ];
    // $where = ['delivery_id' => $this->db->escape_str($input->delivery_id)];

    // $check = $this->M_delivery->updateData($data, $where, 'tb_delivery');
    if ($check["success"] === TRUE) {
      $this->session->set_flashdata('pesan', '<script>sweet("Sukses", "Data Delivery berhasil diubah", "success", "tutup")</script>');
      redirect('delivery');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query failed!", "error", "tutup")</script>');
      redirect('view_delivery_edit/'.$input->delivery_id);
    }
  }

	public function process_delivery_delete($id)
	{
		$delivery_id = (int)$this->db->escape_str($id);
		$check = $this->M_delivery->deleteData(["delivery_id" => $delivery_id], "tb_delivery");
		if ($check) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses","Data Delivery berhasil dihapus!","success","Tutup")</script>');
			redirect("delivery");
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal","Query failed!","success","Tutup")</script>');
			redirect("delivery");
		}
	}

}
