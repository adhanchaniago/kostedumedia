<?php

require_once('generic_dao.php');

class mar_dislocation_history_dao extends Generic_dao {

    public function field_map() {
        return array('mardis_date' => 'mardis_date',
            'mardis_time' => 'mardis_time',
            'mar_id' => 'mar_id',
            'mardis_lat' => 'mardis_lat',
            'mardis_lon' => 'mardis_lon',
            'mardis_location' => 'mardis_location',
            'mardis_dpp' => 'mardis_dpp',
            'mardis_personel_desc' => 'mardis_personel_desc',
            'mardis_matpur_desc' => 'mardis_matpur_desc',
            'operation_id' => 'operation_id');
    }

    public function table_name() {
        return 'mar_dislocation_history';
    }

    public function __construct() {
        parent::__construct();
    }

    public function table_fetch($where = null, $limit = 1000, $offset = 0, $array_search = null, $order_by = null, $asc = true, $position = true) {
        $query_search = "";
        $name_asc;
        if ($asc == true) {
            $name_asc = 'asc';
        } else {
            $name_asc = 'desc';
        }
        if ($array_search != null) {
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
            if (array_key_exists('corps_id', $array_search) && $array_search['corps_id'] != "") {
                if (strlen(trim($query_search)) > 0) {
                    $query_search .= " AND ";
                }
                $query_search .= "a.corps_id= '" . $array_search['corps_id'] . "' ";
            }
            if (array_key_exists('mar_timestamp_date', $array_search) && $array_search['mar_timestamp_date'] != "") {
                if (strlen(trim($query_search)) > 0) {
                    $query_search .= " AND ";
                }
                $query_search .= "md.mardis_date = '" . $array_search['mar_timestamp_date'] . "'";
            }
            if (array_key_exists('mar_timestamp_time', $array_search) && $array_search['mar_timestamp_time'] != "") {
                if (strlen(trim($query_search)) > 0) {
                    $query_search .= " AND ";
                }
                $query_search .= "md.mardis_time = '" . $array_search['mar_timestamp_time'] . ":00'";
            }
        }
        $this->ci->db->select('md.mardis_lat,md.mardis_lat as mar_lat,md.mardis_lon as mar_lon,md.mardis_location as mar_location, md.mardis_dpp as mar_dpp,md.mardis_personel_desc as mar_personel_desc,md.mardis_matpur_desc as mar_matpur_desc
,a.mar_name, c.corps_name,marines_type.martype_name,marines_kolak.kolak_description,marines_condition.marcond_description,o.operation_name');
        $this->ci->db->from('mar_dislocation_history as md
								left join	marines as a 
												on (md.mar_id = a.mar_id)
								left join marines_kolak 
												on (marines_kolak.kolak_id = a.kolak_id)
                left join corps as c
                        on(a.corps_id = c.corps_id)
                left join marines_type
                        on(marines_type.martype_id = a.martype_id) 
                left join marines_condition
                        on(marines_condition.marcond_id = a.marcond_id)
								left join operation o 
                                on (o.operation_id = md.operation_id)');
        if (strlen(trim($query_search)) > 0) {
            $this->ci->db->where($query_search, null, false);
        }

        $this->ci->db->limit($limit, $offset);
        if ($order_by != NULL && is_array($order_by))
            $this->ci->db->order_by($order_by, $name_asc);
        $q = $this->ci->db->get();
        return $q->result();
    }

    public function count_table_fetch($where = null, $array_search = null) {
        $query_search = "";
        if ($array_search != null) {
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
            if (array_key_exists('corps_id', $array_search) && $array_search['corps_id'] != "") {
                if (strlen(trim($query_search)) > 0) {
                    $query_search .= " AND ";
                }
                $query_search .= "a.corps_id= '" . $array_search['corps_id'] . "' ";
            }
            if (array_key_exists('mar_timestamp_date', $array_search) && $array_search['mar_timestamp_date'] != "") {
                if (strlen(trim($query_search)) > 0) {
                    $query_search .= " AND ";
                }
                $query_search .= "md.mardis_date = '" . $array_search['mar_timestamp_date'] . "'";
            }
            if (array_key_exists('mar_timestamp_time', $array_search) && $array_search['mar_timestamp_time'] != "") {
                if (strlen(trim($query_search)) > 0) {
                    $query_search .= " AND ";
                }
                $query_search .= "md.mardis_time = '" . $array_search['mar_timestamp_time'] . ":00'";
            }
        }
        $this->ci->db->select('md.mardis_lat,md.mardis_lat as mar_lat,md.mardis_lon as mar_lon,md.mardis_location as mar_location, md.mardis_dpp as mar_dpp,md.mardis_personel_desc as mar_personal_desc,md.mardis_matpur_desc as mar_matpur_desc
,a.mar_name, c.corps_name,marines_type.martype_name,marines_kolak.kolak_description,marines_condition.marcond_description,o.operation_name');
        $this->ci->db->from('mar_dislocation_history as md
								left join	marines as a 
												on (md.mar_id = a.mar_id)
								left join marines_kolak 
												on (marines_kolak.kolak_id = a.kolak_id)
                left join corps as c
                        on(a.corps_id = c.corps_id)
                left join marines_type
                        on(marines_type.martype_id = a.martype_id) 
                left join marines_condition
                        on(marines_condition.marcond_id = a.marcond_id)
								left join operation o 
                                on (o.operation_id = md.operation_id)');
        if (strlen(trim($query_search)) > 0) {
            $this->ci->db->where($query_search, null, false);
        }

        $q = $this->ci->db->count_all_results();
        return $q;
    }

}
