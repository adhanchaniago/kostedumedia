<?php
	require_once('generic_dao.php');
	class station_class_dao extends Generic_dao  {
		public function table_name(){
			return 'station_class';
		}

		public function field_map() {
			return array ('sclass_id'=>'sclass_id','sclass_name'=>'sclass_name');
		}

		public function __construct() {
			parent::__construct();
		}

		public function key_value(){
			$res = array();
			$sclasses = $this->fetch();
			foreach($sclasses as $sclass){
				$res[$sclass->sclass_id] = $sclass->sclass_name;
			}

			return $res;
		}
	}
?>