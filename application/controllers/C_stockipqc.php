<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class C_stockipqc extends CI_Controller {

  public function __construct()
  {
    parent::__construct();  
		protek_login();
  }

  public function index()
  {
		$this->form_validation->set_rules('stockipqc_kode', 'Kode Stock IPQC', 'required');
		$this->form_validation->set_rules(
			'purchaseorder_id', 'Kode Purchase Order', 'required',
			[
				'required' => 'Wajib masukkan kode purchase order'
			]
		);
		$this->form_validation->set_rules('stockipqc_semi', 'Semi Stock IPQC', 'required');
		$this->form_validation->set_rules('stockipqc_finish', 'Finish Stock IPQC', 'required');
		
		if ($this->form_validation->run() != FALSE) {
			$input = (object) $this->input->post();
			$this->process_stockipqc_add($input);
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Lengakpi form tambah Stock IPQC", "error", "tutup")</script>');
			redirect('stockipqc');
		} else {
			$start = $this->input->post('start_order_date');
			$end = $this->input->post('end_order_date');
			$data = [
				'title' => 'Stock IPQC',
				'menu' => $this->M_menu->get_access_menu()->result_array(),
				'user' => $this->M_stockipqc->editData(['user_id' => $this->session->userdata('admin_id')], 'tb_user')->row(),
				'list_stockipqc' => $this->M_stockipqc->get_view($start,$end)->result(),
				'total_stockipqc' => $this->M_data->getData("tb_stockipqc")->num_rows(),
			];
			$this->load->view('template/v_head', $data);
			$this->load->view('admin/stockipqc/v_stockipqc', $data);
			$this->load->view('template/v_footer');
		}
  }

	private function process_stockipqc_add($input)
	{
		$data = [
			'stockipqc_kode' => $this->db->escape_str($input->stockipqc_kode),
			'purchaseorder_id' => $this->db->escape_str($input->purchaseorder_id),
			'stockipqc_semi' => $this->db->escape_str($input->stockipqc_semi),
			'stockipqc_finish' => $this->db->escape_str($input->stockipqc_finish),
		];
		$check = $this->M_stockipqc->insertData($data, 'tb_stockipqc');
		if ($check["success"] === TRUE) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses menambahkan", "Data Stock IPQC sukses ditambah", "success", "tutup")</script>');
			redirect("stockipqc");
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal menambahkan", "Query failed", "error", "tutup")</script>');
			redirect("stockipqc");
		}
	}

	public function search_purchaseorder()
	{
		$keyword = html_escape($this->input->post("keyword"));
		if ($keyword != "") {
			$check = $this->M_stockipqc->search_purchaseorder($keyword, 10);
			if ($check->success === TRUE) {
				foreach ($check->data as $item) {
					echo "<p onclick=\"addPurchaseorder('$item->purchaseorder_kode', $item->purchaseorder_id)\">$item->purchaseorder_kode : $item->customer_kode, $item->product_kode, $item->model_kode, $item->part_kode, $item->category_nama, $item->tool_kode, $item->hole_nama, $item->colour_nama</p>";
				}
			} else {
				echo "<p>Maaf Stock IPQC tidak ada</p>";
			}
		} else {
			echo "";
		}
	}

  public function view_stockipqc_edit($id)
  {
    $stockipqc_id = (int)$this->db->escape_str($id);
    $check = $this->M_stockipqc->editData(['stockipqc_id' => $stockipqc_id],'tb_stockipqc');
    if ($check) {
      $data = [
        'title' => 'Edit Stock IPQC',
        'menu' => $this->M_menu->get_access_menu()->result_array(),
        'user' => $this->M_stockipqc->editData(['user_id' => $this->session->userdata('admin_id')],'tb_user')->row(),
        'stockipqc_item' => $check->row(),
		'list_purchaseorder' => $this->M_stockipqc->getData('tb_purchaseorder')->result(),
      ];
      $this->load->view('template/v_head', $data);
      $this->load->view('admin/stockipqc/v_editStockipqc', $data);
      $this->load->view('template/v_footer');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query Failed", "error", "tutup")</script>');
      redirect('stockipqc');
    }
  }

 	 public function process_stockipqc_edit()
	{
		$this->form_validation->set_rules('stockipqc_kode', 'Kode Stock IPQC', 'required');
		$this->form_validation->set_rules(
			'purchaseorder_id', 'Kode Purchase Order', 'required',
			[
				'required' => 'Wajib masukkan kode purchase order'
			]
		);
		$this->form_validation->set_rules('stockipqc_semi', 'Semi Stock IPQC', 'required');
		$this->form_validation->set_rules('stockipqc_finish', 'Finish Stock IPQC', 'required');

		$stockipqc_id = $this->input->post('stockipqc_id');
		
		if ($this->form_validation->run() != FALSE) {
		$this->process_stockipqc_edit_act($stockipqc_id);
		} else {
		$this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Masukan data dengan benar dan lengkap!", "error", "tutup")</script>');
		redirect('view_stockipqc_edit/'. $stockipqc_id);
		}
	}

  private function process_stockipqc_edit_act($id)
  {
    $input = (object) $this->input->post();
	$stockipqc = $this->M_stockipqc->editData(['stockipqc_id' => $id], 'tb_stockipqc')->row();

	$purchaseorder_total = $this->M_stockipqc->editData(['purchaseorder_id' => $stockipqc->purchaseorder_id], 'tb_purchaseorder')->result();
	foreach ($purchaseorder_total as $p) {
		if ($input->stockipqc_finish != 0 ||$input->stockipqc_semi != 0) {
			$stockipqc_remain = $p->purchaseorder_remain - ($input->stockipqc_finish + $input->stockipqc_semi);
		} else {
			$stockipqc_remain = 0;
		}

		$data = [
			'stockipqc_kode' => $this->db->escape_str($input->stockipqc_kode),
			'purchaseorder_id' => $this->db->escape_str($input->purchaseorder_id),
			'stockipqc_semi' => $this->db->escape_str($input->stockipqc_semi),
			'stockipqc_finish' => $this->db->escape_str($input->stockipqc_finish),
			'stockipqc_remain' => $this->db->escape_str($stockipqc_remain),
		];

		$where = ['stockipqc_id' => $this->db->escape_str($input->stockipqc_id)];
		$check = $this->M_stockipqc->updateData($data, $where, 'tb_stockipqc');
	}

    if ($check["success"] === TRUE) {
      $this->session->set_flashdata('pesan', '<script>sweet("Sukses", "Data Stock IPQC berhasil diubah", "success", "tutup")</script>');
      redirect('stockipqc');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query failed!", "error", "tutup")</script>');
      redirect('view_stockipqc_edit/'.$input->stockipqc_id);
    }
  }

	public function process_stockipqc_delete($id)
	{
		$stockipqc_id = (int)$this->db->escape_str($id);
		$check = $this->M_stockipqc->deleteData(["stockipqc_id" => $stockipqc_id], "tb_stockipqc");
		if ($check) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses","Data Stock IPQC berhasil dihapus!","success","Tutup")</script>');
			redirect("stockipqc");
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal","Query failed!","success","Tutup")</script>');
			redirect("stockipqc");
		}
	}

}
