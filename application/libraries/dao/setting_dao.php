<?php
	require_once('generic_dao.php');
	class setting_dao extends Generic_dao  {
		public function table_name(){
			return 'setting';
		}

		public function field_map() {
			return array (	'id_param' => 'id_param',
				'parameter'=>'parameter',
				'value'=>'value',
				'description' => 'description'
			);
		}

		public function __construct() {
			parent::__construct();
		}
	}
?>
