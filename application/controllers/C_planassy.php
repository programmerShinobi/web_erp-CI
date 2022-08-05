<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class C_planassy extends CI_Controller {

  public function __construct()
  {
    parent::__construct();  
		protek_login();
  }

  public function index()
  {
		$this->form_validation->set_rules('planassy_kode', 'Kode Plan Assy', 'required');
		$this->form_validation->set_rules(
			'purchaseorder_id', 'Kode Purchase Order', 'required',
			[
				'required' => 'Wajib masukkan kode purchase order'
			]
		);
		$this->form_validation->set_rules('planassy_hasil', 'Hasil Plan Assy', 'required');
		
		if ($this->form_validation->run() != FALSE) {
			$input = (object) $this->input->post();
			$this->process_planassy_add($input);
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Lengakpi form tambah Plan assy", "error", "tutup")</script>');
			redirect('planassy');
		} else {
			$start = $this->input->post('start_order_date');
			$end = $this->input->post('end_order_date');
			$data = [
				'title' => 'Plan Assy',
				'menu' => $this->M_menu->get_access_menu()->result_array(),
				'user' => $this->M_planassy->editData(['user_id' => $this->session->userdata('admin_id')], 'tb_user')->row(),
				'list_planassy' => $this->M_planassy->get_view($start,$end)->result(),
				'total_planassy' => $this->M_data->getData("tb_planassy")->num_rows(),
			];
			$this->load->view('template/v_head', $data);
			$this->load->view('admin/planassy/v_planassy', $data);
			$this->load->view('template/v_footer');
		}
  }

	private function process_planassy_add($input)
	{
		$data = [
			'planassy_kode' => $this->db->escape_str($input->planassy_kode),
			'purchaseorder_id' => $this->db->escape_str($input->purchaseorder_id),
			'planassy_hasil' => $this->db->escape_str($input->planassy_hasil),
		];
		$check = $this->M_planassy->insertData($data, 'tb_planassy');
		if ($check["success"] === TRUE) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses menambahkan", "Data Plan Assy sukses ditambah", "success", "tutup")</script>');
			redirect("planassy");
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal menambahkan", "Query failed", "error", "tutup")</script>');
			redirect("planassy");
		}
	}

	public function search_purchaseorder()
	{
		$keyword = html_escape($this->input->post("keyword"));
		if ($keyword != "") {
			$check = $this->M_planassy->search_purchaseorder($keyword, 10);
			if ($check->success === TRUE) {
				foreach ($check->data as $item) {
					echo "<p onclick=\"addPurchaseorder('$item->purchaseorder_kode', $item->purchaseorder_id)\">$item->purchaseorder_kode : $item->customer_kode, $item->product_kode, $item->model_kode, $item->part_kode, $item->category_nama, $item->tool_kode, $item->hole_nama, $item->colour_nama</p>";
				}
			} else {
				echo "<p>Maaf Plan assy tidak ada</p>";
			}
		} else {
			echo "";
		}
	}

  public function view_planassy_edit($id)
  {
    $planassy_id = (int)$this->db->escape_str($id);
    $check = $this->M_planassy->editData(['planassy_id' => $planassy_id],'tb_planassy');
    if ($check) {
      $data = [
        'title' => 'Edit Plan Assy',
        'menu' => $this->M_menu->get_access_menu()->result_array(),
        'user' => $this->M_planassy->editData(['user_id' => $this->session->userdata('admin_id')],'tb_user')->row(),
        'planassy_item' => $check->row(),
		'list_purchaseorder' => $this->M_planassy->getData('tb_purchaseorder')->result(),
      ];
      $this->load->view('template/v_head', $data);
      $this->load->view('admin/planassy/v_editPlanassy', $data);
      $this->load->view('template/v_footer');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query Failed", "error", "tutup")</script>');
      redirect('planassy');
    }
  }

 	 public function process_planassy_edit()
	{
		$this->form_validation->set_rules('planassy_kode', 'Kode plan Assy', 'required');
		$this->form_validation->set_rules(
			'purchaseorder_id', 'Kode Purchase Order', 'required',
			[
				'required' => 'Wajib masukkan kode purchase order'
			]
		);
		$this->form_validation->set_rules('planassy_hasil', 'Hasil Plan Assy', 'required');

		$planassy_id = $this->input->post('planassy_id');
		
		if ($this->form_validation->run() != FALSE) {
		$this->process_planassy_edit_act($planassy_id);
		} else {
		$this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Masukan data dengan benar dan lengkap!", "error", "tutup")</script>');
		redirect('view_planassy_edit/'. $planassy_id);
		}
	}

  private function process_planassy_edit_act($id)
  {
    $input = (object) $this->input->post();
	$planassy = $this->M_planassy->editData(['planassy_id' => $id], 'tb_planassy')->row();

	$purchaseorder_total = $this->M_planassy->editData(['purchaseorder_id' => $planassy->purchaseorder_id], 'tb_purchaseorder')->result();
	foreach ($purchaseorder_total as $p) {	
		if ($input->planassy_hasil != 0) {
			$planassy_remain = $p->purchaseorder_remain - $input->planassy_hasil;
		} else {
			$planassy_remain = 0;
		}

		$data = [
			'planassy_kode' => $this->db->escape_str($input->planassy_kode),
			'purchaseorder_id' => $this->db->escape_str($input->purchaseorder_id),
			'planassy_hasil' => $this->db->escape_str($input->planassy_hasil),
			'planassy_remain' => $this->db->escape_str($planassy_remain),
		];

		$where = ['planassy_id' => $this->db->escape_str($input->planassy_id)];
		$check = $this->M_planassy->updateData($data, $where, 'tb_planassy');
	}

    if ($check["success"] === TRUE) {
      $this->session->set_flashdata('pesan', '<script>sweet("Sukses", "Data Plan Assy berhasil diubah", "success", "tutup")</script>');
      redirect('planassy');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query failed!", "error", "tutup")</script>');
      redirect('view_planassy_edit/'.$input->planassy_id);
    }
  }

	public function process_planassy_delete($id)
	{
		$planassy_id = (int)$this->db->escape_str($id);
		$check = $this->M_planassy->deleteData(["planassy_id" => $planassy_id], "tb_planassy");
		if ($check) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses","Data Plan Assy berhasil dihapus!","success","Tutup")</script>');
			redirect("planassy");
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal","Query failed!","success","Tutup")</script>');
			redirect("planassy");
		}
	}

}
