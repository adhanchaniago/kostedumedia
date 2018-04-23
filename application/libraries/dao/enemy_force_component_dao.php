<?php

require_once('generic_dao.php');

class enemy_force_component_dao extends Generic_dao{


	
	public function table_name() {
        return 'enemy_force_component';
    }

    public function field_map() {

        return array(
            'enmap_id' => 'enmap_id',
			'fcomp_id'=> 'fcomp_id',
			'efcomp_power' => 'efcomp_power',
			'efcomp_desc' => 'efcomp_desc'
        );
    }

    public function table_fetch( $criteria = null, $order = null, $asc = true, $limit = 1000, $offset = 0 ){

    	$order_command = 'ASC';
    	if(!$asc){
    		$order_command = 'DESC';
    	}

    	if(! is_null($criteria)){
    		

    	}

    	$this->ci->db->select('a.* , b.eforcetype_name');
    	$this->ci->db->from('enemy_force_component a left join force_component b on (a.fcomp_id= b.fcomp_id)');
    	$this->ci->db->order_by('a.enmap_id, a.fcomp_id', 'asc');
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
            

        }

        $this->ci->db->select('a.* , b.eforcetype_name');
        $this->ci->db->from('enemy_force_component a left join force_component b on (a.fcomp_id= b.fcomp_id)');
        $this->ci->db->order_by('a.enmap_id, a.fcomp_id', 'asc');
        // echo 'limit : '.$limit;
        $this->ci->db->limit($limit, $offset);
        $q = $this->ci->db->get();

        return $this->ci->db->count_all_results();
    }

}
