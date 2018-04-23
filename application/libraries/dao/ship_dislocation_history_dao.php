<?php

require_once('generic_dao.php');

class ship_dislocation_history_dao extends Generic_dao {

    public function table_name() {
        return 'ship_dislocation_history';
    }

    public function field_map() {
        return array('ship_id' => 'ship_id',
            'shipdis_time' => 'shipdis_time',
            'shipdis_date' => 'shipdis_date',
            'shipdis_lat' => 'shipdis_lat',
            'shipdis_lon' => 'shipdis_lon',
            'shipdis_direction' => 'shipdis_direction',
            'shipdis_speed' => 'shipdis_speed',
            'operation_id' => 'operation_id',
            'shipdis_water_location' => 'shipdis_water_location');
    }

    public function __construct() {
        parent::__construct();
    }

    public function table_fetch($limit = 1000, $offset = 0, $array_search = null, $order_by = null, $asc = true) {
        $name_asc;
        $query_search = "";
        if ($asc == true) {
            $name_asc = 'asc';
        } else {
            $name_asc = 'desc';
        }

        if ($array_search != null) {
            if (array_key_exists('ship_name', $array_search) && $array_search['ship_name'] != "" && strlen($array_search['ship_name']) > 0) {
                $query_search .= "a.ship_name ilike '%" . $array_search['ship_name'] . "%'";
            }
            if (array_key_exists('shiptype_id', $array_search) && $array_search['shiptype_id'] != "") {

                if (strlen(trim($query_search)) > 0) {
                    $query_search .= " AND ";
                }

                $query_search .= "a.shiptype_id = '{$array_search['shiptype_id']}'";
            }
            if (array_key_exists('ship_id', $array_search) && $array_search['ship_id'] != "" && strlen($array_search['ship_id']) > 0) {

                if (strlen(trim($query_search)) > 0) {
                    $query_search .= " AND ";
                }

                $query_search .= "a.ship_id = '" . $array_search['ship_id'] . "'";
            }
            if (array_key_exists('shipcond_id', $array_search) && $array_search['shipcond_id'] != "") {

                if (strlen(trim($query_search)) > 0) {
                    $query_search .= " AND ";
                }

                $query_search .= "a.shipcond_id= '{$array_search['shipcond_id']}'";
            }
            if (array_key_exists('ship_stat_id', $array_search) && $array_search['ship_stat_id'] != "") {

                if (strlen(trim($query_search)) > 0) {
                    $query_search .= " AND ";
                }

                $query_search .= "a.ship_stat_id= '{$array_search['ship_stat_id']}'";
            }

            if (array_key_exists('corps_id', $array_search) && $array_search['corps_id'] != "") {

                if (strlen(trim($query_search)) > 0) {
                    $query_search .= " AND ";
                }

                $query_search .= "a.corps_id= '" . $array_search['corps_id'] . "'";
            }

            if (array_key_exists('ship_timestamp_date', $array_search) && $array_search['ship_timestamp_date'] != "") {
                if (strlen(trim($query_search)) > 0) {
                    $query_search .= " AND ";
                }
                $query_search .= "sd.shipdis_date = '" . $array_search['ship_timestamp_date'] . "'";
                // if ($array_search['ship_timestamp_time'] == '06.00') {
                //     $query_search .= "sd.ship_timestamp_location >= '" . $array_search['ship_timestamp_date'] . " 06:00:00' and a.ship_timestamp_location <= '" . $array_search['ship_timestamp_date'] . " 09:00:00'";
                // } else {
                //     $query_search .= "sd.ship_timestamp_location >= '" . $array_search['ship_timestamp_date'] . " 18:00:00' and a.ship_timestamp_location <= '" . $array_search['ship_timestamp_date'] . " 19:00:00'";
                // }
            }
            if (array_key_exists('ship_timestamp_time', $array_search) && $array_search['ship_timestamp_time'] != "") {
                if (strlen(trim($query_search)) > 0) {
                    $query_search .= " AND ";
                }
                $query_search .= "sd.shipdis_time = '" . $array_search['ship_timestamp_time'] . ":00'";
            }

            // Added by KP D3
            if (array_key_exists('operation_id', $array_search) && $array_search['operation_id'] != "" && strlen($array_search['operation_id']) > 0)
            {
                if (strlen(trim($query_search)) > 0) {
                    $query_search .= " AND ";
                }
                $query_search .= "sd.operation_id = '" . $array_search['operation_id'] . "'";
            }
            // } end ADDED
        }
        $this->ci->db->select('true as history, sd.shipdis_lat as ship_lat, sd.shipdis_lon as ship_lon, 
        	sd.shipdis_direction as ship_direction, shipdis_speed as ship_speed, 
        	shipdis_water_location as ship_water_location, sd.shipdis_date, sd.shipdis_time, o.operation_name, a.ship_id, a.ship_name,
            a.shiptype_id, a.corps_id, a.ship_stat_id,
        	c.corps_name, d.shiptype_desc, unit_name, f.shipcond_description, b.ship_stat_desc, k.corps_name AS kodal_name', false);
        //D3 added join corps k 
        $this->ci->db->from('ship_dislocation_history sd
								LEFT JOIN ship a 
										ON (sd.ship_id = a.ship_id)
                				LEFT JOIN ship_status b
                                        ON (a.ship_stat_id=b.ship_stat_id)
                                left join corps c
                                        on(a.corps_id = c.corps_id)
                                left join corps k
                                        on(a.kodal_id = k.corps_id)
                                left join ship_type d
                                        on(a.shiptype_id = d.shiptype_id)
                                left join unit e
                                        on(a.unit_id = e.unit_id)
                                left join ship_condition f
                                        on(a.shipcond_id = f.shipcond_id)
                				left join operation o 
                                        on (o.operation_id = sd.operation_id )');

        if (strlen(trim($query_search)) > 0) {
            $this->ci->db->where($query_search, null, false);
        }

        $this->ci->db->limit($limit, $offset);
        //if ($order_by != NULL && is_array($order_by))
        $this->ci->db->order_by('a.ship_name', 'asc');
        $q = $this->ci->db->get(); // echo 'DIKA ' . $this->ci->db->last_query(); die();
        return $q->result();
    }

    public function count_table_fetch($array_search = null) {
        $query_search = "";

        if ($array_search != null) {
            if (array_key_exists('ship_name', $array_search) && $array_search['ship_name'] != "" && strlen($array_search['ship_name']) > 0) {
                $query_search .= "a.ship_name ilike '%" . $array_search['ship_name'] . "%'";
            }
            if (array_key_exists('shiptype_id', $array_search) && $array_search['shiptype_id'] != "") {

                if (strlen(trim($query_search)) > 0) {
                    $query_search .= " AND ";
                }

                $query_search .= "a.shiptype_id = '{$array_search['shiptype_id']}'";
            }
            if (array_key_exists('ship_id', $array_search) && $array_search['ship_id'] != "" && strlen($array_search['ship_id']) > 0) {

                if (strlen(trim($query_search)) > 0) {
                    $query_search .= " AND ";
                }

                $query_search .= "a.ship_id = '" . $array_search['ship_id'] . "'";
            }
            if (array_key_exists('shipcond_id', $array_search) && $array_search['shipcond_id'] != "") {

                if (strlen(trim($query_search)) > 0) {
                    $query_search .= " AND ";
                }

                $query_search .= "a.shipcond_id= '{$array_search['shipcond_id']}'";
            }
            if (array_key_exists('ship_stat_id', $array_search) && $array_search['ship_stat_id'] != "") {

                if (strlen(trim($query_search)) > 0) {
                    $query_search .= " AND ";
                }

                $query_search .= "a.ship_stat_id= '{$array_search['ship_stat_id']}'";
            }

            if (array_key_exists('corps_id', $array_search) && $array_search['corps_id'] != "") {

                if (strlen(trim($query_search)) > 0) {
                    $query_search .= " AND ";
                }

                $query_search .= "a.corps_id= '" . $array_search['corps_id'] . "'";
            }

            if (array_key_exists('ship_timestamp_date', $array_search) && $array_search['ship_timestamp_date'] != "") {
                if (strlen(trim($query_search)) > 0) {
                    $query_search .= " AND ";
                }
                $query_search .= "sd.shipdis_date = '" . $array_search['ship_timestamp_date'] . "'";
            }
            if (array_key_exists('ship_timestamp_time', $array_search) && $array_search['ship_timestamp_time'] != "") {
                if (strlen(trim($query_search)) > 0) {
                    $query_search .= " AND ";
                }
                $query_search .= "sd.shipdis_time = '" . $array_search['ship_timestamp_time'] . ":00'";
            }

            // Added by KP D3
            if (array_key_exists('operation_id', $array_search) && $array_search['operation_id'] != "" && strlen($array_search['operation_id']) > 0)
            {
                if (strlen(trim($query_search)) > 0) {
                    $query_search .= " AND ";
                }
                $query_search .= "sd.operation_id = '" . $array_search['operation_id'] . "'";
            }
            // } end ADDED
            
        }
        $this->ci->db->select('sd.shipdis_lat as ship_lat,sd.shipdis_lon as ship_lon,sd.shipdis_direction as ship_direction,shipdis_speed as ship_speed,shipdis_water_location as ship_water_location,o.operation_name
	,a.ship_id,a.ship_name,c.corps_name,d.shiptype_desc,unit_name,f.shipcond_description,b.ship_stat_desc', false);
        $this->ci->db->from('ship_dislocation_history sd
								LEFT JOIN ship a 
												ON (sd.ship_id = a.ship_id)
								LEFT JOIN ship_status b
                        ON (a.ship_stat_id=b.ship_stat_id)
                left join corps c
                        on(a.corps_id = c.corps_id)
                left join ship_type d
                        on(a.shiptype_id = d.shiptype_id)
                left join unit e
                        on(a.unit_id = e.unit_id)
                left join ship_condition f
                        on(a.shipcond_id = f.shipcond_id)
								left join operation o 
                                on (o.operation_id = sd.operation_id )');

        if (strlen(trim($query_search)) > 0) {
            $this->ci->db->where($query_search, null, false);
        }
        $q = $this->ci->db->count_all_results();
        return $q;
    }

}
