<?php

require_once('generic_dao.php');

class marines_dao extends Generic_dao {

    public function table_name() {
        return 'marines';
    }


    public function field_map() {
        return array(
            'mar_id' => 'mar_id', 'corps_id' => 'corps_id', 'station_id' => 'station_id', 'martype_id' => 'martype_id',
            'mar_name' => 'mar_name', 'mar_description' => 'mar_description','unit_id' => 'unit_id',
            'mar_lat' => 'mar_lat', 'mar_lon' => 'mar_lon',
            'mar_personel_count' => 'mar_personel_count', 'mar_isrealtime' => 'mar_isrealtime', 
            'kolak_id' => 'kolak_id', 'marcond_id' => 'marcond_id',
            'mar_personel_ready' => 'mar_personel_ready', 'mar_personel_notready' => 'mar_personel_notready',
            'mar_location' => 'mar_location',
            'mar_timestamp_location' => 'mar_timestamp_location',
            'mar_dpp' => 'mar_dpp',
            'mar_desc' => 'mar_desc',
            'mar_personel_desc' => 'mar_personel_desc',
            'mar_matpur_desc' => 'mar_matpur_desc',
            'mar_image' => 'mar_image', // added by SKM17
            'maricon_id' => 'maricon_id', // added by SKM17
            'mar_in_ops' => 'mar_in_ops' // added by SKM17
        );
    }

    public function __construct() {
        parent::__construct();
    }
    
