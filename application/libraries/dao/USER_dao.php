<?php
	require_once('generic_dao.php');
	class USER_dao extends Generic_dao  {
		public function table_name(){
			return 'USER';
		}

		public function field_map() {
			return array ('user_id'=>'user_id','corps_id'=>'corps_id','uname'=>'uname','pwd'=>'pwd','name'=>'name');
		}

		public function __construct() {
			parent::__construct();
		}
	}
?>