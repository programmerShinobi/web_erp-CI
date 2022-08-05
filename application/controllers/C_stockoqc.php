<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class C_stockoqc extends CI_Controller {

  public function __construct()
  {
    parent::__construct();  
		protek_login();
  }

  public function index()
  {
		$this->form_validation->set_rules('stockoqc_kode', 'Kode Stock OQC', 'required');
		$this->form_validation->set_rules(
			'purchaseorder_id', 'Kode Purchase Order', 'required',
			[
				'required' => 'Wajib masukkan kode purchase order'
			]
		);
		$this->form_validation->set_rules('stockoqc_semi', 'Semi Stock OQC', 'required');
		$this->form_validation->set_rules('stockoqc_finish', 'Finish Stock OQC', 'required');
		
		if ($this->form_validation->run() != FALSE) {
			$input = (object) $this->input->post();
			$this->process_stockoqc_add($input);
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Lengakpi form tambah Stock OQC", "error", "tutup")</script>');
			redirect('stockoqc');
		} else {
			$start = $this->input->post('start_order_date');
			$end = $this->input->post('end_order_date');
			$data = [
				'title' => 'Stock OQC',
				'menu' => $this->M_menu->get_access_menu()->result_array(),
				'user' => $this->M_stockoqc->editData(['user_id' => $this->session->userdata('admin_id')], 'tb_user')->row(),
				'list_stockoqc' => $this->M_stockoqc->get_view($start,$end)->result(),
				'total_stockoqc' => $this->M_data->getData("tb_stockoqc")->num_rows(),
			];
			$this->load->view('template/v_head', $data);
			$this->load->view('admin/stockoqc/v_stockoqc', $data);
			$this->load->view('template/v_footer');
		}
  }

	private function process_stockoqc_add($input)
	{
		$data = [
			'stockoqc_kode' => $this->db->escape_str($input->stockoqc_kode),
			'purchaseorder_id' => $this->db->escape_str($input->purchaseorder_id),
			'stockoqc_semi' => $this->db->escape_str($input->stockoqc_semi),
			'stockoqc_finish' => $this->db->escape_str($input->stockoqc_finish),
		];
		$check = $this->M_stockoqc->insertData($data, 'tb_stockoqc');
		if ($check["success"] === TRUE) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses menambahkan", "Data Stock OQC sukses ditambah", "success", "tutup")</script>');
			redirect("stockoqc");
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal menambahkan", "Query failed", "error", "tutup")</script>');
			redirect("stockoqc");
		}
	}

	public function search_purchaseorder()
	{
		$keyword = html_escape($this->input->post("keyword"));
		if ($keyword != "") {
			$check = $this->M_stockoqc->search_purchaseorder($keyword, 10);
			if ($check->success === TRUE) {
				foreach ($check->data as $item) {
					echo "<p onclick=\"addPurchaseorder('$item->purchaseorder_kode', $item->purchaseorder_id)\">$item->purchaseorder_kode : $item->customer_kode, $item->product_kode, $item->model_kode, $item->part_kode, $item->category_nama, $item->tool_kode, $item->hole_nama, $item->colour_nama</p>";
				}
			} else {
				echo "<p>Maaf Stock OQC tidak ada</p>";
			}
		} else {
			echo "";
		}
	}

  public function view_stockoqc_edit($id)
  {
    $stockoqc_id = (int)$this->db->escape_str($id);
    $check = $this->M_stockoqc->editData(['stockoqc_id' => $stockoqc_id],'tb_stockoqc');
    if ($check) {
      $data = [
        'title' => 'Edit Stock OQC',
        'menu' => $this->M_menu->get_access_menu()->result_array(),
        'user' => $this->M_stockoqc->editData(['user_id' => $this->session->userdata('admin_id')],'tb_user')->row(),
        'stockoqc_item' => $check->row(),
		'list_purchaseorder' => $this->M_stockoqc->getData('tb_purchaseorder')->result(),
      ];
      $this->load->view('template/v_head', $data);
      $this->load->view('admin/stockoqc/v_editStockoqc', $data);
      $this->load->view('template/v_footer');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query Failed", "error", "tutup")</script>');
      redirect('stockoqc');
    }
  }

 	 public function process_stockoqc_edit()
	{
		$this->form_validation->set_rules('stockoqc_kode', 'Kode Stock OQC', 'required');
		$this->form_validation->set_rules(
			'purchaseorder_id', 'Kode Purchase Order', 'required',
			[
				'required' => 'Wajib masukkan kode purchase order'
			]
		);
		$this->form_validation->set_rules('stockoqc_semi', 'Semi Stock OQC', 'required');
		$this->form_validation->set_rules('stockoqc_finish', 'Finish Stock OQC', 'required');

		$stockoqc_id = $this->input->post('stockoqc_id');
		
		if ($this->form_validation->run() != FALSE) {
		$this->process_stockoqc_edit_act($stockoqc_id);
		} else {
		$this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Masukan data dengan benar dan lengkap!", "error", "tutup")</script>');
		redirect('view_stockoqc_edit/'. $stockoqc_id);
		}
	}

  private function process_stockoqc_edit_act($id)
  {
    $input = (object) $this->input->post();
	$stockoqc = $this->M_stockoqc->editData(['stockoqc_id' => $id], 'tb_stockoqc')->row();

	$purchaseorder_total = $this->M_stockoqc->editData(['purchaseorder_id' => $stockoqc->purchaseorder_id], 'tb_purchaseorder')->result();
	foreach ($purchaseorder_total as $p) {
		if ($input->stockoqc_finish != 0 || $input->stockoqc_semi != 0) {
			$stockoqc_remain = $p->purchaseorder_remain - ($input->stockoqc_finish + $input->stockoqc_semi);
		} else {
			$stockoqc_remain = 0;
		}

		$data = [
			'stockoqc_kode' => $this->db->escape_str($input->stockoqc_kode),
			'purchaseorder_id' => $this->db->escape_str($input->purchaseorder_id),
			'stockoqc_semi' => $this->db->escape_str($input->stockoqc_semi),
			'stockoqc_finish' => $this->db->escape_str($input->stockoqc_finish),
			'stockoqc_remain' => $this->db->escape_str($stockoqc_remain),
		];

		$where = ['stockoqc_id' => $this->db->escape_str($input->stockoqc_id)];
		$check = $this->M_stockoqc->updateData($data, $where, 'tb_stockoqc');
	}

    // $data = [
	// 	'stockoqc_kode' => $this->db->escape_str($input->stockoqc_kode),
	// 	'purchaseorder_id' => $this->db->escape_str($input->purchaseorder_id),
	// 	'stockoqc_semi' => $this->db->escape_str($input->stockoqc_semi),
	// 	'stockoqc_finish' => $this->db->escape_str($input->stockoqc_finish),
	// ];
    // $where = ['stockoqc_id' => $this->db->escape_str($input->stockoqc_id)];

    // $check = $this->M_stockoqc->updateData($data, $where, 'tb_stockoqc');
    if ($check["success"] === TRUE) {
      $this->session->set_flashdata('pesan', '<script>sweet("Sukses", "Data Stock OQC berhasil diubah", "success", "tutup")</script>');
      redirect('stockoqc');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query failed!", "error", "tutup")</script>');
      redirect('view_stockoqc_edit/'.$input->stockoqc_id);
    }
  }

	public function process_stockoqc_delete($id)
	{
		$stockoqc_id = (int)$this->db->escape_str($id);
		$check = $this->M_stockoqc->deleteData(["stockoqc_id" => $stockoqc_id], "tb_stockoqc");
		if ($check) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses","Data Stock OQC berhasil dihapus!","success","Tutup")</script>');
			redirect("stockoqc");
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal","Query failed!","success","Tutup")</script>');
			redirect("stockoqc");
		}
	}

}
