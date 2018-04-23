<?php

require_once('generic_dao.php');

class ship_status_dao extends Generic_dao {

    public function table_name() {
        return 'ship_status';
    }

    public function field_map() {
        return array('ship_stat_id' => 'ship_stat_id', 'ship_stat_desc' => 'ship_stat_desc');
    }

    public function __construct() {
        parent::__construct();
        $this->ci->load->library('dao/ship_dao');
        $this->ci->load->library('dao/personnel_dao');
        $this->ci->load->library('dao/ship_logistics_dao');
        $this->ci->load->library('dao/ship_viewability_dao');
    }

//    public function delete($keys) {
//        /* delete ship relation */
//        $this->ci->db->select('ship.*');
//        $this->ci->db->from('ship');
//        $this->ci->db->where("ship.ship_stat_id = '" . $keys['ship_stat_id'] . "'");
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
//            $this->ci->ship_dao->delete($keys);
//        }
//        $keys_o = $this->to_sql_array($keys);
//        return $this->ci->db->delete($this->table_name(), $keys_o);
//    }

}
?>