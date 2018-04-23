<?php

require_once('generic_dao.php');

class operation2_dao extends Generic_dao {

    public function table_name() {
        return 'operation';
    }

    public function field_map() {
        return array(
            'operation_id' => 'operation_id', 
            'operation_name' => 'operation_name',
            'operation_description' => 'operation_description', 
            'operation_start' => 'operation_start',
            'operation_end' => 'operation_end', 
            'optype_id' => 'optype_id', 
            'operation_annual' => 'operation_is_annual',
            'operation_year' => 'operation_year', 
            'operation_is_template' => 'operation_is_template', 
            'operation_is_active' => 'operation_is_active',
            'operation_type' => 'operation_type',
            'opstatus_id' => 'opstatus_id',
            'corps_id' => 'corps_id'
        );
    }

    public function __construct() {
        parent::__construct();
        //$this->ci->load->library('dao/operation_viewability_dao');
        //$this->ci->load->library('dao/ship_ops_dao');
    }

    public function table_fetch($limit = 1000, $offset = 0, $array_search = null, $order_by = null, $asc = true) {
        $name_asc;
        $query_search = "";
        if ($asc == true) {
            $name_asc = 'asc';
        } else {
            $name_asc = 'desc';
        }
        
        $this->ci->db->select('ops.*, c.corps_name');
        $this->ci->db->from('operation ops LEFT JOIN corps c on (ops.corps_id = c.corps_id)');
        if ($array_search != null) {
            if (array_key_exists('operation_name', $array_search) && $array_search['operation_name'] != "" && strlen($array_search['operation_name']) > 0) {
                $query_search .= "AND ops.operation_name ilike '%" . $array_search['operation_name'] . "%' ";
            }
            if (array_key_exists('corps_id', $array_search) && $array_search['corps_id'] != "" && strlen($array_search['corps_id']) > 0) {
                $query_search .= "AND ops.corps_id = '" . $array_search['corps_id'] . "' ";
            }
            if (array_key_exists('operation_year', $array_search) && $array_search['operation_year'] != "" && strlen($array_search['operation_year']) > 0) {
                $query_search .= "AND ops.operation_year = '" . $array_search['operation_year'] . "' ";
            }
            if ($query_search != "") {
                $this->ci->db->where(substr($query_search, 4, strlen($query_search)));
            }
        }
        $this->ci->db->limit($limit, $offset);
        if ($order_by)
            $this->ci->db->order_by($order_by, $name_asc);
            
        $q = $this->ci->db->get();
        return $q->result();
    }

    public function count_table_fetch($where = null, $array_search = null) {
        $query_search = "";
        $this->ci->db->select('count(operation.*)');
        $this->ci->db->from('operation');
        if ($array_search != null) {
            if (array_key_exists('operation_name', $array_search) && $array_search['operation_name'] != "" && strlen($array_search['operation_name']) > 0) {
                $query_search .= "AND operation.operation_name ilike '%" . $array_search['operation_name'] . "%' ";
            }
            if (array_key_exists('corps_id', $array_search) && $array_search['corps_id'] != "" && strlen($array_search['corps_id']) > 0) {
                $query_search .= "AND operation.corps_id = '" . $array_search['corps_id'] . "' ";
            }
            if (array_key_exists('operation_year', $array_search) && $array_search['operation_year'] != "" && strlen($array_search['operation_year']) > 0) {
                $query_search .= "AND operation.operation_year = '" . $array_search['operation_year'] . "' ";
            }
            if ($query_search != "") {
                $this->ci->db->where(substr($query_search, 4, strlen($query_search)));
            }
        }
        if (!is_null($where) && count($where) > 0) {
            $this->ci->db->where($where);
        }
        $q = $this->ci->db->count_all_results();
        return $q;
    }

    public function getLastKey() {
		$q = $this->ci->db->query('select cast (operation_id as integer) from operation order by operation_id desc LIMIT 1');
        return $q->result();
    }

    public function delete($keys) {
        $this->ci->operation_viewability_dao->delete($keys);
        $this->ci->ship_ops_dao->delete($keys);
        $keys_o = $this->to_sql_array($keys);
        return $this->ci->db->delete($this->table_name(), $keys_o);
    }

}

?>
