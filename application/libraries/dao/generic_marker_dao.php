<?php
    require_once('generic_dao.php');
    class generic_marker_dao extends Generic_dao  {
        public function table_name(){
            return 'generic_marker';
        }

        public function field_map() {
            return array ('gmark_id'=>'gmark_id','gmark_name'=>'gmark_name','gmark_lat'=>'gmark_lat','gmark_lon'=>'gmark_lon','gmarkcat_id'=>'gmarkcat_id','gmark_icon'=>'gmark_icon','gmark_desc'=>'gmark_desc','gmarktype_id'=>'gmarktype_id','gmark_radius'=>'gmark_radius');
        }

        public function __construct() {
            parent::__construct();
        }
		
		public function fetch_data($array_search = null,$limit = 10,$offset = 0){
			$query_search = '';
			if ($array_search != null) {
				if (array_key_exists('gmark_name', $array_search) && $array_search['gmark_name'] != "" && strlen($array_search['gmark_name']) > 0) {
					$query_search .= " AND gmark.gmark_name ilike '%" . $array_search['gmark_name'] . "%'";
				}
				if (array_key_exists('gmarkcat_id', $array_search) && $array_search['gmarkcat_id'] != "") {
					$query_search .= " AND gmark.gmarkcat_id = '" . $array_search['gmarkcat_id'] . "' ";
				}
				if (array_key_exists('gmarktype_id', $array_search) && $array_search['gmarktype_id'] != "") {
					$query_search .= " AND gmark.gmarktype_id= '" . $array_search['gmarktype_id'] . "' ";
				}
			}
			$this->ci->db->select('gmark.*,gmarkcat.gmarkcat_name,gmarktype.gmarktype_name');
			$this->ci->db->from('generic_marker gmark inner JOIN generic_marker_category gmarkcat ON (gmark.gmarkcat_id = gmarkcat.gmarkcat_id) inner JOIN generic_marker_type gmarktype ON (gmark.gmarktype_id=gmarktype.gmarktype_id)');
			$this->ci->db->where('gmark.gmark_id is not null ' . $query_search);
			$this->ci->db->limit($limit, $offset);
			$this->ci->db->order_by('gmark.gmark_id', 'asc');
			$q = $this->ci->db->get();
			return $q->result();
		}
		
		public function fetch_generic_marker_category(){
			return $this->ci->db->get('generic_marker_category')->result();
		}
		
		public function fetch_generic_marker_type(){
			return $this->ci->db->get('generic_marker_type')->result();
		}
		
		public function insert_generic_marker($obj){
			$array_field = array(
				'gmark_name'=>$obj['gmark_name'],
				'gmark_desc'=>$obj['gmark_desc'],
				'gmark_lat'=>($obj['gmark_lat']=="")?null:$obj['gmark_lat'],
				'gmark_lon'=>($obj['gmark_lon']=="")?null:$obj['gmark_lon'],
				'gmark_radius'=>($obj['gmark_radius']=="")?null:$obj['gmark_radius'],
				'gmarkcat_id'=>$obj['gmarkcat_id'],
				'gmarktype_id'=>$obj['gmarktype_id']
			);
			$this->ci->db->insert('generic_marker',$array_field);
			$id = $this->ci->db->insert_id();
			foreach($obj['area_point'] as $k=>$val){
				list($lat,$lon) = explode('|',$val);
				$this->ci->db->insert('generic_marker_area',array(
					'gmark_id'=>$id,
					'gmarkarea_lat'=>$lat,
					'gmarkarea_lon'=>$lon,
				));
			}
		}
		
		public function update_generic_marker($obj,$obj_id){
			$array_field = array(
				'gmark_name'=>$obj['gmark_name'],
				'gmark_desc'=>$obj['gmark_desc'],
				'gmark_lat'=>($obj['gmark_lat']=="")?null:$obj['gmark_lat'],
				'gmark_lon'=>($obj['gmark_lon']=="")?null:$obj['gmark_lon'],
				'gmark_radius'=>($obj['gmark_radius']=="")?null:$obj['gmark_radius'],
				'gmarkcat_id'=>$obj['gmarkcat_id'],
				'gmarktype_id'=>$obj['gmarktype_id']
			);
			$this->ci->db->set($array_field);
			$this->ci->db->where($obj_id);
			$this->ci->db->update('generic_marker');
			$id = $obj_id['gmark_id'];
			$this->ci->db->delete('generic_marker_area',$obj_id);
			foreach($obj['area_point'] as $k=>$val){
				list($lat,$lon) = explode('|',$val);
				$this->ci->db->insert('generic_marker_area',array(
					'gmark_id'=>$id,
					'gmarkarea_lat'=>$lat,
					'gmarkarea_lon'=>$lon,
				));
			}
		}
		
		public function fetch_area_point($gmark_id){
			$this->ci->db->where('gmark_id',$gmark_id);
			return $this->ci->db->get('generic_marker_area')->result();
		}
		
		public function delete_generic_marker($obj_id){
			$this->ci->db->delete('generic_marker_area',$obj_id);
			$this->ci->db->delete('generic_marker',$obj_id);
			return true;
		}
    }
?>