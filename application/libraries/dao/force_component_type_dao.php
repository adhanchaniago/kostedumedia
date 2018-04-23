<?php

require_once('generic_dao.php');

class force_component_type_dao extends Generic_dao{


	
	public function table_name() {
        return 'force_component_type';
    }

    public function field_map() {

        return array(
            'fcomptype_id' => 'fcomptype_id',
			'fcomptype_name'=> 'fcomptype_name'
        );
    }

    public function table_fetch( $criteria = null, $order = null, $asc = true, $limit = 1000, $offset = 0 ){

    	$order_command = 'ASC';
    	if(!$asc){
    		$order_command = 'DESC';
    	}

    	if(! is_null($criteria)){
    		if(array_key_exists('fcomptype_name', $criteria) && $criteria['fcomptype_name']!=''){
    			$this->ci->db->like('fcomptype_name', $criteria['fcomptype_name']);
    		}

    	}

    	$this->ci->db->select('a.*');
    	$this->ci->db->from('force_component_type a');
    	$this->ci->db->order_by('a.fcomptype_name', 'asc');
        // echo 'limit : '.$limit;
    	$this->ci->db->limit($limit, $offset);
    	$q = $this->ci->db->get();

        return $q->result();
    }

    public function count_table_fetch( $criteria = null, $order = null, $asc = true, $limit = 1000, $offset = 0 ){

        $order_command = 'ASC';
        if(!$asc){
            $order_command = 'DESC';
        }

        if(! is_null($criteria)){
            if(array_key_exists('fcomptype_name', $criteria) && $criteria['fcomptype_name']!=''){
                $this->ci->db->like('fcomptype_name', $criteria['fcomptype_name']);
            }

        }

        $this->ci->db->select('a.*');
        $this->ci->db->from('force_component_type a');
        $this->ci->db->order_by('a.fcomptype_name', 'asc');
        // echo 'limit : '.$limit;
        $this->ci->db->limit($limit, $offset);
        $q = $this->ci->db->get();

        return $this->ci->db->count_all_results();
    }

}
