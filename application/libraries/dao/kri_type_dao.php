<?php
	require_once('generic_dao.php');
	class kri_type_dao extends Generic_dao  {
		public function table_name(){
			return 'kri_type';
		}

		public function field_map() {
			return array ('kritype_id'=>'kritype_id','kritype_name'=>'kritype_name');
		}

		public function __construct() {
			parent::__construct();
		}
	}
?>