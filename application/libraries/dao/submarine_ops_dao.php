<?php

require_once('generic_dao.php');

class submarine_ops_dao extends Generic_dao {

    public function table_name() {
        return 'submarine_ops';
    }

    public function field_map() {
        return array('operation_id' => 'operation_id', 'sbm_id' => 'sbm_id', 'so_add_timestamp' => 'so_add_timestamp');
    }

    public function __construct() {
        parent::__construct();
    }
    
    /**
     * 
     * fungsi untuk mencari aeroplane yang belum ada di dalam list operasi yang terdefinisi
     */
    public function submarine_ops($op_id){
        $this->ci->db->select('sbm_id as id,sbm_name as name');
        $this->ci->db->from('submarine');
        $this->ci->db->where('sbm_id NOT IN (select sbm_id from submarine_ops where operation_id = \''.$op_id.'\')');
        $q = $this->ci->db->get();
        return $q->result();
    }
    
    /**
     * Fungsi untuk mengeluarkan ship yang telah masuk ke dalam operasi yang terdefinisi
     */
    public function ops_by_id($op_id){
        $this->ci->db->select("submarine_ops.*, submarine.sbm_name as name, submarine.sbm_id as id");
        $this->ci->db->from("submarine_ops,submarine");
        $this->ci->db->where("submarine_ops.operation_id = '".$op_id."' and submarine_ops.sbm_id = submarine.sbm_id");
        $q = $this->ci->db->get();
        return $q->result();
    }
}

?>