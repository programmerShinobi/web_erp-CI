<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
require('./application/third_party/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class C_material extends CI_Controller {

  public function __construct()
  {
    parent::__construct();  
		protek_login();
  }

  public function index()
  {
		$this->form_validation->set_rules('material_nama', 'Nama Material', 'required');
		$this->form_validation->set_rules('material_stok', 'Stok Material', 'required');

		if ($this->form_validation->run() != FALSE) {
			$input = (object) $this->input->post();
			$this->process_material_add($input);
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Lengakpi form tambah material", "error", "tutup")</script>');
			redirect('material');
		} else {
			$data = [
				'title' => 'Material',
				'menu' => $this->M_menu->get_access_menu()->result_array(),
				'user' => $this->M_material->editData(['user_id' => $this->session->userdata('admin_id')], 'tb_user')->row(),
				'list_material' => $this->M_material->getData('tb_material')->result(),
				'total_material' => $this->M_data->getData("tb_material")->num_rows(),
			];
			$this->load->view('template/v_head', $data);
			$this->load->view('admin/material/v_material', $data);
			$this->load->view('template/v_footer');
		}
  }

	private function process_material_add($input)
	{
		$data = [
			'material_kode' => $this->db->escape_str($input->material_kode),
			'material_nama' => $this->db->escape_str($input->material_nama),
			'material_stok' => $this->db->escape_str($input->material_stok)
		];
		$check = $this->M_material->insertData($data, 'tb_material');
		if ($check["success"] === TRUE) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses menambahkan", "Data material sukses ditambah", "success", "tutup")</script>');
			redirect("material");
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal menambahkan", "Query failed", "error", "tutup")</script>');
			redirect("material");
		}
	}

  public function view_material_edit($id)
  {
    $material_id = (int)$this->db->escape_str($id);
    $check = $this->M_material->editData(['material_id' => $material_id],'tb_material');
    if ($check) {
      $data = [
        'title' => 'Edit Material',
        'menu' => $this->M_menu->get_access_menu()->result_array(),
        'user' => $this->M_material->editData(['user_id' => $this->session->userdata('admin_id')],'tb_user')->row(),
        'material_item' => $check->row()
      ];
      $this->load->view('template/v_head', $data);
      $this->load->view('admin/material/v_editMaterial', $data);
      $this->load->view('template/v_footer');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query Failed", "error", "tutup")</script>');
      redirect('material');
    }
  }

  public function process_material_edit()
  {
    $this->form_validation->set_rules('material_nama', 'material', 'required');
		$this->form_validation->set_rules('material_stok', 'material', 'required');
		$material_id = $this->input->post('material_id');

    if ($this->form_validation->run() != FALSE) {
      $this->process_material_edit_act();
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Masukan data dengan benar dan lengkap!", "error", "tutup")</script>');
      redirect('view_material_edit/'. $material_id);
    }
  }

  private function process_material_edit_act()
  {
    $input = (object) $this->input->post();
    $data = [
			'material_nama' => $this->db->escape_str($input->material_nama),
			'material_stok' => $this->db->escape_str($input->material_stok)
		];
    $where = ['material_id' => $this->db->escape_str($input->material_id)];

    $check = $this->M_material->updateData($data, $where, 'tb_material');
    if ($check["success"] === TRUE) {
      $this->session->set_flashdata('pesan', '<script>sweet("Sukses", "Data material berhasil di edit", "success", "tutup")</script>');
      redirect('material');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query failed!", "error", "tutup")</script>');
      redirect('view_material_edit/'.$input->material_id);
    }
  }

	public function process_material_delete($id)
	{
		$material_id = (int)$this->db->escape_str($id);
		$check = $this->M_material->deleteData(["material_id" => $material_id], "tb_material");
		if ($check) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses","Data material berhasil dihapus!","success","Tutup")</script>');
			redirect("material");
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal","Query failed!","success","Tutup")</script>');
			redirect("material");
		}
	}

	public function export_material()
	{
		$list_material = $this->M_data->getData("tb_material")->result();

		$spreadsheet = new Spreadsheet;

		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'No.')
		->setCellValue('B1', 'Kode material')
		->setCellValue('C1', 'Nama material')
		->setCellValue('D1', 'Stok material');

		$kolom = 2;
		$nomor = 1;
		foreach ($list_material as $item) {
			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A' . $kolom, $nomor)
				->setCellValue('B' . $kolom, $item->material_kode)
				->setCellValue('C' . $kolom, $item->material_nama)
				->setCellValue('D' . $kolom, $item->material_stok);
			$kolom++;
			$nomor++;
		}


		$writer = new Xlsx($spreadsheet);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data_material.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function import_material()
	{
		include APPPATH . 'third_party/PHPExcel/PHPExcel.php';
		$config['upload_path'] = realpath('./vendor/file/');
		$config['allowed_types'] = 'xlsx|xls|csv';
		$config['max_size'] = '1000000000';
		$config['encrypt_name'] = true;

		$this->load->library('upload');
		$this->upload->initialize($config);

		if (!$this->upload->do_upload('import_material')) {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal upload!","File excel gagal diupload!","error","Tutup")</script>');
			redirect('material');
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
						"material_kode" => $row["B"],
						"material_nama" => $row["C"],
						"material_stok" => $row["D"],
					));
				}
				$numrow++;
			}

			//delete file from server
			unlink(realpath('./vendor/file/' . $data_upload['file_name']));
			$this->db->insert_batch('tb_material', $data);
			//upload success
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses upload!","File berhasil diupload!","success","Tutup")</script>');
			//redirect halaman
			redirect('material');
		}
	}

}
