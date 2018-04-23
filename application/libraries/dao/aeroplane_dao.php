<?php

require_once('generic_dao.php');

class aeroplane_dao extends Generic_dao {

    public function table_name() {
        return 'aeroplane';
    }


    public function field_map() {

        return array(
            'station_id' => 'station_id', 'unit_id' => 'unit_id', 'psnreff_nrp' => 'psnreff_nrp',
            'aertype_id' => 'aertype_id', 'aer_id' => 'aer_id',
            'corps_id' => 'corps_id', 'aer_lat' => 'aer_lat',
            'aer_lon' => 'aer_lon', 'aer_name' => 'aer_name',
            'aer_speed' => 'aer_speed', 'aer_endurance' => 'aer_endurance',
            'aer_isrealtime' => 'aer_isrealtime', 'aercond_id' => 'aercond_id',
            'aer_data_taktis' => 'aer_data_taktis',
            'aer_data_utama' => 'aer_data_utama',
            'aer_sistem_penggerak' => 'aer_sistem_penggerak',
            'aer_alat_penolong' => 'aer_alat_penolong',
            'aer_sistem_kendali' => 'aer_sistem_kendali',
            'aer_logistik' => 'aer_logistik',
            'aer_facility_needed' => 'aer_facility_needed',
            'aer_realitation' => 'aer_realitation',
            'aer_pjl_ops' => 'aer_pjl_ops',
            'aer_commander' => 'aer_commander',
            'aer_location' => 'aer_location',
            'aer_timestamp_location' => 'aer_timestamp_location',
            'aer_desc' => 'aer_desc',
            'aer_image' => 'aer_image', // added by SKM17
            'operation_id' => 'operation_id', // added by SKM17
            'aer_is_in_operation' => 'aer_is_in_operation', // added by SKM17
            'aericon_id' => 'aericon_id', // added by SKM17
            'pilot_name' => 'pilot_name', // added by SKM17
            'kodal_id' => 'kodal_id' // added by SKM17
        );
    }

    public function __construct() {
        parent::__construct();
    }
    
    public function by_id_($aer_id) {
//        $obj_id_o = $this->to_sql_array($obj_id);
        $this->ci->db->select('a.*, o.operation_name');
        /* commented by SKM17
        $this->ci->db->from('aeroplane as a left join aeroplane_ops so 
                on (a.aer_id = so.aer_id) 
                left join operation o 
                                on (o.operation_id = so.operation_id and o.operation_is_active = \'t\')');
        */
        $this->ci->db->from('aeroplane AS a LEFT JOIN operation o ON (o.operation_id = a.operation_id)'); // added by SKM17
        $this->ci->db->where('a.aer_id = \''.$aer_id.'\'');
        $q = $this->ci->db->get();
        return $q->row();
    }
    
