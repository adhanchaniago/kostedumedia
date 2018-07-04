<?php

require_once('generic_dao.php');

class penghuni_dao extends Generic_dao  {
	
	public function table_name(){
		return 'penghuni';
	}

	public function field_map() {
		return array (
			'id_penghuni'=>'id_penghuni',
			'nama_penghuni'=>'nama_penghuni',
			'nama_panggilan'=>'nama_panggilan',
			'hp'=>'hp',
			'hpdarurat'=>'hpdarurat',
			'foto'=>'foto',
			'alamat'=>'alamat',
			'no_ktp'=>'no_ktp',
			'tglmasuk'=>'tglmasuk',
			'tglkeluar'=>'tglkeluar',
			'fotoktp'=>'fotoktp',
			'fotoktm'=>'fotoktm',
			'lb'=>'lb',
			'masih_tinggal'=>'masih_tinggal',
			'id_kamar'=>'id_kamar',
			'history_kosan'=>'history_kosan',
			'history_kamar'=>'history_kamar'
		);
	}

	public function __construct() {
		parent::__construct();
	}

	function getPenghuniKamar($id_kamar) {
		return $this->by_id(array('id_kamar' => $id_kamar));
	}

	function saveNewPenghuni($obj) {
		return $this->insert($obj);
	}

	function editPenghuni($id, $obj) {
		return $this->update($obj, array('id_penghuni' => $id));
	}
}

?>
