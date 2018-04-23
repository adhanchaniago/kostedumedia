<?php

require_once('generic_dao.php');

class station_dao extends Generic_dao {

    public function table_name() {
        return 'station';
    }

    public function field_map() {
        return array('station_id' => 'station_id', 
			'sclass_id' => 'sclass_id', 
			'station_arpaid' => 'station_arpaid',
			'stype_id' => 'stype_id', 
			'corps_id' => 'corps_id', 
			'station_parent'=>'station_parent',
			'station_name' => 'station_name', 
			'station_lat' => 'station_lat', 
			'station_lon' => 'station_lon',
			'station_desc'=>'station_desc',
			'station_fac_sandar'=>'station_fac_sandar',
			'station_fac_perbekalan'=>'station_fac_perbekalan',
			'station_fac_perawatan'=>'station_fac_perawatan',
			'station_fac_power'=>'station_fac_power',
			'station_people' => 'station_people',
			'station_commander'=>'station_commander',
			'station_dsp'=>'station_dsp',
			'station_image'=>'station_image', // edited by SKM17 from icon to image
			'station_fac_sandar_image'=>'station_fac_sandar_image', // added by SKM17
			'station_fac_perbekalan_image'=>'station_fac_perbekalan_image', // added by SKM17
			'station_fasharkan'=>'station_fasharkan', // added by SKM17
			'station_location'=>'station_location' // added by SKM17
		);
    }

    public function __construct() {
        parent::__construct();
        $this->ci->load->library('dao/station_logistics_dao');
    }

    public function fetch_skuadron($limit = 1000, $offset = 0, $criteria = null, $order_by = null, $asc = true){

        $this->ci->db->from('station a');
        $this->ci->db->join('station_type b', 'a.stype_id = b.stype_id');
        $this->ci->db->where(array('b.stype_id = ' => STATIONCODE_LANUDAL));
        if(!is_null($criteria)){
            $this->ci->db->where($criteria);
        }
        $this->ci->db->limit($limit, $offset);
        $this->ci->db->order_by('station_name','asc');
        if ($order_by != NULL && is_array($order_by))
            $this->ci->db->order_by($order_by, $name_asc);
        $q = $this->ci->db->get();
        return $q->result();
    }

    public function table_fetch($limit = 1000, $offset = 0, $array_search=null, $order_by = null, $asc = true) {
        $query_search = "";
		$name_asc;
        if ($asc == true) {
            $name_asc = 'asc';
        } else {
            $name_asc = 'desc';
        }
		if($array_search!=null){
			if(array_key_exists ( 'station_name' , $array_search ) && $array_search['station_name']!="" && strlen($array_search['station_name'])>0){
				$query_search .= " AND station.station_name ilike '%".$array_search['station_name']."%'";
			}
			if( array_key_exists ( 'station_id' , $array_search ) && $array_search['station_id']!="" && strlen($array_search['station_id'])>0){
				$query_search .= " AND station.station_id = '".$array_search['station_id']."' ";
			}
            if(array_key_exists ( 'stype_id' , $array_search ) && $array_search['stype_id']!=""){
                $query_search .= " AND station.stype_id= '".$array_search['stype_id']."' ";
            }
			if(array_key_exists ( 'sclass_id' , $array_search ) && $array_search['sclass_id']!=""){
                $query_search .= " AND station.sclass_id= '".$array_search['sclass_id']."' ";
            }
			if(array_key_exists ( 'corps_id' , $array_search ) && $array_search['corps_id']!=""){
                $query_search .= " AND station.corps_id= '".$array_search['corps_id']."' ";
            }
		}
        $this->ci->db->select('station.*, corps.corps_name, station_type.stype_name');
        $this->ci->db->from('station LEFT JOIN corps ON station.corps_id = corps.corps_id, station_type');
        $this->ci->db->where('station.stype_id = station_type.stype_id '.$query_search);
        $this->ci->db->limit($limit, $offset);
        if ($order_by)
            $this->ci->db->order_by($order_by, $name_asc);
        $q = $this->ci->db->get();
        return $q->result();
    }
	
	public function count_table_fetch($array_search=null) {
        $query_search = "";
		if($array_search!=null){
			if(array_key_exists ( 'station_name' , $array_search ) && $array_search['station_name']!="" && strlen($array_search['station_name'])>0){
				$query_search .= " AND station.station_name ilike '%".$array_search['station_name']."%'";
			}
			if( array_key_exists ( 'station_id' , $array_search ) && $array_search['station_id']!="" && strlen($array_search['station_id'])>0){
				$query_search .= " AND station.station_id = '".$array_search['station_id']."' ";
			}
            if(array_key_exists ( 'stype_id' , $array_search ) && $array_search['stype_id']!=""){
                $query_search .= " AND station.stype_id= '".$array_search['stype_id']."' ";
            }
			if(array_key_exists ( 'sclass_id' , $array_search ) && $array_search['sclass_id']!=""){
                $query_search .= " AND station.sclass_id= '".$array_search['sclass_id']."' ";
            }
			if(array_key_exists ( 'corps_id' , $array_search ) && $array_search['corps_id']!=""){
                $query_search .= " AND station.corps_id= '".$array_search['corps_id']."' ";
            }
		}
        $this->ci->db->select('station.*,corps.corps_name,station_type.stype_name');
        $this->ci->db->from('station LEFT JOIN corps ON station.corps_id = corps.corps_id,station_type');
        $this->ci->db->where('station.stype_id = station_type.stype_id '.$query_search);
        $q = $this->ci->db->count_all_results();
        return $q;
    }

    public function fetch_parent_stations(){
        /*
            select * from station
            where corps_id <> '0'
        */
        $this->ci->db->select('station_id, station_name');
        $this->ci->db->from('station');
        $this->ci->db->where("corps_id <> '0'");
        $this->ci->db->order_by("station_name", "asc");
        
        
        
        $q = $this->ci->db->get();
        return $q->result();
    }

    public function delete($keys) {
        /* delete ship relation */
        $this->ci->station_logistics_dao->delete($keys);

        $keys_o = $this->to_sql_array($keys);
        return $this->ci->db->delete($this->table_name(), $keys_o);
    }

}

?>
