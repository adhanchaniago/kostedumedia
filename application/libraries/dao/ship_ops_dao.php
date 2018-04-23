<?php

require_once('generic_dao.php');

class ship_ops_dao extends Generic_dao {

    public function table_name() {
        return 'ship_ops';
    }

    public function field_map() {
        return array('operation_id' => 'operation_id', 'ship_id' => 'ship_id', 'ops_stat_id' => 'ops_stat_id', 'shipops_program_hour' => 'shipops_program_hour', 'shipops_current_hour' => 'shipops_current_hour', 'sh_add_timestamp' => 'sh_add_timestamp', 'shipops_shiptype_id' => 'shipops_shiptype_id');
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
        $this->ci->db->select('ship_ops.*,operation.operation_name,ship.ship_name,ops_status.ops_stat_desc');
        $this->ci->db->from('ship_ops,ship,ops_status,operation');
        $this->ci->db->where('ship_ops.ship_id = ship.ship_id AND
				ship_ops.ops_stat_id = ops_status.ops_stat_id AND
				ship_ops.operation_id = operation.operation_id');
        $this->ci->db->order_by('ship.ship_name', 'asc');
        $this->ci->db->limit($limit, $offset);
        if ($order_by != NULL && is_array($order_by))
            $this->ci->db->order_by($order_by, $name_asc);
        $q = $this->ci->db->get();
        return $q->result();
    }

    /**
     * 
     * fungsi untuk mencari ship yang belum ada di dalam list operasi yang terdefinisi
     */
    public function ship_ops($op_id) {
        $this->ci->db->select('ship.*,corps.corps_name,ship_type.shiptype_desc,station_name,ship_condition.shipcond_description,ship_status.ship_stat_desc');
        $this->ci->db->from('ship LEFT JOIN ship_status ON (ship_status.ship_stat_id=ship.ship_stat_id)
					LEFT JOIN corps ON (ship.corps_id = corps.corps_id)
					LEFT JOIN ship_type ON (ship.shiptype_id = ship_type.shiptype_id)
					LEFT JOIN station ON (ship.station_id = station.station_id)
					LEFT JOIN ship_condition ON (ship_condition.shipcond_id = ship.shipcond_id)');
        $this->ci->db->where('ship.ship_id IN (select ship_id from ship_ops where operation_id = \'' . $op_id . '\') ORDER BY ship.ship_name ASC');
//        $this->ci->db->where(array('id_ship_type' => $type));
        $q = $this->ci->db->get();
        return $q->result();
    }

    /**
     * fungsi untuk mencari kapal yang telah ada di dalam operasi
     */
    public function ship_ops_used_plan($operation) {
        $this->ci->db->select('ship_ops.operation_id,ship_ops.ship_id,ops.operation_name');
        $this->ci->db->from('ship_ops LEFT JOIN operation as ops
            ON ship_ops.operation_id = ops.operation_id');
        $this->ci->db->where('ops.operation_is_active = \'t\' AND ops.operation_end >= \''.$operation->operation_start.'\'');
        $q = $this->ci->db->get();
        return $q->result();
    }

    /**
     * Fungsi untuk mengeluarkan ship yang telah masuk ke dalam operasi yang terdefinisi
     */
    public function ops_by_id($op_id, $type = SHIP_SURFACE_CODE) {
        $this->ci->db->select("ship_ops.*, ship.ship_name as name,ship.ship_id as id");
        $this->ci->db->from("ship_ops,ship");
        $this->ci->db->where("ship_ops.operation_id = '" . $op_id . "' and ship_ops.ship_id = ship.ship_id");
        $this->ci->db->where(array('id_ship_type' => $type));
        $q = $this->ci->db->get();
        return $q->result();
    }

}

?>