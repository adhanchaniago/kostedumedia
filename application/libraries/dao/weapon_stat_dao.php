<?php
	require_once('generic_dao.php');
	class weapon_stat_dao extends Generic_dao  {
		public function table_name(){
			return 'weapon_stat';
		}

		public function field_map() {
			return array ('wstat_id'=>'wstat_id','wstat_desc'=>'wstat_desc');
		}

		public function __construct() {
			parent::__construct();
		}
	}
?>