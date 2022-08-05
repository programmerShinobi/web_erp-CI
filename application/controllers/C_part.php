<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
require('./application/third_party/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class C_part extends CI_Controller {

  public function __construct()
  {
    parent::__construct();  
		protek_login();
  }

  public function index()
  {
		$this->form_validation->set_rules('part_nama', 'Nama Part', 'required');
		$this->form_validation->set_rules('part_kode', 'Kode Part', 'required');

		if ($this->form_validation->run() != FALSE) {
			$input = (object) $this->input->post();
			$this->process_part_add($input);
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Lengakpi form tambah part", "error", "tutup")</script>');
			redirect('part');
		} else {
			$data = [
				'title' => 'Part',
				'menu' => $this->M_menu->get_access_menu()->result_array(),
				'user' => $this->M_part->editData(['user_id' => $this->session->userdata('admin_id')], 'tb_user')->row(),
				'list_part' => $this->M_part->getData('tb_part')->result(),
				'total_part' => $this->M_data->getData("tb_part")->num_rows(),
			];
			$this->load->view('template/v_head', $data);
			$this->load->view('admin/part/v_part', $data);
			$this->load->view('template/v_footer');
		}
  }

	private function process_part_add($input)
	{
		$data = [
			'part_kode' => $this->db->escape_str($input->part_kode),
			'part_nama' => $this->db->escape_str($input->part_nama),
		];
		$check = $this->M_part->insertData($data, 'tb_part');
		if ($check["success"] === TRUE) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses menambahkan", "Data part sukses ditambah", "success", "tutup")</script>');
			redirect("part");
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal menambahkan", "Query failed", "error", "tutup")</script>');
			redirect("part");
		}
	}

  public function view_part_edit($id)
  {
    $part_id = (int)$this->db->escape_str($id);
    $check = $this->M_part->editData(['part_id' => $part_id],'tb_part');
    if ($check) {
      $data = [
        'title' => 'Edit Part',
        'menu' => $this->M_menu->get_access_menu()->result_array(),
        'user' => $this->M_part->editData(['user_id' => $this->session->userdata('admin_id')],'tb_user')->row(),
        'part_item' => $check->row()
      ];
      $this->load->view('template/v_head', $data);
      $this->load->view('admin/part/v_editPart', $data);
      $this->load->view('template/v_footer');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query Failed", "error", "tutup")</script>');
      redirect('part');
    }
  }

  public function process_part_edit()
  {
    $this->form_validation->set_rules('part_nama', 'part', 'required');
	$part_id = $this->input->post('part_id');

    if ($this->form_validation->run() != FALSE) {
      $this->process_part_edit_act();
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Masukan data dengan benar dan lengkap!", "error", "tutup")</script>');
      redirect('view_part_edit/'. $part_id);
    }
  }

  private function process_part_edit_act()
  {
    $input = (object) $this->input->post();
    $data = [
			'part_nama' => $this->db->escape_str($input->part_nama),
		];
    $where = ['part_id' => $this->db->escape_str($input->part_id)];

    $check = $this->M_part->updateData($data, $where, 'tb_part');
    if ($check["success"] === TRUE) {
      $this->session->set_flashdata('pesan', '<script>sweet("Sukses", "Menu berhasil di edit", "success", "tutup")</script>');
      redirect('part');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query failed!", "error", "tutup")</script>');
      redirect('view_part_edit/'.$input->part_id);
    }
  }

	public function process_part_delete($id)
	{
		$part_id = (int)$this->db->escape_str($id);
		$check = $this->M_part->deleteData(["part_id" => $part_id], "tb_part");
		if ($check) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses","Data Part berhasil dihapus!","success","Tutup")</script>');
			redirect("part");
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal","Query failed!","success","Tutup")</script>');
			redirect("part");
		}
	}

	public function export_part()
	{
		$list_part = $this->M_data->getData("tb_part")->result();

		$spreadsheet = new Spreadsheet;

		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'No.')
			->setCellValue('B1', 'Kode Part')
			->setCellValue('C1', 'Nama Part');

		$kolom = 2;
		$nomor = 1;
		foreach ($list_part as $item) {
			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A' . $kolom, $nomor)
				->setCellValue('B' . $kolom, $item->part_kode)
				->setCellValue('C' . $kolom, $item->part_nama);
			$kolom++;
			$nomor++;
		}


		$writer = new Xlsx($spreadsheet);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data_part.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function import_part()
	{
		include APPPATH . 'third_party/PHPExcel/PHPExcel.php';
		$config['upload_path'] = realpath('./vendor/file/');
		$config['allowed_types'] = 'xlsx|xls|csv';
		$config['max_size'] = '1000000000';
		$config['encrypt_name'] = true;

		$this->load->library('upload');
		$this->upload->initialize($config);

		if (!$this->upload->do_upload('import_part')) {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal upload!","File excel gagal diupload!","error","Tutup")</script>');
			redirect('part');
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
						"part_kode" => $row["B"],
						"part_nama" => $row["C"],
					));
				}
				$numrow++;
			}

			//delete file from server
			unlink(realpath('./vendor/file/' . $data_upload['file_name']));
			$this->db->insert_batch('tb_part', $data);
			//upload success
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses upload!","File berhasil diupload!","success","Tutup")</script>');
			//redirect halaman
			redirect('part');
		}
	}


}
