<?php

require_once('generic_dao.php');

class force_component_dao extends Generic_dao{


	
	public function table_name() {
        return 'force_component';
    }

    public function field_map() {

        return array(
            'fcomp_id' => 'fcomp_id',
			'fcomp_name'=> 'fcomp_name',
			'fcomptype_id' => 'fcomptype_id',
			'fcomp_icon' => 'fcomp_icon'
        );
    }

    public function table_fetch( $criteria = null, $order = null, $asc = true, $limit = 1000, $offset = 0 ){

    	$order_command = 'ASC';
    	if(!$asc){
    		$order_command = 'DESC';
    	}

    	if(! is_null($criteria)){
    		if(array_key_exists('fcomp_name', $criteria) && $criteria['fcomp_name']!=''){
    			$this->ci->db->like('fcomp_name', $criteria['fcomp_name']);
    		}

    		if(array_key_exists('fcomptype_id', $criteria) && $criteria['fcomptype_id']!=''){
    			$this->ci->db->where('a.fcomptype_id', $criteria['fcomptype_id']);
    		}

    	}

    	$this->ci->db->select('a.* , b.fcomptype_name');
    	$this->ci->db->from('force_component a left join force_component_type b on (a.fcomptype_id = b.fcomptype_id)');
    	$this->ci->db->order_by('a.fcomp_name', 'asc');
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
            if(array_key_exists('fcomp_name', $criteria) && $criteria['fcomp_name']!=''){
                $this->ci->db->like('fcomp_name', $criteria['fcomp_name']);
            }

            if(array_key_exists('fcomptype_id', $criteria) && $criteria['fcomptype_id']!=''){
                $this->ci->db->where('a.fcomptype_id', $criteria['fcomptype_id']);
            }

        }

        $this->ci->db->select('a.* , b.fcomptype_name');
        $this->ci->db->from('force_component a left join force_component_type b on (a.fcomptype_id = b.fcomptype_id)');
        $this->ci->db->order_by('a.fcomp_name', 'asc');
        // echo 'limit : '.$limit;
        $this->ci->db->limit($limit, $offset);
        $q = $this->ci->db->get();

        return $this->ci->db->count_all_results();
    }

    public function fetch_force_component_type(){

        $this->ci->db->select('a.fcomptype_id , a.fcomptype_name');
        $this->ci->db->from('force_component_type a');
        return $this->ci->db->get()->result();
    }

}
