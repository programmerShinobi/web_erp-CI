<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
require('./application/third_party/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class C_model extends CI_Controller {

  public function __construct()
  {
    parent::__construct();  
		protek_login();
  }

  public function index()
  {
		$this->form_validation->set_rules('model_nama', 'Nama model', 'required');
		$this->form_validation->set_rules('model_kode', 'Kode model', 'required');

		if ($this->form_validation->run() != FALSE) {
			$input = (object) $this->input->post();
			$this->process_model_add($input);
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Lengakpi form tambah model", "error", "tutup")</script>');
			redirect('model');
		} else {
			$data = [
				'title' => 'Model',
				'menu' => $this->M_menu->get_access_menu()->result_array(),
				'user' => $this->M_model->editData(['user_id' => $this->session->userdata('admin_id')], 'tb_user')->row(),
				'list_model' => $this->M_model->getData('tb_model')->result(),
				'total_model' => $this->M_data->getData("tb_model")->num_rows(),
			];
			$this->load->view('template/v_head', $data);
			$this->load->view('admin/model/v_model', $data);
			$this->load->view('template/v_footer');
		}
  }

	private function process_model_add($input)
	{
		$data = [
			'model_kode' => $this->db->escape_str($input->model_kode),
			'model_nama' => $this->db->escape_str($input->model_nama),
		];
		$check = $this->M_model->insertData($data, 'tb_model');
		if ($check["success"] === TRUE) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses menambahkan", "Data model sukses ditambah", "success", "tutup")</script>');
			redirect("model");
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal menambahkan", "Query failed", "error", "tutup")</script>');
			redirect("model");
		}
	}

  public function view_model_edit($id)
  {
    $model_id = (int)$this->db->escape_str($id);
    $check = $this->M_model->editData(['model_id' => $model_id],'tb_model');
    if ($check) {
      $data = [
        'title' => 'Edit Model',
        'menu' => $this->M_menu->get_access_menu()->result_array(),
        'user' => $this->M_model->editData(['user_id' => $this->session->userdata('admin_id')],'tb_user')->row(),
        'model_item' => $check->row()
      ];
      $this->load->view('template/v_head', $data);
      $this->load->view('admin/model/v_editModel', $data);
      $this->load->view('template/v_footer');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query Failed", "error", "tutup")</script>');
      redirect('model');
    }
  }

  public function process_model_edit()
  {
    $this->form_validation->set_rules('model_nama', 'model', 'required');
	$model_id = $this->input->post('model_id');

    if ($this->form_validation->run() != FALSE) {
      $this->process_model_edit_act();
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Masukan data dengan benar dan lengkap!", "error", "tutup")</script>');
      redirect('view_model_edit/'. $model_id);
    }
  }

  private function process_model_edit_act()
  {
    $input = (object) $this->input->post();
    $data = [
			'model_nama' => $this->db->escape_str($input->model_nama),
		];
    $where = ['model_id' => $this->db->escape_str($input->model_id)];

    $check = $this->M_model->updateData($data, $where, 'tb_model');
    if ($check["success"] === TRUE) {
      $this->session->set_flashdata('pesan', '<script>sweet("Sukses", "Data Model berhasil di edit", "success", "tutup")</script>');
      redirect('model');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query failed!", "error", "tutup")</script>');
      redirect('view_model_edit/'.$input->model_id);
    }
  }

	public function process_model_delete($id)
	{
		$model_id = (int)$this->db->escape_str($id);
		$check = $this->M_model->deleteData(["model_id" => $model_id], "tb_model");
		if ($check) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses","Data model berhasil dihapus!","success","Tutup")</script>');
			redirect("model");
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal","Query failed!","success","Tutup")</script>');
			redirect("model");
		}
	}

	public function export_model()
	{
		$list_model = $this->M_data->getData("tb_model")->result();

		$spreadsheet = new Spreadsheet;

		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'No.')
			->setCellValue('B1', 'Kode model')
			->setCellValue('C1', 'Nama model');

		$kolom = 2;
		$nomor = 1;
		foreach ($list_model as $item) {
			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A' . $kolom, $nomor)
				->setCellValue('B' . $kolom, $item->model_kode)
				->setCellValue('C' . $kolom, $item->model_nama);
			$kolom++;
			$nomor++;
		}


		$writer = new Xlsx($spreadsheet);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data_model.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function import_model()
	{
		include APPPATH . 'third_party/PHPExcel/PHPExcel.php';
		$config['upload_path'] = realpath('./vendor/file/');
		$config['allowed_types'] = 'xlsx|xls|csv';
		$config['max_size'] = '1000000000';
		$config['encrypt_name'] = true;

		$this->load->library('upload');
		$this->upload->initialize($config);

		if (!$this->upload->do_upload('import_model')) {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal upload!","File excel gagal diupload!","error","Tutup")</script>');
			redirect('model');
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
						"model_kode" => $row["B"],
						"model_nama" => $row["C"],
					));
				}
				$numrow++;
			}

			//delete file from server
			unlink(realpath('./vendor/file/' . $data_upload['file_name']));
			$this->db->insert_batch('tb_model', $data);
			//upload success
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses upload!","File berhasil diupload!","success","Tutup")</script>');
			//redirect halaman
			redirect('model');
		}
	}


}
