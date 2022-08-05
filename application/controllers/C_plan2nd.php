<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class C_plan2nd extends CI_Controller {

  public function __construct()
  {
    parent::__construct();  
		protek_login();
  }

  public function index()
  {
		$this->form_validation->set_rules('plan2nd_kode', 'Kode Plan 2nd', 'required');
		$this->form_validation->set_rules(
			'purchaseorder_id', 'Kode Purchase Order', 'required',
			[
				'required' => 'Wajib masukkan kode purchase order'
			]
		);
		$this->form_validation->set_rules('plan2nd_hasil', 'Hasil Plan 2nd', 'required');
		
		if ($this->form_validation->run() != FALSE) {
			$input = (object) $this->input->post();
			$this->process_plan2nd_add($input);
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Lengakpi form tambah Plan 2nd", "error", "tutup")</script>');
			redirect('plan2nd');
		} else {
			$start = $this->input->post('start_order_date');
			$end = $this->input->post('end_order_date');
			$data = [
				'title' => 'Plan 2nd Process',
				'menu' => $this->M_menu->get_access_menu()->result_array(),
				'user' => $this->M_plan2nd->editData(['user_id' => $this->session->userdata('admin_id')], 'tb_user')->row(),
				'list_plan2nd' => $this->M_plan2nd->get_view($start,$end)->result(),
				'total_plan2nd' => $this->M_data->getData("tb_plan2nd")->num_rows(),
			];
			$this->load->view('template/v_head', $data);
			$this->load->view('admin/plan2nd/v_plan2nd', $data);
			$this->load->view('template/v_footer');
		}
  }

	private function process_plan2nd_add($input)
	{
		$data = [
			'plan2nd_kode' => $this->db->escape_str($input->plan2nd_kode),
			'purchaseorder_id' => $this->db->escape_str($input->purchaseorder_id),
			'plan2nd_hasil' => $this->db->escape_str($input->plan2nd_hasil),
		];
		$check = $this->M_plan2nd->insertData($data, 'tb_plan2nd');
		if ($check["success"] === TRUE) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses menambahkan", "Data Plan 2nd sukses ditambah", "success", "tutup")</script>');
			redirect("plan2nd");
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal menambahkan", "Query failed", "error", "tutup")</script>');
			redirect("plan2nd");
		}
	}

	public function search_purchaseorder()
	{
		$keyword = html_escape($this->input->post("keyword"));
		if ($keyword != "") {
			$check = $this->M_plan2nd->search_purchaseorder($keyword, 10);
			if ($check->success === TRUE) {
				foreach ($check->data as $item) {
					echo "<p onclick=\"addPurchaseorder('$item->purchaseorder_kode', $item->purchaseorder_id)\">$item->purchaseorder_kode : $item->customer_kode, $item->product_kode, $item->model_kode, $item->part_kode, $item->category_nama, $item->tool_kode, $item->hole_nama, $item->colour_nama</p>";
				}
			} else {
				echo "<p>Maaf Plan 2nd tidak ada</p>";
			}
		} else {
			echo "";
		}
	}

  public function view_plan2nd_edit($id)
  {
    $plan2nd_id = (int)$this->db->escape_str($id);
    $check = $this->M_plan2nd->editData(['plan2nd_id' => $plan2nd_id],'tb_plan2nd');
    if ($check) {
      $data = [
        'title' => 'Edit Plan 2nd Process  ',
        'menu' => $this->M_menu->get_access_menu()->result_array(),
        'user' => $this->M_plan2nd->editData(['user_id' => $this->session->userdata('admin_id')],'tb_user')->row(),
        'plan2nd_item' => $check->row(),
		'list_purchaseorder' => $this->M_plan2nd->getData('tb_purchaseorder')->result(),
      ];
      $this->load->view('template/v_head', $data);
      $this->load->view('admin/plan2nd/v_editPlan2nd', $data);
      $this->load->view('template/v_footer');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query Failed", "error", "tutup")</script>');
      redirect('plan2nd');
    }
  }

 	 public function process_plan2nd_edit()
	{
		$this->form_validation->set_rules('plan2nd_kode', 'Kode plan 2nd', 'required');
		$this->form_validation->set_rules(
			'purchaseorder_id', 'Kode Purchase Order', 'required',
			[
				'required' => 'Wajib masukkan kode purchase order'
			]
		);
		$this->form_validation->set_rules('plan2nd_hasil', 'Hasil plan 2nd', 'required');

		$plan2nd_id = $this->input->post('plan2nd_id');
		
		if ($this->form_validation->run() != FALSE) {
		$this->process_plan2nd_edit_act($plan2nd_id);
		} else {
		$this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Masukan data dengan benar dan lengkap!", "error", "tutup")</script>');
		redirect('view_plan2nd_edit/'. $plan2nd_id);
		}
	}

  private function process_plan2nd_edit_act($id)
  {
    $input = (object) $this->input->post();
	$plan2nd = $this->M_plan2nd->editData(['plan2nd_id' => $id], 'tb_plan2nd')->row();

	$purchaseorder_total = $this->M_plan2nd->editData(['purchaseorder_id' => $plan2nd->purchaseorder_id], 'tb_purchaseorder')->result();
	foreach ($purchaseorder_total as $p) {
		if ($input->plan2nd_hasil != 0) {
			$plan2nd_remain = $p->purchaseorder_remain - $input->plan2nd_hasil;
		} else {
			$plan2nd_remain = 0;
		}

		$data = [
			'plan2nd_kode' => $this->db->escape_str($input->plan2nd_kode),
			'purchaseorder_id' => $this->db->escape_str($input->purchaseorder_id),
			'plan2nd_hasil' => $this->db->escape_str($input->plan2nd_hasil),
			'plan2nd_remain' => $this->db->escape_str($plan2nd_remain),
		];

		$where = ['plan2nd_id' => $this->db->escape_str($input->plan2nd_id)];
		$check = $this->M_plan2nd->updateData($data, $where, 'tb_plan2nd');
	}

    if ($check["success"] === TRUE) {
      $this->session->set_flashdata('pesan', '<script>sweet("Sukses", "Data Plan 2nd berhasil diubah", "success", "tutup")</script>');
      redirect('plan2nd');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query failed!", "error", "tutup")</script>');
      redirect('view_plan2nd_edit/'.$input->plan2nd_id);
    }
  }

	public function process_plan2nd_delete($id)
	{
		$plan2nd_id = (int)$this->db->escape_str($id);
		$check = $this->M_plan2nd->deleteData(["plan2nd_id" => $plan2nd_id], "tb_plan2nd");
		if ($check) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses","Data Plan Spray berhasil dihapus!","success","Tutup")</script>');
			redirect("plan2nd");
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal","Query failed!","success","Tutup")</script>');
			redirect("plan2nd");
		}
	}

}
