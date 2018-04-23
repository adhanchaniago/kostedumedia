<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Autocomplete extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// $this->load->library('dao/autocomplete_search_dao');
		  $this->load->helper('url','form');
		  $this->load->library('javascript');
		  $this->load->library('form_validation');
		  $this->load->library('email');
		  $this->load->library('session');
		  $this->load->database();
		  

	}

	//1-2-3-4-5
	public function search()
	{
		
		$keyword = $this->uri->segment(3);

		// $data = $this->autocomplete_search_dao->search($keyword);

		$data = $this->db->query("(SELECT aer_id, aer_name,aer_lat,aer_lon,aer_is_in_operation, 'PESUD' as type,'' as abbr FROM aeroplane WHERE (aer_id::text LIKE '%".$keyword."%' OR aer_name::text LIKE '%".$keyword."%')AND aer_is_in_operation = true) 
			UNION (SELECT m.mar_id, u.unit_name, m.mar_lat, m.mar_lon, m.mar_in_ops,'MARINES' as type, '' as abbr FROM marines m 
			INNER JOIN unit u ON (m.unit_id = u.unit_id) 
			INNER JOIN corps c ON (m.corps_id = c.corps_id) 
			LEFT JOIN marine_icon i ON (m.maricon_id = i.maricon_id)  
			WHERE (mar_id::text LIKE '%".$keyword."%' OR unit_name::text LIKE '%".$keyword."%')AND mar_in_ops = true) 
			UNION (SELECT ship_id::integer, ship_name,ship_lat,ship_lon,ship_is_in_operation,'KRI' as type,ship_abbr FROM ship WHERE (ship_id::text LIKE '%".$keyword."%' OR ship_name::text LIKE '%".$keyword."%' OR ship_abbr LIKE '%".$keyword."%')AND ship_is_in_operation = true)
			UNION (SELECT station_id::integer, station_name,station_lat,station_lon,true as station_status,'PANGKALAN' as type,'' as abbr FROM station WHERE station_id::text LIKE '%".$keyword."%' OR station_name::text LIKE '%".$keyword."%')
			UNION (SELECT mardis_id::integer, operation_name,mardis_lat,mardis_lon,mardis_in_ops,'SATGAS' as type,'' as abbr FROM marines_dislocation WHERE (mardis_id::text LIKE '%".$keyword."%' OR operation_name::text LIKE '%".$keyword."%')AND mardis_in_ops = true)"); 	

		foreach($data->result() as $row)
		{
			if($row->type == 'KRI'){

				$row->aer_name = substr($row->aer_name,0,15);
				$row->aer_name = substr($row->aer_id."-".$row->abbr."-".$row->aer_name,0,19);
				if(strlen($row->aer_name) >= 19){
					$row->aer_name = $row->aer_name."... ";	
				}
			}
	
			$arr['suggestions'][] = array(
				'value'	=>$row->aer_name.'-('.$row->type.')',
				'id'	=>$row->aer_id,
				'lat'	=>$row->aer_lat,
				'lon'	=>$row->aer_lon,
				'type'  =>$row->type
			);
		}

		echo json_encode($arr);
		
	
	}

	// 1
	public function searchKRI()
	{				
	
		$keyword = $this->uri->segment(3);

		// $data = $this->autocomplete_search_dao->search($keyword);

		$data = $this->db->query("SELECT ship_id::integer, ship_name,ship_lat,ship_lon,ship_is_in_operation,'KRI' as type,ship_abbr FROM ship WHERE (ship_id::text LIKE '%".$keyword."%' OR ship_name::text LIKE '%".$keyword."%' OR ship_abbr LIKE '%".$keyword."%')AND ship_is_in_operation = true");
	
		foreach($data->result() as $row)
		{
			if($row->type == 'KRI'){

				$row->ship_name = substr($row->ship_name,0,15);
				$row->ship_name = substr($row->ship_id."-".$row->ship_abbr."-".$row->ship_name,0,19);
				if(strlen($row->ship_name) >= 19){
					$row->ship_name = $row->ship_name."... ";	
				}
				
			}
	
			$arr['suggestions'][] = array(
				'value'	=>$row->ship_name.'-('.$row->type.')',
				'id'	=>$row->ship_id,
				'lat'	=>$row->ship_lat,
				'lon'	=>$row->ship_lon,
				'type'  =>$row->type
			);
		}

		echo json_encode($arr);
		
	
	}

	// 2
	public function searchPESUD()
	{
		
		
	
		$keyword = $this->uri->segment(3);

		// $data = $this->autocomplete_search_dao->search($keyword);

		$data = $this->db->query("SELECT aer_id, aer_name,aer_lat,aer_lon,aer_is_in_operation, 'PESUD' as type,'' as abbr FROM aeroplane WHERE (aer_id::text LIKE '%".$keyword."%' OR aer_name::text LIKE '%".$keyword."%')AND aer_is_in_operation = true");
	
		foreach($data->result() as $row)
		{
	
			$arr['suggestions'][] = array(
				'value'	=>$row->aer_name.'-('.$row->type.')',
				'id'	=>$row->aer_id,
				'lat'	=>$row->aer_lat,
				'lon'	=>$row->aer_lon,
				'type'  =>$row->type
			);
		}

		echo json_encode($arr);
		
	
	}

	// 3
	public function searchPANGKALAN()
	{
		
		
	
		$keyword = $this->uri->segment(3);

		// $data = $this->autocomplete_search_dao->search($keyword);

		$data = $this->db->query("SELECT station_id::integer, station_name,station_lat,station_lon,true as station_status,'PANGKALAN' as type,'' as abbr FROM station WHERE station_id::text LIKE '%".$keyword."%' OR station_name::text LIKE '%".$keyword."%'");
	
		foreach($data->result() as $row)
		{
			
			$arr['suggestions'][] = array(
				'value'	=>$row->station_name.'-('.$row->type.')',
				'id'	=>$row->station_id,
				'lat'	=>$row->station_lat,
				'lon'	=>$row->station_lon,
				'type'  =>$row->type
			);
		}

		echo json_encode($arr);
		
	
	}

    // 4
	public function searchMARINIR()
	{
		
		
	
		$keyword = $this->uri->segment(3);

		// $data = $this->autocomplete_search_dao->search($keyword);

		$data = $this->db->query("(SELECT m.mar_id, u.unit_name, m.mar_lat, m.mar_lon, m.mar_in_ops,'MARINES' as type, '' as abbr FROM marines m 
		INNER JOIN unit u ON (m.unit_id = u.unit_id) 
		INNER JOIN corps c ON (m.corps_id = c.corps_id) 
		LEFT JOIN marine_icon i ON (m.maricon_id = i.maricon_id)  
		WHERE (mar_id::text LIKE '%".$keyword."%' OR unit_name::text LIKE '%".$keyword."%')AND mar_in_ops = true)");
	
		foreach($data->result() as $row)
		{
			
			$arr['suggestions'][] = array(
				'value'	=>$row->unit_name.'-('.$row->type.')',
				'id'	=>$row->mar_id,
				'lat'	=>$row->mar_lat,
				'lon'	=>$row->mar_lon,
				'type'  =>$row->type
			);
		}

		echo json_encode($arr);		
	
	}

	//5
	public function searchSATGAS()
	{
		
		
	
		$keyword = $this->uri->segment(3);

		// $data = $this->autocomplete_search_dao->search($keyword);

		$data = $this->db->query("SELECT mardis_id::integer, operation_name,mardis_lat,mardis_lon,mardis_in_ops,'SATGAS' as type,'' as abbr FROM marines_dislocation WHERE (mardis_id::text LIKE '%".$keyword."%' OR operation_name::text LIKE '%".$keyword."%')AND mardis_in_ops = true");
	
		foreach($data->result() as $row)
		{
			
			$arr['suggestions'][] = array(
				'value'	=>$row->operation_name.'-('.$row->type.')',
				'id'	=>$row->mardis_id,
				'lat'	=>$row->mardis_lat,
				'lon'	=>$row->mardis_lon,
				'type'  =>$row->type
			);
		}

		echo json_encode($arr);
		
	
	}

	// 1 - 2 - 3
	public function searchKriPesPang()
	{
		
		
	
		$keyword = $this->uri->segment(3);

		// $data = $this->autocomplete_search_dao->search($keyword);

		$data = $this->db->query("(SELECT aer_id, aer_name,aer_lat,aer_lon,aer_is_in_operation, 'PESUD' as type,'' as abbr FROM aeroplane WHERE (aer_id::text LIKE '%".$keyword."%' OR aer_name::text LIKE '%".$keyword."%')AND aer_is_in_operation = true) 
								UNION (SELECT station_id::integer, station_name,station_lat,station_lon,true as station_status,'PANGKALAN' as type,'' as abbr FROM station WHERE station_id::text LIKE '%".$keyword."%' OR station_name::text LIKE '%".$keyword."%') 
								UNION (SELECT ship_id::integer, ship_name,ship_lat,ship_lon,ship_is_in_operation,'KRI' as type,ship_abbr FROM ship WHERE (ship_id::text LIKE '%".$keyword."%' OR ship_name::text LIKE '%".$keyword."%' OR ship_abbr LIKE '%".$keyword."%')AND ship_is_in_operation = true)");
	
		foreach($data->result() as $row)
		{
			if($row->type == 'KRI'){

				$row->aer_name = substr($row->aer_name,0,15);
				$row->aer_name = substr($row->aer_id."-".$row->abbr."-".$row->aer_name,0,19);
				if(strlen($row->aer_name) >= 19){
					$row->aer_name = $row->aer_name."... ";	
				}
			}

			$arr['suggestions'][] = array(
				'value'	=>$row->aer_name.'-('.$row->type.')',
				'id'	=>$row->aer_id,
				'lat'	=>$row->aer_lat,
				'lon'	=>$row->aer_lon,
				'type'  =>$row->type
			);
		}

		echo json_encode($arr);
		
	
	}	

	// 1 - 2 - 4
	public function searchKriPesMar()
	{
		
		
	
		$keyword = $this->uri->segment(3);

		// $data = $this->autocomplete_search_dao->search($keyword);

		$data = $this->db->query("(SELECT aer_id, aer_name,aer_lat,aer_lon,aer_is_in_operation, 'PESUD' as type,'' as abbr FROM aeroplane WHERE (aer_id::text LIKE '%".$keyword."%' OR aer_name::text LIKE '%".$keyword."%')AND aer_is_in_operation = true) 
								UNION (SELECT m.mar_id, u.unit_name, m.mar_lat, m.mar_lon, m.mar_in_ops,'MARINES' as type, '' as abbr FROM marines m 
									INNER JOIN unit u ON (m.unit_id = u.unit_id) 
									INNER JOIN corps c ON (m.corps_id = c.corps_id) 
									LEFT JOIN marine_icon i ON (m.maricon_id = i.maricon_id)  
									WHERE (mar_id::text LIKE '%".$keyword."%' OR unit_name::text LIKE '%".$keyword."%')AND mar_in_ops = true) 
								UNION (SELECT ship_id::integer, ship_name,ship_lat,ship_lon,ship_is_in_operation,'KRI' as type,ship_abbr FROM ship WHERE (ship_id::text LIKE '%".$keyword."%' OR ship_name::text LIKE '%".$keyword."%' OR ship_abbr LIKE '%".$keyword."%')AND ship_is_in_operation = true)");

		foreach($data->result() as $row)
		{
			if($row->type == 'KRI'){

				$row->aer_name = substr($row->aer_name,0,15);
				$row->aer_name = substr($row->aer_id."-".$row->abbr."-".$row->aer_name,0,19);
				if(strlen($row->aer_name) >= 19){
					$row->aer_name = $row->aer_name."... ";	
				}
			}
			
			$arr['suggestions'][] = array(
				'value'	=>$row->aer_name.'-('.$row->type.')',
				'id'	=>$row->aer_id,
				'lat'	=>$row->aer_lat,
				'lon'	=>$row->aer_lon,
				'type'  =>$row->type
			);
		}

		echo json_encode($arr);
		
	
	}

	// 1 - 3 - 4
	public function searchKriPangMar()
	{
		
		
	
		$keyword = $this->uri->segment(3);

		// $data = $this->autocomplete_search_dao->search($keyword);

		$data = $this->db->query("(SELECT ship_id::integer, ship_name,ship_lat,ship_lon,ship_is_in_operation,'KRI' as type,ship_abbr FROM ship WHERE (ship_id::text LIKE '%".$keyword."%' OR ship_name::text LIKE '%".$keyword."%' OR ship_abbr LIKE '%".$keyword."%')AND ship_is_in_operation = true) 
								UNION (SELECT m.mar_id, u.unit_name, m.mar_lat, m.mar_lon, m.mar_in_ops,'MARINES' as type, '' as abbr FROM marines m 
									INNER JOIN unit u ON (m.unit_id = u.unit_id) 
									INNER JOIN corps c ON (m.corps_id = c.corps_id) 
									LEFT JOIN marine_icon i ON (m.maricon_id = i.maricon_id)  
									WHERE (mar_id::text LIKE '%".$keyword."%' OR unit_name::text LIKE '%".$keyword."%')AND mar_in_ops = true) 
								UNION (SELECT station_id::integer, station_name,station_lat,station_lon,true as station_status,'PANGKALAN' as type,'' as abbr FROM station WHERE station_id::text LIKE '%".$keyword."%' OR station_name::text LIKE '%".$keyword."%')");

		foreach($data->result() as $row)
		{
			if($row->type == 'KRI'){

				$row->ship_name = substr($row->ship_name,0,15);
				$row->ship_name = substr($row->ship_id."-".$row->ship_abbr."-".$row->ship_name,0,19);
				if(strlen($row->ship_name) >= 19){
					$row->ship_name = $row->ship_name."... ";	
				}
				
			}
			
			$arr['suggestions'][] = array(
				'value'	=>$row->ship_name.'-('.$row->type.')',
				'id'	=>$row->ship_id,
				'lat'	=>$row->ship_lat,
				'lon'	=>$row->ship_lon,
				'type'  =>$row->type
			);
		}

		echo json_encode($arr);
		
	
	}

	// 2 - 3 - 4
	public function searchPesPangMar()
	{
		
		
	
		$keyword = $this->uri->segment(3);

		// $data = $this->autocomplete_search_dao->search($keyword);

		$data = $this->db->query("(SELECT aer_id, aer_name,aer_lat,aer_lon,aer_is_in_operation, 'PESUD' as type,'' as abbr FROM aeroplane WHERE (aer_id::text LIKE '%".$keyword."%' OR aer_name::text LIKE '%".$keyword."%')AND aer_is_in_operation = true) 
								UNION (SELECT m.mar_id, u.unit_name, m.mar_lat, m.mar_lon, m.mar_in_ops,'MARINES' as type, '' as abbr FROM marines m 
									INNER JOIN unit u ON (m.unit_id = u.unit_id) 
									INNER JOIN corps c ON (m.corps_id = c.corps_id) 
									LEFT JOIN marine_icon i ON (m.maricon_id = i.maricon_id)  
									WHERE (mar_id::text LIKE '%".$keyword."%' OR unit_name::text LIKE '%".$keyword."%')AND mar_in_ops = true) 
								UNION (SELECT station_id::integer, station_name,station_lat,station_lon,true as station_status,'PANGKALAN' as type,'' as abbr FROM station WHERE station_id::text LIKE '%".$keyword."%' OR station_name::text LIKE '%".$keyword."%')");

		foreach($data->result() as $row)
		{
			
			$arr['suggestions'][] = array(
				'value'	=>$row->aer_name.'-('.$row->type.')',
				'id'	=>$row->aer_id,
				'lat'	=>$row->aer_lat,
				'lon'	=>$row->aer_lon,
				'type'  =>$row->type
			);
		}

		echo json_encode($arr);
		
	
	}

	

	// 1 - 2
	public function searchKriPes()
	{
		
		$keyword = $this->uri->segment(3);

		// $data = $this->autocomplete_search_dao->search($keyword);

		$data = $this->db->query("(SELECT aer_id, aer_name,aer_lat,aer_lon,aer_is_in_operation, 'PESUD' as type,'' as abbr FROM aeroplane WHERE (aer_id::text LIKE '%".$keyword."%' OR aer_name::text LIKE '%".$keyword."%')AND aer_is_in_operation = true) 
								UNION (SELECT ship_id::integer, ship_name,ship_lat,ship_lon,ship_is_in_operation,'KRI' as type,ship_abbr FROM ship WHERE (ship_id::text LIKE '%".$keyword."%' OR ship_name::text LIKE '%".$keyword."%' OR ship_abbr LIKE '%".$keyword."%')AND ship_is_in_operation = true)");

		foreach($data->result() as $row)
		{
			if($row->type == 'KRI'){

				$row->aer_name = substr($row->aer_name,0,15);
				$row->aer_name = substr($row->aer_id."-".$row->abbr."-".$row->aer_name,0,19);
				if(strlen($row->aer_name) >= 19){
					$row->aer_name = $row->aer_name."... ";	
				}
			}
			
			$arr['suggestions'][] = array(
				'value'	=>$row->aer_name.'-('.$row->type.')',
				'id'	=>$row->aer_id,
				'lat'	=>$row->aer_lat,
				'lon'	=>$row->aer_lon,
				'type'  =>$row->type
			);
		}

		echo json_encode($arr);
		
	
	}	

	// 1 - 3
	public function searchKriPang()
	{
		
		$keyword = $this->uri->segment(3);

		// $data = $this->autocomplete_search_dao->search($keyword);

		$data = $this->db->query("(SELECT ship_id::integer, ship_name,ship_lat,ship_lon,ship_is_in_operation,'KRI' as type,ship_abbr FROM ship WHERE (ship_id::text LIKE '%".$keyword."%' OR ship_name::text LIKE '%".$keyword."%' OR ship_abbr LIKE '%".$keyword."%')AND ship_is_in_operation = true) 
								UNION (SELECT station_id::integer, station_name,station_lat,station_lon,true as station_status,'PANGKALAN' as type,'' as abbr FROM station WHERE station_id::text LIKE '%".$keyword."%' OR station_name::text LIKE '%".$keyword."%')");

		foreach($data->result() as $row)
		{
			if($row->type == 'KRI'){

				$row->ship_name = substr($row->ship_name,0,15);
				$row->ship_name = substr($row->ship_id."-".$row->ship_abbr."-".$row->ship_name,0,19);
				if(strlen($row->ship_name) >= 19){
					$row->ship_name = $row->ship_name."... ";	
				}
				
			}
			
			$arr['suggestions'][] = array(
				'value'	=>$row->ship_name.'-('.$row->type.')',
				'id'	=>$row->ship_id,
				'lat'	=>$row->ship_lat,
				'lon'	=>$row->ship_lon,
				'type'  =>$row->type
			);
		}

		echo json_encode($arr);
		
	
	}

	// 1 - 4
	public function searchKriMar()
	{
		
		$keyword = $this->uri->segment(3);

		// $data = $this->autocomplete_search_dao->search($keyword);

		$data = $this->db->query("(SELECT ship_id::integer, ship_name,ship_lat,ship_lon,ship_is_in_operation,'KRI' as type,ship_abbr FROM ship WHERE (ship_id::text LIKE '%".$keyword."%' OR ship_name::text LIKE '%".$keyword."%' OR ship_abbr LIKE '%".$keyword."%')AND ship_is_in_operation = true) 
								UNION (SELECT m.mar_id, u.unit_name, m.mar_lat, m.mar_lon, m.mar_in_ops,'MARINES' as type, '' as abbr FROM marines m 
								INNER JOIN unit u ON (m.unit_id = u.unit_id) 
								INNER JOIN corps c ON (m.corps_id = c.corps_id) 
								LEFT JOIN marine_icon i ON (m.maricon_id = i.maricon_id)  
								WHERE (mar_id::text LIKE '%".$keyword."%' OR unit_name::text LIKE '%".$keyword."%')AND mar_in_ops = true)");

		foreach($data->result() as $row)
		{
			if($row->type == 'KRI'){

				$row->ship_name = substr($row->ship_name,0,15);
				$row->ship_name = substr($row->ship_id."-".$row->ship_abbr."-".$row->ship_name,0,19);
				if(strlen($row->ship_name) >= 19){
					$row->ship_name = $row->ship_name."... ";	
				}
				
			}
			
			$arr['suggestions'][] = array(
				'value'	=>$row->ship_name.'-('.$row->type.')',
				'id'	=>$row->ship_id,
				'lat'	=>$row->ship_lat,
				'lon'	=>$row->ship_lon,
				'type'  =>$row->type
			);
		}

		echo json_encode($arr);
		
	
	}

	// 2 - 3
	public function searchPesPang()
	{
		
		$keyword = $this->uri->segment(3);

		// $data = $this->autocomplete_search_dao->search($keyword);

		$data = $this->db->query("(SELECT aer_id, aer_name,aer_lat,aer_lon,aer_is_in_operation, 'PESUD' as type,'' as abbr FROM aeroplane WHERE (aer_id::text LIKE '%".$keyword."%' OR aer_name::text LIKE '%".$keyword."%')AND aer_is_in_operation = true) 
								UNION (SELECT station_id::integer, station_name,station_lat,station_lon,true as station_status,'PANGKALAN' as type,'' as abbr FROM station WHERE station_id::text LIKE '%".$keyword."%' OR station_name::text LIKE '%".$keyword."%')");

		foreach($data->result() as $row)
		{
			
			$arr['suggestions'][] = array(
				'value'	=>$row->aer_name.'-('.$row->type.')',
				'id'	=>$row->aer_id,
				'lat'	=>$row->aer_lat,
				'lon'	=>$row->aer_lon,
				'type'  =>$row->type
			);
		}

		echo json_encode($arr);
		
	
	}

	// 2 - 4
	public function searchPesMar()
	{
		
		$keyword = $this->uri->segment(3);

		// $data = $this->autocomplete_search_dao->search($keyword);

		$data = $this->db->query("(SELECT aer_id, aer_name,aer_lat,aer_lon,aer_is_in_operation, 'PESUD' as type,'' as abbr FROM aeroplane WHERE (aer_id::text LIKE '%".$keyword."%' OR aer_name::text LIKE '%".$keyword."%')AND aer_is_in_operation = true) 
								UNION (SELECT m.mar_id, u.unit_name, m.mar_lat, m.mar_lon, m.mar_in_ops,'MARINES' as type, '' as abbr FROM marines m 
								INNER JOIN unit u ON (m.unit_id = u.unit_id) 
								INNER JOIN corps c ON (m.corps_id = c.corps_id) 
								LEFT JOIN marine_icon i ON (m.maricon_id = i.maricon_id)  
								WHERE (mar_id::text LIKE '%".$keyword."%' OR unit_name::text LIKE '%".$keyword."%')AND mar_in_ops = true)");

		foreach($data->result() as $row)
		{
			
			$arr['suggestions'][] = array(
				'value'	=>$row->aer_name.'-('.$row->type.')',
				'id'	=>$row->aer_id,
				'lat'	=>$row->aer_lat,
				'lon'	=>$row->aer_lon,
				'type'  =>$row->type
			);
		}

		echo json_encode($arr);
		
	
	}	

	// 3 - 4
	public function searchPangMar()
	{
		
		$keyword = $this->uri->segment(3);

		// $data = $this->autocomplete_search_dao->search($keyword);

		$data = $this->db->query("(SELECT station_id::integer, station_name,station_lat,station_lon,true as station_status,'PANGKALAN' as type,'' as abbr FROM station WHERE station_id::text LIKE '%".$keyword."%' OR station_name::text LIKE '%".$keyword."%') 
								UNION (SELECT m.mar_id, u.unit_name, m.mar_lat, m.mar_lon, m.mar_in_ops,'MARINES' as type, '' as abbr FROM marines m 
								INNER JOIN unit u ON (m.unit_id = u.unit_id) 
								INNER JOIN corps c ON (m.corps_id = c.corps_id) 
								LEFT JOIN marine_icon i ON (m.maricon_id = i.maricon_id)  
								WHERE (mar_id::text LIKE '%".$keyword."%' OR unit_name::text LIKE '%".$keyword."%')AND mar_in_ops = true)");

		foreach($data->result() as $row)
		{
			
			$arr['suggestions'][] = array(
				'value'	=>$row->station_name.'-('.$row->type.')',
				'id'	=>$row->station_id,
				'lat'	=>$row->station_lat,
				'lon'	=>$row->station_lon,
				'type'  =>$row->type
			);
		}

		echo json_encode($arr);
		
	
	}	


	//Mulai dari sini, query belum di uji
	//1 - 2 - 3 - 4 
	public function searchKriPesPangMar()
	{
		
		$keyword = $this->uri->segment(3);

		// $data = $this->autocomplete_search_dao->search($keyword);

		$data = $this->db->query("(SELECT aer_id, aer_name,aer_lat,aer_lon,aer_is_in_operation, 'PESUD' as type,'' as abbr FROM aeroplane WHERE (aer_id::text LIKE '%".$keyword."%' OR aer_name::text LIKE '%".$keyword."%')AND aer_is_in_operation = true) 
			UNION (SELECT m.mar_id, u.unit_name, m.mar_lat, m.mar_lon, m.mar_in_ops,'MARINES' as type, '' as abbr FROM marines m 
			INNER JOIN unit u ON (m.unit_id = u.unit_id) 
			INNER JOIN corps c ON (m.corps_id = c.corps_id) 
			LEFT JOIN marine_icon i ON (m.maricon_id = i.maricon_id)  
			WHERE (mar_id::text LIKE '%".$keyword."%' OR unit_name::text LIKE '%".$keyword."%')AND mar_in_ops = true) 
			UNION (SELECT ship_id::integer, ship_name,ship_lat,ship_lon,ship_is_in_operation,'KRI' as type,ship_abbr FROM ship WHERE (ship_id::text LIKE '%".$keyword."%' OR ship_name::text LIKE '%".$keyword."%' OR ship_abbr LIKE '%".$keyword."%')AND ship_is_in_operation = true)
			UNION (SELECT station_id::integer, station_name,station_lat,station_lon,true as station_status,'PANGKALAN' as type,'' as abbr FROM station WHERE station_id::text LIKE '%".$keyword."%' OR station_name::text LIKE '%".$keyword."%')");

		foreach($data->result() as $row)
		{
			
			if($row->type == 'KRI'){

				$row->aer_name = substr($row->aer_name,0,15);
				$row->aer_name = substr($row->aer_id."-".$row->abbr."-".$row->aer_name,0,19);
				if(strlen($row->aer_name) >= 19){
					$row->aer_name = $row->aer_name."... ";	
				}
			}

			$arr['suggestions'][] = array(
				'value'	=>$row->aer_name.'-('.$row->type.')',
				'id'	=>$row->aer_id,
				'lat'	=>$row->aer_lat,
				'lon'	=>$row->aer_lon,
				'type'  =>$row->type
			);
		}

		echo json_encode($arr);
		
	}

	//1 - 2 - 3 - 5
	public function searchKriPesPangSat()
	{
		
		$keyword = $this->uri->segment(3);

		// $data = $this->autocomplete_search_dao->search($keyword);

		$data = $this->db->query("(SELECT aer_id, aer_name,aer_lat,aer_lon,aer_is_in_operation, 'PESUD' as type,'' as abbr FROM aeroplane WHERE (aer_id::text LIKE '%".$keyword."%' OR aer_name::text LIKE '%".$keyword."%')AND aer_is_in_operation = true) 
			UNION (SELECT mardis_id::integer, operation_name,mardis_lat,mardis_lon,mardis_in_ops,'SATGAS' as type,'' as abbr FROM marines_dislocation WHERE (mardis_id::text LIKE '%".$keyword."%' OR operation_name::text LIKE '%".$keyword."%')AND mardis_in_ops = true) 
			UNION (SELECT ship_id::integer, ship_name,ship_lat,ship_lon,ship_is_in_operation,'KRI' as type,ship_abbr FROM ship WHERE (ship_id::text LIKE '%".$keyword."%' OR ship_name::text LIKE '%".$keyword."%' OR ship_abbr LIKE '%".$keyword."%')AND ship_is_in_operation = true)
			UNION (SELECT station_id::integer, station_name,station_lat,station_lon,true as station_status,'PANGKALAN' as type,'' as abbr FROM station WHERE station_id::text LIKE '%".$keyword."%' OR station_name::text LIKE '%".$keyword."%')");

		foreach($data->result() as $row)
		{
			
			if($row->type == 'KRI'){

				$row->aer_name = substr($row->aer_name,0,15);
				$row->aer_name = substr($row->aer_id."-".$row->abbr."-".$row->aer_name,0,19);
				if(strlen($row->aer_name) >= 19){
					$row->aer_name = $row->aer_name."... ";	
				}
			}

			$arr['suggestions'][] = array(
				'value'	=>$row->aer_name.'-('.$row->type.')',
				'id'	=>$row->aer_id,
				'lat'	=>$row->aer_lat,
				'lon'	=>$row->aer_lon,
				'type'  =>$row->type
			);
		}

		echo json_encode($arr);
		
	}

	//1 - 2 - 4 - 5
	public function searchKriPesMarSat()
	{
		
		$keyword = $this->uri->segment(3);

		// $data = $this->autocomplete_search_dao->search($keyword);

		$data = $this->db->query("(SELECT aer_id, aer_name,aer_lat,aer_lon,aer_is_in_operation, 'PESUD' as type,'' as abbr FROM aeroplane WHERE (aer_id::text LIKE '%".$keyword."%' OR aer_name::text LIKE '%".$keyword."%')AND aer_is_in_operation = true) 
			UNION (SELECT mardis_id::integer, operation_name,mardis_lat,mardis_lon,mardis_in_ops,'SATGAS' as type,'' as abbr FROM marines_dislocation WHERE (mardis_id::text LIKE '%".$keyword."%' OR operation_name::text LIKE '%".$keyword."%')AND mardis_in_ops = true) 
			UNION (SELECT ship_id::integer, ship_name,ship_lat,ship_lon,ship_is_in_operation,'KRI' as type,ship_abbr FROM ship WHERE (ship_id::text LIKE '%".$keyword."%' OR ship_name::text LIKE '%".$keyword."%' OR ship_abbr LIKE '%".$keyword."%')AND ship_is_in_operation = true)
			UNION (SELECT m.mar_id, u.unit_name, m.mar_lat, m.mar_lon, m.mar_in_ops,'MARINES' as type, '' as abbr FROM marines m 
			INNER JOIN unit u ON (m.unit_id = u.unit_id) 
			INNER JOIN corps c ON (m.corps_id = c.corps_id) 
			LEFT JOIN marine_icon i ON (m.maricon_id = i.maricon_id)  
			WHERE (mar_id::text LIKE '%".$keyword."%' OR unit_name::text LIKE '%".$keyword."%')AND mar_in_ops = true)");

		foreach($data->result() as $row)
		{
			
			if($row->type == 'KRI'){

				$row->aer_name = substr($row->aer_name,0,15);
				$row->aer_name = substr($row->aer_id."-".$row->abbr."-".$row->aer_name,0,19);
				if(strlen($row->aer_name) >= 19){
					$row->aer_name = $row->aer_name."... ";	
				}
			}

			$arr['suggestions'][] = array(
				'value'	=>$row->aer_name.'-('.$row->type.')',
				'id'	=>$row->aer_id,
				'lat'	=>$row->aer_lat,
				'lon'	=>$row->aer_lon,
				'type'  =>$row->type
			);
		}

		echo json_encode($arr);
		
	}	

	//1 - 3 - 4 - 5
	public function searchKriPangMarSat()
	{
		
		$keyword = $this->uri->segment(3);

		// $data = $this->autocomplete_search_dao->search($keyword);

		$data = $this->db->query("(SELECT station_id::integer, station_name,station_lat,station_lon,true as station_status,'PANGKALAN' as type,'' as abbr FROM station WHERE station_id::text LIKE '%".$keyword."%' OR station_name::text LIKE '%".$keyword."%') 
			UNION (SELECT mardis_id::integer, operation_name,mardis_lat,mardis_lon,mardis_in_ops,'SATGAS' as type,'' as abbr FROM marines_dislocation WHERE (mardis_id::text LIKE '%".$keyword."%' OR operation_name::text LIKE '%".$keyword."%')AND mardis_in_ops = true) 
			UNION (SELECT ship_id::integer, ship_name,ship_lat,ship_lon,ship_is_in_operation,'KRI' as type,ship_abbr FROM ship WHERE (ship_id::text LIKE '%".$keyword."%' OR ship_name::text LIKE '%".$keyword."%' OR ship_abbr LIKE '%".$keyword."%')AND ship_is_in_operation = true)
			UNION (SELECT m.mar_id, u.unit_name, m.mar_lat, m.mar_lon, m.mar_in_ops,'MARINES' as type, '' as abbr FROM marines m 
			INNER JOIN unit u ON (m.unit_id = u.unit_id) 
			INNER JOIN corps c ON (m.corps_id = c.corps_id) 
			LEFT JOIN marine_icon i ON (m.maricon_id = i.maricon_id)  
			WHERE (mar_id::text LIKE '%".$keyword."%' OR unit_name::text LIKE '%".$keyword."%')AND mar_in_ops = true)");

		foreach($data->result() as $row)
		{

			if($row->type == 'KRI'){

				$row->station_name = substr($row->station_name,0,15);
				$row->station_name = substr($row->station_id."-".$row->abbr."-".$row->station_name,0,19);
				if(strlen($row->station_name) >= 19){
					$row->station_name = $row->station_name."... ";	
				}
				
			}

			$arr['suggestions'][] = array(
				'value'	=>$row->station_name.'-('.$row->type.')',
				'id'	=>$row->station_id,
				'lat'	=>$row->station_lat,
				'lon'	=>$row->station_lon,
				'type'  =>$row->type
			);
		}

		echo json_encode($arr);
		
	}

	//2 - 3 - 4 - 5
	public function searchPesPangMarSat()
	{
		
		$keyword = $this->uri->segment(3);

		// $data = $this->autocomplete_search_dao->search($keyword);

		$data = $this->db->query("(SELECT station_id::integer, station_name,station_lat,station_lon,true as station_status,'PANGKALAN' as type,'' as abbr FROM station WHERE station_id::text LIKE '%".$keyword."%' OR station_name::text LIKE '%".$keyword."%') 
			UNION (SELECT mardis_id::integer, operation_name,mardis_lat,mardis_lon,mardis_in_ops,'SATGAS' as type,'' as abbr FROM marines_dislocation WHERE (mardis_id::text LIKE '%".$keyword."%' OR operation_name::text LIKE '%".$keyword."%')AND mardis_in_ops = true) 
			UNION (SELECT aer_id, aer_name,aer_lat,aer_lon,aer_is_in_operation, 'PESUD' as type,'' as abbr FROM aeroplane WHERE (aer_id::text LIKE '%".$keyword."%' OR aer_name::text LIKE '%".$keyword."%')AND aer_is_in_operation = true)
			UNION (SELECT m.mar_id, u.unit_name, m.mar_lat, m.mar_lon, m.mar_in_ops,'MARINES' as type, '' as abbr FROM marines m 
			INNER JOIN unit u ON (m.unit_id = u.unit_id) 
			INNER JOIN corps c ON (m.corps_id = c.corps_id) 
			LEFT JOIN marine_icon i ON (m.maricon_id = i.maricon_id)  
			WHERE (mar_id::text LIKE '%".$keyword."%' OR unit_name::text LIKE '%".$keyword."%')AND mar_in_ops = true)");

		foreach($data->result() as $row)
		{

			$arr['suggestions'][] = array(
				'value'	=>$row->station_name.'-('.$row->type.')',
				'id'	=>$row->station_id,
				'lat'	=>$row->station_lat,
				'lon'	=>$row->station_lon,
				'type'  =>$row->type
			);
		}

		echo json_encode($arr);
		
	}

	//1 - 2 - 5
	public function searchKriPesSat()
	{
		
		$keyword = $this->uri->segment(3);

		// $data = $this->autocomplete_search_dao->search($keyword);

		$data = $this->db->query("(SELECT aer_id, aer_name,aer_lat,aer_lon,aer_is_in_operation, 'PESUD' as type,'' as abbr FROM aeroplane WHERE (aer_id::text LIKE '%".$keyword."%' OR aer_name::text LIKE '%".$keyword."%')AND aer_is_in_operation = true) 
			UNION (SELECT mardis_id::integer, operation_name,mardis_lat,mardis_lon,mardis_in_ops,'SATGAS' as type,'' as abbr FROM marines_dislocation WHERE (mardis_id::text LIKE '%".$keyword."%' OR operation_name::text LIKE '%".$keyword."%')AND mardis_in_ops = true) 
			UNION (SELECT ship_id::integer, ship_name,ship_lat,ship_lon,ship_is_in_operation,'KRI' as type,ship_abbr FROM ship WHERE (ship_id::text LIKE '%".$keyword."%' OR ship_name::text LIKE '%".$keyword."%' OR ship_abbr LIKE '%".$keyword."%')AND ship_is_in_operation = true)");

		foreach($data->result() as $row)
		{
			if($row->type == 'KRI'){

				$row->aer_name = substr($row->aer_name,0,15);
				$row->aer_name = substr($row->aer_id."-".$row->abbr."-".$row->aer_name,0,19);
				if(strlen($row->aer_name) >= 19){
					$row->aer_name = $row->aer_name."... ";	
				}
			}

			$arr['suggestions'][] = array(
				'value'	=>$row->aer_name.'-('.$row->type.')',
				'id'	=>$row->aer_id,
				'lat'	=>$row->aer_lat,
				'lon'	=>$row->aer_lon,
				'type'  =>$row->type
			);
		}

		echo json_encode($arr);
		
	}

	//1 - 3 - 5
	public function searchKriPangSat()
	{
		
		$keyword = $this->uri->segment(3);

		// $data = $this->autocomplete_search_dao->search($keyword);

		$data = $this->db->query("(SELECT station_id::integer, station_name,station_lat,station_lon,true as station_status,'PANGKALAN' as type,'' as abbr FROM station WHERE station_id::text LIKE '%".$keyword."%' OR station_name::text LIKE '%".$keyword."%') 
			UNION (SELECT mardis_id::integer, operation_name,mardis_lat,mardis_lon,mardis_in_ops,'SATGAS' as type,'' as abbr FROM marines_dislocation WHERE (mardis_id::text LIKE '%".$keyword."%' OR operation_name::text LIKE '%".$keyword."%')AND mardis_in_ops = true) 
			UNION (SELECT ship_id::integer, ship_name,ship_lat,ship_lon,ship_is_in_operation,'KRI' as type,ship_abbr FROM ship WHERE (ship_id::text LIKE '%".$keyword."%' OR ship_name::text LIKE '%".$keyword."%' OR ship_abbr LIKE '%".$keyword."%')AND ship_is_in_operation = true)");

		foreach($data->result() as $row)
		{
			if($row->type == 'KRI'){

				$row->station_name = substr($row->station_name,0,15);
				$row->station_name = substr($row->station_id."-".$row->abbr."-".$row->station_name,0,19);
				if(strlen($row->station_name) >= 19){
					$row->station_name = $row->station_name."... ";	
				}
				
			}

			$arr['suggestions'][] = array(
				'value'	=>$row->station_name.'-('.$row->type.')',
				'id'	=>$row->station_id,
				'lat'	=>$row->station_lat,
				'lon'	=>$row->station_lon,
				'type'  =>$row->type
			);
		}

		echo json_encode($arr);
		
	}

	//1 - 4 - 5
	public function searchKriMarSat()
	{
		
		$keyword = $this->uri->segment(3);

		// $data = $this->autocomplete_search_dao->search($keyword);

		$data = $this->db->query("(SELECT m.mar_id, u.unit_name, m.mar_lat, m.mar_lon, m.mar_in_ops,'MARINES' as type, '' as abbr FROM marines m 
			INNER JOIN unit u ON (m.unit_id = u.unit_id) 
			INNER JOIN corps c ON (m.corps_id = c.corps_id) 
			LEFT JOIN marine_icon i ON (m.maricon_id = i.maricon_id)  
			WHERE (mar_id::text LIKE '%".$keyword."%' OR unit_name::text LIKE '%".$keyword."%')AND mar_in_ops = true) 
			UNION (SELECT mardis_id::integer, operation_name,mardis_lat,mardis_lon,mardis_in_ops,'SATGAS' as type,'' as abbr FROM marines_dislocation WHERE (mardis_id::text LIKE '%".$keyword."%' OR operation_name::text LIKE '%".$keyword."%')AND mardis_in_ops = true) 
			UNION (SELECT ship_id::integer, ship_name,ship_lat,ship_lon,ship_is_in_operation,'KRI' as type,ship_abbr FROM ship WHERE (ship_id::text LIKE '%".$keyword."%' OR ship_name::text LIKE '%".$keyword."%' OR ship_abbr LIKE '%".$keyword."%')AND ship_is_in_operation = true)");

		foreach($data->result() as $row)
		{
			if($row->type == 'KRI'){
				$row->unit_name = $row->mar_id." ".$row->abbr;
			}

			if($row->type == 'KRI'){

				$row->unit_name = substr($row->unit_name,0,15);
				$row->unit_name = substr($row->mar_id."-".$row->abbr."-".$row->unit_name,0,19);
				if(strlen($row->unit_name) >= 19){
					$row->unit_name = $row->unit_name."... ";	
				}
				
			}

			$arr['suggestions'][] = array(
				'value'	=>$row->unit_name.'-('.$row->type.')',
				'id'	=>$row->mar_id,
				'lat'	=>$row->mar_lat,
				'lon'	=>$row->mar_lon,
				'type'  =>$row->type
			);
		}

		echo json_encode($arr);
		
	}

	//2 - 3 - 5
	public function searchPesPangSat()
	{
		
		$keyword = $this->uri->segment(3);

		// $data = $this->autocomplete_search_dao->search($keyword);

		$data = $this->db->query("(SELECT station_id::integer, station_name,station_lat,station_lon,true as station_status,'PANGKALAN' as type,'' as abbr FROM station WHERE station_id::text LIKE '%".$keyword."%' OR station_name::text LIKE '%".$keyword."%') 
			UNION (SELECT mardis_id::integer, operation_name,mardis_lat,mardis_lon,mardis_in_ops,'SATGAS' as type,'' as abbr FROM marines_dislocation WHERE (mardis_id::text LIKE '%".$keyword."%' OR operation_name::text LIKE '%".$keyword."%')AND mardis_in_ops = true) 
			UNION (SELECT aer_id, aer_name,aer_lat,aer_lon,aer_is_in_operation, 'PESUD' as type,'' as abbr FROM aeroplane WHERE (aer_id::text LIKE '%".$keyword."%' OR aer_name::text LIKE '%".$keyword."%')AND aer_is_in_operation = true)");

		foreach($data->result() as $row)
		{
			$arr['suggestions'][] = array(
				'value'	=>$row->station_name.'-('.$row->type.')',
				'id'	=>$row->station_id,
				'lat'	=>$row->station_lat,
				'lon'	=>$row->station_lon,
				'type'  =>$row->type
			);
		}

		echo json_encode($arr);
		
	}	

	//2 - 4 - 5
	public function searchPesMarSat()
	{
		
		$keyword = $this->uri->segment(3);

		// $data = $this->autocomplete_search_dao->search($keyword);

		$data = $this->db->query("(SELECT m.mar_id, u.unit_name, m.mar_lat, m.mar_lon, m.mar_in_ops,'MARINES' as type, '' as abbr FROM marines m 
			INNER JOIN unit u ON (m.unit_id = u.unit_id) 
			INNER JOIN corps c ON (m.corps_id = c.corps_id) 
			LEFT JOIN marine_icon i ON (m.maricon_id = i.maricon_id)  
			WHERE (mar_id::text LIKE '%".$keyword."%' OR unit_name::text LIKE '%".$keyword."%')AND mar_in_ops = true) 
			UNION (SELECT mardis_id::integer, operation_name,mardis_lat,mardis_lon,mardis_in_ops,'SATGAS' as type,'' as abbr FROM marines_dislocation WHERE (mardis_id::text LIKE '%".$keyword."%' OR operation_name::text LIKE '%".$keyword."%')AND mardis_in_ops = true) 
			UNION (SELECT aer_id, aer_name,aer_lat,aer_lon,aer_is_in_operation, 'PESUD' as type,'' as abbr FROM aeroplane WHERE (aer_id::text LIKE '%".$keyword."%' OR aer_name::text LIKE '%".$keyword."%')AND aer_is_in_operation = true)");

		foreach($data->result() as $row)
		{
			$arr['suggestions'][] = array(
				'value'	=>$row->unit_name.'-('.$row->type.')',
				'id'	=>$row->mar_id,
				'lat'	=>$row->mar_lat,
				'lon'	=>$row->mar_lon,
				'type'  =>$row->type
			);
		}

		echo json_encode($arr);
		
	}

	//3 - 4 - 5
	public function searchPangMarSat()
	{
		
		$keyword = $this->uri->segment(3);

		// $data = $this->autocomplete_search_dao->search($keyword);

		$data = $this->db->query("(SELECT m.mar_id, u.unit_name, m.mar_lat, m.mar_lon, m.mar_in_ops,'MARINES' as type, '' as abbr FROM marines m 
			INNER JOIN unit u ON (m.unit_id = u.unit_id) 
			INNER JOIN corps c ON (m.corps_id = c.corps_id) 
			LEFT JOIN marine_icon i ON (m.maricon_id = i.maricon_id)  
			WHERE (mar_id::text LIKE '%".$keyword."%' OR unit_name::text LIKE '%".$keyword."%')AND mar_in_ops = true) 
			UNION (SELECT mardis_id::integer, operation_name,mardis_lat,mardis_lon,mardis_in_ops,'SATGAS' as type,'' as abbr FROM marines_dislocation WHERE (mardis_id::text LIKE '%".$keyword."%' OR operation_name::text LIKE '%".$keyword."%')AND mardis_in_ops = true) 
			UNION (SELECT station_id::integer, station_name,station_lat,station_lon,true as station_status,'PANGKALAN' as type,'' as abbr FROM station WHERE station_id::text LIKE '%".$keyword."%' OR station_name::text LIKE '%".$keyword."%')");

		foreach($data->result() as $row)
		{
			$arr['suggestions'][] = array(
				'value'	=>$row->unit_name.'-('.$row->type.')',
				'id'	=>$row->mar_id,
				'lat'	=>$row->mar_lat,
				'lon'	=>$row->mar_lon,
				'type'  =>$row->type
			);
		}

		echo json_encode($arr);
		
	}

	//1 - 5
	public function searchKriSat()
	{
		
		$keyword = $this->uri->segment(3);

		// $data = $this->autocomplete_search_dao->search($keyword);

		$data = $this->db->query("(SELECT ship_id::integer, ship_name,ship_lat,ship_lon,ship_is_in_operation,'KRI' as type,ship_abbr FROM ship WHERE (ship_id::text LIKE '%".$keyword."%' OR ship_name::text LIKE '%".$keyword."%' OR ship_abbr LIKE '%".$keyword."%')AND ship_is_in_operation = true) 
			UNION (SELECT mardis_id::integer, operation_name,mardis_lat,mardis_lon,mardis_in_ops,'SATGAS' as type,'' as abbr FROM marines_dislocation WHERE (mardis_id::text LIKE '%".$keyword."%' OR operation_name::text LIKE '%".$keyword."%')AND mardis_in_ops = true)");

		foreach($data->result() as $row)
		{

			if($row->type == 'KRI'){

				$row->ship_name = substr($row->ship_name,0,15);
				$row->ship_name = substr($row->ship_id."-".$row->ship_abbr."-".$row->ship_name,0,19);
				if(strlen($row->ship_name) >= 19){
					$row->ship_name = $row->ship_name."... ";	
				}
				
			}

			$arr['suggestions'][] = array(
				'value'	=>$row->ship_name.'-('.$row->type.')',
				'id'	=>$row->ship_id,
				'lat'	=>$row->ship_lat,
				'lon'	=>$row->ship_lon,
				'type'  =>$row->type
			);
		}

		echo json_encode($arr);
		
	}											
			
	//2 - 5
	public function searchPesSat()
	{
		
		$keyword = $this->uri->segment(3);

		// $data = $this->autocomplete_search_dao->search($keyword);

		$data = $this->db->query("(SELECT aer_id, aer_name,aer_lat,aer_lon,aer_is_in_operation, 'PESUD' as type,'' as abbr FROM aeroplane WHERE (aer_id::text LIKE '%".$keyword."%' OR aer_name::text LIKE '%".$keyword."%')AND aer_is_in_operation = true) 
			UNION (SELECT mardis_id::integer, operation_name,mardis_lat,mardis_lon,mardis_in_ops,'SATGAS' as type,'' as abbr FROM marines_dislocation WHERE (mardis_id::text LIKE '%".$keyword."%' OR operation_name::text LIKE '%".$keyword."%')AND mardis_in_ops = true)");

		foreach($data->result() as $row)
		{
			$arr['suggestions'][] = array(
				'value'	=>$row->aer_name.'-('.$row->type.')',
				'id'	=>$row->aer_id,
				'lat'	=>$row->aer_lat,
				'lon'	=>$row->aer_lon,
				'type'  =>$row->type
			);
		}

		echo json_encode($arr);
		
	}											
	
	//3 - 5
	public function searchPangSat()
	{
		
		$keyword = $this->uri->segment(3);

		// $data = $this->autocomplete_search_dao->search($keyword);

		$data = $this->db->query("(SELECT station_id::integer, station_name,station_lat,station_lon,true as station_status,'PANGKALAN' as type,'' as abbr FROM station WHERE station_id::text LIKE '%".$keyword."%' OR station_name::text LIKE '%".$keyword."%') 
			UNION (SELECT mardis_id::integer, operation_name,mardis_lat,mardis_lon,mardis_in_ops,'SATGAS' as type,'' as abbr FROM marines_dislocation WHERE (mardis_id::text LIKE '%".$keyword."%' OR operation_name::text LIKE '%".$keyword."%')AND mardis_in_ops = true)");

		foreach($data->result() as $row)
		{
			$arr['suggestions'][] = array(
				'value'	=>$row->station_name.'-('.$row->type.')',
				'id'	=>$row->station_id,
				'lat'	=>$row->station_lat,
				'lon'	=>$row->station_lon,
				'type'  =>$row->type
			);
		}

		echo json_encode($arr);
		
	}	


	//4 - 5
	public function searchMarSat()
	{
		
		$keyword = $this->uri->segment(3);

		// $data = $this->autocomplete_search_dao->search($keyword);

		$data = $this->db->query("(SELECT m.mar_id, u.unit_name, m.mar_lat, m.mar_lon, m.mar_in_ops,'MARINES' as type, '' as abbr FROM marines m 
			INNER JOIN unit u ON (m.unit_id = u.unit_id) 
			INNER JOIN corps c ON (m.corps_id = c.corps_id) 
			LEFT JOIN marine_icon i ON (m.maricon_id = i.maricon_id)  
			WHERE (mar_id::text LIKE '%".$keyword."%' OR unit_name::text LIKE '%".$keyword."%')AND mar_in_ops = true) 
			UNION (SELECT mardis_id::integer, operation_name,mardis_lat,mardis_lon,mardis_in_ops,'SATGAS' as type,'' as abbr FROM marines_dislocation WHERE (mardis_id::text LIKE '%".$keyword."%' OR operation_name::text LIKE '%".$keyword."%')AND mardis_in_ops = true)");

		foreach($data->result() as $row)
		{
			$arr['suggestions'][] = array(
				'value'	=>$row->unit_name.'-('.$row->type.')',
				'id'	=>$row->mar_id,
				'lat'	=>$row->mar_lat,
				'lon'	=>$row->mar_lon,
				'type'  =>$row->type
			);
		}

		echo json_encode($arr);
		
	}								




}
?>