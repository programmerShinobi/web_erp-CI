<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
require('./application/third_party/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class C_tool extends CI_Controller {

  public function __construct()
  {
    parent::__construct();  
		protek_login();
  }

  public function index()
  {
		$this->form_validation->set_rules('tool_nama', 'Nama Tool', 'required');
		$this->form_validation->set_rules('tool_kode', 'kode Tool', 'required');

		if ($this->form_validation->run() != FALSE) {
			$input = (object) $this->input->post();
			$this->process_tool_add($input);
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Lengakpi form tambah tool", "error", "tutup")</script>');
			redirect('tool');
		} else {
			$data = [
				'title' => 'Tool',
				'menu' => $this->M_menu->get_access_menu()->result_array(),
				'user' => $this->M_tool->editData(['user_id' => $this->session->userdata('admin_id')], 'tb_user')->row(),
				'list_tool' => $this->M_tool->getData('tb_tool')->result(),
				'total_tool' => $this->M_data->getData("tb_tool")->num_rows(),
			];
			$this->load->view('template/v_head', $data);
			$this->load->view('admin/tool/v_tool', $data);
			$this->load->view('template/v_footer');
		}
  }

	private function process_tool_add($input)
	{
		$data = [
			'tool_kode' => $this->db->escape_str($input->tool_kode),
			'tool_nama' => $this->db->escape_str($input->tool_nama)
		];
		$check = $this->M_tool->insertData($data, 'tb_tool');
		if ($check["success"] === TRUE) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses menambahkan", "Data tool sukses ditambah", "success", "tutup")</script>');
			redirect("tool");
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal menambahkan", "Query failed", "error", "tutup")</script>');
			redirect("tool");
		}
	}

  public function view_tool_edit($id)
  {
    $tool_id = (int)$this->db->escape_str($id);
    $check = $this->M_tool->editData(['tool_id' => $tool_id],'tb_tool');
    if ($check) {
      $data = [
        'title' => 'Edit Tool',
        'menu' => $this->M_menu->get_access_menu()->result_array(),
        'user' => $this->M_tool->editData(['user_id' => $this->session->userdata('admin_id')],'tb_user')->row(),
        'tool_item' => $check->row()
      ];
      $this->load->view('template/v_head', $data);
      $this->load->view('admin/tool/v_editTool', $data);
      $this->load->view('template/v_footer');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query Failed", "error", "tutup")</script>');
      redirect('tool');
    }
  }

  public function process_tool_edit()
  {
    $this->form_validation->set_rules('tool_nama', 'Nama Tool', 'required');
		$this->form_validation->set_rules('tool_kode', 'Kode Tool', 'required');
		$tool_id = $this->input->post('tool_id');

    if ($this->form_validation->run() != FALSE) {
      $this->process_tool_edit_act();
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Masukan data dengan benar dan lengkap!", "error", "tutup")</script>');
      redirect('view_tool_edit/'. $tool_id);
    }
  }

  private function process_tool_edit_act()
  {
    $input = (object) $this->input->post();
    $data = [
			'tool_nama' => $this->db->escape_str($input->tool_nama),
			'tool_kode' => $this->db->escape_str($input->tool_kode)
		];
    $where = ['tool_id' => $this->db->escape_str($input->tool_id)];

    $check = $this->M_tool->updateData($data, $where, 'tb_tool');
    if ($check["success"] === TRUE) {
      $this->session->set_flashdata('pesan', '<script>sweet("Sukses", "Data tool berhasil di edit", "success", "tutup")</script>');
      redirect('tool');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query failed!", "error", "tutup")</script>');
      redirect('view_tool_edit/'.$input->tool_id);
    }
  }

	public function process_tool_delete($id)
	{
		$tool_id = (int)$this->db->escape_str($id);
		$check = $this->M_tool->deleteData(["tool_id" => $tool_id], "tb_tool");
		if ($check) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses","Data tool berhasil dihapus!","success","Tutup")</script>');
			redirect("tool");
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal","Query failed!","success","Tutup")</script>');
			redirect("tool");
		}
	}

	public function export_tool()
	{
		$list_tool = $this->M_data->getData("tb_tool")->result();

		$spreadsheet = new Spreadsheet;

		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'No.')
		->setCellValue('B1', 'Kode Tool')
		->setCellValue('C1', 'Nama Tool');

		$kolom = 2;
		$nomor = 1;
		foreach ($list_tool as $item) {
			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A' . $kolom, $nomor)
				->setCellValue('B' . $kolom, $item->tool_kode)
				->setCellValue('C' . $kolom, $item->tool_nama);
			$kolom++;
			$nomor++;
		}


		$writer = new Xlsx($spreadsheet);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data_tool.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function import_tool()
	{
		include APPPATH . 'third_party/PHPExcel/PHPExcel.php';
		$config['upload_path'] = realpath('./vendor/file/');
		$config['allowed_types'] = 'xlsx|xls|csv';
		$config['max_size'] = '1000000000';
		$config['encrypt_name'] = true;

		$this->load->library('upload');
		$this->upload->initialize($config);

		if (!$this->upload->do_upload('import_tool')) {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal upload!","File excel gagal diupload!","error","Tutup")</script>');
			redirect('tool');
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
						"tool_kode" => $row["B"],
						"tool_nama" => $row["C"],
					));
				}
				$numrow++;
			}

			//delete file from server
			unlink(realpath('./vendor/file/' . $data_upload['file_name']));
			$this->db->insert_batch('tb_tool', $data);
			//upload success
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses upload!","File berhasil diupload!","success","Tutup")</script>');
			//redirect halaman
			redirect('tool');
		}
	}

}
