<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class C_dashboard extends CI_Controller {

  public function __construct()
  {
    parent::__construct();  
		protek_login();
  }

  public function index()
  {
		$orang= $this->M_menu->editData(['user_id' => $this->session->userdata('admin_id')], 'tb_user')->row();
		// if ($orang->user_role == 1){
			$start = $this->input->post('start_order_date');
			$end = $this->input->post('end_order_date');
			$data = [
					'title' => 'Dashboard',
					'menu' => $this->M_menu->get_access_menu()->result_array(),
					'user' => $this->M_menu->editData(['user_id' => $this->session->userdata('admin_id')],'tb_user')->row(),
					'list_dashboard' => $this->M_dashboard->get_view($start,$end)->result(),
			];
		// }
    $this->load->view('template/v_head', $data);
    $this->load->view('admin/dashboard/v_dashboard', $data);
    $this->load->view('template/v_footer');
  }

}
