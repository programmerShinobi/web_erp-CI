<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class C_planprinting extends CI_Controller {

  public function __construct()
  {
    parent::__construct();  
		protek_login();
  }

  public function index()
  {
		$this->form_validation->set_rules('planprinting_kode', 'Kode Plan Printing', 'required');
		$this->form_validation->set_rules(
			'purchaseorder_id', 'Kode Purchase Order', 'required',
			[
				'required' => 'Wajib masukkan kode purchase order'
			]
		);
		$this->form_validation->set_rules('planprinting_hasil', 'Hasil Plan Printing', 'required');
		
		if ($this->form_validation->run() != FALSE) {
			$input = (object) $this->input->post();
			$this->process_planprinting_add($input);
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Lengakpi form tambah Plan Printing", "error", "tutup")</script>');
			redirect('planprinting');
		} else {
			$start = $this->input->post('start_order_date');
			$end = $this->input->post('end_order_date');
			$data = [
				'title' => 'Plan Printing',
				'menu' => $this->M_menu->get_access_menu()->result_array(),
				'user' => $this->M_planprinting->editData(['user_id' => $this->session->userdata('admin_id')], 'tb_user')->row(),
				'list_planprinting' => $this->M_planprinting->get_view($start,$end)->result(),
				'total_planprinting' => $this->M_data->getData("tb_planprinting")->num_rows(),
			];
			$this->load->view('template/v_head', $data);
			$this->load->view('admin/planprinting/v_planprinting', $data);
			$this->load->view('template/v_footer');
		}
  }

	private function process_planprinting_add($input)
	{
		$data = [
			'planprinting_kode' => $this->db->escape_str($input->planprinting_kode),
			'purchaseorder_id' => $this->db->escape_str($input->purchaseorder_id),
			'planprinting_hasil' => $this->db->escape_str($input->planprinting_hasil),
		];
		$check = $this->M_planprinting->insertData($data, 'tb_planprinting');
		if ($check["success"] === TRUE) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses menambahkan", "Data Plan printing sukses ditambah", "success", "tutup")</script>');
			redirect("planprinting");
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal menambahkan", "Query failed", "error", "tutup")</script>');
			redirect("planprinting");
		}
	}

	public function search_purchaseorder()
	{
		$keyword = html_escape($this->input->post("keyword"));
		if ($keyword != "") {
			$check = $this->M_planprinting->search_purchaseorder($keyword, 10);
			if ($check->success === TRUE) {
				foreach ($check->data as $item) {
					echo "<p onclick=\"addPurchaseorder('$item->purchaseorder_kode', $item->purchaseorder_id)\">$item->purchaseorder_kode : $item->customer_kode, $item->product_kode, $item->model_kode, $item->part_kode, $item->category_nama, $item->tool_kode, $item->hole_nama, $item->colour_nama</p>";
				}
			} else {
				echo "<p>Maaf Plan printing tidak ada</p>";
			}
		} else {
			echo "";
		}
	}

  public function view_planprinting_edit($id)
  {
    $planprinting_id = (int)$this->db->escape_str($id);
    $check = $this->M_planprinting->editData(['planprinting_id' => $planprinting_id],'tb_planprinting');
    if ($check) {
      $data = [
        'title' => 'Edit Plan Printing',
        'menu' => $this->M_menu->get_access_menu()->result_array(),
        'user' => $this->M_planprinting->editData(['user_id' => $this->session->userdata('admin_id')],'tb_user')->row(),
        'planprinting_item' => $check->row(),
		'list_purchaseorder' => $this->M_planprinting->getData('tb_purchaseorder')->result(),
      ];
      $this->load->view('template/v_head', $data);
      $this->load->view('admin/planprinting/v_editPlanprinting', $data);
      $this->load->view('template/v_footer');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query Failed", "error", "tutup")</script>');
      redirect('planprinting');
    }
  }

 	 public function process_planprinting_edit()
	{
		$this->form_validation->set_rules('planprinting_kode', 'Kode plan printing', 'required');
		$this->form_validation->set_rules(
			'purchaseorder_id', 'Kode Purchase Order', 'required',
			[
				'required' => 'Wajib masukkan kode purchase order'
			]
		);
		$this->form_validation->set_rules('planprinting_hasil', 'Hasil plan printing', 'required');

		$planprinting_id = $this->input->post('planprinting_id');
		
		if ($this->form_validation->run() != FALSE) {
		$this->process_planprinting_edit_act($planprinting_id);
		} else {
		$this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Masukan data dengan benar dan lengkap!", "error", "tutup")</script>');
		redirect('view_planprinting_edit/'. $planprinting_id);
		}
	}

  private function process_planprinting_edit_act($id)
  {
    $input = (object) $this->input->post();
	$planprinting = $this->M_planprinting->editData(['planprinting_id' => $id], 'tb_planprinting')->row();

	$purchaseorder_total = $this->M_planprinting->editData(['purchaseorder_id' => $planprinting->purchaseorder_id], 'tb_purchaseorder')->result();
	foreach ($purchaseorder_total as $p) {
		if ($input->planprinting_hasil != 0) {
			$planprinting_remain = $p->purchaseorder_remain - $input->planprinting_hasil;
		} else {
			$planprinting_remain = 0;
		}

		$data = [
			'planprinting_kode' => $this->db->escape_str($input->planprinting_kode),
			'purchaseorder_id' => $this->db->escape_str($input->purchaseorder_id),
			'planprinting_hasil' => $this->db->escape_str($input->planprinting_hasil),
			'planprinting_remain' => $this->db->escape_str($planprinting_remain),
		];

		$where = ['planprinting_id' => $this->db->escape_str($input->planprinting_id)];
		$check = $this->M_planprinting->updateData($data, $where, 'tb_planprinting');
	}

    if ($check["success"] === TRUE) {
      $this->session->set_flashdata('pesan', '<script>sweet("Sukses", "Data Plan Printin berhasil diubah", "success", "tutup")</script>');
      redirect('planprinting');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query failed!", "error", "tutup")</script>');
      redirect('view_planprinting_edit/'.$input->planprinting_id);
    }
  }

	public function process_planprinting_delete($id)
	{
		$planprinting_id = (int)$this->db->escape_str($id);
		$check = $this->M_planprinting->deleteData(["planprinting_id" => $planprinting_id], "tb_planprinting");
		if ($check) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses","Data Plan Printing berhasil dihapus!","success","Tutup")</script>');
			redirect("planprinting");
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal","Query failed!","success","Tutup")</script>');
			redirect("planprinting");
		}
	}

}
