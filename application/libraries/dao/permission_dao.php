<?php
	require_once('generic_dao.php');
	class permission_dao extends Generic_dao  {
		public function table_name(){
			return 'permission';
		}

		public function field_map() {
			return array ('feature_id'=>'feature_id','role_id'=>'role_id','access'=>'access','update'=>'update','delete'=>'delete');
		}

		public function __construct() {
			parent::__construct();
		}
	}
?>