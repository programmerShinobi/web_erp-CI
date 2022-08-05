<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class C_purchaseorder extends CI_Controller {

  public function __construct()
  {
    parent::__construct();  
		protek_login();
  }

  public function index()
  {
		$this->form_validation->set_rules('purchaseorder_kode', 'Kode Purchase Order', 'required');
		$this->form_validation->set_rules('purchaseorder_tanggal', 'Tanggal Purchase Order', 'required');
		$this->form_validation->set_rules(
			'customer_id', 'Kode Customer', 'required',
			[
				'required' => 'Wajib masukkan kode customer'
			]
		);
		$this->form_validation->set_rules(
			'product_id', 'Part Code', 'required',
			[
				'required' => 'Wajib masukkan kode product'
			]
		);
		$this->form_validation->set_rules('purchaseorder_jumlah', 'Jumlah Purchase Order', 'required');

		if ($this->form_validation->run() != FALSE) {
			$input = (object) $this->input->post();
			$this->process_purchaseorder_add($input);
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Lengakpi form tambah purchaseorder", "error", "tutup")</script>');
			redirect('purchaseorder');
		} else {
			$start = $this->input->post('start_order_date');
			$end = $this->input->post('end_order_date');
			$data = [
				'title' => 'Purchase Order',
				'menu' => $this->M_menu->get_access_menu()->result_array(),
				'user' => $this->M_purchaseorder->editData(['user_id' => $this->session->userdata('admin_id')], 'tb_user')->row(),
				'list_purchaseorder' => $this->M_purchaseorder->get_view($start,$end)->result(),
				'total_purchaseorder' => $this->M_data->getData("tb_purchaseorder")->num_rows(),
			];
			$this->load->view('template/v_head', $data);
			$this->load->view('admin/purchaseorder/v_purchaseorder', $data);
			$this->load->view('template/v_footer');
		}
  }

	private function process_purchaseorder_add($input)
	{
		$data = [
			'purchaseorder_kode' => $this->db->escape_str($input->purchaseorder_kode),
			'purchaseorder_tanggal' => $this->db->escape_str($input->purchaseorder_tanggal),
			'customer_id' => $this->db->escape_str($input->customer_id),
			'product_id' => $this->db->escape_str($input->product_id),
			'purchaseorder_jumlah' => $this->db->escape_str($input->purchaseorder_jumlah),
		];
		$check = $this->M_purchaseorder->insertData($data, 'tb_purchaseorder');
		if ($check["success"] === TRUE) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses menambahkan", "Data purchase Order sukses ditambah", "success", "tutup")</script>');
			redirect("purchaseorder");
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal menambahkan", "Query failed", "error", "tutup")</script>');
			redirect("purchaseorder");
		}
	}

	public function search_customer()
	{
		$keyword = html_escape($this->input->post("keyword"));
		if ($keyword != "") {
			$check = $this->M_purchaseorder->search_customer($keyword, 10);
			if ($check->success === TRUE) {
				foreach ($check->data as $item) {
					echo "<p onclick=\"addCustomer('$item->customer_kode', $item->customer_id)\">$item->customer_kode - $item->customer_nama</p>";
				}
			} else {
				echo "<p>Maaf customer tidak ada</p>";
			}
		} else {
			echo "";
		}
	}

	public function search_product()
	{
		$keyword = html_escape($this->input->post("keyword"));
		if ($keyword != "") {
			$check = $this->M_purchaseorder->search_product($keyword, 50);
			if ($check->success === TRUE) {
				foreach ($check->data as $item) {
					echo "<p onclick=\"addProduct('$item->part_kode', $item->product_id)\">$item->part_kode, $item->model_kode, $item->category_nama, $item->hole_nama, $item->colour_nama</p>";
				}
			} else {
				echo "<p>Maaf product tidak ada</p>";
			}
		} else {
			echo "";
		}
	}

  public function view_purchaseorder_edit($id)
  {
    $purchaseorder_id = (int)$this->db->escape_str($id);
    $check = $this->M_purchaseorder->editData(['purchaseorder_id' => $purchaseorder_id],'tb_purchaseorder');
    if ($check) {
      $data = [
        'title' => 'Edit Purchase Order',
        'menu' => $this->M_menu->get_access_menu()->result_array(),
        'user' => $this->M_purchaseorder->editData(['user_id' => $this->session->userdata('admin_id')],'tb_user')->row(),
        'purchaseorder_item' => $check->row(),
		'list_customer' => $this->M_menu->getData('tb_customer')->result(),
		'list_product' => $this->M_purchaseorder->get_view_list_product()->result(),
      ];
      $this->load->view('template/v_head', $data);
      $this->load->view('admin/purchaseorder/v_editPurchaseorder', $data);
      $this->load->view('template/v_footer');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query Failed", "error", "tutup")</script>');
      redirect('purchaseorder');
    }
  }

 	 public function process_purchaseorder_edit()
	{
		$this->form_validation->set_rules('purchaseorder_kode', 'Kode Purchase Order', 'required');
		$this->form_validation->set_rules('purchaseorder_tanggal', 'Tanggal Purchase Order', 'required');
		$this->form_validation->set_rules(
			'customer_id', 'Kode Customer', 'required',
			[
				'required' => 'Wajib masukkan kode customer'
			]
		);
		$this->form_validation->set_rules(
			'product_id', 'Kode Product', 'required',
			[
				'required' => 'Wajib masukkan kode product'
			]
		);
		$this->form_validation->set_rules('purchaseorder_jumlah', 'Jumlah Purchase Order', 'required');
		$purchaseorder_id = $this->input->post('purchaseorder_id');
		if ($this->form_validation->run() != FALSE) {
		$this->process_purchaseorder_edit_act();
		} else {
		$this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Masukan data dengan benar dan lengkap!", "error", "tutup")</script>');
		redirect('view_purchaseorder_edit/'. $purchaseorder_id);
		}
	}

  private function process_purchaseorder_edit_act()
  {
    $input = (object) $this->input->post();
	if ($input->purchaseorder_stockopnamesemi != 0 || $input->purchaseorder_stockopnamefinish != 0 ){
			$purchaseorder_remain = $input->purchaseorder_jumlah - ($input->purchaseorder_stockopnamesemi + $input->purchaseorder_stockopnamefinish);
	} else {
			$purchaseorder_remain = 0 ;
	}
	$data = [
		'purchaseorder_kode' => $this->db->escape_str($input->purchaseorder_kode),
		'purchaseorder_tanggal' => $this->db->escape_str($input->purchaseorder_tanggal),
		'customer_id' => $this->db->escape_str($input->customer_id),
		'product_id' => $this->db->escape_str($input->product_id),
		'purchaseorder_jumlah' => $this->db->escape_str($input->purchaseorder_jumlah),
		'purchaseorder_stockopnamesemi' => $this->db->escape_str($input->purchaseorder_stockopnamesemi),
		'purchaseorder_stockopnamefinish' => $this->db->escape_str($input->purchaseorder_stockopnamefinish),
		'purchaseorder_remain' => $this->db->escape_str($purchaseorder_remain),
	];
	$where = ['purchaseorder_id' => $this->db->escape_str($input->purchaseorder_id)];
	
    $check = $this->M_purchaseorder->updateData($data, $where, 'tb_purchaseorder');
    if ($check["success"] === TRUE) {
      $this->session->set_flashdata('pesan', '<script>sweet("Sukses", "Data Purchase Order berhasil di edit", "success", "tutup")</script>');
      redirect('purchaseorder');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query failed!", "error", "tutup")</script>');
      redirect('view_purchaseorder_edit/'.$input->purchaseorder_id);
    }
  }

	public function process_purchaseorder_delete($id)
	{
		$purchaseorder_id = (int)$this->db->escape_str($id);
		$check = $this->M_purchaseorder->deleteData(["purchaseorder_id" => $purchaseorder_id], "tb_purchaseorder");
		if ($check) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses","Data Purchase Order berhasil dihapus!","success","Tutup")</script>');
			redirect("purchaseorder");
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal","Query failed!","success","Tutup")</script>');
			redirect("purchaseorder");
		}
	}

}
