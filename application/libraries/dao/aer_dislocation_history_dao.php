<?php

require_once('generic_dao.php');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class aer_dislocation_history_dao extends Generic_dao {

    public function field_map() {
        return array('aerdis_date' => 'aerdis_date',
            'aerdis_time' => 'aerdis_time',
            'aer_id' => 'aer_id',
            'aerdis_lat' => 'aerdis_lat',
            'aerdis_lon' => 'aerdis_lon',
            'aerdis_direction' => 'aerdis_direction',
            'aerdis_speed' => 'aerdis_speed',
            'operation_id' => 'operation_id',
            'aerdis_location' => 'aerdis_location',
            'aerdis_endurance' => 'aerdis_endurance');
    }

    public function table_name() {
        return 'aer_dislocation_history';
    }

    public function __construct() {
        parent::__construct();
    }

    public function table_fetch($where = null, $limit = 1000, $offset = 0, $array_search = null, $order_by = null, $asc = true) {
        $name_asc;
        $query_search = "";
        if ($asc == true) {
            $name_asc = 'asc';
        } else {
            $name_asc = 'desc';
        }
        if ($array_search != null) {
            if (array_key_exists('aer_name', $array_search) && $array_search['aer_name'] != "" && strlen($array_search['aer_name']) > 0) {
                $query_search .= " AND aer.aer_name ilike '%" . $array_search['aer_name'] . "%'";
            }
            if (array_key_exists('aer_isrealtime', $array_search) && $array_search['aer_isrealtime'] != "") {
                $query_search .= " AND aer.aer_isrealtime = " . $array_search['aer_isrealtime'] . " ";
            }
//            if(array_key_exists ( 'station_id' , $array_search ) && $array_search['station_id']!=""){
//                $query_search .= " AND aer.station_id= '".$array_search['station_id']."' ";
//            }
            if (array_key_exists('aertype_id', $array_search) && $array_search['aertype_id'] != "") {
                $query_search .= " AND aer.aertype_id= '" . $array_search['aertype_id'] . "' ";
            }
            if (array_key_exists('corps_id', $array_search) && $array_search['corps_id'] != "") {
                $query_search .= " AND aer.corps_id= '" . $array_search['corps_id'] . "' ";
            }
            if (array_key_exists('aer_timestamp_date', $array_search) && $array_search['aer_timestamp_date'] != "") {
                $query_search .= " AND ad.aerdis_date = '" . $array_search['aer_timestamp_date'] . "'";
            }
            if (array_key_exists('aer_timestamp_time', $array_search) && $array_search['aer_timestamp_time'] != "") {
                $query_search .= " AND ad.aerdis_time = '" . $array_search['aer_timestamp_time'] . ":00'";
            }
            //added by KP D3
            if (array_key_exists('operation_id', $array_search) && $array_search['operation_id'] != "") {
                $query_search .= " AND ad.operation_id= '" . $array_search['operation_id'] . "' ";
            }
            //end added
        }
        $this->ci->db->select('ad.aerdis_lat, ad.aerdis_lat as aer_lat, ad.aerdis_lon as aer_lon, ad.aerdis_speed as aer_speed,
        	ad.aerdis_endurance as aer_endurance, aerdis_location as aer_location, aer.aer_id,aer.aer_name, aer.pilot_name, aer.aericon_id,
        	ad.aerdis_date, ad.aerdis_time, a.corps_name, b.aertype_name, c.aercond_description, d.unit_name, o.operation_name,
            k.corps_name AS kodal_name
            ');
        //D3 added join corps k , aer.pilot_name
        $this->ci->db->from('aer_dislocation_history as ad
			LEFT JOIN aeroplane as aer on (ad.aer_id = aer.aer_id)
			LEFT JOIN corps as a on(aer.corps_id = a.corps_id)
            left join corps k on(aer.kodal_id = k.corps_id)
			LEFT JOIN aeroplane_type b on(b.aertype_id = aer.aertype_id)
			LEFT JOIN aeroplane_condition as c on(c.aercond_id = aer.aercond_id)
			LEFT JOIN unit d on (aer.unit_id=d.unit_id)
			LEFT JOIN operation o on (o.operation_id = ad.operation_id)');
        $this->ci->db->where('aer.corps_id = a.corps_id ' . $query_search);
        $this->ci->db->order_by('aer.aer_name', 'asc');
        if (!is_null($where) && count($where) > 0) {
            $this->ci->db->where($where,null,false);
        }

        $this->ci->db->limit($limit, $offset);
        $q = $this->ci->db->get();
        return $q->result();
    }

    public function count_table_fetch($where = null, $array_search = null) {
        $query_search = "";
        if ($array_search != null) {
            if (array_key_exists('aer_name', $array_search) && $array_search['aer_name'] != "" && strlen($array_search['aer_name']) > 0) {
                $query_search .= " AND aer.aer_name ilike '%" . $array_search['aer_name'] . "%'";
            }
            if (array_key_exists('aer_isrealtime', $array_search) && $array_search['aer_isrealtime'] != "") {
                $query_search .= " AND aer.aer_isrealtime = " . $array_search['aer_isrealtime'] . " ";
            }
//            if(array_key_exists ( 'station_id' , $array_search ) && $array_search['station_id']!=""){
//                $query_search .= " AND aer.station_id= '".$array_search['station_id']."' ";
//            }
            if (array_key_exists('aertype_id', $array_search) && $array_search['aertype_id'] != "") {
                $query_search .= " AND aer.aertype_id= '" . $array_search['aertype_id'] . "' ";
            }
            if (array_key_exists('corps_id', $array_search) && $array_search['corps_id'] != "") {
                $query_search .= " AND aer.corps_id= '" . $array_search['corps_id'] . "' ";
            }
            if (array_key_exists('aer_timestamp_date', $array_search) && $array_search['aer_timestamp_date'] != "") {
                $query_search .= " AND ad.aerdis_date = '" . $array_search['aer_timestamp_date'] . "'";
            }
            if (array_key_exists('aer_timestamp_time', $array_search) && $array_search['aer_timestamp_time'] != "") {
                $query_search .= " AND ad.aerdis_time = '" . $array_search['aer_timestamp_time'] . ":00'";
            }
             //added by KP D3
            if (array_key_exists('operation_id', $array_search) && $array_search['operation_id'] != "") {
                $query_search .= " AND ad.operation_id= '" . $array_search['operation_id'] . "' ";
            }
            //end added
        }

//        $this->ci->db->select('ad.aerdis_lat as aer_lot,ad.aerdis_lon as aer_lon,ad.aerdis_speed as aer_speed,ad.aerdis_endurance as aer_endurance
//	,aer.aer_id,aer.aer_name, a.corps_name,b.aertype_name,c.aercond_description,d.unit_name,o.operation_name');
        $this->ci->db->from('aer_dislocation_history as ad
			LEFT JOIN	aeroplane as aer on (ad.aer_id = aer.aer_id)
			LEFT JOIN corps as a on(aer.corps_id = a.corps_id)
			LEFT JOIN aeroplane_type b on(b.aertype_id = aer.aertype_id)
			LEFT JOIN aeroplane_condition as c on(c.aercond_id = aer.aercond_id)
			LEFT JOIN unit d on (aer.unit_id=d.unit_id)
			LEFT JOIN operation o on (o.operation_id = ad.operation_id)');
        $this->ci->db->where('aer.corps_id = a.corps_id ' . $query_search);

        if (!is_null($where) && count($where) > 0) {
            $this->ci->db->where($where);
        }
        $q = $this->ci->db->count_all_results();
        return $q;
    }

}
