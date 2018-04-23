<?php

require_once('generic_dao.php');

class personnel_reff_dao extends Generic_dao {

    public function table_name() {
        return 'personnel_reff';
    }

    public function field_map() {
        return array('psnreff_nrp' => 'psnreff_nrp', 'psnreff_name' => 'psnreff_name');
    }

    public function __construct() {
        parent::__construct();
        $this->ci->load->library('dao/personnel_dao');
    }
    
    public function delete($keys){
        $this->ci->personnel_dao->delete($keys);
        $keys_o = $this->to_sql_array($keys);
        return $this->ci->db->delete($this->table_name(), $keys_o);
    }

    public function fetch_pilots($limit = 1000, $offset = 0, $criteria = null, $order_by = null, $asc = true){

        $this->ci->db->from('personnel_reff a');
        $this->ci->db->where(array('a.psnreff_ispilot = ' => 't'));
        if(!is_null($criteria)){
            $this->ci->db->where($criteria);
        }
        $this->ci->db->limit($limit, $offset);

        if ($order_by != NULL && is_array($order_by))
            $this->ci->db->order_by($order_by, $name_asc);
        $q = $this->ci->db->get();
        return $q->result();
    }
	
	public function fetch_data($limit = 1000, $offset = 0, $order_by = null, $asc = true,$array_search=null) {
		$name_asc;
		$query_search = "";
        if ($asc == true) {
            $name_asc = 'asc';
        } else {
            $name_asc = 'desc';
        }
		if($array_search!=null){
			if($array_search['psnreff_nrp']!="" && strlen($array_search['psnreff_nrp'])>0){
				$query_search .= "AND psnreff_nrp ilike '%".$this->ci->db->escape_str(str_replace('/', '_',$array_search['psnreff_nrp']))."%' ";
			}
			if($array_search['psnreff_name']!="" && strlen($array_search['psnreff_name'])>0){
				$query_search .= "AND psnreff_name ilike '%".$array_search['psnreff_name']."%' ";
			}
		}
        $this->ci->db->select('psnreff_nrp,psnreff_name');
		if($query_search!=""){
			$this->ci->db->where(substr($query_search,4,strlen($query_search)));
		}
        $this->ci->db->limit($limit, $offset);
		
        if ($order_by != NULL)
            $this->ci->db->order_by($order_by, $name_asc);
        $q = $this->ci->db->get($this->table_name());
        return $q->result();
    }
	
	public function count_fetch_data($array_search=null) {
		$name_asc;
		$query_search = "";
		if($array_search!=null){
			if($array_search['psnreff_nrp']!="" && strlen($array_search['psnreff_nrp'])>0){
				$query_search .= "AND psnreff_nrp ilike '%".$this->ci->db->escape_str(str_replace('/', '_',$array_search['psnreff_nrp']))."%' ";
			}
			if($array_search['psnreff_name']!="" && strlen($array_search['psnreff_name'])>0){
				$query_search .= "AND psnreff_name ilike '%".$array_search['psnreff_name']."%' ";
			}
		}
        $this->ci->db->select('psnreff_nrp,psnreff_name');
		if($query_search!=""){
			$this->ci->db->where(substr($query_search,4,strlen($query_search)));
		}
		$this->ci->db->from($this->table_name());
        $q = $this->ci->db->count_all_results();
        return $q;
    }
}

?>