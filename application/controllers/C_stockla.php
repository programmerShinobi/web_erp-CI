<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class C_stockla extends CI_Controller {

  public function __construct()
  {
    parent::__construct();  
		protek_login();
  }

  public function index()
  {
		$this->form_validation->set_rules('stockla_kode', 'Kode Stock Loading Area', 'required');
		$this->form_validation->set_rules(
			'purchaseorder_id', 'Kode Purchase Order', 'required',
			[
				'required' => 'Wajib masukkan kode purchase order'
			]
		);
		$this->form_validation->set_rules('stockla_semi', 'Semi Stock Loading Area', 'required');
		$this->form_validation->set_rules('stockla_finish', 'Finish Stock Loading Area', 'required');
		
		if ($this->form_validation->run() != FALSE) {
			$input = (object) $this->input->post();
			$this->process_stockla_add($input);
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Lengakpi form tambah Stock Loading Area", "error", "tutup")</script>');
			redirect('stockla');
		} else {
			$start = $this->input->post('start_order_date');
			$end = $this->input->post('end_order_date');
			$data = [
				'title' => 'Stock Loading Area',
				'menu' => $this->M_menu->get_access_menu()->result_array(),
				'user' => $this->M_stockla->editData(['user_id' => $this->session->userdata('admin_id')], 'tb_user')->row(),
				'list_stockla' => $this->M_stockla->get_view($start,$end)->result(),
				'total_stockla' => $this->M_data->getData("tb_stockla")->num_rows(),
			];
			$this->load->view('template/v_head', $data);
			$this->load->view('admin/stockla/v_stockla', $data);
			$this->load->view('template/v_footer');
		}
  }

	private function process_stockla_add($input)
	{
		$data = [
			'stockla_kode' => $this->db->escape_str($input->stockla_kode),
			'purchaseorder_id' => $this->db->escape_str($input->purchaseorder_id),
			'stockla_semi' => $this->db->escape_str($input->stockla_semi),
			'stockla_finish' => $this->db->escape_str($input->stockla_finish),
		];
		$check = $this->M_stockla->insertData($data, 'tb_stockla');
		if ($check["success"] === TRUE) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses menambahkan", "Data Stock Loading Area sukses ditambah", "success", "tutup")</script>');
			redirect("stockla");
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal menambahkan", "Query failed", "error", "tutup")</script>');
			redirect("stockla");
		}
	}

	public function search_purchaseorder()
	{
		$keyword = html_escape($this->input->post("keyword"));
		if ($keyword != "") {
			$check = $this->M_stockla->search_purchaseorder($keyword, 10);
			if ($check->success === TRUE) {
				foreach ($check->data as $item) {
					echo "<p onclick=\"addPurchaseorder('$item->purchaseorder_kode', $item->purchaseorder_id)\">$item->purchaseorder_kode : $item->customer_kode, $item->product_kode, $item->model_kode, $item->part_kode, $item->category_nama, $item->tool_kode, $item->hole_nama, $item->colour_nama</p>";
				}
			} else {
				echo "<p>Maaf Stock Loading Area tidak ada</p>";
			}
		} else {
			echo "";
		}
	}

  public function view_stockla_edit($id)
  {
    $stockla_id = (int)$this->db->escape_str($id);
    $check = $this->M_stockla->editData(['stockla_id' => $stockla_id],'tb_stockla');
    if ($check) {
      $data = [
        'title' => 'Edit Stock Loading Area',
        'menu' => $this->M_menu->get_access_menu()->result_array(),
        'user' => $this->M_stockla->editData(['user_id' => $this->session->userdata('admin_id')],'tb_user')->row(),
        'stockla_item' => $check->row(),
		'list_purchaseorder' => $this->M_stockla->getData('tb_purchaseorder')->result(),
      ];
      $this->load->view('template/v_head', $data);
      $this->load->view('admin/stockla/v_editStockla', $data);
      $this->load->view('template/v_footer');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query Failed", "error", "tutup")</script>');
      redirect('stockla');
    }
  }

 	 public function process_stockla_edit()
	{
		$this->form_validation->set_rules('stockla_kode', 'Kode Stock Loading Area', 'required');
		$this->form_validation->set_rules(
			'purchaseorder_id', 'Kode Purchase Order', 'required',
			[
				'required' => 'Wajib masukkan kode purchase order'
			]
		);
		$this->form_validation->set_rules('stockla_semi', 'Semi Stock Loading Area', 'required');
		$this->form_validation->set_rules('stockla_finish', 'Finish Stock Loading Area', 'required');

		$stockla_id = $this->input->post('stockla_id');
		
		if ($this->form_validation->run() != FALSE) {
		$this->process_stockla_edit_act();
		} else {
		$this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Masukan data dengan benar dan lengkap!", "error", "tutup")</script>');
		redirect('view_stockla_edit/'. $stockla_id);
		}
	}

  private function process_stockla_edit_act()
  {
    $input = (object) $this->input->post();
    $data = [
		'stockla_kode' => $this->db->escape_str($input->stockla_kode),
		'purchaseorder_id' => $this->db->escape_str($input->purchaseorder_id),
		'stockla_semi' => $this->db->escape_str($input->stockla_semi),
		'stockla_finish' => $this->db->escape_str($input->stockla_finish),
	];
    $where = ['stockla_id' => $this->db->escape_str($input->stockla_id)];

    $check = $this->M_stockla->updateData($data, $where, 'tb_stockla');
    if ($check["success"] === TRUE) {
      $this->session->set_flashdata('pesan', '<script>sweet("Sukses", "Data Stock Loading Area berhasil diubah", "success", "tutup")</script>');
      redirect('stockla');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query failed!", "error", "tutup")</script>');
      redirect('view_stockla_edit/'.$input->stockla_id);
    }
  }

	public function process_stockla_delete($id)
	{
		$stockla_id = (int)$this->db->escape_str($id);
		$check = $this->M_stockla->deleteData(["stockla_id" => $stockla_id], "tb_stockla");
		if ($check) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses","Data Stock Loading Area berhasil dihapus!","success","Tutup")</script>');
			redirect("stockla");
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal","Query failed!","success","Tutup")</script>');
			redirect("stockla");
		}
	}

}
