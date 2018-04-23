<?php
	require_once('generic_dao.php');
	class skuadron_dao extends Generic_dao  {
		public function table_name(){
			return 'skuadron';
		}

		public function field_map() {
			return array ('sku_code'=>'sku_code','sku_name'=>'sku_name');
		}

		public function __construct() {
			parent::__construct();
		}
	}
?>