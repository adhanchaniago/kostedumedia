<?php

require_once('generic_dao.php');

class ship_viewability_dao extends Generic_dao {

    public function table_name() {
        return 'ship_viewability';
    }

    public function field_map() {
        return array('corps_id' => 'corps_id', 'ship_id' => 'ship_id', 'viewable' => 'viewable');
    }

    public function __construct() {
        parent::__construct();
    }

    public function table_fetch($limit = 1000, $offset = 0, $order_by = null, $asc = true) {
        $name_asc;
        if ($asc == true) {
            $name_asc = 'asc';
        } else {
            $name_asc = 'desc';
        }
        $this->ci->db->select('ship_viewability.*,corps.corps_name,ship.ship_name');
        $this->ci->db->from('ship_viewability,corps,ship');
        $this->ci->db->where('ship_viewability.ship_id = ship.ship_id AND
				ship_viewability.corps_id = corps.corps_id');
        $this->ci->db->limit($limit, $offset);
        if ($order_by != NULL && is_array($order_by))
            $this->ci->db->order_by($order_by, $name_asc);
        $q = $this->ci->db->get();
        return $q->result();
    }

}

?>