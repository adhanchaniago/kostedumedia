<?php
	require_once('generic_dao.php');
	class ops_status_dao extends Generic_dao  {
		public function table_name(){
			return 'ops_status';
		}

		public function field_map() {
			return array ('ops_stat_id'=>'ops_stat_id','ops_stat_desc'=>'ops_stat_desc');
		}

		public function __construct() {
			parent::__construct();
		}
	}
?>