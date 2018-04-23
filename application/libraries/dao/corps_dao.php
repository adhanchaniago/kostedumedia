<?php

require_once('generic_dao.php');

class corps_dao extends Generic_dao {

    public function table_name() {
        return 'corps';
    }

    public function field_map() {
        return array(
            'corps_id' => 'corps_id',
            'corps_name' => 'corps_name',
            'corps_description' => 'corps_description',
            'corps_lat' => 'corps_lat_ref',
            'corps_lon' => 'corps_lon_ref',
            'corps_type_id' => 'corps_type_id',
        );
    }

    public function __construct() {
        parent::__construct();
        $this->ci->load->library('dao/operation_viewability_dao');
        $this->ci->load->library('dao/ship_viewability_dao');
        $this->ci->load->library('dao/station_dao');
        $this->ci->load->library('dao/station_logistics_dao');
        $this->ci->load->library('dao/ship_dao');
        $this->ci->load->library('dao/personnel_dao');
        $this->ci->load->library('dao/ship_logistics_dao');
        $this->ci->load->library('dao/ship_viewability_dao');
    }

    public function table_fetch($limit = 1000, $offset = 0, $array_search = null, $order_by = null, $asc = true) {
        $name_asc;
        $query_search = "";
        if ($asc == true) {
            $name_asc = 'asc';
        } else {
            $name_asc = 'desc';
        }

        $this->ci->db->select('corps.*');
        $this->ci->db->from('corps');
        if ($array_search != null) {
            if (array_key_exists('corps_name', $array_search) && $array_search['corps_name'] != "" && strlen($array_search['corps_name']) > 0) {
                $query_search .= "AND corps.corps_name ilike '%" . $array_search['corps_name'] . "%' ";
            }
            if (array_key_exists('corps_type_id', $array_search) && $array_search['corps_type_id'] != "" && strlen($array_search['corps_type_id']) > 0) {
                $query_search .= "AND corps.corps_type_id = '" . $array_search['corps_type_id'] . "' ";
            }
            if ($query_search != "") {
                $this->ci->db->where(substr($query_search, 4, strlen($query_search)));
            }
        }
        $this->ci->db->limit($limit, $offset);
        if ($order_by != null)
            $this->ci->db->order_by($order_by, $name_asc);
        $q = $this->ci->db->get();
        return $q->result();
    }

    public function count_table_fetch($array_search = null) {
        // echo strlen($array_search['corps_name']);
        $query_search = "";
        $this->ci->db->select('count(*)');
        $this->ci->db->from('corps');
        
        if ($array_search != null) {
            if (array_key_exists('corps_name', $array_search) && $array_search['corps_name'] != "" && strlen($array_search['corps_name']) > 0) {
                $query_search .= "AND corps.corps_name ilike '%" . $array_search['corps_name'] . "%' ";
            }
            if (array_key_exists('corps_type_id', $array_search) && $array_search['corps_type_id'] != "" && strlen($array_search['corps_type_id']) > 0) {
                $query_search .= "AND corps.corps_type_id = '" . $array_search['corps_type_id'] . "' ";
            }
            if ($query_search != "") {
                $this->ci->db->where(substr($query_search, 4, strlen($query_search)));
            }
		}
		
        $q = $this->ci->db->count_all_results();
        return $q;
    }

//    public function delete($keys) {
//        // fix
//        //delete operatation viewability and ship viewability
//        $this->ci->operation_viewability_dao->delete($keys);
//        $this->ci->ship_viewability_dao->delete($keys);
//        //delete station
//        $this->ci->db->select('station.*');
//        $this->ci->db->from('station');
//        $this->ci->db->where("station.corps_id = '" . $keys['corps_id'] . "'");
//
//        $q = $this->ci->db->get()->result();
//        /* delete station relation */
//        if ($q != null) {
//            foreach ($q as $station) {
//                $logitem_id = array('station_id' => $station->station_id);
//                $this->ci->station_dao->delete($logitem_id);
////                $logitem_id = array('station_id' => $station->station_id);
////                $this->ci->station_logistics_dao->delete($logitem_id);
//            }
//        }
//
//        /* delete ship relation */
//        $this->ci->db->select('ship.*');
//        $this->ci->db->from('ship');
//        $this->ci->db->where("ship.corps_id = '" . $keys['corps_id'] . "'");
//
//        $q = $this->ci->db->get()->result();
//        if ($q != null) {
//            foreach ($q as $ship) {
//                $ship_id = array('ship_id' => $ship->ship_id);
//                $this->ci->ship_dao->delete($ship_id);
////                $this->ci->personnel_dao->deleteByShip($ship_id);
////                $this->ci->ship_logistics_dao->delete($ship_id);
////                $this->ci->ship_viewability_dao->delete($ship_id);
//            }
////            $this->ci->ship_dao->delete($keys);
//        }
//
//        $keys_o = $this->to_sql_array($keys);
//        return $this->ci->db->delete($this->table_name(), $keys_o);
//    }

}

?>
