<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class C_podelivery extends CI_Controller {

  public function __construct()
  {
    parent::__construct();  
		protek_login();
  }

  public function index()
  {
		$this->form_validation->set_rules('podelivery_kode', 'Kode PO - Delivery', 'required');
		$this->form_validation->set_rules(
			'purchaseorder_id', 'Kode Purchase Order', 'required',
			[
				'required' => 'Wajib masukkan kode purchase order'
			]
		);
		$this->form_validation->set_rules('podelivery_hasil', 'Hasil PO - Delivery', 'required');
		$this->form_validation->set_rules('podelivery_remain', 'Remain PO - Delivery', 'required');
		
		if ($this->form_validation->run() != FALSE) {
			$input = (object) $this->input->post();
			$this->process_podelivery_add($input);
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Lengakpi form tambah podelivery", "error", "tutup")</script>');
			redirect('podelivery');
		} else {
			$start = $this->input->post('start_order_date');
			$end = $this->input->post('end_order_date');
			$data = [
				'title' => 'PO - Delivery',
				'menu' => $this->M_menu->get_access_menu()->result_array(),
				'user' => $this->M_podelivery->editData(['user_id' => $this->session->userdata('admin_id')], 'tb_user')->row(),
				'list_podelivery' => $this->M_podelivery->get_view($start,$end)->result(),
				'total_podelivery' => $this->M_data->getData("tb_podelivery")->num_rows(),
			];
			$this->load->view('template/v_head', $data);
			$this->load->view('admin/podelivery/v_podelivery', $data);
			$this->load->view('template/v_footer');
		}
  }

	private function process_podelivery_add($input)
	{
		$data = [
			'podelivery_kode' => $this->db->escape_str($input->podelivery_kode),
			'purchaseorder_id' => $this->db->escape_str($input->purchaseorder_id),
			'podelivery_hasil' => $this->db->escape_str($input->podelivery_hasil),
			'podelivery_remain' => $this->db->escape_str($input->podelivery_remain),
		];
		$check = $this->M_podelivery->insertData($data, 'tb_podelivery');
		if ($check["success"] === TRUE) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses menambahkan", "Data purchase Order sukses ditambah", "success", "tutup")</script>');
			redirect("podelivery");
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal menambahkan", "Query failed", "error", "tutup")</script>');
			redirect("podelivery");
		}
	}

	public function search_purchaseorder()
	{
		$keyword = html_escape($this->input->post("keyword"));
		if ($keyword != "") {
			$check = $this->M_podelivery->search_purchaseorder($keyword, 10);
			if ($check->success === TRUE) {
				foreach ($check->data as $item) {
					echo "<p onclick=\"addPurchaseorder('$item->purchaseorder_kode', $item->purchaseorder_id)\">$item->purchaseorder_kode : $item->customer_kode, $item->product_kode, $item->model_kode, $item->part_kode, $item->category_nama, $item->tool_kode, $item->hole_nama, $item->colour_nama</p>";
				}
			} else {
				echo "<p>Maaf Purchase Order tidak ada</p>";
			}
		} else {
			echo "";
		}
	}

  public function view_podelivery_edit($id)
  {
    $podelivery_id = (int)$this->db->escape_str($id);
    $check = $this->M_podelivery->editData(['podelivery_id' => $podelivery_id],'tb_podelivery');
    if ($check) {
      $data = [
        'title' => 'Edit Purchase Order',
        'menu' => $this->M_menu->get_access_menu()->result_array(),
        'user' => $this->M_podelivery->editData(['user_id' => $this->session->userdata('admin_id')],'tb_user')->row(),
        'podelivery_item' => $check->row(),
		'list_purchaseorder' => $this->M_podelivery->getData('tb_purchaseorder')->result(),
      ];
      $this->load->view('template/v_head', $data);
      $this->load->view('admin/podelivery/v_editPodelivery', $data);
      $this->load->view('template/v_footer');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query Failed", "error", "tutup")</script>');
      redirect('podelivery');
    }
  }

 	 public function process_podelivery_edit()
	{
		$this->form_validation->set_rules('podelivery_kode', 'Kode Purchase Order', 'required');
		$this->form_validation->set_rules(
			'purchaseorder_id', 'Kode Purchase Order', 'required',
			[
				'required' => 'Wajib masukkan kode purchase order'
			]
		);
		$this->form_validation->set_rules('podelivery_hasil', 'Hasil PO - Delivery', 'required');
		$this->form_validation->set_rules('podelivery_remain', 'Remain PO - Delivery', 'required');
		$podelivery_id = $this->input->post('podelivery_id');
		
		if ($this->form_validation->run() != FALSE) {
		$this->process_podelivery_edit_act();
		} else {
		$this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Masukan data dengan benar dan lengkap!", "error", "tutup")</script>');
		redirect('view_podelivery_edit/'. $podelivery_id);
		}
	}

  private function process_podelivery_edit_act()
  {
    $input = (object) $this->input->post();
    $data = [
		'podelivery_kode' => $this->db->escape_str($input->podelivery_kode),
		'purchaseorder_id' => $this->db->escape_str($input->purchaseorder_id),
		'podelivery_hasil' => $this->db->escape_str($input->podelivery_hasil),
		'podelivery_remain' => $this->db->escape_str($input->podelivery_remain),
	];
    $where = ['podelivery_id' => $this->db->escape_str($input->podelivery_id)];

    $check = $this->M_podelivery->updateData($data, $where, 'tb_podelivery');
    if ($check["success"] === TRUE) {
      $this->session->set_flashdata('pesan', '<script>sweet("Sukses", "Data PO - Delivery berhasil di edit", "success", "tutup")</script>');
      redirect('podelivery');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query failed!", "error", "tutup")</script>');
      redirect('view_podelivery_edit/'.$input->podelivery_id);
    }
  }

	public function process_podelivery_delete($id)
	{
		$podelivery_id = (int)$this->db->escape_str($id);
		$check = $this->M_podelivery->deleteData(["podelivery_id" => $podelivery_id], "tb_podelivery");
		if ($check) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses","Data PO - Delivery berhasil dihapus!","success","Tutup")</script>');
			redirect("podelivery");
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal","Query failed!","success","Tutup")</script>');
			redirect("podelivery");
		}
	}

}
