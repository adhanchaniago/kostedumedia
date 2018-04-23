<?php
	require_once('generic_dao.php');
	class marines_type_dao extends Generic_dao  {
		public function table_name(){
			return 'marines_type';
		}

		public function field_map() {
			return array ('martype_id'=>'martype_id','martype_name'=>'martype_name');
		}

		public function __construct() {
			parent::__construct();
		}

		public function key_value(){
			$entries = array();
			$objs = $this->fetch();
			foreach($objs as $obj){
				$entries[$obj->martype_id] = $obj->martype_name;
			}

			return $entries;
		}
	}
?>