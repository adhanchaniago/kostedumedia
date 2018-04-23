<?php

require_once('generic_dao.php');

class marines_dislocation_dao extends Generic_dao {

	public function field_map() {
		return array('mardis_id' => 'mardis_id',
			'operation_name' => 'operation_name',
			'mardis_is_active' => 'mardis_is_active',
			'mardis_image' => 'mardis_image',
			'maricon_id' => 'maricon_id',
			'mardis_date' => 'mardis_date',
			'mardis_time' => 'mardis_time',
			'mardis_lat' => 'mardis_lat',
			'mardis_lon' => 'mardis_lon',
			'mardis_location' => 'mardis_location',
			'mardis_dpp' => 'mardis_dpp',
			'mardis_personnel' => 'mardis_personnel',
			'mardis_matpur' => 'mardis_matpur',
			'mardis_in_ops' => 'mardis_in_ops'
		);
	}

	public function table_name() {
		return 'marines_dislocation';
	}

	public function __construct() {
		parent::__construct();
	}

	public function table_fetch ($limit = 1000, $offset = 0, $array_search = null) {
		$query_search = "";

		//$this->ci->db->select('mh.*, md.operation_name, md.mardis_is_active', false);
		$this->ci->db->from($this->table_name());

		if ($array_search != null) {
			if (array_key_exists('operation_name', $array_search) && $array_search['operation_name'] != "" && strlen($array_search['operation_name']) > 0) {
				$query_search .= "operation_name ilike '%" . $array_search['operation_name'] . "%'";
			}
			if (array_key_exists('mardis_location', $array_search) && $array_search['mardis_location'] != "" && strlen($array_search['mardis_location']) > 0) {
				if (strlen(trim($query_search)) > 0) {
					$query_search .= " AND ";
				}
				$query_search .= "mardis_location ilike '%" . $array_search['mardis_location'] . "%'";
			}
			if (array_key_exists('mardis_dpp', $array_search) && $array_search['mardis_dpp'] != "" && strlen($array_search['mardis_dpp']) > 0) {
				if (strlen(trim($query_search)) > 0) {
					$query_search .= " AND ";
				}
					$query_search .= "mardis_dpp ilike '%" . $array_search['mardis_dpp'] . "%'";
			}
		}

		if (strlen(trim($query_search)) > 0) {
			$this->ci->db->where($query_search, null, false);
		}
		$this->ci->db->limit($limit, $offset);
		$this->ci->db->order_by('operation_name', 'asc');

		$q = $this->ci->db->get();
		return $q->result();
	}

	public function count_table_fetch($where = null, $array_search = null) {
		$query_search = "";
		
		$this->ci->db->from($this->table_name());

		if ($array_search != null) {
			if (array_key_exists('operation_name', $array_search) && $array_search['operation_name'] != "" && strlen($array_search['operation_name']) > 0) {
				$query_search .= "operation_name ilike '%" . $array_search['operation_name'] . "%'";
			}
			if (array_key_exists('mardis_location', $array_search) && $array_search['mardis_location'] != "" && strlen($array_search['mardis_location']) > 0) {
				if (strlen(trim($query_search)) > 0) {
					$query_search .= " AND ";
				}
				$query_search .= "mardis_location ilike '%" . $array_search['mardis_location'] . "%'";
			}
			if (array_key_exists('mardis_dpp', $array_search) && $array_search['mardis_dpp'] != "" && strlen($array_search['mardis_dpp']) > 0) {
				if (strlen(trim($query_search)) > 0) {
					$query_search .= " AND ";
				}
					$query_search .= "mardis_dpp ilike '%" . $array_search['mardis_dpp'] . "%'";
			}
		}

		if (strlen(trim($query_search)) > 0) {
			$this->ci->db->where($query_search, null, false);
		}   

		$q = $this->ci->db->count_all_results();
		return $q;
	}

	public function insertOperation($opName, $imgName, $idIcon) {
	$status = $this->ci->db->insert('marines_dislocation', 
	array('operation_name' => $opName, 'mardis_is_active' => 'TRUE', 'mardis_image' => $imgName, 'maricon_id' => $idIcon));

	// mengambil id dari data yg baru disimpan
	if ($status) {
	$result = $this->ci->db->get_where('marines_dislocation', array('operation_name' => $opName));
	$row = $result->row();
	$ID = $row->mardis_id;
	return $ID;
	}

	return false;
	}

	public function updateOperation($objId, $opName, $imgName, $idIcon) {
	$this->ci->db->where('mardis_id', $objId);
	return $this->ci->db->update('marines_dislocation', array ('operation_name' => $opName, 'mardis_image' => $imgName, 'maricon_id' => $idIcon)); 
	}

	public function by_id_($mardis_id) {
	//        $obj_id_o = $this->to_sql_array($obj_id);
	$this->ci->db->select('mh.*, md.operation_name, md.mardis_image, md.mardis_is_active, md.maricon_id');
	$this->ci->db->from('mardis_history AS mh LEFT JOIN marines_dislocation md
	on (mh.mardis_id = md.mardis_id)');
	$this->ci->db->where('mh.mardis_id = ' . $mardis_id);
	$q = $this->ci->db->get();
	return $q->row();
	}

	public function deletePosition($objId) {
	$this->ci->db->delete('mardis_history', $objId);
	return $this->ci->db->delete('marines_dislocation', $objId);
	}

}
