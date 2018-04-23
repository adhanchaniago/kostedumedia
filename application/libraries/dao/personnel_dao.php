<?php

require_once('generic_dao.php');

class personnel_dao extends Generic_dao {

    public function table_name() {
        return 'personnel';
    }

    public function field_map() {
        return array('ship_id' => 'ship_id', 'psntype_id' => 'psntype_id', 'psnreff_nrp' => 'psnreff_nrp', 'psn_value' => 'psn_value');
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
        $this->ci->db->select('personnel.*,ship.ship_name,personnel_reff.psnreff_name');
        $this->ci->db->from('personnel,ship,personnel_reff');
        $this->ci->db->where('personnel.ship_id = ship.ship_id 
            and personnel.psnreff_nrp = personnel_reff.psnreff_nrp
            and personnel.ship_id = \''.$ship_id.'\'');
        $this->ci->db->limit($limit, $offset);
        if ($order_by != NULL && is_array($order_by))
            $this->ci->db->order_by($order_by, $name_asc);
        $q = $this->ci->db->get();
        return $q->result();
    }

    public function deleteByShip($obj_id = null) {
        $keys_o = $this->to_sql_array($obj_id);
        return $this->ci->db->delete($this->table_name(), $keys_o);
    }

}

?>