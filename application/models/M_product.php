<?php

use phpDocumentor\Reflection\Types\False_;

defined('BASEPATH') OR exit('No direct script access allowed');

class M_product extends CI_Model {
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

	//Fungsi View
	public function get_product()
	{
		return $this->db->select("*")
			->from("tb_product")
			->join("tb_model", "tb_product.model_id = tb_model.model_id")
			->join("tb_part", "tb_product.part_id = tb_part.part_id")
			->join("tb_category", "tb_product.category_id = tb_category.category_id")
			->join("tb_hole", "tb_product.hole_id = tb_hole.hole_id")
			->join("tb_tool", "tb_product.tool_id = tb_tool.tool_id")
			->join("tb_colour", "tb_product.colour_id = tb_colour.colour_id")
			->order_by("tb_product.product_id", "ASC")
			->get();
	}

	// Fungsi Search Model
	public function search_model($keyword, $limit = FALSE)
	{
		$response = new stdClass();
		$query = $this->db->select("*")
		->from("tb_model")
		->like("model_kode", $keyword, "both")
		->limit($limit)
			->get();
		if ($query->num_rows() > 0) {
			$response->success = TRUE;
			$response->data = $query->result();
		} else {
			$response->success = FALSE;
		}
		return $response;
	}

	// Fungsi Search Part
	public function search_part($keyword, $limit = FALSE)
	{
		$response = new stdClass();
		$query = $this->db->select("*")
		->from("tb_part")
		->like("part_kode", $keyword, "both")
		->limit($limit)
			->get();
		if ($query->num_rows() > 0) {
			$response->success = TRUE;
			$response->data = $query->result();
		} else {
			$response->success = FALSE;
		}
		return $response;
	}

	// Fungsi Search Category
	public function search_category($keyword, $limit = FALSE)
	{
		$response = new stdClass();
		$query = $this->db->select("*")
		->from("tb_category")
		->like("category_nama", $keyword, "both")
		->limit($limit)
			->get();
		if ($query->num_rows() > 0) {
			$response->success = TRUE;
			$response->data = $query->result();
		} else {
			$response->success = FALSE;
		}
		return $response;
	}

	// Fungsi Search Tool
	public function search_tool($keyword, $limit = FALSE)
	{
		$response = new stdClass();
		$query = $this->db->select("*")
		->from("tb_tool")
		->like("tool_kode", $keyword, "both")
		->limit($limit)
			->get();
		if ($query->num_rows() > 0) {
			$response->success = TRUE;
			$response->data = $query->result();
		} else {
			$response->success = FALSE;
		}
		return $response;
	}

	// Fungsi Search Hole
	public function search_hole($keyword, $limit = FALSE)
	{
		$response = new stdClass();
		$query = $this->db->select("*")
		->from("tb_hole")
		->like("hole_nama", $keyword, "both")
		->limit($limit)
			->get();
		if ($query->num_rows() > 0) {
			$response->success = TRUE;
			$response->data = $query->result();
		} else {
			$response->success = FALSE;
		}
		return $response;
	}

	// Fungsi Search Colour
	public function search_colour($keyword, $limit = FALSE)
	{
		$response = new stdClass();
		$query = $this->db->select("*")
		->from("tb_colour")
		->like("colour_nama", $keyword, "both")
		->limit($limit)
			->get();
		if ($query->num_rows() > 0) {
			$response->success = TRUE;
			$response->data = $query->result();
		} else {
			$response->success = FALSE;
		}
		return $response;
	}
	
}
