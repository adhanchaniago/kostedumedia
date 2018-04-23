<?php

require_once('generic_dao.php');

class areal_report_dao extends Generic_dao {

    public function table_name() {
        return 'areal_report';
    }

    public function field_map() {
        return array(
            'ar_id' => 'ar_id', 'user_id' => 'user_id', 'vt_id' => 'vt_id', 
            'rt_id' => 'rt_id', 'ar_date' => 'ar_date', 'ar_time' => 'ar_time', 
            'ar_title' => 'ar_title', 'ar_content' => 'ar_content', 
            'ar_lat' => 'ar_lat', 'ar_lon' => 'ar_lon', 'ar_posting_timestamp' => 'ar_posting_timestamp',
            'ar_reporter' => 'ar_reporter');
    }

    public function __construct() {
        parent::__construct();
    }

    public function table_fetch($limit = 1000, $offset = 0,$array_search=null, $order_by = null, $asc = true) {
        $name_asc;
        if ($asc == true) {
            $name_asc = 'asc';
        } else {
            $name_asc = 'desc';
        }
		$query_search = "";
		if($array_search!=null){
			if( array_key_exists ( 'ar_date_start' , $array_search ) && $array_search['ar_date_start']!="" && array_key_exists ( 'ar_date_end' , $array_search ) && $array_search['ar_date_end']!=""){
				$query_search .= " AND areal_report.ar_date <= '".$array_search['ar_date_end']."' and areal_report.ar_date >= '".$array_search['ar_date_start']."' ";
			}
            if(array_key_exists ( 'vt_id' , $array_search ) && $array_search['vt_id']!=""){
                $query_search .= " AND areal_report.vt_id= '".$array_search['vt_id']."' ";
            }
			if(array_key_exists ( 'rt_id' , $array_search ) && $array_search['rt_id']!=""){
                $query_search .= " AND areal_report.rt_id= '".$array_search['rt_id']."' ";
            }
		}
        $this->ci->db->select('areal_report.*,u.username,v.vt_desc,r.rt_desc');
        $this->ci->db->from('areal_report, users as u, violation_type as v, report_type as r');
        $this->ci->db->where('areal_report.user_id = u.user_id AND
				areal_report.vt_id = v.vt_id AND
				areal_report.rt_id = r.rt_id'.$query_search);
        $this->ci->db->limit($limit, $offset);
        if ($order_by != NULL && is_array($order_by))
            $this->ci->db->order_by($order_by, $name_asc);
        $q = $this->ci->db->get();
        return $q->result();
    }
	
	public function count_table_fetch($array_search=null) {
		$query_search = "";
		if($array_search!=null){
			if( array_key_exists ( 'ar_date_start' , $array_search ) && $array_search['ar_date_start']!="" && array_key_exists ( 'ar_date_end' , $array_search ) && $array_search['ar_date_end']!=""){
				$query_search .= " AND areal_report.ar_date <= '".$array_search['ar_date_end']."' and areal_report.ar_date >= '".$array_search['ar_date_start']."' ";
			}
            if(array_key_exists ( 'vt_id' , $array_search ) && $array_search['vt_id']!=""){
                $query_search .= " AND areal_report.vt_id= '".$array_search['vt_id']."' ";
            }
			if(array_key_exists ( 'rt_id' , $array_search ) && $array_search['rt_id']!=""){
                $query_search .= " AND areal_report.rt_id= '".$array_search['rt_id']."' ";
            }
		}
        $this->ci->db->select('areal_report.*,u.username,v.vt_desc,r.rt_desc');
        $this->ci->db->from('areal_report, users as u, violation_type as v, report_type as r');
        $this->ci->db->where('areal_report.user_id = u.user_id AND
				areal_report.vt_id = v.vt_id AND
				areal_report.rt_id = r.rt_id'.$query_search);
        $q = $this->ci->db->count_all_results();
        return $q;
    }

}

?>