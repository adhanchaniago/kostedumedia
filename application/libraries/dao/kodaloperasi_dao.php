<?php
	require_once('generic_dao.php');
	class kodaloperasi_dao extends Generic_dao  {
		public function table_name(){
			return 'kodaloperasi';
		}

		public function field_map() {
			return array ('kodaloperasi_id'=>'kodaloperasi_id','kodaloperasi_desc'=>'kodaloperasi_desc');
		}

		public function __construct() {
			parent::__construct();
		}
	}
?>