<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class C_planinjection extends CI_Controller {

  public function __construct()
  {
    parent::__construct();  
		protek_login();
  }

  public function index()
  {
		$this->form_validation->set_rules('planinjection_kode', 'Kode Plan Injection', 'required');
		$this->form_validation->set_rules(
			'purchaseorder_id', 'Kode Purchase Order', 'required',
			[
				'required' => 'Wajib masukkan kode purchase order'
			]
		);
		$this->form_validation->set_rules('planinjection_hasil', 'Hasil Plan Injection', 'required');
		
		if ($this->form_validation->run() != FALSE) {
			$input = (object) $this->input->post();
			$this->process_planinjection_add($input);
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Lengakpi form tambah Plan Injection", "error", "tutup")</script>');
			redirect('planinjection');
		} else {
			$start = $this->input->post('start_order_date');
			$end = $this->input->post('end_order_date');
			$data = [
				'title' => 'Plan Injection',
				'menu' => $this->M_menu->get_access_menu()->result_array(),
				'user' => $this->M_planinjection->editData(['user_id' => $this->session->userdata('admin_id')], 'tb_user')->row(),
				'list_planinjection' => $this->M_planinjection->get_view($start,$end)->result(),
				'total_planinjection' => $this->M_data->getData("tb_planinjection")->num_rows(),
			];
			$this->load->view('template/v_head', $data);
			$this->load->view('admin/planinjection/v_planinjection', $data);
			$this->load->view('template/v_footer');
		}
  }

	private function process_planinjection_add($input)
	{
		$data = [
			'planinjection_kode' => $this->db->escape_str($input->planinjection_kode),
			'purchaseorder_id' => $this->db->escape_str($input->purchaseorder_id),
			'planinjection_hasil' => $this->db->escape_str($input->planinjection_hasil),
		];
		$check = $this->M_planinjection->insertData($data, 'tb_planinjection');
		if ($check["success"] === TRUE) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses menambahkan", "Data Plan Injection sukses ditambah", "success", "tutup")</script>');
			redirect("planinjection");
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal menambahkan", "Query failed", "error", "tutup")</script>');
			redirect("planinjection");
		}
	}

	public function search_purchaseorder()
	{
		$keyword = html_escape($this->input->post("keyword"));
		if ($keyword != "") {
			$check = $this->M_planinjection->search_purchaseorder($keyword, 10);
			if ($check->success === TRUE) {
				foreach ($check->data as $item) {
					echo "<p onclick=\"addPurchaseorder('$item->purchaseorder_kode', $item->purchaseorder_id)\">$item->purchaseorder_kode : $item->customer_kode, $item->product_kode, $item->model_kode, $item->part_kode, $item->category_nama, $item->tool_kode, $item->hole_nama, $item->colour_nama</p>";
				}
			} else {
				echo "<p>Maaf Plan Injection tidak ada</p>";
			}
		} else {
			echo "";
		}
	}

  public function view_planinjection_edit($id)
  {
    $planinjection_id = (int)$this->db->escape_str($id);
    $check = $this->M_planinjection->editData(['planinjection_id' => $planinjection_id],'tb_planinjection');
    if ($check) {
      $data = [
        'title' => 'Edit Plan Injection',
        'menu' => $this->M_menu->get_access_menu()->result_array(),
        'user' => $this->M_planinjection->editData(['user_id' => $this->session->userdata('admin_id')],'tb_user')->row(),
        'planinjection_item' => $check->row(),
		'list_purchaseorder' => $this->M_planinjection->getData('tb_purchaseorder')->result(),
      ];
      $this->load->view('template/v_head', $data);
      $this->load->view('admin/planinjection/v_editPlaninjection', $data);
      $this->load->view('template/v_footer');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query Failed", "error", "tutup")</script>');
      redirect('planinjection');
    }
  }

 	 public function process_planinjection_edit()
	{
		$this->form_validation->set_rules('planinjection_kode', 'Kode plan injection', 'required');
		$this->form_validation->set_rules(
			'purchaseorder_id', 'Kode Purchase Order', 'required',
			[
				'required' => 'Wajib masukkan kode purchase order'
			]
		);
		$this->form_validation->set_rules('planinjection_hasil', 'Hasil plan injection', 'required');

		$planinjection_id = $this->input->post('planinjection_id');
		
		if ($this->form_validation->run() != FALSE) {
		$this->process_planinjection_edit_act($planinjection_id);
		} else {
		$this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Masukan data dengan benar dan lengkap!", "error", "tutup")</script>');
		redirect('view_planinjection_edit/'. $planinjection_id);
		}
	}

  private function process_planinjection_edit_act($id)
  {
    $input = (object) $this->input->post();
	$planinjection = $this->M_planinjection->editData(['planinjection_id' => $id], 'tb_planinjection')->row();

	$purchaseorder_total = $this->M_planinjection->editData(['purchaseorder_id' => $planinjection->purchaseorder_id], 'tb_purchaseorder')->result();
	foreach ($purchaseorder_total as $p) {
		if ($input->planinjection_hasil != 0) {
			$planinjection_remain = $p->purchaseorder_remain - $input->planinjection_hasil;
		} else {
			$planinjection_remain = 0;
		}

		$data = [
			'planinjection_kode' => $this->db->escape_str($input->planinjection_kode),
			'purchaseorder_id' => $this->db->escape_str($input->purchaseorder_id),
			'planinjection_hasil' => $this->db->escape_str($input->planinjection_hasil),
			'planinjection_remain' => $this->db->escape_str($planinjection_remain),
		];

		$where = ['planinjection_id' => $this->db->escape_str($input->planinjection_id)];
		$check = $this->M_planinjection->updateData($data, $where, 'tb_planinjection');
	}

    if ($check["success"] === TRUE) {
      $this->session->set_flashdata('pesan', '<script>sweet("Sukses", "Data Plan Injection berhasil diubah", "success", "tutup")</script>');
      redirect('planinjection');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query failed!", "error", "tutup")</script>');
      redirect('view_planinjection_edit/'.$input->planinjection_id);
    }
  }

	public function process_planinjection_delete($id)
	{
		$planinjection_id = (int)$this->db->escape_str($id);
		$check = $this->M_planinjection->deleteData(["planinjection_id" => $planinjection_id], "tb_planinjection");
		if ($check) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses","Data Plan Spray berhasil dihapus!","success","Tutup")</script>');
			redirect("planinjection");
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal","Query failed!","success","Tutup")</script>');
			redirect("planinjection");
		}
	}

}
