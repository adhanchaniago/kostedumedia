<?php
	require_once('generic_dao.php');

	class groundstation_dao extends Generic_dao  {
		public function table_name(){
			return 'groundstation';
		}

		public function field_map() {
			return array (	
				'gs_id'=>'gs_id',
				'gs_place'=>'gs_place',
				'gs_ip'=>'gs_ip',
				'connection_status'=>'connection_status',				
				'gs_lat' => 'gs_lat',
				'gs_lon' => 'gs_lon',
				'gs_desc' => 'gs_desc',
				'gs_frec' => 'gs_frec'
			);
		}

		public function table_fetch ($limit = 1000, $offset = 0, $array_search = null) {
			$query_search = "";
			
			$this->ci->db->from($this->table_name());

			if ($array_search != null) {
				if (array_key_exists('gs_place', $array_search) && $array_search['gs_place'] != "" && strlen($array_search['gs_place']) > 0) {
					$query_search .= "gs_place ilike '%" . $array_search['gs_place'] . "%'";
				}
			}

			if (strlen(trim($query_search)) > 0) {
				$this->ci->db->where($query_search, null, false);
			}
			$this->ci->db->limit($limit, $offset);
			$this->ci->db->order_by('gs_place', 'asc');

			$q = $this->ci->db->get();
			return $q->result();
		}

		public function count_table_fetch( $criteria = null){

			$query_search = "";

			if(! is_null($criteria)){
				if(array_key_exists('gs_place', $criteria) && $criteria['gs_place']!=''){
					$query_search .= "gs_place ilike '%" . $criteria['gs_place'] . "%'";
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
		public function fetch_gs($gs_id){
			// return $this->ci->db->get('defined_area_point',array('da_id'=>$area_id))->result();
			return $this->ci->db->query("select * from groundstation where gs_id='".$gs_id."'")->result();
		}
//end dao edit



		public function by_id_($gs_id) {

			$this->ci->db->select('*');
				 
			$this->ci->db->from('groundstation'); // added by SKM17
			$this->ci->db->where('gs_id = \''.$gs_id.'\'');
			$q = $this->ci->db->get();
			return $q->row();
		}

		public function __construct() {
			parent::__construct();
		}
	}
?>
