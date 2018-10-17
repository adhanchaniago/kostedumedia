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
			'alamat'=>'alamat_penghuni',
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
			'metode_bayar'=>'metode_bayar',
			'sisa_pelunasan'=>'sisa_pelunasan',
			'email'=>'email',
			'fb'=>'fb',
			'twitter'=>'twitter',
			'bbm'=>'bbm',
			'ig'=>'ig'
		);
	}

	public function __construct() {
		parent::__construct();
	}

	function getPenghuni($id_penghuni) {
		return $this->by_id(array('id_penghuni' => $id_penghuni));
	}

	function saveNewPenghuni($obj) {
		$this->insert($obj);
		return $this->insert_id();
	}

	function editPenghuni($id, $obj) {
		return $this->update($obj, array('id_penghuni' => $id));
	}

	function deletePenghuni($id) {
		return $this->delete(array('id_penghuni' => $id));
	}

	function getCompletePenghuni($id_penghuni) {
		$this->ci->db->select('penghuni.*, id_kamar, nama_kamar AS hist_kamar, nama_kosan AS hist_kosan');
		$this->ci->db->from('kamar RIGHT JOIN kosan ON (kamar.id_kosan = kosan.id_kosan)
				LEFT JOIN penghuni ON (kamar.id_penghuni = penghuni.id_penghuni)
		');
		
		$q = $this->ci->db->where('penghuni.id_penghuni = ' . $id_penghuni);
		$q = $this->ci->db->get();
		return $q->row();
	}

	function getDaftarPenghuni() {
		$this->ci->db->select('penghuni.*, nama_kamar, nama_kosan');
		$this->ci->db->from('kamar RIGHT JOIN penghuni ON (kamar.id_penghuni = penghuni.id_penghuni)
				LEFT JOIN kosan ON (kamar.id_kosan = kosan.id_kosan)'
		);
		
		$q = $this->ci->db->get();
		return $q->result();
	}
}

?>
