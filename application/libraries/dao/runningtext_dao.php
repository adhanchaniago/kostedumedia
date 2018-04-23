<?php
	require_once('generic_dao.php');
	class runningtext_dao extends Generic_dao  {
		public function table_name(){
			return 'running_text';
		}

		public function field_map() {
			return array (	
				'pk'=>'pk',
				'status'=>'status',
				'status_desc' => 'status_desc',
				'datetime' => 'datetime',
				'day'=>'day'

			);
		}

		public function __construct() {
			parent::__construct();
		}
	}
?>
