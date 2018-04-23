<?php

require_once('generic_dao.php');

class pilots_dao extends Generic_dao {

    public function table_name() {
        return 'pilots';
    }

    public function field_map() {
        return array('plev_id' => 'plev_id', 'pilot_id' => 'pilot_id', 'pilot_name' => 'pilot_name');
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
        $this->ci->db->select('pilots.pilot_id,pilots.pilot_name,pilots.plev_id,pilot_grade.plev_name');
        $this->ci->db->from('pilots,pilot_grade');
        $this->ci->db->where('pilots.plev_id = pilot_grade.plev_id');
        $this->ci->db->limit($limit, $offset);
        if ($order_by != NULL && is_array($order_by))
            $this->ci->db->order_by($order_by, $name_asc);
        $q = $this->ci->db->get();
        return $q->result();
    }
}

?>