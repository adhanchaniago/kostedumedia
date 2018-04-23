<?php
require_once('generic_dao.php');
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class autocomplete_search_dao extends Generic_dao {

	public function __construct() {
        parent::__construct();
    }

    public function search($keyword){

    	$data = $this->db->query("(SELECT aer_id, aer_name,aer_lat,aer_lon,aer_is_in_operation, 'AEROPLANE' as type,'' as abbr FROM aeroplane WHERE (aer_id::text LIKE '%".$keyword."%' OR aer_name::text LIKE '%".$keyword."%')AND aer_is_in_operation = true) 
			UNION (SELECT mar_id, mar_name,mar_lat,mar_lon,mar_in_ops, 'MARINES' as type, '' as abbr FROM marines WHERE (mar_id::text LIKE '%".$keyword."%' OR mar_name::text LIKE '%".$keyword."%')AND mar_in_ops = true) 
			UNION (SELECT ship_id::integer, ship_name,ship_lat,ship_lon,ship_is_in_operation,'KRI' as type,ship_abbr FROM ship WHERE (ship_id::text LIKE '%".$keyword."%' OR ship_name::text LIKE '%".$keyword."%' OR ship_abbr LIKE '%".$keyword."%')AND ship_is_in_operation = true)
			UNION (SELECT station_id::integer, station_name,station_lat,station_lon,true as station_status,'PANGKALAN' as type,'' as abbr FROM station WHERE station_id::text LIKE '%".$keyword."%' OR station_name::text LIKE '%".$keyword."%')
			UNION (SELECT mardis_id::integer, operation_name,mardis_lat,mardis_lon,mardis_is_active,'SATGAS' as type,'' as abbr FROM marines_dislocation WHERE (mardis_id::text LIKE '%".$keyword."%' OR operation_name::text LIKE '%".$keyword."%')AND mardis_is_active = true)"); 	

    	return $data;
    }

}