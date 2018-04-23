<?php
	require_once('generic_dao.php');

	class myfleet_dao extends Generic_dao  {
		public function table_name(){
			return 'myfleet';
		}

		public function field_map() {
			return array (	
				'mf_mmsi' => 'mf_mmsi',
				'mf_name' => 'mf_name',
				'mf_imo' => 'mf_imo',
				'mf_callsign' => 'mf_callsign',
				'mf_flag' => 'mf_flag',
				'mf_photos' => 'mf_photos',
				'mf_publicurl' => 'mf_publicurl',
				'mf_type' => 'mf_type',
				'mf_lat' => 'mf_lat',
				'mf_lon' => 'mf_lon',
				'mf_hdg' => 'mf_hdg',
				'mf_course' => 'mf_course',
				'mf_speed' => 'mf_speed',
				'mf_draught' => 'mf_draught',
				'mf_nav_status' => 'mf_nav_status',
				'mf_location' => 'mf_location',
				'mf_destination' => 'mf_destination',
				'mf_etatime' => 'mf_etatime',
				'mf_positionreceived' => 'mf_positionreceived',
				'mf_lastevent_event' => 'mf_lastevent_event',
				'mf_lastevent_eventtime' => 'mf_lastevent_eventtime',
				'mf_lastport_arrival' => 'mf_lastport_arrival',
				'mf_lastport_departure' => 'mf_lastport_departure',
				'mf_lastport_locode' => 'mf_lastport_locode',
				'mf_lastport_name' => 'mf_lastport_name',
				'mf_nextport_country' => 'mf_nextport_country',
				'mf_nextport_countryiso2' => 'mf_nextport_countryiso2',
				'mf_nextport_locode' => 'mf_nextport_locode',
				'mf_nextport_name' => 'mf_nextport_name',
				'mf_last_reload' => 'mf_last_reload'
			);
		}

		public function table_fetch ($limit = 1000, $offset = 0, $array_search = null) {
			$query_search = "";
			
			$this->ci->db->from($this->table_name());

			if ($array_search != null) {
				if (array_key_exists('mf_mmsi', $array_search) && $array_search['mf_mmsi'] != "" && strlen($array_search['mf_mmsi']) > 0) {
					$query_search .= " mf_mmsi = " . $array_search['mf_mmsi'];
				}
				if (array_key_exists('mf_name', $array_search) && $array_search['mf_name'] != "" && strlen($array_search['mf_name']) > 0) {
					$query_search .= " mf_name ilike '%" . $array_search['mf_name'] . "%'";
				}
			}

			if (strlen(trim($query_search)) > 0) {
				$this->ci->db->where($query_search, null, false);
			}
			$this->ci->db->limit($limit, $offset);
			$this->ci->db->order_by('mf_last_reload', 'desc');

			$q = $this->ci->db->get();
			return $q->result();
		}

		public function count_table_fetch( $criteria = null){

			$query_search = "";

			if(! is_null($criteria)){
				if(array_key_exists('mf_mmsi', $criteria) && $criteria['mf_mmsi']!=''){
					$query_search .= "mf_mmsi = " . $criteria['mf_mmsi'];
				}
				if(array_key_exists('mf_name', $criteria) && $criteria['mf_name']!=''){
					$query_search .= " mf_name ilike '%" . $criteria['mf_name'] . "%'";
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

		public function __construct() {
			parent::__construct();
		}
	}
?>
