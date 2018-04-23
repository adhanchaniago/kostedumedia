<?php
	require_once('generic_dao.php');

	class port_dao extends Generic_dao  {
		public function table_name(){
			return 'port';
		}

		public function field_map() {
			return array (	
				'port_id'=>'port_id',
				'port_name'=>'port_name',
				'port_lat' => 'port_lat',
				'port_lon' => 'port_lon',
				'port_desc' => 'port_desc',
			);
		}

		public function table_fetch ($limit = 1000, $offset = 0, $array_search = null) {
			$query_search = "";
			
			$this->ci->db->from($this->table_name());

			if ($array_search != null) {
				if (array_key_exists('port_name', $array_search) && $array_search['port_name'] != "" && strlen($array_search['port_name']) > 0) {
					$query_search .= "port_name ilike '%" . $array_search['port_name'] . "%'";
				}
			}

			if (strlen(trim($query_search)) > 0) {
				$this->ci->db->where($query_search, null, false);
			}
			$this->ci->db->limit($limit, $offset);
			$this->ci->db->order_by('port_name', 'asc');

			$q = $this->ci->db->get();
			return $q->result();
		}

		public function count_table_fetch( $criteria = null){

			$query_search = "";

			if(! is_null($criteria)){
				if(array_key_exists('port_name', $criteria) && $criteria['port_name']!=''){
					$query_search .= "port_name ilike '%" . $criteria['port_name'] . "%'";
				}
			}

			// $this->ci->db->select('*');
			$this->ci->db->from($this->table_name());
			if (strlen(trim($query_search)) > 0) {
				$this->ci->db->where($query_search, null, false);
			}
			// $this->ci->db->limit($limit, $offset);

			return $this->ci->db->count_all_results();
		}



//dao edittt 
		public function fetch_pelabuhan($port_id){
			// return $this->ci->db->get('defined_area_point',array('da_id'=>$area_id))->result();
			return $this->ci->db->query("select * from port where port_id='".$port_id."'")->result();
		}
//end dao edit



		public function by_id_($port_id) {

			$this->ci->db->select('*');
				 
			$this->ci->db->from('port'); // added by SKM17
			$this->ci->db->where('port_id = \''.$port_id.'\'');
			$q = $this->ci->db->get();
			return $q->row();
		}

		public function __construct() {
			parent::__construct();
		}
	}
?>
