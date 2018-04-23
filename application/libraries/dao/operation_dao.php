<?php

require_once('generic_dao.php');

class operation_dao extends Generic_dao {

	public function table_name() {
		return 'operation';
	}

	public function field_map() {
		return array(
			'operation_id' => 'operation_id', 'operation_name' => 'operation_name',
			'operation_description' => 'operation_description', 'operation_start' => 'operation_start',
			'operation_end' => 'operation_end', 'optype_id' => 'optype_id', 'operation_annual' => 'operation_is_annual',
			'operation_year' => 'operation_year', 'operation_is_template' => 'operation_is_template', 'operation_is_active' => 'operation_is_active',
			'operation_type' => 'operation_type','opstatus_id' => 'opstatus_id');
	}

	public function __construct() {
		parent::__construct();
		$this->ci->load->library('dao/operation_viewability_dao');
		$this->ci->load->library('dao/ship_ops_dao');
	}

	public function fetch_All(){
		return $this->fetch(1000, 0, 'operation_name');
	}

	public function table_fetch($status = 'plan', $limit = 1000, $offset = 0, $where = null, $array_search = null, $order_by = null, $asc = true) {
		$name_asc;
		$query_search = "";
		if ($asc == true) {
			$name_asc = 'asc';
		} else {
			$name_asc = 'desc';
		}
		$this->ci->db->select('ops.*,ops_type.level4 as jenis_ops, os.opstatus_name as operation_status');
		$this->ci->db->from('operation as ops LEFT JOIN jenisops4 as ops_type
	ON ops.operation_type = ops_type.level4_id LEFT JOIN operation_status os ON ops.opstatus_id=os.opstatus_id');
		if ($status == 'plan') {
			$this->ci->db->where('ops.opstatus_id = 0');
		} else if($status == 'occur'){
			$this->ci->db->where('ops.opstatus_id = 1');
		} else if($status == 'ended'){
			$this->ci->db->where('ops.opstatus_id = 2');
		}
		if ($array_search != null) {
			if (array_key_exists('operation_name', $array_search) && $array_search['operation_name'] != "" && strlen($array_search['operation_name']) > 0) {
				$query_search .= "AND operation.operation_name ilike '%" . $array_search['operation_name'] . "%'";
			}
			if (array_key_exists('optype_id', $array_search) && $array_search['optype_id'] != "") {
				$query_search .= "AND operation.optype_id = " . $array_search['optype_id'] . " ";
			}
			if ($query_search != "") {
				$this->ci->db->where(substr($query_search, 4, strlen($query_search)));
			}
		}
		if (!is_null($where) && count($where) > 0) {
			$this->ci->db->where($where);
		}
		$this->ci->db->limit($limit, $offset);
		if ($order_by != NULL && is_array($order_by))
			$this->ci->db->order_by($order_by, $name_asc);
		$q = $this->ci->db->get();
		return $q->result();
	}

	public function count_table_fetch($where = null, $array_search = null) {
		$query_search = "";
		$this->ci->db->select('count(operation.*)');
		$this->ci->db->from('operation');
		if ($array_search != null) {
			if (array_key_exists('operation_name', $array_search) && $array_search['operation_name'] != "" && strlen($array_search['operation_name']) > 0) {
				$query_search .= "AND operation.operation_name ilike '%" . $array_search['operation_name'] . "%'";
			}
			if (array_key_exists('optype_id', $array_search) && $array_search['optype_id'] != "") {
				$query_search .= "AND operation.optype_id = " . $array_search['optype_id'] . " ";
			}
			if ($query_search != "") {
				$this->ci->db->where(substr($query_search, 4, strlen($query_search)));
			}
		}
		if (!is_null($where) && count($where) > 0) {
			$this->ci->db->where($where);
		}
		$q = $this->ci->db->count_all_results();
		return $q;
	}

	public function getLastKey() {
		//$this->ci->db->select('cast (operation_id as integer)');
		//$this->ci->db->from('operation');
		//$this->ci->db->limit(1);
		//$this->ci->db->order_by('operation_id', 'desc');
		//$q = $this->ci->db->get();
		$q = $this->ci->db->query('select cast (operation_id as integer) from operation order by operation_id desc LIMIT 1');
		return $q->result();
	}

	public function delete($keys) {
		$this->ci->operation_viewability_dao->delete($keys);
		$this->ci->ship_ops_dao->delete($keys);
		$keys_o = $this->to_sql_array($keys);
		return $this->ci->db->delete($this->table_name(), $keys_o);
	}

}

?>