    public function table_fetch($where = null, $limit = 1000, $offset = 0, $array_search = null, $order_by = null, $asc = true, $position = false) {
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
            // added by SKM17
            if (array_key_exists('kodal_id', $array_search) && $array_search['kodal_id'] != "") {
                $query_search .= " AND aer.kodal_id= '" . $array_search['kodal_id'] . "' ";
            }
            if (array_key_exists('aer_timestamp_date', $array_search) && array_key_exists('aer_timestamp_time', $array_search) && $array_search['aer_timestamp_date'] != "" && $array_search['aer_timestamp_time'] != "") {
                if ($array_search['aer_timestamp_time'] == '06.00') {
                    $query_search .= " AND aer.aer_timestamp_location >= '" . $array_search['aer_timestamp_date'] . " 06:00:00' and aer.aer_timestamp_location <= '" . $array_search['aer_timestamp_date'] . " 09:00:00'";
                } else {
                    $query_search .= " AND aer.aer_timestamp_location >= '" . $array_search['aer_timestamp_date'] . " 17:00:00' and aer.aer_timestamp_location <= '" . $array_search['aer_timestamp_date'] . " 19:00:00'";
                }
            }
            // added by SKM17
            if (array_key_exists('aer_is_in_operation', $array_search) && $array_search['aer_is_in_operation'] != "") {
                $query_search .= " AND aer.aer_is_in_operation = '" . $array_search['aer_is_in_operation'] . "' ";
            }
            //added by KP D3
            if (array_key_exists('operation_id', $array_search) && $array_search['operation_id'] != "") {
                $query_search .= " AND aer.operation_id= '" . $array_search['operation_id'] . "' ";
            }
            //end added

        }
        $from_cond = '';
        if($position == true){
            $this->ci->db->select('aer.*, a.corps_name, b.aertype_name, c.aercond_description, d.unit_name, o.operation_name, o.operation_id, k.corps_name AS kodal_name');
            /* commented by SKM17
            $from_cond = ' left join aeroplane_ops ao
                            on (aer.aer_id = ao.aer_id)
                            left join operation o
                                on (o.operation_id = ao.operation_id and o.operation_is_active = \'t\')';
            */
            $from_cond = ' LEFT JOIN operation o ON (o.operation_id = aer.operation_id)'; // added by SKM17
        }else{
            $this->ci->db->select('aer.*, a.corps_name, b.aertype_name, c.aercond_description, d.unit_name, k.corps_name AS kodal_name');
        }
        $this->ci->db->from('aeroplane as aer
			LEFT JOIN corps as a on(aer.corps_id = a.corps_id)
			LEFT JOIN corps as k on (aer.kodal_id = k.corps_id)
			LEFT JOIN aeroplane_type b on(b.aertype_id = aer.aertype_id)
			LEFT JOIN aeroplane_condition as c on(c.aercond_id = aer.aercond_id)
			LEFT JOIN unit d on (aer.unit_id=d.unit_id)'.$from_cond);
        $this->ci->db->where('aer.corps_id = a.corps_id ' . $query_search);
        $this->ci->db->order_by('aer.aer_name', 'asc');
        if (!is_null($where) && count($where) > 0) {
            $this->ci->db->where($where);
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
            // added by SKM17
            if (array_key_exists('corps_id_not', $array_search) && $array_search['corps_id_not'] != "") {
                foreach ($array_search['corps_id_not'] as &$value) {
                    $query_search .= " AND aer.corps_id <> '" . $value . "' ";
                }
            }
            if (array_key_exists('kodal_id', $array_search) && $array_search['kodal_id'] != "") {
                $query_search .= " AND aer.kodal_id= '" . $array_search['kodal_id'] . "' ";
            }
            if (array_key_exists('aer_timestamp_date', $array_search) && array_key_exists('aer_timestamp_time', $array_search) && $array_search['aer_timestamp_date'] != "" && $array_search['aer_timestamp_time'] != "") {
                if ($array_search['aer_timestamp_time'] == '06.00') {
                    $query_search .= " AND aer.aer_timestamp_location >= '" . $array_search['aer_timestamp_date'] . " 06:00:00' and aer.aer_timestamp_location <= '" . $array_search['aer_timestamp_date'] . " 09:00:00'";
                } else {
                    $query_search .= " AND aer.aer_timestamp_location >= '" . $array_search['aer_timestamp_date'] . " 17:00:00' and aer.aer_timestamp_location <= '" . $array_search['aer_timestamp_date'] . " 19:00:00'";
                }
            }
            // added by SKM17
            if (array_key_exists('aer_is_in_operation', $array_search) && $array_search['aer_is_in_operation'] != "") {
                $query_search .= " AND aer.aer_is_in_operation = '" . $array_search['aer_is_in_operation'] . "' ";
            }
            //added by KP D3
            if (array_key_exists('operation_id', $array_search) && $array_search['operation_id'] != "") {
                $query_search .= " AND aer.operation_id= '" . $array_search['operation_id'] . "' ";
            }
            //end added

        }

        $this->ci->db->from('aeroplane as aer
            LEFT JOIN corps as a on(aer.corps_id = a.corps_id)
            LEFT JOIN aeroplane_type b on(b.aertype_id = aer.aertype_id)
            LEFT JOIN aeroplane_condition as c on(c.aercond_id = aer.aercond_id)
            LEFT JOIN unit d on (aer.unit_id=d.unit_id)');
        $this->ci->db->where('aer.corps_id = a.corps_id ' . $query_search);

        if (!is_null($where) && count($where) > 0) {
            $this->ci->db->where($where);
        }
        $q = $this->ci->db->count_all_results();
        return $q;
    }

}

?>
