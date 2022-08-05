<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class C_admin extends CI_Controller {

  public function __construct()
  {
    parent::__construct();  
		protek_login();
  }

  public function index()
  {
		$orang= $this->M_data->editData(['user_id' => $this->session->userdata('admin_id')], 'tb_user')->row();
		if ($orang->user_role == 1){
			$data = [
					'title' => 'Dashboard',
					'menu' => $this->M_menu->get_access_menu()->result_array(),
					'user' => $this->M_data->editData(['user_id' => $this->session->userdata('admin_id')],'tb_user')->row()
			];
		}
    $this->load->view('template/v_head', $data);
    $this->load->view('admin/v_index', $data);
    $this->load->view('template/v_footer');
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
