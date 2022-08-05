<?php

use phpDocumentor\Reflection\Types\False_;

defined('BASEPATH') OR exit('No direct script access allowed');

class M_dashboard extends CI_Model {
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
	public function get_view($start,$end)
	{
		if ($start == null || $end == null) {
			// $start = date("Y-m-d", strtotime("-30Days"));
			// $end = date("Y-m-d");
			return $this->db->select("*")
				->from("tb_purchaseorder")
				->join("tb_podelivery", "tb_purchaseorder.purchaseorder_id = tb_podelivery.purchaseorder_id")
				->join("tb_planinjection", "tb_purchaseorder.purchaseorder_id = tb_planinjection.purchaseorder_id")
				->join("tb_plan2nd", "tb_purchaseorder.purchaseorder_id = tb_plan2nd.purchaseorder_id")
				->join("tb_planprinting", "tb_purchaseorder.purchaseorder_id = tb_planprinting.purchaseorder_id")
				->join("tb_planspray", "tb_purchaseorder.purchaseorder_id = tb_planspray.purchaseorder_id")
				->join("tb_planassy", "tb_purchaseorder.purchaseorder_id = tb_planassy.purchaseorder_id")
				->join("tb_stockipqc", "tb_purchaseorder.purchaseorder_id = tb_stockipqc.purchaseorder_id")
				->join("tb_stockoqc", "tb_purchaseorder.purchaseorder_id = tb_stockoqc.purchaseorder_id")
				->join("tb_stockla", "tb_purchaseorder.purchaseorder_id = tb_stockla.purchaseorder_id")
				->join("tb_delivery", "tb_purchaseorder.purchaseorder_id = tb_delivery.purchaseorder_id")
				->join("tb_customer", "tb_purchaseorder.customer_id = tb_customer.customer_id")
				->join("tb_product", "tb_purchaseorder.product_id = tb_product.product_id")
				->join("tb_model", "tb_product.model_id = tb_model.model_id")
				->join("tb_part", "tb_product.part_id = tb_part.part_id")
				->join("tb_category", "tb_product.category_id = tb_category.category_id")
				->join("tb_tool", "tb_product.tool_id = tb_tool.tool_id")
				->join("tb_hole", "tb_product.hole_id = tb_hole.hole_id")
				->join("tb_colour", "tb_product.colour_id = tb_colour.colour_id")
				// ->where('purchaseorder_tanggal BETWEEN "' . $start . '" AND "' . $end . '" ')
				->order_by("tb_purchaseorder.purchaseorder_id", "DESC")
				->get();
		} else {
			return $this->db->select("*")
				->from("tb_purchaseorder")
				->join("tb_podelivery", "tb_purchaseorder.purchaseorder_id = tb_podelivery.purchaseorder_id")
				->join("tb_planinjection", "tb_purchaseorder.purchaseorder_id = tb_planinjection.purchaseorder_id")
				->join("tb_plan2nd", "tb_purchaseorder.purchaseorder_id = tb_plan2nd.purchaseorder_id")
				->join("tb_planprinting", "tb_purchaseorder.purchaseorder_id = tb_planprinting.purchaseorder_id")
				->join("tb_planspray", "tb_purchaseorder.purchaseorder_id = tb_planspray.purchaseorder_id")
				->join("tb_planassy", "tb_purchaseorder.purchaseorder_id = tb_planassy.purchaseorder_id")
				->join("tb_stockipqc", "tb_purchaseorder.purchaseorder_id = tb_stockipqc.purchaseorder_id")
				->join("tb_stockoqc", "tb_purchaseorder.purchaseorder_id = tb_stockoqc.purchaseorder_id")
				->join("tb_stockla", "tb_purchaseorder.purchaseorder_id = tb_stockla.purchaseorder_id")
				->join("tb_delivery", "tb_purchaseorder.purchaseorder_id = tb_delivery.purchaseorder_id")
				->join("tb_customer", "tb_purchaseorder.customer_id = tb_customer.customer_id")
				->join("tb_product", "tb_purchaseorder.product_id = tb_product.product_id")
				->join("tb_model", "tb_product.model_id = tb_model.model_id")
				->join("tb_part", "tb_product.part_id = tb_part.part_id")
				->join("tb_category", "tb_product.category_id = tb_category.category_id")
				->join("tb_tool", "tb_product.tool_id = tb_tool.tool_id")
				->join("tb_hole", "tb_product.hole_id = tb_hole.hole_id")
				->join("tb_colour", "tb_product.colour_id = tb_colour.colour_id")
				->where('purchaseorder_tanggal BETWEEN "' . $start . '" AND "' . $end . '" ')
				->order_by("tb_purchaseorder.purchaseorder_id", "DESC")
				->get();
		}
	}

	// Fungsi Search Customer
	public function search_customer($keyword, $limit = FALSE)
	{
		$response = new stdClass();
		$query = $this->db->select("*")
		->from("tb_customer")
		->like("customer_kode", $keyword, "both")
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

	// Fungsi Search product
	public function search_product($keyword, $limit = FALSE)
	{
		$response = new stdClass();
		$query = $this->db->select("*")
		->from("tb_product")
		->join("tb_model", "tb_product.model_id = tb_model.model_id")
		->join("tb_part", "tb_product.part_id = tb_part.part_id")
		->join("tb_category", "tb_product.category_id = tb_category.category_id")
		->join("tb_tool", "tb_product.tool_id = tb_tool.tool_id")
		->join("tb_hole", "tb_product.hole_id = tb_hole.hole_id")
		->join("tb_colour", "tb_product.colour_id = tb_colour.colour_id")
		->like("product_kode", $keyword, "both")
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
