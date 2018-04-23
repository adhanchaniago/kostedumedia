<?php

require_once('generic_dao.php');

class aeroplane_ops_dao extends Generic_dao {

    public function table_name() {
        return 'aeroplane_ops';
    }

    public function field_map() {
        return array('operation_id' => 'operation_id', 'aer_id' => 'aer_id', 'ao_add_timestamp' => 'ao_add_timestamp');
    }

    public function __construct() {
        parent::__construct();
    }
    
    /**
     * 
     * fungsi untuk mencari aeroplane yang belum ada di dalam list operasi yang terdefinisi
     */
    public function aeroplane_ops($op_id){
        $this->ci->db->select('aer.*, c.corps_name,aeroplane_type.aertype_name,ac.aercond_description');
        $this->ci->db->from('aeroplane as aer
	LEFT JOIN corps as c ON (aer.corps_id = c.corps_id)
	LEFT JOIN aeroplane_type ON (aeroplane_type.aertype_id = aer.aertype_id)
	LEFT JOIN aeroplane_condition as ac ON (ac.aercond_id = aer.aercond_id)');
        $this->ci->db->where('aer.aer_id IN (select aer_id from aeroplane_ops where operation_id = \''.$op_id.'\') ORDER BY aer.aer_name ASC');
        $q = $this->ci->db->get();
        return $q->result();
    }
    
    /**
     * fungsi untuk mencari pesud yang telah ada di dalam operasi
     */
    public function aeroplane_ops_used_plan($operation) {
        $this->ci->db->select('aeroplane_ops.operation_id,aeroplane_ops.aer_id,ops.operation_name');
        $this->ci->db->from('aeroplane_ops LEFT JOIN operation as ops
ON aeroplane_ops.operation_id = ops.operation_id');
        $this->ci->db->where('ops.operation_is_active = \'t\' AND ops.operation_end >= \''.$operation->operation_start.'\'');
        $q = $this->ci->db->get();
        return $q->result();
    }
    
    /**
     * Fungsi untuk mengeluarkan ship yang telah masuk ke dalam operasi yang terdefinisi
     */
    public function ops_by_id($op_id){
        $this->ci->db->select("aeroplane_ops.*, aeroplane.aer_name as name,aeroplane.aer_id as id");
        $this->ci->db->from("aeroplane_ops,aeroplane");
        $this->ci->db->where("aeroplane_ops.operation_id = '".$op_id."' and aeroplane_ops.aer_id = aeroplane.aer_id");
        $q = $this->ci->db->get();
        return $q->result();
    }
}

?>