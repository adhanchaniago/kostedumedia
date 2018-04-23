<?php

require_once('generic_dao.php');

class enemy_force_dao extends Generic_dao{



	
	public function table_name() {
        return 'enemy_force';
    }

    public function field_map() {

        return array(
            'enmap_id' => 'enmap_id',
			'eforcetype_id'=> 'eforcetype_id',
			'enmap_name' => 'enmap_name',
			'enmap_lat' => 'enmap_lat',
			'enmap_lon' => 'enmap_lon',
			'enmap_desc' => 'enmap_desc',
            //'enmap_image' => 'enmap_image', // added by SKM17
			'enmap_icon' => 'enmap_icon', // commented by SKM17 //uncommented by D3
			'eforceflag_id' => 'eforceflag_id' // added by SKM17
        );
    }
  public function __construct() {
        parent::__construct();
    }
                   
    public function table_fetch( $criteria = null, $order_by = null, $asc = true, $limit = 1000, $offset = 0 )
    {
      $query_search = "";
    	$order_command = 'ASC';
    	if(!$asc){
    		$order_command = 'DESC';
    	}

    	if(! is_null($criteria)){
    		 if(array_key_exists('enmap_name', $criteria) && $criteria['enmap_name']!=''){
    			//$this->ci->db->like('enmap_name', $criteria['enmap_name']);
    			$query_search .= "a.enmap_name ilike '%" . $criteria['enmap_name'] . "%'";
    		}
			
    		
			if(array_key_exists('eforceflag_id', $criteria) && $criteria['eforceflag_id']!='') {
				if (strlen(trim($query_search)) > 0) {
					$query_search .= " AND ";
				}
				$query_search .= "a.eforceflag_id = '" . $criteria['eforceflag_id'] . "'";
			}
    	}

    	$this->ci->db->select('a.*, b.eforcetype_name, f.eforceflag_name');
    	$this->ci->db->from('enemy_force a left join enemy_force_type b on (a.eforcetype_id = b.eforcetype_id) ' .
    		'LEFT JOIN enemy_force_flag f ON (a.eforceflag_id = f.eforceflag_id)');
		if (strlen(trim($query_search)) > 0) {
			$this->ci->db->where($query_search, null, false);
		}
		
        // $this->ci->db->order_by($order_by, $order_command);
    	$this->ci->db->limit($limit, $offset);
    	$q = $this->ci->db->get();
        return $q->result();

    }

    public function fetch_force_type(){

        $this->ci->db->from('enemy_force_type');
        $this->ci->db->order_by('eforcetype_id', 'asc');

        return $this->ci->db->get()->result();
    }

    public function fetch_force_components($criteria = null){
        
        if($criteria!=null){
            $this->ci->db->where($criteria);
        }
        $this->ci->db->select('a.*,b.fcomp_name , b.fcomp_icon');
        $this->ci->db->from('enemy_force_component a 
                    left join force_component b on (a.fcomp_id = b.fcomp_id)');
        return $this->ci->db->get()->result();
    }

    public function count_table_fetch( $criteria = null, $order = null, $asc = true, $limit = 1000, $offset = 0 ){

      $query_search = "";
        $order_command = 'ASC';
        if(!$asc){
            $order_command = 'DESC';
        }

        if(! is_null($criteria)){
            if(array_key_exists('enmap_name', $criteria) && $criteria['enmap_name']!=''){
                //$this->ci->db->like('enmap_name', $criteria['enmap_name']); // edited by SKM17 from where to like
    						$query_search .= "a.enmap_name ilike '%" . $criteria['enmap_name'] . "%'";
            }

            if (array_key_exists('eforcetype_id', $criteria) && $criteria['eforcetype_id']!=''){
					if (strlen(trim($query_search)) > 0) {
						$query_search .= " AND ";
					}
    			//$this->ci->db->where('a.enforcetype_id', $criteria['enforcetype_id']);
    			$query_search .= "a.eforcetype_id = '" . $criteria['eforcetype_id'] . "'";
            }

        }

        $this->ci->db->select('a.* , b.eforcetype_name');
        $this->ci->db->from('enemy_force a left join enemy_force_type b on (a.eforcetype_id = b.eforcetype_id)');
      if (strlen(trim($query_search)) > 0) {
          $this->ci->db->where($query_search, null, false);
      }
        // $this->ci->db->order_by('a.enmap_name', 'asc');
        // echo 'limit : '.$limit;
        $this->ci->db->limit($limit, $offset);

        return $this->ci->db->count_all_results();
    }

}
