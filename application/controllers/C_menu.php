<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class C_menu extends CI_Controller {

  public function __construct()
  {
    parent::__construct();  
		protek_login();
  }

  public function index()
  {
		$this->form_validation->set_rules('menu_judul', 'Judul Menu', 'required');

		if ($this->form_validation->run() != FALSE) {
			$input = (object) $this->input->post();
			$this->process_menu_add($input);
		} else {
			$data = [
				'title' => 'Menu',
				'menu' => $this->M_menu->get_access_menu()->result_array(),
				'user' => $this->M_menu->editData(['user_id' => $this->session->userdata('admin_id')], 'tb_user')->row(),
				'role' => $this->M_user->getData("tb_role")->result(),
				'list_access' => $this->M_menu->get_access_join_menu()->result(),
				'list_menu' => $this->M_menu->getData('tb_menu')->result()
			];
			$this->load->view('template/v_head', $data);
			$this->load->view('admin/menu/v_menu', $data);
			$this->load->view('template/v_footer');
		}
  }

  public function view_menu_edit($id)
  {
    $menu_id = (int)$this->db->escape_str($id);
    $check = $this->M_menu->editData(['menu_id' => $menu_id],'tb_menu');
    if ($check) {
      $data = [
        'title' => 'Menu',
        'menu' => $this->M_menu->get_access_menu()->result_array(),
        'user' => $this->M_menu->editData(['user_id' => $this->session->userdata('admin_id')],'tb_user')->row(),
        'menu_item' => $check->row()
      ];
      $this->load->view('template/v_head', $data);
      $this->load->view('admin/menu/v_editMenu', $data);
      $this->load->view('template/v_footer');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query Failed", "error", "tutup")</script>');
      redirect('menu');
    }
  }

  public function process_menu_edit()
  {
    $this->form_validation->set_rules('menu_judul', 'Menu', 'required');
    $menu_id = $this->input->post('menu_id');

    if ($this->form_validation->run() != FALSE) {
      $this->process_menu_edit_act();
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Masukan data dengan benar dan lengkap!", "error", "tutup")</script>');
      redirect('view_menu_edit/'.$menu_id);
    }
  }

  private function process_menu_edit_act()
  {
    $input = (object) $this->input->post();
    $data = ['menu_judul' => $this->db->escape_str($input->menu_judul)];
    $where = ['menu_id' => $this->db->escape_str($input->menu_id)];

    $check = $this->M_menu->updateData($data, $where, 'tb_menu');
    if ($check["success"] === TRUE) {
      $this->session->set_flashdata('pesan', '<script>sweet("Sukses", "Menu berhasil di edit", "success", "tutup")</script>');
      redirect('menu');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal", "Query failed!", "error", "tutup")</script>');
      redirect('view_menu_edit/'.$input->menu_id);
    }
  }

  public function process_menu_delete($id)
  {
    $menu_id = (int)$this->db->escape_str($id);
    $check = $this->M_menu->delete_menu(['menu_id' => $menu_id]);
    if ($check) {
      $this->session->set_flashdata('pesan', '<script>sweet("Berhasil menghapus", "Data menu berhasil dihapus", "success", "tutup")</script>');
      redirect('menu');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal menghapus", "Data menu gagal dihapus", "error", "tutup")</script>');
      redirect('menu');
    }
  }

  private function process_menu_add($input)
  {
    $data = ['menu_judul' => $this->db->escape_str($input->menu_judul)];
    $check = $this->M_menu->insertData($data,'tb_menu');
    if ($check["success"] === TRUE) {
      $this->session->set_flashdata('pesan', '<script>sweet("Sukses menambahkan", "Data menu sukses ditambah", "success", "tutup")</script>');
      redirect("menu");
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal menambahkan", "Query failed", "error", "tutup")</script>');
      redirect("menu");
    }
  }

  public function view_access_edit($id) 
  {
    $access_id = (int)$this->db->escape_str($id);
    $check = $this->M_menu->editData(['access_id' => $access_id], 'tb_access');
    if ($check) {
      $data = [
        'title' => 'Menu',
        'menu' => $this->M_menu->get_access_menu()->result_array(),
        'user' => $this->M_menu->editData(['user_id' => $this->session->userdata('admin_id')],'tb_user')->row(),
        'access_item' => $check->row(),
				'role' => $this->M_user->getData("tb_role")->result(),
        'list_menu' => $this->M_menu->getData('tb_menu')->result()
      ];
      $this->load->view('template/v_head', $data);
      $this->load->view('admin/menu/v_editAccess', $data);
      $this->load->view('template/v_footer');
    }
  }

  public function validation_access_edit()
  {
    $this->form_validation->set_rules('menu_id', 'Menu', 'required');
    $this->form_validation->set_rules('role_id', 'Role', 'required');
    $access_id = (int)$this->input->post('access_id');

    if ($this->form_validation->run() === FALSE) {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal update", "Masukan data dengan benar & lengkap!", "error", "tutup")</script>');
      redirect("access_edit/".$access_id);
    } else {
      $this->process_access_update();
    }
  }

  private function process_access_update()
  {
    $input = (object)$this->db->escape_str($this->input->post());
    $data = [
      'menu_id' => $input->menu_id,
      'role_id' => $input->role_id
    ];
    $where = ['access_id' => $input->access_id];
    $check = $this->M_menu->updateData($data, $where, 'tb_access');
    if ($check["success"] === TRUE) {
      $this->session->set_flashdata('pesan', '<script>sweet("Sukses Update", "Data access berhasil diupdate!", "success", "tutup")</script>');
      redirect("menu");
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal mengupdate", "Query failed!", "error", "tutup")</script>');
      redirect("access_edit/".$input->access_id);
    }
  }

  public function process_access_add()
  {
    $this->form_validation->set_rules('menu_id', 'Menu', 'required');
    $this->form_validation->set_rules('role_id', 'Role', 'required');

    if ($this->form_validation->run() === FALSE) {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal menambahkan", "Masukan data dengan benar & lengkap!", "error", "tutup")</script>');
      redirect("menu");
    } else {
      $this->process_access_add_act();
    }
  }

  public function process_access_add_act()
  {
    $input = (object)$this->db->escape_str($this->input->post());
    $data = [
      'menu_id' => $input->menu_id,
      'role_id' => $input->role_id
    ];
    $check = $this->M_menu->insertData($data, 'tb_access');
    if ($check["success"] === TRUE) {
      $this->session->set_flashdata('pesan', '<script>sweet("Sukses menambahkan", "Data access berhasil ditambahkan!", "success", "tutup")</script>');
      redirect("menu");
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal menambahkan", "Query failed", "error", "tutup")</script>');
      redirect("menu");
    }
  }

  public function process_access_delete($id)
  {
    $access_id = (int)$this->db->escape_str($id);
    $check = $this->M_menu->deleteData(['access_id' => $access_id], 'tb_access');
    if ($check["success"] === TRUE) {
      $this->session->set_flashdata('pesan', '<script>sweet("Sukses menghapus", "Data access berhasil dihapus!", "success", "tutup")</script>');
      redirect("menu");
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal menghapus", "Query failed!", "success", "tutup")</script>');
      redirect("menu");
    }
  }

  public function view_sub_menu()
  {
    $data = [
      'title' => 'Sub Menu',
      'menu' => $this->M_menu->get_access_menu()->result_array(),
      'user' => $this->M_menu->editData(['user_id' => $this->session->userdata('admin_id')],'tb_user')->row(),
      'list_sub' => $this->M_menu->get_sub_join_menu()->result(),
      'list_menu' => $this->M_menu->getData('tb_menu')->result()
    ];
    $this->load->view('template/v_head', $data);
    $this->load->view('admin/menu/v_subMenu', $data);
    $this->load->view('template/v_footer');
  }

  public function view_sub_edit($id)
  {
    $sub_id = (int)$this->db->escape_str($id);
    $check = $this->M_menu->editData(['sub_id' => $id], 'tb_sub');
    if ($check) {
      $data = [
        'title' => 'Sub Menu',
        'menu' => $this->M_menu->get_access_menu()->result_array(),
        'user' => $this->M_menu->editData(['user_id' => $this->session->userdata('admin_id')],'tb_user')->row(),
        'sub_item' => $check->row(),
        'list_menu' => $this->M_menu->getData('tb_menu')->result()
      ];
      $this->load->view('template/v_head', $data);
      $this->load->view('admin/menu/v_editSub', $data);
      $this->load->view('template/v_footer');
    }
  }

  public function validation_sub_add()
  {
    $this->form_validation->set_rules('menu_id', 'Menu', 'required|numeric');
    $this->form_validation->set_rules('sub_judul', 'Menu', 'required');
    $this->form_validation->set_rules('sub_link', 'Menu', 'required');
    $this->form_validation->set_rules('sub_icon', 'Menu', 'required');
    $this->form_validation->set_rules('sub_status', 'Menu', 'required|numeric');
    
    if ($this->form_validation->run() == FALSE) {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal menambahkan", "Masukan data dengan benar & lengkap!", "error", "tutup")</script>');
      redirect("subMenu");
    } else {
      $this->process_sub_add();
    }
  }

  public function validation_sub_edit()
  {
    $this->form_validation->set_rules('sub_id', 'Menu', 'required|numeric');
    $this->form_validation->set_rules('menu_id', 'Menu', 'required|numeric');
    $this->form_validation->set_rules('sub_judul', 'Menu', 'required');
    $this->form_validation->set_rules('sub_link', 'Menu', 'required');
    $this->form_validation->set_rules('sub_icon', 'Menu', 'required');
    $this->form_validation->set_rules('sub_status', 'Menu', 'required|numeric');

    if ($this->form_validation->run() == FALSE) {
      $sub_id = (int)$this->input->post("sub_id");
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal update", "Masukan data dengan benar & lengkap!", "error", "tutup")</script>');
      redirect("edit_sub/".$sub_id);
    } else {
      $this->process_sub_update();
    }
  }

  private function process_sub_update()
  {
    $input = (object)$this->db->escape_str($this->input->post());
    $data = [
      'menu_id' => $input->menu_id,
      'sub_judul' => $input->sub_judul,
      'sub_link' => $input->sub_link,
      'sub_icon' => $input->sub_icon,
      'sub_status' => $input->sub_status
    ];
    $where = ['sub_id' => $input->sub_id];
    $check = $this->M_menu->updateData($data, $where, "tb_sub");
    if ($check["success"] === TRUE) {
      $this->session->set_flashdata('pesan', '<script>sweet("Sukses update", "Data submenu berhasil diupdate!", "success", "tutup")</script>');
      redirect("subMenu");
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal update", "Query failed!", "error", "tutup")</script>');
      redirect("subMenu");
    }
  }

  private function process_sub_add() 
  {
    $input = (object)$this->db->escape_str($this->input->post());
    $data = [
      'menu_id' => $input->menu_id,
      'sub_judul' => $input->sub_judul,
      'sub_link' => $input->sub_link,
      'sub_icon' => $input->sub_icon,
      'sub_status' => $input->sub_status
    ];
    $check = $this->M_menu->insertData($data, 'tb_sub');
    if ($check["success"] === TRUE) {
      $this->session->set_flashdata('pesan', '<script>sweet("Sukses menambahkan", "Data submenu berhasil ditambahkan!", "success", "tutup")</script>');
      redirect("subMenu");
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal menambahkan", "Query failed!", "error", "tutup")</script>');
      redirect("subMenu");
    }
  }

  public function process_sub_delete($id)
  {
    $sub_id = (int)$this->db->escape_str($id);
    $check = $this->M_menu->deleteData(['sub_id' => $sub_id], 'tb_sub');
    if ($check["success"] === TRUE) {
      $this->session->set_flashdata('pesan', '<script>sweet("Sukses menghapus", "Data submenu berhasil dihapus!", "success", "tutup")</script>');
      redirect("subMenu");
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal dihapus", "Query failed!", "error", "tutup")</script>');
      redirect("subMenu");
    }
  }
}
