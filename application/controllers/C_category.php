<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
require('./application/third_party/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class C_category extends CI_Controller {

  public function __construct()
  {
    parent::__construct();  
		protek_login();
  }

  public function index()
  {
		$this->form_validation->set_rules('category_nama', 'Nama category', 'required');

		if ($this->form_validation->run() != FALSE) {
			$input = (object) $this->input->post();
			$this->process_category_add($input);
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Lengakpi form tambah category", "error", "tutup")</script>');
			redirect('category');
		} else {
			$data = [
				'title' => 'Category',
				'menu' => $this->M_menu->get_access_menu()->result_array(),
				'user' => $this->M_category->editData(['user_id' => $this->session->userdata('admin_id')], 'tb_user')->row(),
				'list_category' => $this->M_category->getData('tb_category')->result(),
				'total_category' => $this->M_data->getData("tb_category")->num_rows(),
			];
			$this->load->view('template/v_head', $data);
			$this->load->view('admin/category/v_category', $data);
			$this->load->view('template/v_footer');
		}
  }

	private function process_category_add($input)
	{
		$data = [
			'category_nama' => $this->db->escape_str($input->category_nama),
		];
		$check = $this->M_category->insertData($data, 'tb_category');
		if ($check["success"] === TRUE) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses menambahkan", "Data category sukses ditambah", "success", "tutup")</script>');
			redirect("category");
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal menambahkan", "Query failed", "error", "tutup")</script>');
			redirect("category");
		}
	}

  public function view_category_edit($id)
  {
    $category_id = (int)$this->db->escape_str($id);
    $check = $this->M_category->editData(['category_id' => $category_id],'tb_category');
    if ($check) {
      $data = [
        'title' => 'Edit Category',
        'menu' => $this->M_menu->get_access_menu()->result_array(),
        'user' => $this->M_category->editData(['user_id' => $this->session->userdata('admin_id')],'tb_user')->row(),
        'category_item' => $check->row()
      ];
      $this->load->view('template/v_head', $data);
      $this->load->view('admin/category/v_editCategory', $data);
      $this->load->view('template/v_footer');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query Failed", "error", "tutup")</script>');
      redirect('category');
    }
  }

  public function process_category_edit()
  {
    $this->form_validation->set_rules('category_nama', 'category', 'required');
		$category_id = $this->input->post('category_id');

    if ($this->form_validation->run() != FALSE) {
      $this->process_category_edit_act();
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Masukan data dengan benar dan lengkap!", "error", "tutup")</script>');
      redirect('view_category_edit/'. $category_id);
    }
  }

  private function process_category_edit_act()
  {
    $input = (object) $this->input->post();
    $data = [
			'category_nama' => $this->db->escape_str($input->category_nama),
		];
    $where = ['category_id' => $this->db->escape_str($input->category_id)];

    $check = $this->M_category->updateData($data, $where, 'tb_category');
    if ($check["success"] === TRUE) {
      $this->session->set_flashdata('pesan', '<script>sweet("Sukses", "Data Nama berhasil di edit", "success", "tutup")</script>');
      redirect('category');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query failed!", "error", "tutup")</script>');
      redirect('view_category_edit/'.$input->category_id);
    }
  }

	public function process_category_delete($id)
	{
		$category_id = (int)$this->db->escape_str($id);
		$check = $this->M_category->deleteData(["category_id" => $category_id], "tb_category");
		if ($check) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses","Data Nama berhasil dihapus!","success","Tutup")</script>');
			redirect("category");
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal","Query failed!","success","Tutup")</script>');
			redirect("category");
		}
	}

  
	public function export_category()
	{
		$list_category = $this->M_data->getData("tb_category")->result();

		$spreadsheet = new Spreadsheet;

		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'No.')
			->setCellValue('B1', 'Nama category');

		$kolom = 2;
		$nomor = 1;
		foreach ($list_category as $item) {
			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A' . $kolom, $nomor)
				->setCellValue('B' . $kolom, $item->category_nama);
			$kolom++;
			$nomor++;
		}


		$writer = new Xlsx($spreadsheet);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data_category.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function import_category()
	{
		include APPPATH . 'third_party/PHPExcel/PHPExcel.php';
		$config['upload_path'] = realpath('./vendor/file/');
		$config['allowed_types'] = 'xlsx|xls|csv';
		$config['max_size'] = '1000000000';
		$config['encrypt_name'] = true;

		$this->load->library('upload');
		$this->upload->initialize($config);

		if (!$this->upload->do_upload('import_category')) {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal upload!","File excel gagal diupload!","error","Tutup")</script>');
			redirect('category');
		} else {
			$data_upload = $this->upload->data();
			$excelreader   = new PHPExcel_Reader_Excel2007();
			$loadexcel     = $excelreader->load('./vendor/file/' . $data_upload['file_name']); // Load file yang telah diupload ke folder excel
			$sheet         = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

			$data  = array();

			$numrow = 1;
			foreach ($sheet as $row) {
				if ($numrow > 1) {
					array_push($data, array(
						"category_nama" => $row["B"],
					));
				}
				$numrow++;
			}

			//delete file from server
			unlink(realpath('./vendor/file/' . $data_upload['file_name']));
			$this->db->insert_batch('tb_category', $data);
			//upload success
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses upload!","File berhasil diupload!","success","Tutup")</script>');
			//redirect halaman
			redirect('category');
		}
	}


}
