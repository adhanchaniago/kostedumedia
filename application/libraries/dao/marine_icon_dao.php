<?php
require_once('generic_dao.php');

class marine_icon_dao extends Generic_dao  {
	public function table_name(){
		return 'marine_icon';
	}

	public function field_map() {
		return array ('maricon_id'=>'maricon_id', 'maricon_desc'=>'maricon_desc', 'maricon_file'=>'maricon_file');
	}

	public function __construct() {
		parent::__construct();
	}

	public function table_fetch($limit = 1000, $offset = 0, $array_search = null, $order_by = null, $asc = true) {
		$name_asc;
		$query_search = "";
		if ($asc == true) {
			$name_asc = 'asc';
		} else {
			$name_asc = 'desc';
		}

		$this->ci->db->from('marine_icon');
		if ($array_search != null) {
			if (array_key_exists('maricon_desc', $array_search) && $array_search['maricon_desc'] != "" && strlen($array_search['maricon_desc']) > 0) {
				$query_search .= "maricon_desc ilike '%" . $array_search['maricon_desc'] . "%' ";
			}
            if ($query_search != "") {
                $this->ci->db->where($query_search);
            }
		}
		$this->ci->db->limit($limit, $offset);
		if ($order_by != null)
			$this->ci->db->order_by($order_by, $name_asc);
		$q = $this->ci->db->get();
		return $q->result();
	}

	public function count_table_fetch($array_search = null) {
		$query_search = "";
		$this->ci->db->select('count(*)');
		$this->ci->db->from('marine_icon');

		if ($array_search != null) {
			if (array_key_exists('maricon_desc', $array_search) && $array_search['maricon_desc'] != "" && strlen($array_search['maricon_desc']) > 0) {
				$query_search .= "maricon_desc ilike '%" . $array_search['maricon_desc'] . "%' ";
			}
			if ($query_search != "") {
				$this->ci->db->where($query_search);
			}
		}

		$q = $this->ci->db->count_all_results();
		return $q;
	}
}
?>
