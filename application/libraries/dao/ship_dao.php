<?php

require_once('generic_dao.php');

class ship_dao extends Generic_dao {

	public function table_name() {
		return 'ship';
	}

	public function field_map() {
		return array(
			'ship_id' => 'ship_id', 'ship_stat_id' => 'ship_stat_id', 
			'ship_abbr' => 'ship_abbr', 'unit_id' => 'unit_id',
			'corps_id' => 'corps_id', 'shiptype_id' => 'shiptype_id', 'shipcond_id' => 'shipcond_id',
			'ship_imo' => 'ship_imo', 'ship_name' => 'ship_name', 'ship_icon' => 'ship_icon',
			'ship_lat' => 'ship_lat', 'ship_lon' => 'ship_lon', 'ship_image' => 'ship_image',
			'ship_machinehour' => 'ship_machinehour', 'ship_currenthour' => 'ship_currenthour',
			'ship_lasttrans' => 'ship_lasttrans', 'ship_iskri' => 'ship_iskri',
			'ship_direction' => 'ship_direction', 'ship_speed' => 'ship_speed', 'ship_isrealtime' => 'ship_isrealtime',
			'ship_dsp' => 'ship_dsp', 'ship_condition' => 'ship_condition',
			'ship_skep_kasal' => 'ship_skep_kasal',
			'ship_created' => 'ship_created',
			'ship_factory' => 'ship_factory',
			'ship_country_created' => 'ship_country_created',
			'ship_work_year' => 'ship_work_year',
			'ship_nickname' => 'ship_nickname',
			'ship_weight' => 'ship_weight',
			'ship_length' => 'ship_length',
			'ship_width' => 'ship_width',
			'ship_draft' => 'ship_draft',
			'ship_machine' => 'ship_machine',
			'ship_speed_desc' => 'ship_speed_desc',
			'ship_people' => 'ship_people',
			'ship_history' => 'ship_history',
			'ship_weapon' => 'ship_weapon',
			'ship_helicopter' => 'ship_helicopter',
			'ship_radar' => 'ship_radar',
			'ship_sonar' => 'ship_sonar',
			'ship_dock' => 'ship_dock',
			'ship_water_location' => 'ship_water_location',
			'ship_pjl_ops' => 'ship_pjl_ops',
			'ship_realitation' => 'ship_realitation',
			'ship_riil' => 'ship_riil',
			'ship_commander' => 'ship_commander',
			'ship_timestamp_location' => 'ship_timestamp_location',
			'ship_cctv_ip' => 'ship_cctv_ip',
			'ship_cctv_uname' => 'ship_cctv_uname',
			'ship_cctv_pwd' => 'ship_cctv_pwd',
			'ship_desc' => 'ship_desc',
			'operation_id' => 'operation_id', // added by SKM17
			'ship_is_in_operation' => 'ship_is_in_operation', // added by SKM17
			'kodal_id' => 'kodal_id' // added by SKM17
		);
	}

	public function __construct() {
		parent::__construct();
		$this->ci->load->library('dao/personnel_dao');
		$this->ci->load->library('dao/ship_logistics_dao');
		$this->ci->load->library('dao/ship_viewability_dao');
		$this->ci->load->library('dao/ship_ops_dao');
	}
	
