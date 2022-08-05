<?php
defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('Asia/Jakarta');

class C_profile extends CI_Controller {  

  public function __construct()
  {
    parent::__construct();
    protek_login();  
  }

  public function editProfile() 
  {
    $this->form_validation->set_rules('nama', 'Nama', 'required',[
      'required' => 'Wajib masukan nama!'
    ]);
    $this->form_validation->set_rules('email', 'Email', 'required',[
      'required' => 'Wajib masukan Email!'
    ]);
    $this->form_validation->set_rules('noHP', 'Nomor HP', 'required',[
      'required' => 'Wajib masukan nomor hp!'
    ]);

    
    if ($this->form_validation->run() == FALSE) {
      $data = [
        'title' => 'Profil',
        'user' => $this->M_menu->editData(['user_id' => $this->session->userdata('admin_id')],'tb_user')->row(),
        'menu' => $this->M_menu->get_access_menu()->result_array()
      ];
      $this->load->view('template/v_head', $data);
      $this->load->view('admin/v_editProfile', $data);
      $this->load->view('template/v_footer');
    } else {
      $this->prosesEdit();
    } 
  }

  private function prosesEdit()
  {
    $id           = $this->session->userdata('admin_id');
    $nama         = html_escape($this->input->post('nama',true));
    $email        = html_escape($this->input->post('email',true));
    $noHp         = html_escape($this->input->post('noHP',true));
    $foto         = $_FILES['foto']['name'];

    if($foto != '') {
      $cek = $this->M_menu->editData(['user_id' => $id],'tb_user')->row();

      if($cek->user_foto != 'default.jpg') {
        unlink('./vendor/img/user/'.$cek->user_foto);
      }

      $config['upload_path']          = './vendor/img/user/';
      $config['allowed_types']        = 'jpg|png|jpeg';
      $config['max_size']             = 502400;
      $config['max_width']            = 5000;
      $config['max_height']           = 5000;

      $this->load->library('upload');
      $this->upload->initialize($config);

      if (!$this->upload->do_upload('foto'))
      {
        $this->session->set_flashdata('pesan', '<script>sweet("Gagal","Gagal Upload Foto!","error","Tutup")</script>');
        redirect('editProfile');
      } else {
        $foto = $this->upload->data('file_name');
      }

      $data = [
        'user_nama' => $this->db->escape_str($nama),
        'user_foto' => $foto,
        'user_email' => $this->db->escape_str($email),
        'user_noHP' => $this->db->escape_str($noHp)
      ];
      $where = ['user_id' => $this->session->userdata('admin_id')];
  
      $this->M_menu->updateData($data,$where,'tb_user');
      $this->session->set_flashdata('pesan', '<script>sweet("Sukses Update Profil!","Data profil sukses diperbaharui!","success","Tutup")</script>');
      redirect('profile');
    } else {
      $data = [
        'user_nama' => $this->db->escape_str($nama),
        'user_email' => $this->db->escape_str($email),
        'user_noHP' => $this->db->escape_str($noHp)
      ];
      $where = ['user_id' => $this->session->userdata('admin_id')];
  
      $this->M_menu->updateData($data,$where,'tb_user');
      $this->session->set_flashdata('pesan', '<script>sweet("Sukses Update Profil!","Data profil sukses diperbaharui!","success","Tutup")</script>');
      redirect('profile');
    }
  }

  public function gantiPassword()
  {
    $this->form_validation->set_rules('passLama', 'Password Lama', 'required',[
      'required' => 'Wajib masukan password lama anda!'
    ]);
    $this->form_validation->set_rules('passBaru', 'Password Baru', 'required|min_length[5]|max_length[12]|matches[passBaru1]',[
      'required' => 'Wajib masukan password baru!',
      'min_length' => 'Panjang karakter minimal 5!',
      'max_length' => 'Panjang karakter maximal 12',
      'matches' => 'Password tidak sesuai!'
    ]);
    $this->form_validation->set_rules('passBaru1', 'Password Baru', 'required|min_length[5]|max_length[12]|matches[passBaru]',[
      'required' => 'Wajib masukan password baru!',
      'min_length' => 'Panjang karakter minimal 5!',
      'max_length' => 'Panjang karakter maximal 12',
      'matches' => 'Password tidak sesuai!'
    ]);    

    
    if ($this->form_validation->run() == FALSE) {
      $data = [
        'title' => 'Ganti Password',
        'user' => $this->M_menu->editData(['user_id' => $this->session->userdata('admin_id')],'tb_user')->row(),
        'menu' => $this->M_menu->get_access_menu()->result_array()
      ];
      $this->load->view('template/v_head', $data);
      $this->load->view('admin/v_changePass', $data);
      $this->load->view('template/v_footer');
    } else {
      $this->prosesGantiPass();
    } 
  }

  private function prosesGantiPass()
  {
    $passLama       = html_escape($this->input->post('passLama'));
    $cek            = $this->M_menu->editData(['user_id' => $this->session->userdata('admin_id')],'tb_user')->row();

    if(password_verify($passLama,$cek->user_password)) {
      $passNew    = password_hash($this->input->post('passBaru'), PASSWORD_DEFAULT);
      
      $data = ['user_password' => $passNew];
      $where = ['user_id' => $this->session->userdata('admin_id')];
      $this->M_menu->updateData($data,$where,'tb_user');

      $this->session->set_flashdata('pesan', '<script>sweet("Sukses Update Password!","Password telah diperbaharui!","success","Tutup")</script>');
      redirect('gantiPassword');
    } else {
      $this->session->set_flashdata('pesan', '<script>sweet("Gagal mengganti password!","Password lama anda tidak sesuai!","error","Tutup")</script>');
      redirect('gantiPassword');
    }
  }

  public function logout()
  {    
    $this->session->set_flashdata('pesan', '<script>sweet("Anda telah logout","Sampai jumpa!","warning","Tutup")</script>');
    redirect('login');
  }
}
