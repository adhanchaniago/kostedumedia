<?php
	require_once('generic_dao.php');
	class logistic_item_context_dao extends Generic_dao  {
		public function table_name(){
			return 'logistic_item_context';
		}

		public function field_map() {
			return array ('logitemctx_id'=>'logitemctx_id','logitemctx_name'=>'logitemctx_name');
		}

		public function __construct() {
			parent::__construct();
		}
	}
?>