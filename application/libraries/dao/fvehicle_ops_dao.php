<?php

require_once('generic_dao.php');

class fvehicle_ops_dao extends Generic_dao {

    public function table_name() {
        return 'fvehicle_ops';
    }

    public function field_map() {
        return array('operation_id' => 'operation_id', 'fv_id' => 'fv_id', 'fvo_add_timestamp' => 'fvo_add_timestamp');
    }

    public function __construct() {
        parent::__construct();
    }
    
    /**
     * 
     * fungsi untuk mencari aeroplane yang belum ada di dalam list operasi yang terdefinisi
     */
    public function fvehicle_ops($op_id){
        $this->ci->db->select('fv_id as id,fv_name as name');
        $this->ci->db->from('fighting_vehicle');
        $this->ci->db->where('fv_id NOT IN (select fv_id from fvehicle_ops where operation_id = \''.$op_id.'\')');
        $q = $this->ci->db->get();
        return $q->result();
    }
    
    /**
     * Fungsi untuk mengeluarkan ship yang telah masuk ke dalam operasi yang terdefinisi
     */
    public function ops_by_id($op_id){
        $this->ci->db->select("fvehicle_ops.*, fighting_vehicle.fv_name as name,fighting_vehicle.fv_id as id");
        $this->ci->db->from("fvehicle_ops,fighting_vehicle");
        $this->ci->db->where("fvehicle_ops.operation_id = '".$op_id."' and fvehicle_ops.fv_id = fighting_vehicle.fv_id");
        $q = $this->ci->db->get();
        return $q->result();
    }
}

?>