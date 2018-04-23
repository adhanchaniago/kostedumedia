<?php

abstract class Generic_dao {

    public abstract function table_name();

    public abstract function field_map();

    public $ci;

    function __construct() {
        $this->ci = & get_instance();
        $this->ci->load->database();
    }

    protected function field_query() {
        $fields = $this->field_map();
        $keys = array_keys($fields);
        $total = count($fields) - 1;
        $count = 0;
        $field_s = '';

        foreach ($keys as $key) {
            $field_s .= $fields[$key] . ' as ' . $key; //.' as '.$fields[$key];
            if ($count < $total) {
                $field_s.=', ';
            }
            $count++;
        }
        return $field_s;
    }

    protected function field_object() {
        $fields = array_flip($this->field_map());
        $keys = array_keys($fields);
        $total = count($fields) - 1;
        $count = 0;
        $field_s = '';

        foreach ($keys as $key) {
            $field_s .= $fields[$key] . ' as ' . $key; //.' as '.$fields[$key];
            if ($count < $total) {
                $field_s.=', ';
            }
            $count++;
        }
        return $field_s;
    }

    /**
      @description
      converting application layer array to
      database layer-understandable array.
      example :

      array('id'=>'007', 'name'=>'Bond, James');

      using child class map:
      array('id'=>'agent_id', 'name'=>'agent_name');

      after processing with this function the result
      array will be :
      array('agent_id'=>'007', 'agent_name'=>'Bond, James');
     */
    protected function to_sql_array($arr) {
        $keys = array_keys($arr);
        $maps = $this->field_map();

        $sql_arr = array();
        foreach ($keys as $key) {

            if(is_string($arr[$key])){
                $sql_arr[$maps[$key]] = $arr[$key];
            }else{
                $sql_arr[$maps[$key]] = $arr[$key];
            }
        }

        return $sql_arr;
    }

    /**
      @param <array> $id_array
      array containing data key. array index
      using object index.
      example :
      altough table representation :
      -----------------------
      |agent_id | agent_name|
      -----------------------
      |007      | James Bond |
      |404      | Not found  |

      but when your map shows :
      array('id'=>'agent_id', 'name'=>'agent_name');

      what you should pass when doing a search by id is :

      array('id','077'); <b>NOT</b> : array('agent_id','077')
     */
    public function by_id($obj_id) {
        $obj_id_o = $this->to_sql_array($obj_id);
        $this->ci->db->select($this->field_query());
        $this->ci->db->where($obj_id_o);
        $q = $this->ci->db->get($this->table_name());
        return $q->row();
    }

    public function arr_by_id($obj_id) {
        $obj_id_o = $this->to_sql_array($obj_id);
        $this->ci->db->select($this->field_query());
        $this->ci->db->where($obj_id_o);
        $q = $this->ci->db->get($this->table_name());
        return $q->result();
    }

    public function fetch($limit = 1000, $offset = 0, $order_by = null,  $where = null,  $asc = true) {
        $name_asc;
        if ($asc == true) {
            $name_asc = 'asc';
        } else {
            $name_asc = 'desc';
        }
        $this->ci->db->select($this->field_query());
        $this->ci->db->limit($limit, $offset);

        if(!is_null($where)){
			$this->ci->db->where($where);
        }
		
        if ($order_by != NULL)
            $this->ci->db->order_by($order_by, $name_asc);
        $q = $this->ci->db->get($this->table_name());
        return $q->result();
    }

    public function insert($obj) {
        $obj_o = $this->to_sql_array($obj);
        $status = $this->ci->db->insert($this->table_name(), $obj_o);
        if($status ==false){
            echo $this->ci->db->_error_message();exit();
        }
        return $status;
    }

    public function update($obj, $keys) {
        // fix
        $obj_o = $this->to_sql_array($obj);
        $keys_o = $this->to_sql_array($keys);
        $this->ci->db->where($keys_o);
        return $this->ci->db->update($this->table_name(), $obj_o);
    }

    public function delete($keys) {
        // fix
        $db_debug = $this->ci->db->db_debug; //save setting
        $this->ci->db->db_debug = FALSE; //disable debugging for queries

        $keys_o = $this->to_sql_array($keys);
        return $this->ci->db->delete($this->table_name(), $keys_o);
        $this->db->db_debug = $db_debug; //restore setting
    }

    public function count_all() {
        // fix
        return $this->ci->db->count_all($this->table_name());
    }

    public function table_fetch($table_name, $map, $order_by = null, $is_asc = true) {
        $name_asc;
        if ($is_asc == true) {
            $name_asc = 'asc';
        } else {
            $name_asc = 'desc';
        }
        $this->ci->db->select($this->field_object());
        if ($order_by != NULL && is_array($order_by)) {
            $this->ci->db->order_by($order_by, $name_asc);
        }
        $q = $this->ci->db->get($table_name);
        return $q->result();
    }

    public function insert_id() {
        return $this->ci->db->insert_id();
    }

    public function __commit() {
        $this->ci->db->trans_commit();
    }

    public function __rollback() {
        $this->ci->db->trans_rollback();
    }

}
