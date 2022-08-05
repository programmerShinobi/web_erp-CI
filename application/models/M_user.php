<?php

use phpDocumentor\Reflection\Types\False_;

defined('BASEPATH') OR exit('No direct script access allowed');

class M_user extends CI_Model {
  protected $response = [];

  //Fungsi Input Daata
  public function insertData($data,$table) {
    $insert = $this->db->insert($table,$data);
    if($insert) {
      $this->response['success'] = TRUE;
    } else {
      $this->response['failed'] = FALSE;
    }
    return $this->response;
  }

  //Fungsi Read Data
  public function getData($table)
  {
    $get = $this->db->get($table);
    if ($get) {
      return $get;
    } else {
      var_dump($get);
      return FALSE;
    }
  }

  //Fungsi Ambil Data tertetnu
  public function editData($where,$table, $limit = "") {
    $get = $this->db->where($where)->get($table, $limit);
    if ($get) {
      return $get;
    } else {
      return FALSE;
    }
  }
  
  //Fungsi Ambil 2 Data tertetnu
  public function editData_2($where1,$where2,$table, $limit = "") {
    $get = $this->db->where($where1)->where($where2)->get($table, $limit);
    if ($get) {
      return $get;
    } else {
      return FALSE;
    }
  }

  //Fungsi Update Data
  public function updateData($data,$where,$table)
  {
    $update = $this->db->where($where)->update($table,$data);
    if ($update) {
      $this->response['success'] = TRUE;
    } else {
      $this->response['failed'] = FALSE;
    }
    return $this->response;
  }

  //Fungsi hapus data
  public function deleteData($where,$table)
  {
    $delete = $this->db->delete($table,$where);
    if ($delete) {
      $this->response['success'] = TRUE;
    } else {
      $this->response['success'] = FALSE;
    }
    return $this->response;
  }

	//Fungsi Get User
	public function getUser()
	{
			return $this->db->select("*")
			->from("tb_user")
			->join("tb_klasifikasi", "tb_user.user_klasifikasi = tb_klasifikasi.pekerjaan_id")
			->join("tb_role", "tb_user.user_role = tb_role.role_id")
			->order_by("tb_user.user_id", "DESC")
			->get();

	}


	//Fungsi Get User Aktif
	public function getUserAktif()
	{
		return $this->db->select("*")
		->from("tb_user")
		->join("tb_klasifikasi", "tb_user.user_klasifikasi = tb_klasifikasi.pekerjaan_id")
		->join("tb_role", "tb_user.user_role = tb_role.role_id")
		->order_by("tb_user.user_id", "DESC")
		->where("tb_user.`user_backlist` = " . 0)
		->get();
	}

	//Fungsi Get User Aktif
	public function getUserNonaktif()
	{
		return $this->db->select("*")
		->from("tb_user")
		->join("tb_klasifikasi", "tb_user.user_klasifikasi = tb_klasifikasi.pekerjaan_id")
		->join("tb_role", "tb_user.user_role = tb_role.role_id")
		->order_by("tb_user.user_id", "DESC")
		->where("tb_user.`user_backlist` = " . 1)
		->get();
	}

	//Get user detail
	public function get_user_detail($user_id)
	{
		return $this->db->select("*")
		->from("`tb_user` tbu")
		->join("`tb_identitas_orangtua` tbio", "tbu.`user_id` = tbio.`orangtua_user`")
		->join("`tb_pertanyaan_keamanan` tbpk", "tbu.`user_id` = tbpk.`pertanyaan_user`")
		->where("tbu.`user_id` = " . $user_id)
			->get();
	}
	
	public function get_log()
	{
		return $this->db->select("*")
		->from("tb_log")
		->join("tb_user", "tb_log.log_user = tb_user.user_id")
		->order_by("tb_log.log_id", "DESC")
		->get();
	}



}