	public function by_id_($ship_id) {
//		$obj_id_o = $this->to_sql_array($obj_id);
		$this->ci->db->select('a.*,o.operation_id');
		$this->ci->db->from('ship as a left join ship_ops so 
				on (a.ship_id = so.ship_id) 
				left join operation o 
								on (o.operation_id = so.operation_id and o.operation_is_active = \'t\')');
		$this->ci->db->where('a.ship_id = \''.$ship_id.'\'');
		$q = $this->ci->db->get();
		return $q->row();
	}
	
	public function table_fetch($limit = 1000, $offset = 0, $array_search = null, $order_by = null, $asc = true, $position = false) {
		$name_asc;
		$query_search = "";
		if ($asc == true) {
			$name_asc = 'asc';
		} else {
			$name_asc = 'desc';
		}

		if ($array_search != null) {
			if (array_key_exists('ship_name', $array_search) && $array_search['ship_name'] != "" && strlen($array_search['ship_name']) > 0) {
				$query_search .= "a.ship_name ilike '%" . $array_search['ship_name'] . "%'";
			}

			if (array_key_exists('shiptype_id', $array_search) && $array_search['shiptype_id'] != "") {

				if (strlen(trim($query_search)) > 0) {
					$query_search .= " AND ";
				}

				$query_search .= "a.shiptype_id = '{$array_search['shiptype_id']}'";
			}
			if (array_key_exists('ship_id', $array_search) && $array_search['ship_id'] != "" && strlen($array_search['ship_id']) > 0) {

				if (strlen(trim($query_search)) > 0) {
					$query_search .= " AND ";
				}

				// $array_search['ship_iskri'] = ($array_search['ship_iskri']==1)?'TRUE':'FALSE';
				$query_search .= "a.ship_id = '" . $array_search['ship_id'] . "'";
			}

			if (array_key_exists('ship_abbr', $array_search) && $array_search['ship_abbr'] != "" && strlen($array_search['ship_abbr']) > 0) {

				if (strlen(trim($query_search)) > 0) {
					$query_search .= " AND ";
				}

				// $array_search['ship_iskri'] = ($array_search['ship_iskri']==1)?'TRUE':'FALSE';
				$query_search .= "a.ship_abbr ILIKE '%" . $array_search['ship_abbr'] . "%'"; // edited by SKM17 become ILIKE
			}

			if (array_key_exists('shipcond_id', $array_search) && $array_search['shipcond_id'] != "") {

				if (strlen(trim($query_search)) > 0) {
					$query_search .= " AND ";
				}

				$query_search .= "a.shipcond_id= '{$array_search['shipcond_id']}'";
			}
			if (array_key_exists('ship_stat_id', $array_search) && $array_search['ship_stat_id'] != "") {

				if (strlen(trim($query_search)) > 0) {
					$query_search .= " AND ";
				}

				$query_search .= "a.ship_stat_id= '{$array_search['ship_stat_id']}'";
			}

			if (array_key_exists('corps_id', $array_search) && $array_search['corps_id'] != "") {

				if (strlen(trim($query_search)) > 0) {
					$query_search .= " AND ";
				}

				$query_search .= "a.corps_id= '" . $array_search['corps_id'] . "'";
			}

			// added by SKM17 {
			if (array_key_exists('kodal_id', $array_search) && $array_search['kodal_id'] != "") {

				if (strlen(trim($query_search)) > 0) {
					$query_search .= " AND ";
				}

				$query_search .= "a.kodal_id= '" . $array_search['kodal_id'] . "'";
			}
			// } end ADDED

			if (array_key_exists('ship_timestamp_date', $array_search) && array_key_exists('ship_timestamp_time', $array_search) && $array_search['ship_timestamp_date'] != "" && $array_search['ship_timestamp_time'] != "") {
				if (strlen(trim($query_search)) > 0) {
					$query_search .= " AND ";
				}
				if ($array_search['ship_timestamp_time'] == '06.00') {
					$query_search .= "a.ship_timestamp_location >= '" . $array_search['ship_timestamp_date'] . " 06:00:00' and a.ship_timestamp_location <= '" . $array_search['ship_timestamp_date'] . " 09:00:00'";
				} else {
					$query_search .= "a.ship_timestamp_location >= '" . $array_search['ship_timestamp_date'] . " 17:00:00' and a.ship_timestamp_location <= '" . $array_search['ship_timestamp_date'] . " 19:00:00'";
				}
			}
			
			// added by SKM17 {
			if (array_key_exists('ship_is_in_operation', $array_search) && $array_search['ship_is_in_operation'] != "" && strlen($array_search['ship_is_in_operation']) > 0)
			{
				if (strlen(trim($query_search)) > 0) {
					$query_search .= " AND ";
				}
				$query_search .= "a.ship_is_in_operation = '" . $array_search['ship_is_in_operation'] . "'";
			}
			// } end ADDED

			// Added by KP D3
			if (array_key_exists('operation_id', $array_search) && $array_search['operation_id'] != "" && strlen($array_search['operation_id']) > 0)
			{
				if (strlen(trim($query_search)) > 0) {
					$query_search .= " AND ";
				}
				$query_search .= "a.operation_id = '" . $array_search['operation_id'] . "'";
			}
			// } end ADDED
		}
		$from_cond = '';
		if ($position == true) {
			$this->ci->db->select(
				'a.*, c.corps_name, d.shiptype_desc, unit_name, f.shipcond_description, b.ship_stat_desc, o.operation_name, o.operation_id, k.corps_name AS kodal_name', 
				false);
			/* commented by SKM17
			$from_cond = ' left join ship_ops so 
				on (a.ship_id = so.ship_id) 
				left join operation o 
								on (o.operation_id = so.operation_id and o.operation_is_active = \'t\')';
			*/
			$from_cond = ' LEFT JOIN operation o ON (o.operation_id = a.operation_id)'; // added by SKM17
		} else {
			$this->ci->db->select('a.*, c.corps_name, d.shiptype_desc, unit_name, f.shipcond_description, b.ship_stat_desc, k.corps_name AS kodal_name', false);
		}
		$this->ci->db->from('ship a left JOIN ship_status b
						ON (a.ship_stat_id=b.ship_stat_id)
				left join corps c
						on(a.corps_id = c.corps_id)
				left join corps k
						on(a.kodal_id = k.corps_id)
				left join ship_type d
						on(a.shiptype_id = d.shiptype_id)
				left join unit e
						on(a.unit_id = e.unit_id)
				left join ship_condition f
						on(a.shipcond_id = f.shipcond_id)' . $from_cond);

		if (strlen(trim($query_search)) > 0) {
			$this->ci->db->where($query_search, null, false);
		}

		$this->ci->db->limit($limit, $offset);
		//if ($order_by != NULL && is_array($order_by))
		$this->ci->db->order_by('a.ship_name', 'asc');
		$q = $this->ci->db->get(); 
		return $q->result();
	}
	
	public function updateOperation($obj) {
		// cek apakah sudah ada pasangan op_id dan ship_id
		$this->ci->db->where('operation_id', $obj['operation_id']);
		$this->ci->db->where('ship_id', $obj['ship_id']);
		$query = $this->ci->db->get('ship_ops');
		
		if ($query->num_rows() > 0) { // sudah ada data di db, update tanggal
			$this->ci->db->where('operation_id', $obj['operation_id']);
			$this->ci->db->where('ship_id', $obj['ship_id']);
			return $this->ci->db->update('ship_ops', array ('sh_add_timestamp' => date("Y-m-d"))); 
		} else { // belum ada di db, insert data baru
			$data = array (
				'operation_id' => $obj['operation_id'] ,
				'ship_id' => $obj['ship_id'],
				'sh_add_timestamp' => date("Y-m-d")
			);
			
			return $this->ci->db->insert('ship_ops', $data);
		}
	}

	public function count_table_fetch($array_search = null) {
		$query_search = "";

		if ($array_search != null) {
			if (array_key_exists('ship_name', $array_search) && $array_search['ship_name'] != "" && strlen($array_search['ship_name']) > 0) {
				$query_search .= " AND a.ship_name ilike '%" . $array_search['ship_name'] . "%'";
			}
			if (array_key_exists('shiptype_id', $array_search) && $array_search['shiptype_id'] != "") {
				$query_search .= " AND a.shiptype_id = '" . $array_search['shiptype_id'] . "' ";
			}
			if (array_key_exists('ship_abbr', $array_search) && $array_search['ship_abbr'] != "") {
				$query_search .= " AND a.ship_abbr = '" . $array_search['ship_abbr'] . "' ";
			}
			if (array_key_exists('ship_id', $array_search) && $array_search['ship_id'] != "" && strlen($array_search['ship_id']) > 0) {
				// $array_search['ship_iskri'] = ($array_search['ship_iskri']==1)?'TRUE':'FALSE';
				$query_search .= " AND a.ship_id = '" . $array_search['ship_id'] . "' ";
			}
			if (array_key_exists('shipcond_id', $array_search) && $array_search['shipcond_id'] != "") {
				$query_search .= " AND a.shipcond_id= '" . $array_search['shipcond_id'] . "' ";
			}
			if (array_key_exists('ship_stat_id', $array_search) && $array_search['ship_stat_id'] != "") {
				$query_search .= " AND a.ship_stat_id= '" . $array_search['ship_stat_id'] . "' ";
			}
			if (array_key_exists('corps_id', $array_search) && $array_search['corps_id'] != "") {
				$query_search .= " AND a.corps_id= '" . $array_search['corps_id'] . "' ";
			}

			// added by SKM17
			if (array_key_exists('corps_id_not', $array_search) && $array_search['corps_id_not'] != "") {
				foreach ($array_search['corps_id_not'] as &$value) {
					$query_search .= " AND a.corps_id <> '" . $value . "' ";
				}
			}
			if (array_key_exists('kodal_id', $array_search) && $array_search['kodal_id'] != "") {
				$query_search .= " AND a.kodal_id= '" . $array_search['kodal_id'] . "' ";
			}

			// added by KP D3
			if (array_key_exists('operation_id', $array_search) && $array_search['operation_id'] != "") {
				$query_search .= " AND a.operation_id= '" . $array_search['operation_id'] . "' ";
			}
			// end added

			if (array_key_exists('ship_timestamp_date', $array_search) && array_key_exists('ship_timestamp_time', $array_search) && $array_search['ship_timestamp_date'] != "" && $array_search['ship_timestamp_time'] != "") {
				if ($array_search['ship_timestamp_time'] == '06.00') {
					$query_search .= "AND a.ship_timestamp_location >= '" . $array_search['ship_timestamp_date'] . " 06:00:00' and a.ship_timestamp_location <= '" . $array_search['ship_timestamp_date'] . " 09:00:00'";
				} else {
					$query_search .= "AND a.ship_timestamp_location >= '" . $array_search['ship_timestamp_date'] . " 17:00:00' and a.ship_timestamp_location <= '" . $array_search['ship_timestamp_date'] . " 19:00:00'";
				}
			}

			// added by SKM17 {
			if (array_key_exists('ship_is_in_operation', $array_search) && $array_search['ship_is_in_operation'] != "") {
				$query_search .= " AND a.ship_is_in_operation = '" . $array_search['ship_is_in_operation'] . "' ";
			}
			
			if (array_key_exists('ship_isrealtime', $array_search) && $array_search['ship_isrealtime'] != "") {
				$query_search .= " AND a.ship_isrealtime = '" . $array_search['ship_isrealtime'] . "' ";
			}
			// } END ADDED
		}

		$this->ci->db->select('a.ship_id');
		$this->ci->db->from('ship a');
		$this->ci->db->where('a.ship_id is not null ' . $query_search);
		$q = $this->ci->db->count_all_results();
		return $q;
	}

	public function delete($keys) {
		/* delete ship relation */
		$this->ci->personnel_dao->deleteByShip($keys);
		$this->ci->ship_logistics_dao->delete($keys);
		$this->ci->ship_viewability_dao->delete($keys);
		$this->ci->ship_ops_dao->delete($keys);

		$keys_o = $this->to_sql_array($keys);
		return $this->ci->db->delete($this->table_name(), $keys_o);
	}

	public function get_gallery_image($obj_id) {
		return $this->ci->db->get_where('ship_images', $obj_id)->result();
	}

	public function save_gallery_image($file_name, $ship_id) {
		return $this->ci->db->insert('ship_images', array('ship_id' => $ship_id, 'shipimg_filename' => $file_name));
	}

	public function delete_gallery_image($ship_id) {
		return $this->ci->db->delete('ship_images', array('ship_id' => $ship_id));
	}
	
	public function fetch_for_msg() {
		$this->ci->db->select('ship_id, ship_name');
		$this->ci->db->from('ship');
		$this->ci->db->where('ship_isrealtime', 'true');
		$this->ci->db->order_by('ship_id', 'asc');
		
		$q = $this->ci->db->get(); 
		return $q->result();
	}

	public function fetch_in_ops() {
		$this->ci->db->select('ship_id, ship_name');
		$this->ci->db->from('ship');
		$this->ci->db->where('ship_isrealtime', 'true');
		$this->ci->db->order_by('ship_id', 'asc');
		
		$q = $this->ci->db->get(); 
		return $q->result();
	}
	
	public function fetch_for_onboards() {
		$this->ci->db->select('ship_abbr, ship_lat, ship_lon');
		$this->ci->db->from('ship');
		$this->ci->db->where('ship_lat IS NOT NULL AND ship_lon IS NOT NULL');
		$this->ci->db->order_by('ship_abbr', 'asc');
		
		$q = $this->ci->db->get(); 
		return $q->result();
	}

}

?>
