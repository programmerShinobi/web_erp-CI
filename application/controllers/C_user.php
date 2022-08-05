<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
require('./application/third_party/phpoffice/vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class C_user extends CI_Controller {

  public function __construct()
  {
    parent::__construct();
    protek_login();
  }

  public function index()
  {
    $data = [
      'title' => 'Data User',
      'menu' => $this->M_menu->get_access_menu()->result_array(),
      'user' => $this->M_user->editData(['user_id' => $this->session->userdata('admin_id')],'tb_user')->row(),
      'pekerjaan' => $this->M_user->getData("tb_klasifikasi")->result(),
			'role' => $this->M_user->getData("tb_role")->result(),
			'list_user' => $this->M_user->getUser()->result(),
			'total_user' => $this->M_user->getData("tb_user")->num_rows(),
			'user_aktif' => $this->M_user->getUserAktif()->result(),
			'user_nonaktif' => $this->M_user->getUserNonaktif()->result(),
			// 'user_aktif' => $this->M_user->editData(['user_backlist' => 0], 'tb_user')->result(),
			// 'user_nonaktif' => $this->M_user->editData(['user_backlist' => 1], 'tb_user')->result(),
    ];
    $this->load->view('template/v_head', $data);
    $this->load->view('admin/user/v_user', $data);
    $this->load->view('template/v_footer');
  }

	public function process_user_check($id)
	{
		$cek = $this->M_user->editData(["user_id" => $id], "tb_user")->row();
		if ($cek->user_backlist == 0) {
			$data = [
				"user_backlist" => 1
			];
		} else {
			$data = [
				"user_backlist" => 0
			];
		}
		$where = ["user_id" => $id];
		$check = $this->M_user->updateData($data, $where, "tb_user");
		if ($check) {
			$this->session->set_flashdata('pesan', '<script>sweet("Sukses", "Status berhasil diubah!", "success", "tutup")</script>');
			redirect('user');
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query failed!", "error", "tutup")</script>');
			redirect('user');
		}
	}

  public function validation_user_add()
  {
    $this->form_validation->set_rules('user_nama', 'User', 'required');
    $this->form_validation->set_rules('user_tempatLahir', 'User', 'required');
    $this->form_validation->set_rules('user_tanggalLahir', 'User', 'required');
    $this->form_validation->set_rules('user_klasifikasi', 'User', 'required');
		$this->form_validation->set_rules('user_role', 'User', 'required');
    $this->form_validation->set_rules('user_ktp', 'User', 'required|numeric');
    $this->form_validation->set_rules('user_username', 'User', 'required');
    $this->form_validation->set_rules('user_password', 'User', 'required');
    $this->form_validation->set_rules('user_noHP', 'User', 'required|numeric');
    $this->form_validation->set_rules('user_email', 'User', 'required|valid_email|is_unique[tb_user.user_email]');
    $this->form_validation->set_rules('orangtua_nama', 'User', 'required');
    $this->form_validation->set_rules('orangtua_noHP', 'User', 'required|numeric');
    $this->form_validation->set_rules('orangtua_tempatLahir', 'User', 'required');
    $this->form_validation->set_rules('orangtua_tanggalLahir', 'User', 'required');
    $this->form_validation->set_rules('pertanyaan', 'User', 'required');
    $this->form_validation->set_rules('jawaban', 'User', 'required');
    
    if ($this->form_validation->run() == FALSE) {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal menambah", "Dikarenakan data tidak lengkap/email user sudah terdaftar!", "error", "tutup")</script>');
      redirect("user");
    } else {
      $this->process_user_add();
    }
  }

  private function process_user_add()
  {
    $input = (object)$this->db->escape_str($this->input->post());
    $user_id = html_escape($this->input->post('user_noId', true));
    //$user_id = rand(1, 1000000);
    $this->load->library('ciqrcode');

    $config['cacheable']    = true; //boolean, the default is true
    $config['cachedir']     = './vendor/'; //string, the default is application/cache/
    $config['errorlog']     = './vendor/'; //string, the default is application/logs/
    $config['imagedir']     = './vendor/img/qr/'; //direktori penyimpanan qr code
    $config['quality']      = true; //boolean, the default is true
    $config['size']         = '512'; //interger, the default is 1024
    $config['black']        = array(224,255,255); // array, default is array(255,255,255)
    $config['white']        = array(70,130,180); // array, default is array(0,0,0)
    $this->ciqrcode->initialize($config);

		$image_name=$user_id.'.png'; //buat name dari qr code sesuai dengan nim
		
		$dataqr = $user_id;

    $params['data'] = $dataqr; //data yang akan di jadikan QR CODE
    $params['level'] = 'H'; //H=High
    $params['size'] = 10;
    $params['savename'] = $config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
    $this->ciqrcode->generate($params);

    $data1 = [
      'user_noId' => $user_id,
      'user_nama' => $input->user_nama,
      'user_tempatLahir' => $input->user_tempatLahir,
      'user_tanggalLahir' => $input->user_tanggalLahir,
      'user_klasifikasi' => $input->user_klasifikasi,
			'user_role' => $input->user_role,
      'user_ktp' => $input->user_ktp,
      'user_foto' => "default.jpg",
      'user_username' => $input->user_username,
      'user_password' => password_hash($input->user_password, PASSWORD_DEFAULT),
			'user_alamat' => $input->user_alamat,
      'user_noHP' => $input->user_noHP,
      'user_email' => $input->user_email,
      'user_qr' => $image_name
    ];
    $query = $this->M_user->insertData($data1, "tb_user");
    $user_id = $this->db->insert_id();
    if ($query) {
      $data2 = [
        'orangtua_user' => $user_id,
        'orangtua_nama' => $input->orangtua_nama,
        'orangtua_tempatLahir' => $input->orangtua_tempatLahir,
        'orangtua_tanggalLahir' => $input->orangtua_tanggalLahir,
        'orangtua_noHP' => $input->orangtua_noHP
      ];
      $query2 = $this->M_user->insertData($data2, "tb_identitas_orangtua");
      if ($query2) {
        $data3 = [
          'pertanyaan_user' => $user_id,
          'pertanyaan' => $input->pertanyaan,
          'pertanyaan_jawaban' => $input->jawaban
        ];
        $query3 = $this->M_user->insertData($data3, "tb_pertanyaan_keamanan");
        if ($query3) {
          $this->session->set_flashdata('pesan', '<script>sweet("Sukses menambah", "Data petugas berhasil ditambah!", "success", "tutup")</script>');
          redirect("user");
        } else {
          $this->session->set_flashdata('pesan', '<script>sweet("Gagal menambah", "Query3 failed!", "success", "tutup")</script>');
          redirect("user");
        }
      } else {
        $this->session->set_flashdata('pesan', '<script>sweet("Gagal menambah", "Query2 failed!", "success", "tutup")</script>');
        redirect("user");
      }
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal menambah", "Query1 failed!", "success", "tutup")</script>');
      redirect("user");
    }
  }

  public function view_user_edit($id)
  {
    $user_id = (int)$this->db->escape_str($id);
    $check = $this->M_user->get_user_detail($user_id);
    if ($check) {
      $data = [
        'title' => 'Data User',
        'menu' => $this->M_menu->get_access_menu()->result_array(),
        'user' => $this->M_user->editData(['user_id' => $this->session->userdata('admin_id')],'tb_user')->row(),
        'user_detail' => $check->row(),
				'pekerjaan' => $this->M_user->getData("tb_klasifikasi")->result(),
				'role' => $this->M_user->getData("tb_role")->result(),
      ];
      $this->load->view('template/v_head', $data);
      $this->load->view('admin/user/v_editUser', $data);
      $this->load->view('template/v_footer');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query failed!", "error", "tutup")</script>');
      redirect("user");
    }
  }

  public function validation_user_edit()
  {
    $this->form_validation->set_rules('user_noId', 'User', 'required|is_unique[tb_user.user_noId]');
    $this->form_validation->set_rules('user_nama', 'User', 'required');
    $this->form_validation->set_rules('user_tempatLahir', 'User', 'required');
    $this->form_validation->set_rules('user_tanggalLahir', 'User', 'required');
    $this->form_validation->set_rules('user_klasifikasi', 'User', 'required');
		$this->form_validation->set_rules('user_role', 'User', 'required');
    $this->form_validation->set_rules('user_ktp', 'User', 'required|numeric');
    $this->form_validation->set_rules('user_username', 'User', 'required');
    $this->form_validation->set_rules('user_noHP', 'User', 'required|numeric');
    $this->form_validation->set_rules('user_email', 'User', 'required|valid_email|is_unique[tb_user.user_email]');
    $this->form_validation->set_rules('orangtua_nama', 'User', 'required');
    $this->form_validation->set_rules('orangtua_noHP', 'User', 'required|numeric');
    $this->form_validation->set_rules('orangtua_tempatLahir', 'User', 'required');
    $this->form_validation->set_rules('orangtua_tanggalLahir', 'User', 'required');
    $this->form_validation->set_rules('pertanyaan', 'User', 'required');
    $this->form_validation->set_rules('jawaban', 'User', 'required');
    $user_id = (int)$this->input->post("user_id");
    
    if ($this->form_validation->run() == FALSE) {
      $this->process_user_update();
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal Update", "Isi data dengan benar & lengkap!", "danger", "tutup")</script>');
      redirect("user_edit/".$user_id);
    }
  }

  private function process_user_update()
  {
    $user_id = (int)$this->input->post("user_id");
    $input = (object)$this->db->escape_str($this->input->post());
    $user_foto = $_FILES["user_foto"]["name"];
    $data = [];
    
    if ($user_foto != "") {
      $check = $this->M_user->editData(["user_id" => $input->user_id], "tb_user")->row();
      // var_dump($input->petugas_id);
      if ($check->user_foto != "default.jpg") {
        unlink("./vendor/img/user/".$check->user_foto);
      }
      $config['upload_path']          = './vendor/img/user/';
      $config['allowed_types']        = 'jpg|png|jpeg';
      $config['max_size']             = 512000;
      $config['max_width']            = 5000;
      $config['max_height']           = 5000;

      $this->load->library('upload');
      $this->upload->initialize($config);
      if (!$this->upload->do_upload('user_foto')) {
        $this->session->set_flashdata('pesan', '<script>sweet("Gagal","Gagal Upload Foto!","error","Tutup")</script>');
        redirect('user_edit/'.$input->user_id);
      }
      $data = ["user_foto" => $user_foto];
      $where = ["user_id" => $input->user_id];
      $query = $this->M_user->updateData($data, $where, "tb_user");
    } 
    if ($input->user_password != "") {
      $data = ["user_password" => password_hash($input->user_password, PASSWORD_DEFAULT)];
      $where = ["user_id" => $input->user_id];
      $query = $this->M_user->updateData($data, $where, "tb_user");
    }

    $user_noId=$input->user_noId;

    $this->load->library('ciqrcode');

    $config['cacheable']    = true; //boolean, the default is true
    $config['cachedir']     = './vendor/'; //string, the default is application/cache/
    $config['errorlog']     = './vendor/'; //string, the default is application/logs/
    $config['imagedir']     = './vendor/img/qr/'; //direktori penyimpanan qr code
    $config['quality']      = true; //boolean, the default is true
    $config['size']         = '512'; //interger, the default is 1024
    $config['black']        = array(224,255,255); // array, default is array(255,255,255)
    $config['white']        = array(70,130,180); // array, default is array(0,0,0)
    $this->ciqrcode->initialize($config);

		$image_name=$user_noId.'.png'; //buat name dari qr code sesuai dengan nim
		
		$dataqr = $user_noId;

    $params['data'] = $dataqr; //data yang akan di jadikan QR CODE
    $params['level'] = 'H'; //H=High
    $params['size'] = 10;
    $params['savename'] = $config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
    $this->ciqrcode->generate($params);

    $data = [
      'user_noId' => $input->user_noId,
      'user_nama' => $input->user_nama,
      'user_tempatLahir' => $input->user_tempatLahir,
      'user_tanggalLahir' => $input->user_tanggalLahir,
      'user_klasifikasi' => $input->user_klasifikasi,
			'user_role' => $input->user_role,
      'user_ktp' => $input->user_ktp,
      'user_username' => $input->user_username,
			'user_alamat' => $input->user_alamat,
      'user_noHP' => $input->user_noHP,
      'user_email' => $input->user_email,
      'user_qr' => $image_name
    ];
    $where1 = ["user_id" => $input->user_id];
    $query = $this->M_user->updateData($data, $where1, "tb_user");
    if ($query) {
      $data2 = [
        'orangtua_nama' => $input->orangtua_nama,
        'orangtua_tempatLahir' => $input->orangtua_tempatLahir,
        'orangtua_tanggalLahir' => $input->orangtua_tanggalLahir,
        'orangtua_noHP' => $input->orangtua_noHP
      ];
      $where2 = ["orangtua_user" => $input->user_id];
      $query2 = $this->M_user->updateData($data2, $where2, "tb_identitas_orangtua");
      if ($query2) {
        $data3 = [
          'pertanyaan' => $input->pertanyaan,
          'pertanyaan_jawaban' => $input->jawaban
        ];
        $where3 = ["pertanyaan_user" => $input->user_id];
        $query3 = $this->M_user->updateData($data3, $where3, "tb_pertanyaan_keamanan");
        if ($query3) {
          $this->session->set_flashdata('pesan', '<script>sweet("Sukses","Data user berhasil diubah!","success","Tutup")</script>');
          redirect("user");
        } else {
          $this->session->set_flashdata('pesan', '<script>sweet("Gagal","Query3 failed!","error","Tutup")</script>');
          redirect('user_edit/'.$input->user_id);
        }
      } else {
        $this->session->set_flashdata('pesan', '<script>sweet("Gagal","Query2 failed!","error","Tutup")</script>');
        redirect('user_edit/'.$input->user_id);
      }
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal","Query1 failed!","error","Tutup")</script>');
      redirect('user_edit/'.$input->user_id);
    }
  }

  public function process_user_delete($id)
  {
    $user_id = (int)$this->db->escape_str($id);
    $get_user = $this->M_user->editData(["user_id" => $user_id], "tb_user")->row();
    unlink("./vendor/img/qr/".$get_user->user_qr);
    $check = $this->M_user->deleteData(["user_id" => $user_id], "tb_user");
    if ($check) {
      $this->M_user->deleteData(["orangtua_user" => $user_id], "tb_identitas_orangtua");
      $this->M_user->deleteData(["pertanyaan_user" => $user_id], "tb_pertanyaan_keamanan");
      $this->session->set_flashdata('pesan', '<script>sweet("Sukses","Data user berhasil dihapus!","success","Tutup")</script>');
      redirect("user");
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal","Query failed!","success","Tutup")</script>');
      redirect("user");
    }
  }

  public function cetakUser($id)
  {
    $data = [
      'title' => 'Cetak Kartu',
      'user' => $this->M_user->editData(['user_id' => $this->session->userdata('id')],'tb_user')->row(),
      'menu' => $this->M_menu->get_access_menu()->result_array(),
      'user' => $this->M_user->editData(['user_id' => (int)$id],'tb_user')->row(),
			'total_user' => $this->M_user->editData(["user_role" => 3], "tb_user")->num_rows(),
    ];
    $this->load->view('admin/v_cetakUser',$data);
  }

	public function cardUser($id)
	{
		$data = [
			'title' => 'Kartu Digital',
			'user' => $this->M_user->editData(['user_id' => $this->session->userdata('id')], 'tb_user')->row(),
			'menu' => $this->M_menu->get_access_menu()->result_array(),
			'user' => $this->M_user->editData(['user_id' => (int)$id], 'tb_user')->row(),
			'total_user' => $this->M_user->editData(["user_role" => 3], "tb_user")->num_rows(),
		];
		$this->load->view('admin/v_cardUser', $data);
	}

  public function view_log_user()
  {
    $data = [
      'title' => 'Log User',
      'menu' => $this->M_menu->get_access_menu()->result_array(),
      'user' => $this->M_user->editData(['user_id' => $this->session->userdata('admin_id')],'tb_user')->row(),
      'log_user' => $this->M_user->get_log()->result()
    ];
    $this->load->view('template/v_head', $data);
    $this->load->view('admin/user/v_logUser', $data);
    $this->load->view('template/v_footer');
  }

  public function export_user()
  {
    $list_user = $this->M_user->getData("tb_user")->result();

    $spreadsheet = new Spreadsheet;

    $spreadsheet->setActiveSheetIndex(0)
      ->setCellValue('A1', 'No.')
      ->setCellValue('B1', 'Kode User')
      ->setCellValue('C1', 'Nama')
      ->setCellValue('D1', 'JK')
      ->setCellValue('E1', 'Klasifikasi')
      ->setCellValue('F1', 'Alamat')
      ->setCellValue('G1', 'Tempat Lahir')
      ->setCellValue('H1', 'Tanggal Lahir')
      ->setCellValue('I1', 'Nomor Handphone')
      ->setCellValue('J1', 'Nomor KTP / Kartu Pelajar')
      ->setCellValue('K1', 'Email')
      ->setCellValue('L1', 'Username')
      ->setCellValue('M1', 'Password')
			->setCellValue('N1', 'Status');

    $kolom = 2;
    $nomor = 1;
    foreach ($list_user as $item) {

      if ($item->user_role == 3) {
        if ($item->user_klasifikasi == 1) {
          $klasifikasi_data = "TK";
        } elseif ($item->user_klasifikasi == 2) {
          $klasifikasi_data = "SD";
        } elseif ($item->user_klasifikasi == 3) {
          $klasifikasi_data = "SMP";
        } elseif ($item->user_klasifikasi == 4) {
          $klasifikasi_data = "SMA";
        } elseif ($item->user_klasifikasi == 5) {
          $klasifikasi_data = "Mahasiswa";
        } elseif ($item->user_klasifikasi == 6) {
          $klasifikasi_data = "PNS";
        } elseif ($item->user_klasifikasi == 7) {
          $klasifikasi_data = "Karyawan";
        } elseif ($item->user_klasifikasi == 8) {
          $klasifikasi_data = "Umum";
        } else {
          $klasifikasi_data = "Umum";
        }

				if ($item->user_backlist == 0) {
					$status = "Aktif";
				} else {
					$status = "Non Aktif";
				}

        $spreadsheet->setActiveSheetIndex(0)
          ->setCellValue('A' . $kolom, $nomor)
          ->setCellValue('B' . $kolom, $item->user_noId)
          ->setCellValue('C' . $kolom, $item->user_nama)
          ->setCellValue('D' . $kolom, $item->user_jk)
          ->setCellValue('E' . $kolom, $klasifikasi_data)
          ->setCellValue('F' . $kolom, $item->user_alamat)
          ->setCellValue('G' . $kolom, $item->user_tempatLahir)
          ->setCellValue('H' . $kolom, $item->user_tanggalLahir)
          ->setCellValue('I' . $kolom, $item->user_noHP)
          ->setCellValue('J' . $kolom, $item->user_ktp)
          ->setCellValue('K' . $kolom, $item->user_email)
          ->setCellValue('L' . $kolom, $item->user_username)
          ->setCellValue('M' . $kolom, $item->user_password)
					->setCellValue('N' . $kolom, $status);

        $kolom++;
        $nomor++;
      }
    }

    $writer = new Xlsx($spreadsheet);

    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="Data_user.xlsx"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
  }

  public function import_user()
  {
    include APPPATH . 'third_party/PHPExcel/PHPExcel.php';

    $config['upload_path'] = realpath('./vendor/file/');
    $config['allowed_types'] = 'xlsx|xls|csv';
    $config['max_size'] = '1000000000';
    $config['encrypt_name'] = true;

    $this->load->library('upload');
    $this->upload->initialize($config);

    if (!$this->upload->do_upload('import_user')) {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal upload!","File excel gagal diupload!","error","Tutup")</script>');
      redirect('user');
    } else {

      $data_upload = $this->upload->data();

      $excelreader   = new PHPExcel_Reader_Excel2007();
      $loadexcel     = $excelreader->load('./vendor/file/' . $data_upload['file_name']); // Load file yang telah diupload ke folder excel
      $sheet         = $loadexcel->getActiveSheet()->toArray(null, true, true, true);

      $data  = array();
      $data1 = array();
      $data2 = array();

      $numrow = 1;
      foreach ($sheet as $row) {
        if ($numrow > 1) {

          if ($row["E"] == "TK") {
            $klasifikasi_data = 1;
          } elseif ($row["E"] == "SD") {
            $klasifikasi_data = 2;
          } elseif ($row["E"] == "SMP") {
            $klasifikasi_data = 3;
          } elseif ($row["E"] == "SMA") {
            $klasifikasi_data = 4;
          } elseif ($row["E"] == "Mahasiswa") {
            $klasifikasi_data = 5;
          } elseif ($row["E"] == "PNS") {
            $klasifikasi_data = 6;
          } elseif ($row["E"] == "Karyawan") {
            $klasifikasi_data = 7;
          } elseif ($row["E"] == "Umum") {
            $klasifikasi_data = 8;
          } else {
            $klasifikasi_data = 8;
          }

					if ($row["N"] == "Aktif") {
						$status = "0";
					} else {
						$status = "1";
					}
          $this->load->library('ciqrcode');

          $config['cacheable']    = true; //boolean, the default is true
          $config['cachedir']     = './vendor/'; //string, the default is application/cache/
          $config['errorlog']     = './vendor/'; //string, the default is application/logs/
          $config['imagedir']     = './vendor/img/qr/'; //direktori penyimpanan qr code
          $config['quality']      = true; //boolean, the default is true
          $config['size']         = '512'; //interger, the default is 1024
          $config['black']        = array(224,255,255); // array, default is array(255,255,255)
          $config['white']        = array(70,130,180); // array, default is array(0,0,0)
          $this->ciqrcode->initialize($config);

          $image_name=$row["B"].'.png'; //buat name dari qr code sesuai dengan nim
          
          $dataqr = $row["B"];

          $params['data'] = $dataqr; //data yang akan di jadikan QR CODE
          $params['level'] = 'H'; //H=High
          $params['size'] = 10;
          $params['savename'] = $config['imagedir'].$image_name; //simpan image QR CODE ke folder assets/images/
          $this->ciqrcode->generate($params);

          $nomor           = rand(1,1000000000);
          array_push($data, array(
            "user_id" => $nomor,
            "user_noId" => $row["B"],
            "user_noId" => $row["B"],
            "user_nama" => $row["C"],
            "user_jk" => $row["D"],
            "user_klasifikasi" => $klasifikasi_data,
            "user_alamat" => $row["F"],
            "user_tempatLahir" => $row["G"],
            "user_tanggalLahir" => $row["H"],
            "user_noHP" => $row["I"],
            "user_ktp" => $row["J"],
            "user_email" => $row["K"],
            "user_username" => $row["L"],
            "user_password" => password_hash($row["M"], PASSWORD_DEFAULT),
						"user_backlist" => $status,
            "user_role" => 3,
            "user_qr" => $image_name,
            "user_foto" => "default.jpg"
          ));

          array_push($data1, array(
            "orangtua_user" => "$nomor",
            "orangtua_nama" => "",
            "orangtua_alamat" => "",
            "orangtua_tempatLahir" => "",
            "orangtua_tanggalLahir" => "",
            "orangtua_noHP" => ""
          ));

          array_push($data2, array(
            "pertanyaan_user" => "$nomor",
            "pertanyaan" => "",
            "pertanyaan_jawaban" => ""
          ));

          // array_push($data1, array(
          //   "orangtua_nama" => $row["N"],
          //   "orangtua_alamat" => $row["O"],
          //   "orangtua_tempatLahir" => $row["P"],
          //   "orangtua_tanggalLahir" => $row["Q"],
          //   "orangtua_noHP" => $row["R"]
          // ));

          // array_push($data2, array(
          //   "pertanyaan" => $row["S"],
          //   "pertanyaan_jawaban" => $row["T"]
          // ));

        }
        $numrow++;
      }

      $this->db->insert_batch('tb_user', $data);
      $this->db->insert_batch('tb_identitas_orangtua', $data1);
      $this->db->insert_batch('tb_pertanyaan_keamanan', $data2);
      //delete file from server
      unlink(realpath('./vendor/file/' . $data_upload['file_name']));

      //upload success
      $this->session->set_flashdata('pesan', '<script>sweet("Sukses upload!","File berhasil diupload!","success","Tutup")</script>');
      //redirect halaman
      redirect('user');
    }
  }
}
