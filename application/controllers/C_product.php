<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class C_product extends CI_Controller {

  public function __construct()
  {
    parent::__construct();  
		protek_login();
  }

  public function index()
  {
		$this->form_validation->set_rules('product_kode', 'Kode product', 'required');
		$this->form_validation->set_rules(
			'model_id',
			'Model product',
			'required',
			[
				'required' => 'Wajib masukkan kode model'
			]
		);
		$this->form_validation->set_rules(
			'part_id',
			'Part Code product',
			'required',
			[
				'required' => 'Wajib masukkan kode part'
			]
		);
		$this->form_validation->set_rules(
			'category_id',
			'Nama product',
			'required',
			[
				'required' => 'Wajib masukkan nama product'
			]
		);
		$this->form_validation->set_rules(
			'tool_id',
			'tool product',
			'required',
			[
				'required' => 'Wajib masukkan kode tool'
			]
		);
		$this->form_validation->set_rules(
			'hole_id',
			'hole product',
			'required',
			[
				'required' => 'Wajib masukkan kode hole'
			]
		);
		$this->form_validation->set_rules(
			'colour_id',
			'Colour product',
			'required',
			[
				'required' => 'Wajib masukkan nama colour'
			]
		);

		if ($this->form_validation->run() != FALSE) {
			$input = (object) $this->input->post();
			$this->process_product_add($input);
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Lengakpi form tambah product", "error", "tutup")</script>');
			redirect('product');
		} else {
			$data = [
				'title' => 'Product',
				'menu' => $this->M_menu->get_access_menu()->result_array(),
				'user' => $this->M_product->editData(['user_id' => $this->session->userdata('admin_id')], 'tb_user')->row(),
				'list_product' => $this->M_product->get_product()->result(),
				'total_product' => $this->M_data->getData("tb_product")->num_rows(),
			];
			$this->load->view('template/v_head', $data);
			$this->load->view('admin/product/v_product', $data);
			$this->load->view('template/v_footer');
		}
  }

	private function process_product_add($input)
	{
		
		$data = [
			'product_kode' => $this->db->escape_str($input->product_kode),
			'model_id' => $this->db->escape_str($input->model_id),
			'part_id' => $this->db->escape_str($input->part_id),
			'category_id' => $this->db->escape_str($input->category_id),
			'tool_id' => $this->db->escape_str($input->tool_id),
			'hole_id' => $this->db->escape_str($input->hole_id),
			'colour_id' => $this->db->escape_str($input->colour_id),
		];
		
		$check = $this->M_product->insertData($data, 'tb_product');
		if ($check["success"] === TRUE) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses menambahkan", "Data product sukses ditambah", "success", "tutup")</script>');
			redirect("product");
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal menambahkan", "Query failed", "error", "tutup")</script>');
			redirect("product");
		}
	}

	public function search_model()
	{
		$keyword = html_escape($this->input->post("keyword"));
		if ($keyword != "") {
			$check = $this->M_product->search_model($keyword, 10);
			if ($check->success === TRUE) {
				foreach ($check->data as $item) {
					echo "<p onclick=\"addModel('$item->model_kode', $item->model_id)\">$item->model_kode : $item->model_nama</p>";
				}
			} else {
				echo "<p>Maaf model tidak ada</p>";
			}
		} else {
			echo "";
		}
	}

	public function search_part()
	{
		$keyword = html_escape($this->input->post("keyword"));
		if ($keyword != "") {
			$check = $this->M_product->search_part($keyword, 10);
			if ($check->success === TRUE) {
				foreach ($check->data as $item) {
					echo "<p onclick=\"addPart('$item->part_kode', $item->part_id)\">$item->part_kode : $item->part_nama</p>";
				}
			} else {
				echo "<p>Maaf part tidak ada</p>";
			}
		} else {
			echo "";
		}
	}

	public function search_category()
	{
		$keyword = html_escape($this->input->post("keyword"));
		if ($keyword != "") {
			$check = $this->M_product->search_category($keyword, 10);
			if ($check->success === TRUE) {
				foreach ($check->data as $item) {
					echo "<p onclick=\"addCategory('$item->category_nama', $item->category_id)\">$item->category_nama</p>";
				}
			} else {
				echo "<p>Maaf category tidak ada</p>";
			}
		} else {
			echo "";
		}
	}

	public function search_tool()
	{
		$keyword = html_escape($this->input->post("keyword"));
		if ($keyword != "") {
			$check = $this->M_product->search_tool($keyword, 10);
			if ($check->success === TRUE) {
				foreach ($check->data as $item) {
					echo "<p onclick=\"addTool('$item->tool_kode', $item->tool_id)\">$item->tool_kode : $item->tool_nama</p>";
				}
			} else {
				echo "<p>Maaf tool tidak ada</p>";
			}
		} else {
			echo "";
		}
	}

	public function search_hole()
	{
		$keyword = html_escape($this->input->post("keyword"));
		if ($keyword != "") {
			$check = $this->M_product->search_hole($keyword, 10);
			if ($check->success === TRUE) {
				foreach ($check->data as $item) {
					echo "<p onclick=\"addHole('$item->hole_nama', $item->hole_id)\">$item->hole_nama</p>";
				}
			} else {
				echo "<p>Maaf hole tidak ada</p>";
			}
		} else {
			echo "";
		}
	}

	public function search_colour()
	{
		$keyword = html_escape($this->input->post("keyword"));
		if ($keyword != "") {
			$check = $this->M_product->search_colour($keyword, 10);
			if ($check->success === TRUE) {
				foreach ($check->data as $item) {
					echo "<p onclick=\"addColour('$item->colour_nama', $item->colour_id)\">$item->colour_nama</p>";
				}
			} else {
				echo "<p>Maaf colour tidak ada</p>";
			}
		} else {
			echo "";
		}
	}

  public function view_product_edit($id)
  {
    $product_id = (int)$this->db->escape_str($id);
    $check = $this->M_product->editData(['product_id' => $product_id],'tb_product');
    if ($check) {
      $data = [
        'title' => 'Edit Product',
        'menu' => $this->M_menu->get_access_menu()->result_array(),
        'user' => $this->M_product->editData(['user_id' => $this->session->userdata('admin_id')],'tb_user')->row(),
        'product_item' => $check->row(),
		'list_model' => $this->M_product->getData('tb_model')->result(),
		'list_part' => $this->M_product->getData('tb_part')->result(),
		'list_category' => $this->M_product->getData('tb_category')->result(),
		'list_tool' => $this->M_product->getData('tb_tool')->result(),
		'list_hole' => $this->M_product->getData('tb_hole')->result(),
		'list_colour' => $this->M_product->getData('tb_colour')->result(),
      ];
      $this->load->view('template/v_head', $data);
      $this->load->view('admin/product/v_editProduct', $data);
      $this->load->view('template/v_footer');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query Failed", "error", "tutup")</script>');
      redirect('product');
    }
  }

  	public function process_product_edit()
  	{
		$this->form_validation->set_rules('product_kode', 'Kode product', 'required');
		$this->form_validation->set_rules(
			'model_id', 'Model product', 'required',
			[
				'required' => 'Wajib masukkan kode model'
			]
		);
		$this->form_validation->set_rules(
			'part_id', 'Part Code product', 'required',
			[
				'required' => 'Wajib masukkan kode part'
			]
		);
		$this->form_validation->set_rules(
			'category_id', 'Nama product', 'required',
			[
				'required' => 'Wajib masukkan nama product'
			]
		);
		$this->form_validation->set_rules(
			'tool_id', 'tool product', 'required',
			[
				'required' => 'Wajib masukkan kode tool'
			]
		);
		$this->form_validation->set_rules(
			'hole_id', 'hole product', 'required',
			[
				'required' => 'Wajib masukkan kode hole'
			]
		);
		$this->form_validation->set_rules(
			'colour_id', 'Colour product', 'required',
			[
				'required' => 'Wajib masukkan nama colour'
			]
		);
		$product_id = $this->input->post('product_id');

		if ($this->form_validation->run() != FALSE) {
		$this->process_product_edit_act();
		} else {
		$this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Masukan data dengan benar dan lengkap!", "error", "tutup")</script>');
		redirect('view_product_edit/'. $product_id);
		}
  	}

	private function process_product_edit_act()
	{
    	$input = (object) $this->input->post();
		$data = [
			'product_kode' => $this->db->escape_str($input->product_kode),
			'model_id' => $this->db->escape_str($input->model_id),
			'part_id' => $this->db->escape_str($input->part_id),
			'category_id' => $this->db->escape_str($input->category_id),
			'tool_id' => $this->db->escape_str($input->tool_id),
			'hole_id' => $this->db->escape_str($input->hole_id),
			'colour_id' => $this->db->escape_str($input->colour_id),
		];
		
		$where = ['product_id' => $this->db->escape_str($input->product_id)];

		$check = $this->M_product->updateData($data, $where, 'tb_product');
		if ($check["success"] === TRUE) {
		$this->session->set_flashdata('pesan', '<script>sweet("Sukses", "Data Product berhasil diubah", "success", "tutup")</script>');
		redirect('product');
		} else {
		$this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query failed!", "error", "tutup")</script>');
		redirect('view_product_edit/'.$input->product_id);
		}
	}

	public function process_product_delete($id)
	{
		$product_id = (int)$this->db->escape_str($id);
		$check = $this->M_product->deleteData(["product_id" => $product_id], "tb_product");
		if ($check) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses","Data Product berhasil dihapus!","success","Tutup")</script>');
			redirect("product");
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal","Query failed!","success","Tutup")</script>');
			redirect("product");
		}
	}

}
