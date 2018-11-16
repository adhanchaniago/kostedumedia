<?php

require_once('generic_dao.php');

class komplain_dao extends Generic_dao  {
	
	public function table_name(){
		return 'komplain';
	}

	public function field_map() {
		return array (
			'id_komplain'=>'id_komplain',
			'lokasi'=>'lokasi',
			'orang_kamar'=>'orang_kamar',
			'masalah'=>'masalah',
			'start_komplain'=>'start_komplain',
			'end_komplain'=>'end_komplain',
			'status_beres'=>'status_beres',
			'foto'=>'foto',
			'solusi'=>'solusi'
		);
	}

	public function __construct() {
		parent::__construct();
	}

	function getDaftarKomplain() {
		$limit = 1000;
		$offset = 0;
		return $this->fetch($limit, $offset, 'orang_kamar');
	}

	function getDataKomplain($id_komplain) {
		return $this->by_id(array('id_komplain' => $id_komplain));
	}

	function saveNewKomplain($obj) {
		return $this->insert($obj);
	}

	function editKomplain($id, $obj) {
		return $this->update($obj, array('id_komplain' => $id));
	}

	function deleteKomplain($id) {
		return $this->delete(array('id_komplain' => $id));
	}
}

?>
