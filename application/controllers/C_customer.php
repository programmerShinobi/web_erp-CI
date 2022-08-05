<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
require('./application/third_party/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class C_customer extends CI_Controller {

  public function __construct()
  {
    parent::__construct();  
		protek_login();
  }

  public function index()
  {
		$this->form_validation->set_rules('customer_kode', 'Kode Customer', 'required');
		$this->form_validation->set_rules('customer_nama', 'Nama Customer', 'required');
		$this->form_validation->set_rules('customer_alamat', 'Alamat Customer', 'required');

		if ($this->form_validation->run() != FALSE) {
			$input = (object) $this->input->post();
			$this->process_customer_add($input);
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal menambahkan customer", "Lengkapi form tambah customer", "error", "tutup")</script>');
		
		} else {
			$data = [
				'title' => 'Customer',
				'menu' => $this->M_menu->get_access_menu()->result_array(),
				'user' => $this->M_customer->editData(['user_id' => $this->session->userdata('admin_id')], 'tb_user')->row(),
				'list_customer' => $this->M_customer->getData('tb_customer')->result(),
				'total_customer' => $this->M_data->getData("tb_customer")->num_rows(),
				'total_customer' => $this->M_data->getData("tb_customer")->num_rows(),
			];
			$this->load->view('template/v_head', $data);
			$this->load->view('admin/customer/v_customer', $data);
			$this->load->view('template/v_footer');
		}
  }

	private function process_customer_add($input)
	{
		$CustomerCode = $this->M_customer->getData('tb_customer')->result();
		foreach ($CustomerCode as $item){
			if ($item->customer_kode != $input->customer_kode) {
				$data = [
					'customer_kode' => $this->db->escape_str($input->customer_kode),
					'customer_nama' => $this->db->escape_str($input->customer_nama),
					'customer_alamat' => $this->db->escape_str($input->customer_alamat)
				];

				$check = $this->M_customer->insertData($data, 'tb_customer');
				if ($check["success"] === TRUE) {
					$this->session->set_flashdata('pesan', '<script>sweet("Sukses menambahkan customer", "Data customer sukses ditambah", "success", "tutup")</script>');
					redirect("customer");
				} else {
					$this->session->set_flashdata('pesan', '<script>sweet("Gagal menambahkan customer", "Query failed", "error", "tutup")</script>');
					redirect("customer");
				}
			} else {
				$this->session->set_flashdata('pesan', '<script>sweet("Gagal menambahkan customer", "Kode customer sudah terdaftar", "error", "tutup")</script>');
				redirect("customer");
			}
		}
	}

  public function view_customer_edit($id)
  {
    $customer_id = (int)$this->db->escape_str($id);
    $check = $this->M_customer->editData(['customer_id' => $customer_id],'tb_customer');
    if ($check) {
      $data = [
        'title' => 'Edit Customer',
        'menu' => $this->M_menu->get_access_menu()->result_array(),
        'user' => $this->M_customer->editData(['user_id' => $this->session->userdata('admin_id')],'tb_user')->row(),
        'customer_item' => $check->row()
      ];
      $this->load->view('template/v_head', $data);
      $this->load->view('admin/customer/v_editCustomer', $data);
      $this->load->view('template/v_footer');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query Failed", "error", "tutup")</script>');
      redirect('customer');
    }
  }

  public function process_customer_edit()
  {
    $this->form_validation->set_rules('customer_nama', 'Customer', 'required');
		$customer_id = $this->input->post('customer_id');

    if ($this->form_validation->run() != FALSE) {
      $this->process_customer_edit_act();
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Masukan data dengan benar dan lengkap!", "error", "tutup")</script>');
      redirect('view_customer_edit/'. $customer_id);
    }
  }

  private function process_customer_edit_act()
  {
    $input = (object) $this->input->post();
    $data = [
			'customer_nama' => $this->db->escape_str($input->customer_nama),
			'customer_alamat' => $this->db->escape_str($input->customer_alamat)
		];
    $where = ['customer_id' => $this->db->escape_str($input->customer_id)];

    $check = $this->M_customer->updateData($data, $where, 'tb_customer');
    if ($check["success"] === TRUE) {
      $this->session->set_flashdata('pesan', '<script>sweet("Sukses", "Data customer berhasil di edit", "success", "tutup")</script>');
      redirect('customer');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query failed!", "error", "tutup")</script>');
      redirect('view_customer_edit/'.$input->customer_id);
    }
  }

	public function process_customer_delete($id)
	{
		$customer_id = (int)$this->db->escape_str($id);
		$check = $this->M_customer->deleteData(["customer_id" => $customer_id], "tb_customer");
		if ($check) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses","Data customer berhasil dihapus!","success","Tutup")</script>');
			redirect("customer");
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal","Query failed!","success","Tutup")</script>');
			redirect("customer");
		}
	}

	public function export_customer()
	{
		$list_customer = $this->M_data->getData("tb_customer")->result();

		$spreadsheet = new Spreadsheet;

		$spreadsheet->setActiveSheetIndex(0)
		->setCellValue('A1', 'No.')
		->setCellValue('B1', 'Kode Customer')
		->setCellValue('C1', 'Nama Customer');

		$kolom = 2;
		$nomor = 1;
		foreach ($list_customer as $item) {
			$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A' . $kolom, $nomor)
				->setCellValue('B' . $kolom, $item->customer_kode)
				->setCellValue('C' . $kolom, $item->customer_nama);
			$kolom++;
			$nomor++;
		}


		$writer = new Xlsx($spreadsheet);

		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="Data_customer.xlsx"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function import_customer()
	{
		include APPPATH . 'third_party/PHPExcel/PHPExcel.php';
		$config['upload_path'] = realpath('./vendor/file/');
		$config['allowed_types'] = 'xlsx|xls|csv';
		$config['max_size'] = '1000000000';
		$config['encrypt_name'] = true;

		$this->load->library('upload');
		$this->upload->initialize($config);

		if (!$this->upload->do_upload('import_customer')) {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal upload!","File excel gagal diupload!","error","Tutup")</script>');
			redirect('customer');
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
						"customer_kode" => $row["B"],
						"customer_nama" => $row["C"],
					));
				}
				$numrow++;
			}

			//delete file from server
			unlink(realpath('./vendor/file/' . $data_upload['file_name']));
			$this->db->insert_batch('tb_customer', $data);
			//upload success
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses upload!","File berhasil diupload!","success","Tutup")</script>');
			//redirect halaman
			redirect('customer');
		}
	}
}
