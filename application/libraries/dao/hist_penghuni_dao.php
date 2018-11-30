<?php

require_once('generic_dao.php');

class hist_penghuni_dao extends Generic_dao  {
	
	public function table_name(){
		return 'hist_penghuni';
	}

	public function field_map() {
		return array (
			'id_history'=>'id_history',
			'nama_penghuni'=>'nama_penghuni',
			'nama_panggilan'=>'nama_panggilan',
			'hp'=>'hp',
			'hpdarurat'=>'hpdarurat',
			'foto'=>'foto',
			'alamat_penghuni'=>'alamat_penghuni',
			'no_ktp'=>'no_ktp',
			'tglmasuk'=>'tglmasuk',
			'tglkeluar'=>'tglkeluar',
			'fotoktp'=>'fotoktp',
			'fotoktm'=>'fotoktm',
			'lb'=>'lb',
			'ttl'=>'ttl',
			'gender'=>'gender',
			'agama'=>'agama',
			'hp2'=>'hp2',
			'jurusan'=>'jurusan',
			'fakultas'=>'fakultas',
			'nim'=>'nim',
			'ket_ayah'=>'ket_ayah',
			'ket_ibu'=>'ket_ibu',
			'sisa_pelunasan'=>'sisa_pelunasan',
			'email'=>'email',
			'fb'=>'fb',
			'twitter'=>'twitter',
			'bbm'=>'bbm',
			'ig'=>'ig',
			'hist_kosan'=>'hist_kosan',
			'hist_kamar'=>'hist_kamar',
			'alias_kosan'=>'alias_kosan'
		);
	}

	public function __construct() {
		parent::__construct();
	}

	function saveNewHistPenghuni($obj) {
		// penyesuaian data
		unset($obj->id_penghuni);
		unset($obj->id_kamar);
		unset($obj->metode_bayar);
		// convert ke array biar bisa pake fungsi yg udah dibikin
		$arrPenghuni = (array) $obj;

		return $this->insert($arrPenghuni);
	}

	function getDaftarHistPenghuni() {
		$limit = 1000;
		$offset = 0;
		return $this->fetch($limit, $offset, 'hist_kosan');
	}

	function getDataHistPenghuni($id_history) {
		$this->ci->db->select('hist_penghuni.*, daftar_agama.desc AS agama_penghuni');
		$this->ci->db->from('hist_penghuni LEFT JOIN daftar_agama ON (hist_penghuni.agama = daftar_agama.id)');
		
		$q = $this->ci->db->where('id_history = ' . $id_history);
		$q = $this->ci->db->get();
		return $q->row();
	}
}

?>
