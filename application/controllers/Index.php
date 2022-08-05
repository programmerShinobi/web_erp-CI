<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');
class Index extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$data = [
			'title' => 'Login',
		];
		$this->load->view('v_header', $data);
		$this->load->view('v_footer');

		$this->session->unset_userdata('status');
		$this->session->unset_userdata('admin_id');

		$this->form_validation->set_rules('username', 'Username', 'required|min_length[3]', [
			'required' => 'Wajib masukan username!',
			'min_length' => 'Masukan minimal 3 karakter!'
		]);
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[3]', [
			'required' => 'Wajib masukan password!',
			'min_length' => 'Masukan minimal 3 karakter!'
		]);
		$this->form_validation->set_rules('captcha', 'Captcha', 'required', [
			'required' => 'Wajib masukan captcha!'
		]);


		if ($this->form_validation->run() == FALSE) {

			$options = [
				'img_path' => './vendor/img/captcha/',
				'img_url' => base_url('vendor/img/captcha/'),
				'img_width' => 205,
				'img_height' => 35,
				'expiration' => 7200
			];
			$cap = create_captcha($options);
			$img = $cap['image'];

			$text = $cap['word'];
			$this->session->set_userdata('captcha', $text);

			$data = [
				'img' => $img,
				'text' => $text,
				'title' => 'Login - OneCompany'
			];

			$this->load->view('v_login', $data);
		} else {
			$captcha = $this->input->post('captcha');

			if ($captcha == $this->session->userdata('captcha')) {
				$this->prosesLogin();
			} else {
				$this->session->set_flashdata('pesan', '<script>sweet("Gagal Login!","Captcha tidak sesuai!","error","Tutup");</script>');

				redirect('index');
			}
		}
	}

	private function prosesLogin()
	{

		$user 		= html_escape($this->input->post('username', true));
		$pass 		= html_escape($this->input->post('password', true));

		$cek = $this->M_data->editData(['user_username' => $this->db->escape_str($user)], 'tb_user')->row();
		date_default_timezone_set('Asia/Jakarta');

		if ($cek) {
			if (password_verify($pass, $cek->user_password)) {
				// if ($cek->user_role == 1) {
					$sesi = [
						'admin_id' => $cek->user_id,
						'role_id' => $cek->user_role,
						'status' => TRUE
					];

					$data = [
						'log_user' => $cek->user_id,
						'log_tanggal' => date('Y-m-d'),
						'log_time' => date('H:i:s')
					];
					$this->M_data->insertData($data, 'tb_log');
					$this->session->set_flashdata('pesan', '<script>sweet("Sukses Login", "Selamat datang!", "success", "tutup")</script>');
					$this->session->set_userdata($sesi);
					redirect('dashboard');
				// }
			} else {
				$this->session->set_flashdata('pesan', '<script>sweet("Gagal Login!","Username/Password yang anda masukan salah!","error","Tutup");</script>');
				redirect('index');
			}
		} else {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal Login!","Username anda belum terdaftar!","error","Tutup");</script>');
			redirect('index');
		}
	}

	public function lupaPassword()
	{
		$data = [
			'title' => 'Lupa Passoword',
		];
		$this->load->view('v_header', $data);
		$this->load->view('v_footer');

		$this->form_validation->set_rules('email', 'Email', 'required|valid_email', [
			'required' => 'Wajib masukan email',
			'valid_email' => 'Masukan format email dengan benar!'
		]);


		if ($this->form_validation->run() == FALSE) {
			$data = [
				'title' => 'Lupa password'
			];
			$this->load->view('v_lupaPassword', $data);
		} else {
			$email = html_escape($this->input->post('email'));

			$this->session->set_userdata('email', $email);
			redirect('pertanyaan');
		}
	}

	public function pertanyaan()
	{
		$data = [
			'title' => 'Lupa Passoword ',
		];
		$this->load->view('v_header', $data);
		$this->load->view('v_footer');

		if (!$this->session->userdata('email')) {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal!","Masukan email terlebih dahulu!","error","Tutup")</script>');
			redirect('lupaPassword');
		} else {
			$this->form_validation->set_rules('jawaban', 'Jawaban', 'required', [
				'required' => 'Wajib menjawab pertanyaan!'
			]);

			$user_id = $this->M_data->editData(['user_email' => $this->session->userdata('email')], 'tb_user')->row();
			if ($this->form_validation->run() == FALSE) {
				if ($user_id) {
					$data = [
						'title' => 'Pertanyaan - Lupa Password',
						'pertanyaan' => $this->M_data->editData(['pertanyaan_user' => $user_id->user_id], 'tb_pertanyaan_keamanan')->row()
					];
					$this->load->view('v_lupaPassword2', $data);
				} else {
					$data = [
						'title' => 'Pertanyaan - Lupa Password'
					];
					$this->session->set_flashdata('pesan', '<script>sweet("Gagal!","E-mail anda salah!","error","Tutup")</script>');
					redirect('lupaPassword');
				}
			} else {
				$jawaban = html_escape($this->input->post('jawaban', true));

				$where = [
					'pertanyaan_user' => $user_id->user_id,
					'pertanyaan_jawaban' => $jawaban
				];
				$cekJawaban = $this->M_data->editData($where, 'tb_pertanyaan_keamanan')->row();

				if ($cekJawaban) {
					$this->session->set_userdata('user', $user_id->user_id);
					redirect('resetPassword');
				} else {
					$this->session->set_flashdata('pesan', '<script>sweet("Gagal!","Jawaban anda salah!","error","Tutup")</script>');
					redirect('pertanyaan');
				}
			}
		}
	}

	public function resetPassword()
	{
		$data = [
			'title' => 'Lupa Passoword',
		];
		$this->load->view('v_header', $data);
		$this->load->view('v_footer');

		if (!$this->session->userdata('user')) {
			$this->session->set_flashdata('pesan', '<script>sweet("Gagal!","Wajib menjawab pertanyaan terlebih dahulu!","error","Tutup")</script>');
			redirect('pertanyaan');
		} else {
			$this->form_validation->set_rules('password', 'Password', 'required', [
				'required' => 'Wajib masukan Password'
			]);

			if ($this->form_validation->run() == FALSE) {
				$data = ['title' => 'Reset Password'];
				$this->load->view('v_lupaPassword3', $data);
			} else {
				$this->resetPasswordAct();
			}
		}
	}

	private function resetPasswordAct()
	{
		$password   = html_escape($this->input->post('password', true));
		$data 			= ['user_password' => password_hash($password, PASSWORD_DEFAULT)];
		$where 			= ['user_id' => $this->session->userdata('user')];
		$this->M_data->updateData($data, $where, 'tb_user');
		$this->session->set_flashdata('pesan', '<script>sweet("Sukses!","Password berhasil diganti!","success","Tutup")</script>');
		redirect('login');
	}

	public function logout()
	{
		// $this->session->sess_destroy();
		$this->session->unset_userdata('admin_id');
		$this->session->unset_userdata('role_id');
		$this->session->unset_userdata('id');
		$this->session->unset_userdata('status');
		$this->session->set_flashdata('pesan', '<script>sweet("Anda telah logout", "Sampai jumpa!", "warning", "tutup")</script>');
		redirect("index");
	}

}

