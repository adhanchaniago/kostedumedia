<?php
	require_once('generic_dao.php');
	
	class message_dao extends Generic_dao  {
	
		public function table_name() {
			return 'message';
		}

		public function field_map() {
			return array (
				'msg_id'=>'msg_id', 
				'id_from'=>'id_from',
				'id_to'=>'id_to',
				'msg'=>'msg',
				'state'=>'state',
				'changed_state_time'=>'changed_state_time',
				'created_time'=>'created_time'
			);
		}

		public function __construct() {
			parent::__construct();
		}


		/////////////////////
		//Inbox
		public function table_fetch_inbox($limit = 1000, $offset = 0, $array_search = null, $order_by = null, $asc = true) {
			$name_asc;
			$query_search = "";
			if ($asc == true) {
				$name_asc = 'asc';
			} else {
				$name_asc = 'desc';
			}

			$this->ci->db->select('a.* , b.state_description');
			$this->ci->db->from('message a left join message_state b on (a.state = b.state)');
			$this->ci->db->where("(a.state = '6' OR a.state = '7')");

			if ($array_search != null) {
				if (array_key_exists('id_from', $array_search) && $array_search['id_from'] != "" && strlen($array_search['id_from']) > 0) {
					if (strlen(trim($query_search)) > 0) {
						$query_search .= " AND ";
					}
					$query_search .= "id_from = '" . $array_search['id_from'] . "'";
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

		public function count_table_inbox($array_search = null) {
			$query_search = "";
			$this->ci->db->select('a.* , b.state_description');
			$this->ci->db->from('message a left join message_state b on (a.state = b.state)');
			$this->ci->db->where("(a.state = '6' OR a.state = '7')");
			if ($array_search != null) {
				if (array_key_exists('id_from', $array_search) && $array_search['id_from'] != "" && strlen($array_search['id_from']) > 0) {
					if (strlen(trim($query_search)) > 0) {
						$query_search .= " AND ";
					}
					$query_search .= "id_from = '" . $array_search['id_from'] . "'";
				}
				if ($query_search != "") {
					 $this->ci->db->where($query_search);
				}
			}
			$q = $this->ci->db->count_all_results();
			return $q;
		}

		//outbox

		public function table_fetch_outbox($limit = 1000, $offset = 0, $array_search = null, $order_by = null, $asc = true) {
			$name_asc;
			$query_search = "";
			if ($asc == true) {
				$name_asc = 'asc';
			} else {
				$name_asc = 'desc';
			}

			$this->ci->db->select('a.* , b.state_description');
			$this->ci->db->from('message a left join message_state b on (a.state = b.state)');
			$this->ci->db->where("(a.state = '1' OR a.state = '2' OR a.state = '3' OR a.state = '4' OR a.state = '5')");
			if ($array_search != null) {
				if (array_key_exists('id_to', $array_search) && $array_search['id_to'] != "" && strlen($array_search['id_to']) > 0) {
					if (strlen(trim($query_search)) > 0) {
						$query_search .= " AND ";
					}
					$query_search .= "id_to = '" . $array_search['id_to'] . "'";
				}
				if ($query_search != "") {
					 $this->ci->db->where($query_search);
				}
			}
		
			$this->ci->db->limit($limit, $offset);
			if ($order_by != NULL)
				$this->ci->db->order_by($order_by, $name_asc);
			$q = $this->ci->db->get();
			return $q->result();
		}
	
		public function count_table_outbox($array_search = null) {
			$query_search = "";
			$this->ci->db->select('a.* , b.state_description');
			$this->ci->db->from('message a left join message_state b on (a.state = b.state)');
			$this->ci->db->where("(a.state = '1' OR a.state = '2' OR a.state = '3' OR a.state = '4' OR a.state = '5')");
			if ($array_search != null) {
				if (array_key_exists('id_to', $array_search) && $array_search['id_to'] != "" && strlen($array_search['id_to']) > 0) {
					if (strlen(trim($query_search)) > 0) {
						$query_search .= " AND ";
					}
					$query_search .= "id_to = '" . $array_search['id_to'] . "'";
				}
				if ($query_search != "") {
					 $this->ci->db->where($query_search);
				}
			}		
			$q = $this->ci->db->count_all_results();
			return $q;
		}

		//konsep
		public function table_fetch($limit = 1000, $offset = 0, $array_search = null, $order_by = null, $asc = true, $where = null) {
			$name_asc;
			$query_search = "";
			if ($asc == true) {
				$name_asc = 'asc';
			} else {
				$name_asc = 'desc';
			}

			$this->ci->db->from('message');
			$this->ci->db->where('state = 0');
			if ($array_search != null) {
				if (array_key_exists('id_to', $array_search) && $array_search['id_to'] != "" && strlen($array_search['id_to']) > 0) {
					if (strlen(trim($query_search)) > 0) {
						$query_search .= " AND ";
					}
					$query_search .= "id_to = '" . $array_search['id_to'] . "'";
				}
				/*if (array_key_exists('rcvr_name', $array_search) && $array_search['rcvr_name'] != "" && strlen($array_search['rcvr_name']) > 0) {
					if (strlen(trim($query_search)) > 0) {
						$query_search .= " AND ";
					}
					$query_search .= "rcvr_name ilike '%" . $array_search['rcvr_name'] . "%' ";
				}
				if (array_key_exists('msg', $array_search) && $array_search['msg'] != "" && strlen($array_search['msg']) > 0) {
					if (strlen(trim($query_search)) > 0) {
						$query_search .= " AND ";
					}
					$query_search .= "msg ilike '%" . $array_search['msg'] . "%' ";
				}*/
				if ($query_search != "") {
					 $this->ci->db->where($query_search);
				}
			}
		
			$this->ci->db->limit($limit, $offset);
			if ($order_by != NULL)
				$this->ci->db->order_by($order_by, $name_asc);
			$q = $this->ci->db->get();
			return $q->result();
		}
		public function count_table_draft($array_search = null) {
			// echo strlen($array_search['corps_name']);
			$query_search = "";
			$this->ci->db->select('count(*)');
			$this->ci->db->from('message');
			$this->ci->db->where('state = 0');
			if ($array_search != null) {
				if (array_key_exists('id_to', $array_search) && $array_search['id_to'] != "" && strlen($array_search['id_to']) > 0) {
					if (strlen(trim($query_search)) > 0) {
						$query_search .= " AND ";
					}
					$query_search .= "id_to = '" . $array_search['id_to'] . "'";
				}
				/*if (array_key_exists('rcvr_name', $array_search) && $array_search['rcvr_name'] != "" && strlen($array_search['rcvr_name']) > 0) {
					if (strlen(trim($query_search)) > 0) {
						$query_search .= " AND ";
					}
					$query_search .= "rcvr_name ilike '%" . $array_search['rcvr_name'] . "%' ";
				}
				if (array_key_exists('msg', $array_search) && $array_search['msg'] != "" && strlen($array_search['msg']) > 0) {
					if (strlen(trim($query_search)) > 0) {
						$query_search .= " AND ";
					}
					$query_search .= "msg ilike '%" . $array_search['msg'] . "%' ";
				}*/
				if ($query_search != "") {
					 $this->ci->db->where($query_search);
				}
			}
			$q = $this->ci->db->count_all_results();
			return $q;
		}

		/////////////






		
		public function count($where, $where_value = null) {
			if ($where_value)
				$this->ci->db->where($where, $where_value);
			else 
				$this->ci->db->where($where);
			$this->ci->db->from($this->table_name());
			return $this->ci->db->count_all_results();
		}
		
		public function fetch_id($created_time, $id_to = null) {
			$this->ci->db->where('created_time', $created_time);
			if ($id_to)
				$this->ci->db->where('id_to', $id_to);
			$q = $this->ci->db->get($this->table_name());
			return $q->row()->msg_id;
		}
		
		public function count_where($where_array) {
			if ($where_array)
				$this->ci->db->where($where_array);
			$this->ci->db->from($this->table_name());
			return $this->ci->db->count_all_results();
		}
		
		public function fetch_msg_thread($ship_id) {
			$q = $this->ci->db->query("SELECT m.*, to_char(m.created_time,'HH:MI:SS dd-MM-yyyy') as waktu FROM message AS m WHERE (m.id_from = 1 AND m.id_to = " . $ship_id . ") OR (m.id_from = " . $ship_id . " AND m.id_to = 1) ORDER BY m.created_time DESC LIMIT 20");
			return $q->result();
		}
		
	}
?>
