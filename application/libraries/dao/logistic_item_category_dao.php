<?php
	require_once('generic_dao.php');
	class logistic_item_category_dao extends Generic_dao  {
		public function table_name(){
			return 'logistic_item_category';
		}

		public function field_map() {
			return array ('logitemcat_id'=>'logitemcat_id','logitemcat_name'=>'logitemcat_name');
		}

		public function __construct() {
			parent::__construct();
		}
	}
?>