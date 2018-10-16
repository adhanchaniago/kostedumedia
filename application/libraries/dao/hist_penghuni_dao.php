<?php

require_once('generic_dao.php');

class hist_penghuni_dao extends Generic_dao  {
	
	public function table_name(){
		return 'hist_penghuni';
	}

	public function field_map() {
		return array (
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
			'hist_kosan'=>'hist_kosan',
			'hist_kamar'=>'hist_kamar'
		);
	}

	public function __construct() {
		parent::__construct();
	}

	function saveNewHistPenghuni($obj) {
		// penyesuaian data
		unset($obj->id_penghuni);
		unset($obj->id_kamar);
		// convert ke array biar bisa pake fungsi yg udah dibikin
		$arrPenghuni = (array) $obj;

		return $this->insert($arrPenghuni);
	}

	function getDaftarHistPenghuni() {
		$limit = 1000;
		$offset = 0;
		return $this->fetch($limit, $offset, 'hist_kosan');
	}
}

?>
