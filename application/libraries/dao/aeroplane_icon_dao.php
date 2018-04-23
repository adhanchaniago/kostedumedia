<?php
	require_once('generic_dao.php');
	class aeroplane_icon_dao extends Generic_dao  {
		public function table_name(){
			return 'aeroplane_icon';
		}

		public function field_map() {
			return array ('aericon_id'=>'aericon_id', 'aericon_file'=>'aericon_file', 'aericon_desc'=>'aericon_desc');
		}

		public function __construct() {
			parent::__construct();
		}
	}
?>
