<?php
	require_once('generic_dao.php');
	class poi_dao extends Generic_dao  {
		public function table_name(){
			return 'poi';
		}

		public function field_map() {
			return array ('poi_id'=>'poi_id','operation_id'=>'operation_id','aptype_id'=>'aptype_id','poi_name'=>'poi_name','poi_icon'=>'poi_icon','poi_description'=>'poi_description','poi_lat'=>'poi_lat','poi_lon'=>'poi_lon');
		}

		public function __construct() {
			parent::__construct();
		}


	public function table_fetch ($limit = 1000, $offset = 0, $array_search = null) {
		$query_search = "";
		
		$this->ci->db->from($this->table_name());

		if ($array_search != null) {
			if (array_key_exists('poi_name', $array_search) && $array_search['poi_name'] != "" && strlen($array_search['poi_name']) > 0) {
				$query_search .= "poi_name ilike '%" . $array_search['poi_name'] . "%'";
			}
			
		}

		if (strlen(trim($query_search)) > 0) {
			$this->ci->db->where($query_search, null, false);
		}
		$this->ci->db->limit($limit, $offset);
		$this->ci->db->order_by('poi_name', 'asc');

		$q = $this->ci->db->get();
		return $q->result();
	}

	public function count_table_fetch($array_search = null) {
		$query_search = "";
		
		$this->ci->db->from($this->table_name());

		if ($array_search != null) {
			if (array_key_exists('poi_name', $array_search) && $array_search['poi_name'] != "" && strlen($array_search['poi_name']) > 0) {
				$query_search .= "poi_name ilike '%" . $array_search['poi_name'] . "%'";
			}
		}

		if (strlen(trim($query_search)) > 0) {
			$this->ci->db->where($query_search, null, false);
		}   

		$q = $this->ci->db->count_all_results();
		return $q;
	}


		public function by_id_($poi_id) {
//        $obj_id_o = $this->to_sql_array($obj_id);
        $this->ci->db->select('*');
        /* commented by SKM17
        $this->ci->db->from('aeroplane as a left join aeroplane_ops so 
                on (a.aer_id = so.aer_id) 
                left join operation o 
                                on (o.operation_id = so.operation_id and o.operation_is_active = \'t\')');
        */
        $this->ci->db->from('poi'); // added by SKM17
        $this->ci->db->where('poi_id = \''.$poi_id.'\'');
        $q = $this->ci->db->get();
        return $q->row();
    }

		public function fetch_all(){
			return $this->ci->db->get('poi')->result();
		}
		
		public function fetch_area_point($area_id){
			// return $this->ci->db->get('defined_area_point',array('da_id'=>$area_id))->result();
			return $this->ci->db->query("select * from poi where poi_id='".$area_id."'")->result();
		}
		public function save_icon($file_name, $poi_id) {
		return $this->ci->db->insert('poi_icon', array('poi_id' => $poi_id, 'shipimg_filename' => $file_name));
		}

		
	}
?>