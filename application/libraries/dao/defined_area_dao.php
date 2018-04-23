<?php
	require_once('generic_dao.php');

	class defined_area_dao extends Generic_dao  {
		public function table_name(){
			return 'defined_area';
		}

		public function field_map() {
			return array (
				'da_id'=>'da_id',
				'da_name'=>'da_name',
				'da_description'=>'da_description',
				'dac_id'=>'dac_id'
			);
		}

		public function __construct() {
			parent::__construct();
			$this->ci = & get_instance();
		}
		
		public function table_fetch2( $criteria = null, $order_by = null, $asc = true, $limit = 1000, $offset = 0 )
		{
			$query_search = "";
			$order_command = 'ASC';
			if(!$asc){
				$order_command = 'DESC';
			}

			if(! is_null($criteria)){
				if(array_key_exists('da_name', $criteria) && $criteria['da_name']!=''){
					$query_search .= "da.da_name ilike '%" . $criteria['da_name'] . "%'";
				}
				
				if(array_key_exists('dac_id', $criteria) && $criteria['dac_id']!='') {
					if (strlen(trim($query_search)) > 0) {
						$query_search .= " AND ";
					}
					$query_search .= "da.dac_id = '" . $criteria['dac_id'] . "'";
				}
			}

			$this->ci->db->select('da.*, dac.dac_description, dac.dac_color');
			$this->ci->db->from('defined_area da LEFT JOIN defined_area_category dac ON (da.dac_id = dac.dac_id) ');
			if (strlen(trim($query_search)) > 0) {
				$this->ci->db->where($query_search, null, false);
			}
			
			if ($order_by) $this->ci->db->order_by($order_by, $order_command);
			$this->ci->db->limit($limit, $offset);
			$q = $this->ci->db->get();

			return $q->result();
		}
		
		public function fetch_all(){
			return $this->ci->db->get('defined_area')->result();
		}
		
		public function fetch_area_point($area_id){
			// return $this->ci->db->get('defined_area_point',array('da_id'=>$area_id))->result();
			return $this->ci->db->query("select * from defined_area_point where da_id='".$area_id."'")->result();
		}
		
		public function fetch_area_color($category_id){
			// $this->ci->db->get('defined_area_category',array('dac_id'=>$category_id))->result();
			// echo $this->ci->db->last_query(); die();
			return $this->ci->db->query("select * from defined_area_category where dac_id='".$category_id."'")->result();
		}
		
		public function insert_defined_area($obj){
			$array_field = array(
				'da_name'=>$obj['da_name'],
				'da_description'=>$obj['da_description']
			);
			$this->ci->db->insert('defined_area',$array_field);
			$id = $this->ci->db->insert_id();
			foreach($obj['area_point'] as $k=>$val){
				list($lat,$lon) = explode('|',$val);
				$this->ci->db->insert('defined_area_point',array(
					'da_id'=>$id,
					'depoint_lat'=>$lat,
					'depoint_lon'=>$lon,
				));
			}
		}
		
		public function update_defined_area($obj,$obj_id){
			$array_field = array(
				'da_name'=>$obj['da_name'],
				'dac_id'=>$obj['dac_id'], // ini untuk categori wilayah 
				'da_description'=>$obj['da_description']
			);
			$this->ci->db->set($array_field);
			$this->ci->db->where($obj_id);
			$this->ci->db->update('defined_area');
			$id = $obj_id['da_id'];
			$this->ci->db->delete('defined_area_point',$obj_id);
			foreach($obj['area_point'] as $k=>$val){
				list($lat,$lon) = explode('|',$val);
				$this->ci->db->insert('defined_area_point',array(
					'da_id'=>$id,
					'depoint_lat'=>$lat,
					'depoint_lon'=>$lon,
				));
			}
		}
		
		public function delete_defined_area($obj_id){
			$this->ci->db->delete('defined_area_point',$obj_id);
			$this->ci->db->delete('defined_area',$obj_id);
			return true;
		}

		public function count_table_fetch($array_search = null,  $order = null, $asc = true, $limit = 1000, $offset = 0 ) {
			$query_search = "";
	    	$order_command = 'ASC';
	        if(!$asc){
	            $order_command = 'DESC';
	        }

	        if ($array_search != null) {
	            if (array_key_exists('da_name', $array_search) && $array_search['da_name'] != "" && strlen($array_search['da_name']) > 0) {
	                $query_search .= "da_name ilike '%" . $array_search['da_name'] . "%'";
	            }
	            
	        }
        	$this->ci->db->select('*');

	        $this->ci->db->from('defined_area');
		    if (strlen(trim($query_search)) > 0) {
       		   $this->ci->db->where($query_search, null, false);
      		}
	        return $this->ci->db->count_all_results();
		}



		public function table_fetch($limit = 1000, $offset = 0, $array_search = null, $order_by = null, $asc = true) {
			$name_asc;
	        $query_search = "";
	        if ($asc == true) {
	            $name_asc = 'asc';
	        } else {
	            $name_asc = 'desc';
	        }
	        if ($array_search != null) {
	            if (array_key_exists('da_name', $array_search) && $array_search['da_name'] != "" && strlen($array_search['da_name']) > 0) {
	                $query_search .= "da_name ilike '%" . $array_search['da_name'] . "%'";
	            }
	        }
	        //$from_cond = '';
	        $this->ci->db->from('defined_area');
	        //$this->ci->db->where($query_search);
	        if (strlen(trim($query_search)) > 0) {
				$this->ci->db->where($query_search, null, false);
			}
	        $this->ci->db->order_by('da_name', 'asc');
	        // if (!is_null($where) && count($where) > 0) {
	        //     $this->ci->db->where($where);
	        // }

	        $this->ci->db->limit($limit, $offset);
	        $q = $this->ci->db->get();
	        return $q->result();
		}
	}
?>