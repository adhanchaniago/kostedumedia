<?php

require_once('generic_dao.php');

class logistic_item_dao extends Generic_dao {

    public function table_name() {
        return 'logistic_item';
    }

    public function field_map() {
        return array('logitem_id' => 'logitem_id', 'logitem_desc' => 'logitem_desc', 
                    'logitem_metric' => 'logitem_metric', 'logitemctx_id'=>'logitemctx_id',
                    'logitemcat_id'=>'logitemcat_id');
    }

    public function __construct() {
        parent::__construct();
    }
    
	public function fetch($context = null, $limit = 1000, $offset = 0,$array_search=null, $order_by = null, $asc = true) {
		$name_asc;
		if ($asc == true) {
			$name_asc = 'asc';
		} else {
			$name_asc = 'desc';
		}
		$query_search = "";
		// $this->ci->db->select($this->field_query());
		
		if (!is_null($context)) $query_search .= "AND li.logitemctx_id = '".$context."'";
		
		if($array_search!=null){
			if(array_key_exists ( 'logitem_desc' , $array_search ) && $array_search['logitem_desc']!="" && strlen($array_search['logitem_desc'])>0){
				$query_search .= "AND li.logitem_desc ilike '%".$array_search['logitem_desc']."%'";
			}
			if( array_key_exists ( 'logitemctx_id' , $array_search ) && $array_search['logitemctx_id']!=""){
				$query_search .= "AND li.logitemctx_id = ".$array_search['logitemctx_id']." ";
			}
			if(array_key_exists ( 'logitemcat_id' , $array_search ) && $array_search['logitemcat_id']!=""){
				$query_search .= "AND li.logitemcat_id= '".$array_search['logitemcat_id']."' ";
			}
		}
		
        $this->ci->db->select('li.*, lic.logitemctx_name, licat.logitemcat_name');
        $this->ci->db->from('logistic_item li LEFT JOIN logistic_item_context lic ON (li.logitemctx_id = lic.logitemctx_id)
        	LEFT JOIN logistic_item_category licat ON (li.logitemcat_id = licat.logitemcat_id)'
        );
		if ($query_search!="") $this->ci->db->where(substr($query_search,4,strlen($query_search)));
        
		$this->ci->db->limit($limit, $offset);
		if ($order_by != NULL) $this->ci->db->order_by('li.' . $order_by, $name_asc);
		
		$q = $this->ci->db->get();
		return $q->result();
	}
	
	public function count_table_fetch($context = null,$array_search=null) {
		$query_search = "";
		if (!is_null($context)) $query_search .= "AND li.logitemctx_id = '".$context."'";
		
		if($array_search!=null){
			if(array_key_exists ( 'logitem_desc' , $array_search ) && $array_search['logitem_desc']!="" && strlen($array_search['logitem_desc'])>0){
				$query_search .= "AND li.logitem_desc ilike '%".$array_search['logitem_desc']."%'";
			}
			if( array_key_exists ( 'logitemctx_id' , $array_search ) && $array_search['logitemctx_id']!=""){
				$query_search .= "AND li.logitemctx_id = ".$array_search['logitemctx_id']." ";
			}
			if(array_key_exists ( 'logitemcat_id' , $array_search ) && $array_search['logitemcat_id']!=""){
				$query_search .= "AND li.logitemcat_id= '".$array_search['logitemcat_id']."' ";
			}
		}
		
        $this->ci->db->select('li.*');
        $this->ci->db->from('logistic_item li');
		if ($query_search!="") $this->ci->db->where(substr($query_search,4,strlen($query_search)));
		
		$q = $this->ci->db->count_all_results();
		return $q;
	}
}

?>
