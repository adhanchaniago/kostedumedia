<?php
	require_once('generic_dao.php');
	class role_dao extends Generic_dao  {
		public function table_name(){
			return 'role';
		}

		public function field_map() {
			return array ('role_id'=>'role_id','role_name'=>'role_name','role_mapurl'=>'role_mapurl');
		}

		public function __construct() {
			parent::__construct();
		}
	}
?>