    public function by_id_($mar_id) {
//        $obj_id_o = $this->to_sql_array($obj_id);
        $this->ci->db->select('a.*,o.operation_id');
        $this->ci->db->from('marines as a left join marines_ops mo 
                on (a.mar_id = mo.mar_id) 
                left join operation o 
                                on (o.operation_id = mo.operation_id and o.operation_is_active = \'t\')');
        $this->ci->db->where('a.mar_id = \''.$mar_id.'\'');
        $q = $this->ci->db->get();
        return $q->row();
    }
    
    public function table_fetch ($limit = 1000, $offset = 0, $array_search = null, $where = null, $order_by = null, $asc = true, $position = false) {
        $query_search = "";
        $name_asc;
        if ($asc == true) {
            $name_asc = 'asc';
        } else {
            $name_asc = 'desc';
        }
        if ($array_search != null) {
            /* commented by SKM17
            if (array_key_exists('mar_name', $array_search) && $array_search['mar_name'] != "" && strlen($array_search['mar_name']) > 0) {
                if (strlen(trim($query_search)) > 0) {
                    $query_search .= " AND ";
                }
                $query_search .= "a.mar_name ilike '%" . $array_search['mar_name'] . "%'";
            }
            if (array_key_exists('mar_isrealtime', $array_search) && $array_search['mar_isrealtime'] != "") {
                if (strlen(trim($query_search)) > 0) {
                    $query_search .= " AND ";
                }
                $query_search .= "a.mar_isrealtime = " . $array_search['mar_isrealtime'] . " ";
            }
            if (array_key_exists('martype_id', $array_search) && $array_search['martype_id'] != "") {
                if (strlen(trim($query_search)) > 0) {
                    $query_search .= " AND ";
                }
                $query_search .= "a.martype_id= '" . $array_search['martype_id'] . "' ";
            }
            */
            if (array_key_exists('corps_id', $array_search) && $array_search['corps_id'] != "") {
                if (strlen(trim($query_search)) > 0) {
                    $query_search .= " AND ";
                }
                $query_search .= "a.corps_id= '" . $array_search['corps_id'] . "' ";
            }
            if (array_key_exists('unit_id', $array_search) && $array_search['unit_id'] != "") {
                if (strlen(trim($query_search)) > 0) {
                    $query_search .= " AND ";
                }
                $query_search .= "a.unit_id= '" . $array_search['unit_id'] . "' ";
            }
            /* commented by SKM17
            if (array_key_exists('mar_timestamp_date', $array_search) && array_key_exists('mar_timestamp_time', $array_search) && $array_search['mar_timestamp_date'] != "" && $array_search['mar_timestamp_time'] != "") {
                if (strlen(trim($query_search)) > 0) {
                    $query_search .= " AND ";
                }
                if ($array_search['mar_timestamp_time'] == '06.00') {
                    $query_search .= "a.mar_timestamp_location >= '" . $array_search['mar_timestamp_date'] . " 06:00:00' and a.mar_timestamp_location <= '" . $array_search['mar_timestamp_date'] . " 09:00:00'";
                } else {
                    $query_search .= "a.mar_timestamp_location >= '" . $array_search['mar_timestamp_date'] . " 17:00:00' and a.mar_timestamp_location <= '" . $array_search['mar_timestamp_date'] . " 19:00:00'";
                }
            }
            */
        }
        $from_cond = '';
        if ($position == true) {
            $this->ci->db->select('a.*, c.corps_name,marines_type.martype_name,
                    marines_kolak.kolak_description,marines_condition.marcond_description,o.operation_name');
            $from_cond = ' left join marines_ops mo 
                on (a.mar_id = mo.mar_id) 
                left join operation o 
                                on (o.operation_id = mo.operation_id and o.operation_is_active = \'t\')';
        } else {
            $this->ci->db->select('a.*, c.corps_name,marines_type.martype_name,marines_kolak.kolak_description,
                                marines_condition.marcond_description, unit.unit_name');
        }
        $this->ci->db->from('marines as a LEFT JOIN marines_kolak ON (marines_kolak.kolak_id = a.kolak_id)
                left join corps as c
                        on(a.corps_id = c.corps_id)
                left join marines_type
                        on(marines_type.martype_id = a.martype_id) 
                left join marines_condition
                        on(marines_condition.marcond_id = a.marcond_id)
                left join unit 
                        on(unit.unit_id = a.unit_id)' . $from_cond);
        if (strlen(trim($query_search)) > 0) {
            $this->ci->db->where($query_search, null, false);
        }
        if (!is_null($where) && count($where) > 0) {
            $this->ci->db->where($where);
        }

        $this->ci->db->limit($limit, $offset);
        //if ($order_by != NULL && is_array($order_by))
        //    $this->ci->db->order_by($order_by, $name_asc);
        $this->ci->db->order_by('unit.unit_name', 'asc');
        $q = $this->ci->db->get();
        return $q->result();
    }

    public function count_table_fetch($array_search = null, $position = false) {
        $query_search = "";
        if ($array_search != null) {
            /* commented by SKM17
            if (array_key_exists('mar_name', $array_search) && $array_search['mar_name'] != "" && strlen($array_search['mar_name']) > 0) {
                if (strlen(trim($query_search)) > 0) {
                    $query_search .= " AND ";
                }
                $query_search .= "a.mar_name ilike '%" . $array_search['mar_name'] . "%'";
            }
            if (array_key_exists('mar_isrealtime', $array_search) && $array_search['mar_isrealtime'] != "") {
                if (strlen(trim($query_search)) > 0) {
                    $query_search .= " AND ";
                }
                $query_search .= "a.mar_isrealtime = " . $array_search['mar_isrealtime'] . " ";
            }
            if (array_key_exists('martype_id', $array_search) && $array_search['martype_id'] != "") {
                if (strlen(trim($query_search)) > 0) {
                    $query_search .= " AND ";
                }
                $query_search .= "a.martype_id= '" . $array_search['martype_id'] . "' ";
            }
            */
            if (array_key_exists('corps_id', $array_search) && $array_search['corps_id'] != "") {
                if (strlen(trim($query_search)) > 0) {
                    $query_search .= " AND ";
                }
                $query_search .= "a.corps_id= '" . $array_search['corps_id'] . "' ";
            }
            if (array_key_exists('unit_id', $array_search) && $array_search['unit_id'] != "") {
                if (strlen(trim($query_search)) > 0) {
                    $query_search .= " AND ";
                }
                $query_search .= "a.unit_id= '" . $array_search['unit_id'] . "' ";
            }
            /* commented by SKM17
            if (array_key_exists('mar_timestamp_date', $array_search) && array_key_exists('mar_timestamp_time', $array_search) && $array_search['mar_timestamp_date'] != "" && $array_search['mar_timestamp_time'] != "") {
                if ($array_search['mar_timestamp_time'] == '06.00') {
                    $query_search .= "a.mar_timestamp_location >= '" . $array_search['mar_timestamp_date'] . " 06:00:00' and a.mar_timestamp_location <= '" . $array_search['mar_timestamp_date'] . " 09:00:00'";
                } else {
                    $query_search .= "a.mar_timestamp_location >= '" . $array_search['mar_timestamp_date'] . " 17:00:00' and a.mar_timestamp_location <= '" . $array_search['mar_timestamp_date'] . " 19:00:00'";
                }
            }
            */
        }
        $from_cond = '';
        if ($position == true) {
            $this->ci->db->select('a.*, c.corps_name,marines_type.martype_name,

                    marines_kolak.kolak_description,marines_condition.marcond_description,o.operation_name');
            $from_cond = ' left join marines_ops mo 
                on (a.mar_id = mo.mar_id) 
                left join operation o 
                                on (o.operation_id = mo.operation_id and o.operation_is_active = \'t\')';
        } else {
            $this->ci->db->select('a.*, c.corps_name,marines_type.martype_name,marines_kolak.kolak_description,
                                marines_condition.marcond_description, unit.unit_name');
        }
        $this->ci->db->select('a.*, c.corps_name,marines_type.martype_name,marines_kolak.kolak_description,marines_condition.marcond_description');
        $this->ci->db->from('marines as a LEFT JOIN marines_kolak ON (marines_kolak.kolak_id = a.kolak_id)
                left join corps as c
                        on(a.corps_id = c.corps_id)
                left join marines_type
                        on(marines_type.martype_id = a.martype_id) 
                left join marines_condition
                        on(marines_condition.marcond_id = a.marcond_id)' . $from_cond);
        if (strlen(trim($query_search)) > 0) {
            $this->ci->db->where($query_search, null, false);
        }

        $q = $this->ci->db->count_all_results();
        return $q;
    }

}

?>
