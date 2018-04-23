<?php

function set_data_restriction(){

}

function get_data_restriction($data_restriction){

	if($data_restriction == COMMANDO_MABESAL || $data_restriction == OLD_COMMANDO_MABESAL){
		$data_restriction = null;
	}

	return $data_restriction;
}

function is_permitted($uid, $feature, $type = 'access'){

	$ci = &get_instance();
	$ci->db->select("d.*, c.featacc_access as access");
	$ci->db->from("user_role a");
	$ci->db->join("role b","a.role_id = b.role_id");
	$ci->db->join("feature_access c","c.role_id = b.role_id");
	$ci->db->join("features d ", "c.feat_id = d.feat_id");

	$ci->db->where(array("a.user_id"=>$uid, "d.feat_id"=>$feature));
	//$ci->db->or_where(array("a.user_id"=>$uid, "d.feat_id"=>"*"));

	return count($ci->db->get()->result()) > 0;
}


function all_permission($uid, $type = 'access'){

	$ci = &get_instance();

	$ci->db->select("d.*, c.featacc_access as access");
	$ci->db->from("user_role a");
	$ci->db->join("role b","a.role_id = b.role_id");
	$ci->db->join("feature_access c","c.role_id = b.role_id");
	$ci->db->join("features d ", "c.feat_id = d.feat_id");

	$ci->db->where(array("a.user_id"=>$uid));
	//$ci->db->or_where(array("a.user_id"=>$uid, "d.feat_id"=>"*"));

	return $ci->db->get()->result();
}

function all_permission_string($uid){
	$permissions = all_permission($uid);
	$str = '';
	foreach ($permissions as $p) {

		if($p->access > 0){
			$expl = explain_permission($p->access, 'R');
			if(strlen($expl)>0){
				$str .= $p->feat_id.'-'.$expl;
			}

			$expl = explain_permission($p->access, 'E');
			if(strlen($expl)>0){
				$str .= $p->feat_id.'-'.$expl;
			}

			$expl = explain_permission($p->access, 'D');
			if(strlen($expl)>0){
				$str .= $p->feat_id.'-'.$expl;
			}

		}else{
			$str .= $p->feat_id;
		}
	}
	return $str;
}

function is_has_access($component, $permission_string){
	$scomp = preg_replace("/[#\.\-]/",'', $component);
	$pstring = preg_replace("/[#\.\-]/",'', $permission_string);
	if(preg_match("/.*\*.*/", $pstring)){
		return true;
	}
        if($scomp=='*')$scomp = '\*';
	if(preg_match("/".$scomp."/", $pstring)){
		return true;
	}

	return false;
}

function get_permission($uid,$component){
    return is_has_access($component, all_permission_string($uid));
}

function codify_permission($R = false, $E = false, $D = false){
	$num = 0;
	if($R){
		$num += 1;
	}

	if($W){
		$num += 2;
	}

	if($D){
		$num += 4;
	}

	return $num;
}

function explain_permission($permission, $par){
	if(trim($par) == 'r'){
		return (($permission & 1)==1)?true:false;
	}

	if(trim($par) == 'e'){
		return (($permission & 2) == 2)?true:false;
	}

	if(trim($par) == 'd'){
		return (($permission & 4)==4)?true:false;
	}

	if(trim($par) == 'R'){
		return (($permission & 1)==1)?'read':'';
	}

	if(trim($par) == 'E'){
		return (($permission & 2)==2)?'edit':'';
	}

	if(trim($par) == 'D'){
		return (($permission & 4)==4)?'delete':'';
	}

	if(trim($par) == 's'){
		$str = '';

		$str .= (($permission & 1)==1)?'Read':'';
		if(strlen($str) > 0){
			$str .= ',';
		}
		$str .= (($permission & 2)==2)?'Edit':'';
		if(strlen($str) > 0){
			$str .= ',';
		}
		$str .= (($permission & 4)==4)?'Delete':'';

		return $str;
	}
}
