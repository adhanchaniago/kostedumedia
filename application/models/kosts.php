<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Kosts extends CI_Model {
		private $ci; // added by SKM17

	function __construct() {
		parent::__construct();
		$this->ci = & get_instance();
		$client = new MongoClient($this->ci->config->item('ip_mongo'));
		$this->db = $client->kost;
		$this->data = $this->db->data;
	}

	function getUserById($id) {
		$user = $this->data->findOne(array('_id' => new MongoId($id)));
		if ($user) return $user;

		return false;
	}

	function getDaftarKosan($id) {
		$user = $this->data->findOne(array('_id' => new MongoId($id)));

		return $user['features'];
	}

	function getInfoKosan($id_user, $id_kosan) {
		$user = $this->data->findOne(array('_id' => new MongoId($id_user)));
		foreach ($user['features'] as $kosan) {
			if ($kosan['properties']['judul'] == $id_kosan) {
				return $kosan['properties'];
			}
		}

		return false;
	}

	function saveNewKosan($user_id, $datakosan='') {
		if ($datakosan != ''){
			$this->data->update(
				array('_id' => new MongoId($user_id)), 
				array('$push' => array(
					"features" => $datakosan
				))
			);
		}
	}

	function editKosan($user_id, $namakosanlama, $datakosan='') {
		if ($datakosan != '') {
			// pull data kosan lama
			$this->data->update(
				array('_id' => new MongoId($user_id)), 
				array('$pull' => array(
					"features"=> array("properties.judul" => $namakosanlama)
				))
			);

		// push data kosan baru
			$this->data->update(
				array('_id' => new MongoId($user_id)), 
				array('$push' => array(
					"features"=> $datakosan
				))
			);
		}
	}

	function deleteKosan($user_id, $namakosanlama) {
		$this->data->update(
			array('_id' => new MongoId($user_id)), 
			array('$pull' => array(
				"features"=> array("properties.judul" => $namakosanlama)
			))
		);
	}

	function editPemilik($user_id, $datapemilik) {
		$this->data->update(
			array('_id' => new MongoId($user_id)), 
			array('$set' => $datapemilik)
		);
	}

	// FOR LOGIN --------------------------------------------------------
	function get_user_by_login($login) {
		$user = $this->data->findOne(array('namauser' => $login));
		if ($user) return $user;

		return false;
	}

	function getAllDaftarKosan() {
		$users = $this->data->find();
		$usersArr = iterator_to_array($users);
		$arrKosan = array();

		foreach ($usersArr as $user) {
			foreach ($user['features'] as $listkosan) {
				array_push($arrKosan, $listkosan);
			}
		}

		return $arrKosan;
	}


/////////////// GA KEPAKE
	/** Insert new record */
	function save($member='') {
		if ($member != ''){
			if (!isset($member['id'])){ // new record
				$this->posts->insert($member);
				return $member['_id'];
			} else { // edit existing record
				$memberid = $member['id'];
				$this->posts->update(array('_id' => new MongoId($memberid)), $member, array("multiple" => false));
				return $memberid;
			}
		}
	}

	/** Fetches all records with limit and orderby values's */
	function getAll($limit='', $orderby='') {
		$members = $this->data->find();
		if ($limit != ''){ $members->limit($limit);}
		if ($orderby != ''){$members = $members->sort($orderby);}
		$array = iterator_to_array($members);
			// print_r($array); die();
		return $members;
	}

	/** Fetches a record by its' passed field and values's */
	function getByColumn($field='id', $value='') {
		$member = $this->posts->findOne(array($field => $value));
		if ($member) {
			return $member;
		}
		return false;
	}

	/** Deletes a record by it's primary key */
	function deleteById($id) {
		$this->posts->remove(array('_id' => new MongoId($id)), array("justOne" => true));
	}

}