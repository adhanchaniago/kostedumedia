<?php

require_once('generic_dao.php');

class daftar_agama_dao extends Generic_dao  {
	
	public function table_name(){
		return 'daftar_agama';
	}

	public function field_map() {
		return array (
			'id'=>'id',
			'desc'=>'desc'
		);
	}

	public function __construct() {
		parent::__construct();
	}

	function getDaftar() {
		$limit = 100;
		$offset = 0;
		return $this->fetch($limit, $offset, 'id');
	}
	
}

?>
