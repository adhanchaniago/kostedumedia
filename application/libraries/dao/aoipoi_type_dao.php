<?php
	require_once('generic_dao.php');
	class aoipoi_type_dao extends Generic_dao  {
		public function table_name(){
			return 'aoipoi_type';
		}

		public function field_map() {
			return array ('aptype_id'=>'aptype_id','aptype_name'=>'aptype_name');
		}

		public function __construct() {
			parent::__construct();
		}
	}
?>