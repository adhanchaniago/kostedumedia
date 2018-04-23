<?php
    require_once('generic_dao.php');
    class unit_dao extends Generic_dao  {
        public function table_name(){
            return 'unit';
        }

        public function field_map() {
            return array ('unit_id'=>'unit_id','unit_name'=>'unit_name','unitcat_id'=>'unitcat_id');
        }

        public function __construct() {
            parent::__construct();
        }
		
		public function fetch_data($criteria = null, $limit = 16, $offset = 0, $order_by = null, $asc = true) { // modified by SKM17

		    $name_asc;
		    if ($asc == true) {
		        $name_asc = 'asc';
		    } else {
		        $name_asc = 'desc';
		    }
        	$query_search = "";
        	
            $this->ci->db->select("u.*, uc.unitcat_name");
            $this->ci->db->from("unit u 
                        LEFT JOIN unit_category uc 
                        ON (u.unitcat_id = uc.unitcat_id)");

            
			if ($criteria != null) {
		        if (array_key_exists('unit_name', $criteria) && $criteria['unit_name'] != "" 
		        		&& strlen($criteria['unit_name']) > 0) {
		            $query_search .= "AND u.unit_name ilike '%" . $criteria['unit_name'] . "%' ";
		        }
		        
		        if (array_key_exists('unitcat_id', $criteria) && $criteria['unitcat_id'] != "" 
		        		&& strlen($criteria['unitcat_id']) > 0) {
		            $query_search .= "AND u.unitcat_id = '" . $criteria['unitcat_id'] . "' ";
		        }
		        
		        if ($query_search != "") {
		            $this->ci->db->where(substr($query_search, 4, strlen($query_search)));
		        }
			}

            // $this->ci->db->sort("u.unit_name", "asc"); 
            // added by SKM17 {
		    if ($order_by) $this->ci->db->order_by($order_by, $name_asc);
		    // } end ADDED
        
            $this->ci->db->limit($limit, $offset);
            
			$q = $this->ci->db->get(); // echo $this->ci->db->last_query(); die();
			return $q->result();
		}

		public function count_table_fetch($array_search = null) {
		    $query_search = "";
		    $this->ci->db->select('count(*)');
		    $this->ci->db->from('unit');
		    
			if ($array_search != null) {
		        if (array_key_exists('unit_name', $array_search) && $array_search['unit_name'] != "" 
		        		&& strlen($array_search['unit_name']) > 0) {
		            $query_search .= "AND unit_name ilike '%" . $array_search['unit_name'] . "%' ";
		        }
		        
		        if (array_key_exists('unitcat_id', $array_search) && $array_search['unitcat_id'] != "" 
		        		&& strlen($array_search['unitcat_id']) > 0) {
		            $query_search .= "AND unitcat_id = '" . $array_search['unitcat_id'] . "' ";
		        }
		        
		        if ($query_search != "") {
		            $this->ci->db->where(substr($query_search, 4, strlen($query_search)));
		        }
			}
		
		    $q = $this->ci->db->count_all_results();
		    return $q;
		}
		
		public function fetch_unit_category(){
			return $this->ci->db->get('unit_category')->result();
		}
    }
?>
