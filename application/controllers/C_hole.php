<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
require('./application/third_party/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class C_hole extends CI_Controller {

  public function __construct()
  {
    parent::__construct();  
		protek_login();
  }

  public function index()
  {
		$this->form_validation->set_rules('hole_nama', 'Nama Hole', 'required');

		if ($this->form_validation->run() != FALSE) {
			$input = (object) $this->input->post();
			$this->process_hole_add($input);
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Lengakpi form tambah hole", "error", "tutup")</script>');
			redirect('hole');
		} else {
			$data = [
				'title' => 'Hole',
				'menu' => $this->M_menu->get_access_menu()->result_array(),
				'user' => $this->M_hole->editData(['user_id' => $this->session->userdata('admin_id')], 'tb_user')->row(),
				'list_hole' => $this->M_hole->getData('tb_hole')->result(),
				'total_hole' => $this->M_data->getData("tb_hole")->num_rows(),
			];
			$this->load->view('template/v_head', $data);
			$this->load->view('admin/hole/v_hole', $data);
			$this->load->view('template/v_footer');
		}
  }

	private function process_hole_add($input)
	{
		$data = [
			'hole_nama' => $this->db->escape_str($input->hole_nama),
		];
		$check = $this->M_hole->insertData($data, 'tb_hole');
		if ($check["success"] === TRUE) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses menambahkan", "Data hole sukses ditambah", "success", "tutup")</script>');
			redirect("hole");
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal menambahkan", "Query failed", "error", "tutup")</script>');
			redirect("hole");
		}
	}

  public function view_hole_edit($id)
  {
    $hole_id = (int)$this->db->escape_str($id);
    $check = $this->M_hole->editData(['hole_id' => $hole_id],'tb_hole');
    if ($check) {
      $data = [
        'title' => 'Edit Hole',
        'menu' => $this->M_menu->get_access_menu()->result_array(),
        'user' => $this->M_hole->editData(['user_id' => $this->session->userdata('admin_id')],'tb_user')->row(),
        'hole_item' => $check->row()
      ];
      $this->load->view('template/v_head', $data);
      $this->load->view('admin/hole/v_editHole', $data);
      $this->load->view('template/v_footer');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query Failed", "error", "tutup")</script>');
      redirect('hole');
    }
  }

  public function process_hole_edit()
  {
    $this->form_validation->set_rules('hole_nama', 'Hole', 'required');
		$hole_id = $this->input->post('hole_id');

    if ($this->form_validation->run() != FALSE) {
      $this->process_hole_edit_act();
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Masukan data dengan benar dan lengkap!", "error", "tutup")</script>');
      redirect('view_hole_edit/'. $hole_id);
    }
  }

  private function process_hole_edit_act()
  {
    $input = (object) $this->input->post();
    $data = [
			'hole_nama' => $this->db->escape_str($input->hole_nama),
		];
    $where = ['hole_id' => $this->db->escape_str($input->hole_id)];

    $check = $this->M_hole->updateData($data, $where, 'tb_hole');
    if ($check["success"] === TRUE) {
      $this->session->set_flashdata('pesan', '<script>sweet("Sukses", "Data hole berhasil di edit", "success", "tutup")</script>');
      redirect('hole');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query failed!", "error", "tutup")</script>');
      redirect('view_hole_edit/'.$input->hole_id);
    }
  }

	public function process_hole_delete($id)
	{
		$hole_id = (int)$this->db->escape_str($id);
		$check = $this->M_hole->deleteData(["hole_id" => $hole_id], "tb_hole");
		if ($check) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses","Data hole berhasil dihapus!","success","Tutup")</script>');
			redirect("hole");
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal","Query failed!","success","Tutup")</script>');
			redirect("hole");
		}
	}

	public function export_hole()
	{
		$list_hole = $this->M_data->getData("tb_hole")->result();

		$spreadsheet = new Spreadsheet;

		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'No.')
			->setCellValue('B1', 'Nama hole');

		$kolom = 2;
		$nomor = 1;
		foreach ($list_hole as $item) {
			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A' . $kolom, $nomor)
				->setCellValue('B' . $kolom, $item->hole_nama);
			$kolom++;
			$nomor++;
		}


		$writer = new Xlsx($spreadsheet);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data_hole.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function import_hole()
	{
		include APPPATH . 'third_party/PHPExcel/PHPExcel.php';
		$config['upload_path'] = realpath('./vendor/file/');
		$config['allowed_types'] = 'xlsx|xls|csv';
		$config['max_size'] = '1000000000';
		$config['encrypt_name'] = true;

		$this->load->library('upload');
		$this->upload->initialize($config);

		if (!$this->upload->do_upload('import_hole')) {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal upload!","File excel gagal diupload!","error","Tutup")</script>');
			redirect('hole');
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
						"hole_nama" => $row["B"],
					));
				}
				$numrow++;
			}

			//delete file from server
			unlink(realpath('./vendor/file/' . $data_upload['file_name']));
			$this->db->insert_batch('tb_hole', $data);
			//upload success
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses upload!","File berhasil diupload!","success","Tutup")</script>');
			//redirect halaman
			redirect('hole');
		}
	}


}
