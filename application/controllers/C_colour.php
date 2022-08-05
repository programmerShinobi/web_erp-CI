<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
require('./application/third_party/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class C_colour extends CI_Controller {

	public function __construct()
	{
		parent::__construct();  
			protek_login();
	}

	public function index()
	{
			$this->form_validation->set_rules('colour_nama', 'Nama Colour', 'required');

			if ($this->form_validation->run() != FALSE) {
				$input = (object) $this->input->post();
				$this->process_colour_add($input);
				$this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Lengakpi form tambah colour", "error", "tutup")</script>');
				redirect('colour');
			} else {
				$data = [
					'title' => 'Colour',
					'menu' => $this->M_menu->get_access_menu()->result_array(),
					'user' => $this->M_colour->editData(['user_id' => $this->session->userdata('admin_id')], 'tb_user')->row(),
					'list_colour' => $this->M_colour->getData('tb_colour')->result(),
					'total_colour' => $this->M_data->getData("tb_colour")->num_rows(),
				];
				$this->load->view('template/v_head', $data);
				$this->load->view('admin/colour/v_colour', $data);
				$this->load->view('template/v_footer');
			}
	}

	private function process_colour_add($input)
	{
		$data = [
			'colour_nama' => $this->db->escape_str($input->colour_nama),
		];
		$check = $this->M_colour->insertData($data, 'tb_colour');
		if ($check["success"] === TRUE) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses menambahkan", "Data colour sukses ditambah", "success", "tutup")</script>');
			redirect("colour");
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal menambahkan", "Query failed", "error", "tutup")</script>');
			redirect("colour");
		}
	}

	public function view_colour_edit($id)
	{
		$colour_id = (int)$this->db->escape_str($id);
		$check = $this->M_colour->editData(['colour_id' => $colour_id],'tb_colour');
		if ($check) {
		$data = [
			'title' => 'Edit Colour',
			'menu' => $this->M_menu->get_access_menu()->result_array(),
			'user' => $this->M_colour->editData(['user_id' => $this->session->userdata('admin_id')],'tb_user')->row(),
			'colour_item' => $check->row()
		];
		$this->load->view('template/v_head', $data);
		$this->load->view('admin/colour/v_editColour', $data);
		$this->load->view('template/v_footer');
		} else {
		$this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query Failed", "error", "tutup")</script>');
		redirect('colour');
		}
	}

	public function process_colour_edit()
	{
		$this->form_validation->set_rules('colour_nama', 'Colour', 'required');
			$colour_id = $this->input->post('colour_id');

		if ($this->form_validation->run() != FALSE) {
		$this->process_colour_edit_act();
		} else {
		$this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Masukan data dengan benar dan lengkap!", "error", "tutup")</script>');
		redirect('view_colour_edit/'. $colour_id);
		}
	}

	private function process_colour_edit_act()
	{
		$input = (object) $this->input->post();
		$data = [
				'colour_nama' => $this->db->escape_str($input->colour_nama),
			];
		$where = ['colour_id' => $this->db->escape_str($input->colour_id)];

		$check = $this->M_colour->updateData($data, $where, 'tb_colour');
		if ($check["success"] === TRUE) {
		$this->session->set_flashdata('pesan', '<script>sweet("Sukses", "Data colour berhasil di edit", "success", "tutup")</script>');
		redirect('colour');
		} else {
		$this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query failed!", "error", "tutup")</script>');
		redirect('view_colour_edit/'.$input->colour_id);
		}
	}

	public function process_colour_delete($id)
	{
		$colour_id = (int)$this->db->escape_str($id);
		$check = $this->M_colour->deleteData(["colour_id" => $colour_id], "tb_colour");
		if ($check) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses","Data colour berhasil dihapus!","success","Tutup")</script>');
			redirect("colour");
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal","Query failed!","success","Tutup")</script>');
			redirect("colour");
		}
	}

	public function export_colour()
	{
		$list_colour = $this->M_data->getData("tb_colour")->result();

		$spreadsheet = new Spreadsheet;

		$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A1', 'No.')
			->setCellValue('B1', 'Nama Colour');

		$kolom = 2;
		$nomor = 1;
		foreach ($list_colour as $item) {
			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A' . $kolom, $nomor)
				->setCellValue('B' . $kolom, $item->colour_nama);
			$kolom++;
			$nomor++;
		}


		$writer = new Xlsx($spreadsheet);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data_colour.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function import_colour()
	{
		include APPPATH . 'third_party/PHPExcel/PHPExcel.php';
		$config['upload_path'] = realpath('./vendor/file/');
		$config['allowed_types'] = 'xlsx|xls|csv';
		$config['max_size'] = '1000000000';
		$config['encrypt_name'] = true;

		$this->load->library('upload');
		$this->upload->initialize($config);

		if (!$this->upload->do_upload('import_colour')) {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal upload!","File excel gagal diupload!","error","Tutup")</script>');
			redirect('colour');
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
						"colour_nama" => $row["B"],
					));
				}
				$numrow++;
			}

			//delete file from server
			unlink(realpath('./vendor/file/' . $data_upload['file_name']));
			$this->db->insert_batch('tb_colour', $data);
			//upload success
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses upload!","File berhasil diupload!","success","Tutup")</script>');
			//redirect halaman
			redirect('colour');
		}
	}

}
