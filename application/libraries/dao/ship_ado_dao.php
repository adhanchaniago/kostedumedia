<?php

require_once('generic_dao.php');

class ship_ado_dao extends Generic_dao {

    public function table_name() {
        return 'ship_ado';
    }

    public function field_map() {
        return array('ship_id' => 'ship_id', 'ado_report' => 'ado_report', 'ado_time' => 'ado_time');
    }

    public function __construct() {
        parent::__construct();
    }
    
    public function table_fetch($ship_id,$limit = 1000, $offset = 0, $order_by = null, $asc = true) {
        $name_asc;
        if ($asc == true) {
            $name_asc = 'asc';
        } else {
            $name_asc = 'desc';
        }
        $this->ci->db->select('ship_ado.*,ship.ship_name');
        $this->ci->db->from('ship_ado,ship');
        $this->ci->db->where('ship_ado.ship_id = ship.ship_id 
            and ship_ado.ship_id = \''.$ship_id.'\'');
        $this->ci->db->limit($limit, $offset);
        if ($order_by != NULL && is_array($order_by))
            $this->ci->db->order_by($order_by, $name_asc);
        $q = $this->ci->db->get();
        return $q->result();
    }
}

?>