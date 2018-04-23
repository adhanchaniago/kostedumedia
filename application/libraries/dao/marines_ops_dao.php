<?php

require_once('generic_dao.php');

class marines_ops_dao extends Generic_dao {

    public function table_name() {
        return 'marines_ops';
    }

    public function field_map() {
        return array('operation_id' => 'operation_id', 'mar_id' => 'mar_id', 'mo_add_timestamp' => 'mo_add_timestamp','mo_martype_id'=>'mo_martype_id','mar_count'=>'mar_count');
    }

    public function __construct() {
        parent::__construct();
    }

    /**
     * 
     * fungsi untuk mencari aeroplane yang belum ada di dalam list operasi yang terdefinisi
     */
    public function marine_ops($op_id) {
        $this->ci->db->select('a.*, c.corps_name,marines_type.martype_name,marines_kolak.kolak_description,marines_condition.marcond_description');
        $this->ci->db->from('marines as a LEFT JOIN marines_kolak ON (marines_kolak.kolak_id = a.kolak_id)
	LEFT JOIN corps as c ON (a.corps_id = c.corps_id)
	LEFT JOIN marines_type ON (marines_type.martype_id = a.martype_id)
	LEFT JOIN marines_condition ON (marines_condition.marcond_id = a.marcond_id)');
        $this->ci->db->where('a.mar_id IN (select mar_id from marines_ops where operation_id =  \'' . $op_id . '\') ORDER BY c.corps_name ASC');
//        $this->ci->db->where(array('martype_id' => $type));
        $q = $this->ci->db->get();
        return $q->result();
    }
    
    /**
     * fungsi untuk mencari pesud yang telah ada di dalam operasi
     */
    public function marine_ops_used_plan($operation) {
        $this->ci->db->select('marines_ops.operation_id,marines_ops.mar_id,marines_ops.mar_count,ops.operation_name');
        $this->ci->db->from('marines_ops LEFT JOIN operation as ops
ON marines_ops.operation_id = ops.operation_id');
        $this->ci->db->where('ops.operation_is_active = \'t\' AND ops.operation_end >= \''.$operation->operation_start.'\'');
        $q = $this->ci->db->get();
        return $q->result();
    }
    
    /**
     * Fungsi untuk mengeluarkan ship yang telah masuk ke dalam operasi yang terdefinisi
     */
    public function ops_by_id($op_id, $type = MARINES_SATPURMAR_CODE) {
        $this->ci->db->select("marines_ops.*, marines.mar_name as name, marines.mar_id as id");
        $this->ci->db->from("marines_ops,marines");
        $this->ci->db->where("marines_ops.operation_id = '" . $op_id . "' and marines_ops.mar_id = marines.mar_id");
        $this->ci->db->where(array('marines.martype_id' => $type));
        $q = $this->ci->db->get();
        return $q->result();
    }

    public function delete($keys) {
        // fix
        $db_debug = $this->ci->db->db_debug; //save setting
        $this->ci->db->db_debug = FALSE; //disable debugging for queries

        $keys_o = $this->to_sql_array($keys);
        return $this->ci->db->delete($this->table_name(), $keys_o);
        $this->db->db_debug = $db_debug; //restore setting
    }

}

?>