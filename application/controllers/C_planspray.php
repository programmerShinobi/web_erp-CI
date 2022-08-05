<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class C_planspray extends CI_Controller {

  public function __construct()
  {
    parent::__construct();  
		protek_login();
  }

  public function index()
  {
		$this->form_validation->set_rules('planspray_kode', 'Kode Plan spray', 'required');
		$this->form_validation->set_rules(
			'purchaseorder_id', 'Kode Purchase Order', 'required',
			[
				'required' => 'Wajib masukkan kode purchase order'
			]
		);
		$this->form_validation->set_rules('planspray_hasil', 'Hasil Plan Spray', 'required');
		
		if ($this->form_validation->run() != FALSE) {
			$input = (object) $this->input->post();
			$this->process_planspray_add($input);
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Lengakpi form tambah Plan Spray", "error", "tutup")</script>');
			redirect('planspray');
		} else {
			$start = $this->input->post('start_order_date');
			$end = $this->input->post('end_order_date');
			$data = [
				'title' => 'Plan Spray',
				'menu' => $this->M_menu->get_access_menu()->result_array(),
				'user' => $this->M_planspray->editData(['user_id' => $this->session->userdata('admin_id')], 'tb_user')->row(),
				'list_planspray' => $this->M_planspray->get_view($start,$end)->result(),
				'total_planspray' => $this->M_data->getData("tb_planspray")->num_rows(),
			];
			$this->load->view('template/v_head', $data);
			$this->load->view('admin/planspray/v_planspray', $data);
			$this->load->view('template/v_footer');
		}
  }

	private function process_planspray_add($input)
	{
		$data = [
			'planspray_kode' => $this->db->escape_str($input->planspray_kode),
			'purchaseorder_id' => $this->db->escape_str($input->purchaseorder_id),
			'planspray_hasil' => $this->db->escape_str($input->planspray_hasil),
		];
		$check = $this->M_planspray->insertData($data, 'tb_planspray');
		if ($check["success"] === TRUE) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses menambahkan", "Data Plan Spray sukses ditambah", "success", "tutup")</script>');
			redirect("planspray");
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal menambahkan", "Query failed", "error", "tutup")</script>');
			redirect("planspray");
		}
	}

	public function search_purchaseorder()
	{
		$keyword = html_escape($this->input->post("keyword"));
		if ($keyword != "") {
			$check = $this->M_planspray->search_purchaseorder($keyword, 10);
			if ($check->success === TRUE) {
				foreach ($check->data as $item) {
					echo "<p onclick=\"addPurchaseorder('$item->purchaseorder_kode', $item->purchaseorder_id)\">$item->purchaseorder_kode : $item->customer_kode, $item->product_kode, $item->model_kode, $item->part_kode, $item->category_nama, $item->tool_kode, $item->hole_nama, $item->colour_nama</p>";
				}
			} else {
				echo "<p>Maaf Plan spray tidak ada</p>";
			}
		} else {
			echo "";
		}
	}

  public function view_planspray_edit($id)
  {
    $planspray_id = (int)$this->db->escape_str($id);
    $check = $this->M_planspray->editData(['planspray_id' => $planspray_id],'tb_planspray');
    if ($check) {
      $data = [
        'title' => 'Edit Plan Spray',
        'menu' => $this->M_menu->get_access_menu()->result_array(),
        'user' => $this->M_planspray->editData(['user_id' => $this->session->userdata('admin_id')],'tb_user')->row(),
        'planspray_item' => $check->row(),
		'list_purchaseorder' => $this->M_planspray->getData('tb_purchaseorder')->result(),
      ];
      $this->load->view('template/v_head', $data);
      $this->load->view('admin/planspray/v_editPlanspray', $data);
      $this->load->view('template/v_footer');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query Failed", "error", "tutup")</script>');
      redirect('planspray');
    }
  }

 	 public function process_planspray_edit()
	{
		$this->form_validation->set_rules('planspray_kode', 'Kode plan spray', 'required');
		$this->form_validation->set_rules(
			'purchaseorder_id', 'Kode Purchase Order', 'required',
			[
				'required' => 'Wajib masukkan kode purchase order'
			]
		);
		$this->form_validation->set_rules('planspray_hasil', 'Hasil Plan Spray', 'required');

		$planspray_id = $this->input->post('planspray_id');
		
		if ($this->form_validation->run() != FALSE) {
		$this->process_planspray_edit_act($planspray_id);
		} else {
		$this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Masukan data dengan benar dan lengkap!", "error", "tutup")</script>');
		redirect('view_planspray_edit/'. $planspray_id);
		}
	}

  private function process_planspray_edit_act($id)
  {
    $input = (object) $this->input->post();
	$planspray = $this->M_planspray->editData(['planspray_id' => $id], 'tb_planspray')->row();

	$purchaseorder_total = $this->M_planspray->editData(['purchaseorder_id' => $planspray->purchaseorder_id], 'tb_purchaseorder')->result();
	foreach ($purchaseorder_total as $p) {
		if ($input->planspray_hasil != 0) {
			$planspray_remain = $p->purchaseorder_remain - $input->planspray_hasil;
		} else {
			$planspray_remain = 0;
		}

		$data = [
			'planspray_kode' => $this->db->escape_str($input->planspray_kode),
			'purchaseorder_id' => $this->db->escape_str($input->purchaseorder_id),
			'planspray_hasil' => $this->db->escape_str($input->planspray_hasil),
			'planspray_remain' => $this->db->escape_str($planspray_remain),
		];

		$where = ['planspray_id' => $this->db->escape_str($input->planspray_id)];
		$check = $this->M_planspray->updateData($data, $where, 'tb_planspray');
	}

    if ($check["success"] === TRUE) {
      $this->session->set_flashdata('pesan', '<script>sweet("Sukses", "Data Plan Spray berhasil diubah", "success", "tutup")</script>');
      redirect('planspray');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query failed!", "error", "tutup")</script>');
      redirect('view_planspray_edit/'.$input->planspray_id);
    }
  }

	public function process_planspray_delete($id)
	{
		$planspray_id = (int)$this->db->escape_str($id);
		$check = $this->M_planspray->deleteData(["planspray_id" => $planspray_id], "tb_planspray");
		if ($check) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses","Data Plan Spray berhasil dihapus!","success","Tutup")</script>');
			redirect("planspray");
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal","Query failed!","success","Tutup")</script>');
			redirect("planspray");
		}
	}

}
