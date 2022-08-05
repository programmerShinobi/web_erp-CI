<?php

use phpDocumentor\Reflection\Types\False_;

defined('BASEPATH') OR exit('No direct script access allowed');

class M_colour extends CI_Model {
  protected $response = [];

	//Fungsi Input Daata
	public function insertData($data, $table)
	{
		$insert = $this->db->insert($table, $data);
		if ($insert) {
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
	public function editData($where, $table, $limit = "")
	{
		$get = $this->db->where($where)->get($table, $limit);
		if ($get) {
			return $get;
		} else {
			return FALSE;
		}
	}

	//Fungsi Ambil 2 Data tertetnu
	public function editData_2($where1, $where2, $table, $limit = "")
	{
		$get = $this->db->where($where1)->where($where2)->get($table, $limit);
		if ($get) {
			return $get;
		} else {
			return FALSE;
		}
	}

	//Fungsi Update Data
	public function updateData($data, $where, $table)
	{
		$update = $this->db->where($where)->update($table, $data);
		if ($update) {
			$this->response['success'] = TRUE;
		} else {
			$this->response['failed'] = FALSE;
		}
		return $this->response;
	}

	//Fungsi hapus data
	public function deleteData($where, $table)
	{
		$delete = $this->db->delete($table, $where);
		if ($delete) {
			$this->response['success'] = TRUE;
		} else {
			$this->response['success'] = FALSE;
		}
		return $this->response;
	}
	
}
