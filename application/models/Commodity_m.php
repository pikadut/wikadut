
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Commodity_m extends CI_Model {

	public function __construct(){

		parent::__construct();

	}

	public function getSourcing($id = ""){

		if(!empty($id)){

			$this->db->where("sourcing_id",$id);

		}

		return $this->db->get("com_sourcing");

	}

	public function getMatCatalog($id = ""){

		$this->db->select("*,COALESCE(
			(
			SELECT cmp.total_cost FROM com_mat_price cmp WHERE cmc.mat_catalog_code = cmp.mat_catalog_code AND cmp.status = 'A' ORDER BY cmp.updated_datetime DESC LIMIT 1
			),0) as total_price,
			CASE status WHEN 'A' THEN 'Aktif' WHEN 'R' THEN 'Revisi' WHEN 'N' THEN 'Nonaktif' ELSE 'Belum Disetujui' END AS status_name",false);

		if(!empty($id)){

			$this->db->where("cmc.mat_catalog_code ='".$id."'");

		}

		$this->db->join("vw_com_group","vw_com_group.code_group = cmc.mat_group_code","inner");

		$this->db->where("type_group","M");

		$this->db->order_by("cmc.updated_datetime","desc");

		return $this->db->get("com_mat_catalog cmc");

	}
	
	public function getTiketCatalog($id = ""){

		$this->db->select("*,COALESCE(
			(
			SELECT cmp.total_cost FROM com_mat_price cmp WHERE cmc.mat_catalog_code = cmp.mat_catalog_code AND cmp.status = 'A' ORDER BY cmp.updated_datetime DESC LIMIT 1
			),0) as total_price,
			CASE status WHEN 'A' THEN 'Aktif' WHEN 'R' THEN 'Revisi' WHEN 'N' THEN 'Nonaktif' ELSE 'Belum Disetujui' END AS status_name",false);

		if(!empty($id)){

			$this->db->where("cmc.mat_catalog_code ='".$id."'");

		}

		$this->db->join("vw_com_group","vw_com_group.code_group = cmc.mat_group_code","inner");

		$where = "type_group='M' AND mat_group_code=14111801";
		//$this->db->where("type_group","M")->group_start()->where("mat_group_code","14111801")->group_end();
		$this->db->where($where);
		$this->db->order_by("cmc.updated_datetime","desc");

		return $this->db->get("com_mat_catalog cmc");

	}

	public function getMatCatalogActive($id = ""){
		$this->db->where("status !=","N");
		return $this->getMatCatalog($id);
	}

	public function getSrvCatalog($id = ""){

		$this->db->select("*,'' as uom,COALESCE(
			(
			SELECT csp.total_price FROM com_srv_price csp WHERE csc.srv_catalog_code = csp.srv_catalog_code AND csp.status = 'A' ORDER BY csp.updated_datetime DESC LIMIT 1
			),0) as total_price,
			CASE status WHEN 'A' THEN 'Aktif' WHEN 'R' THEN 'Revisi' WHEN 'N' THEN 'Nonaktif' ELSE 'Belum Disetujui' END AS status_name",false);

		if(!empty($id)){

			$this->db->where("csc.srv_catalog_code ='".$id."'");

		}

		$this->db->join("vw_com_group","vw_com_group.code_group = csc.srv_group_code","inner");

		$this->db->where("type_group","S");

		$this->db->order_by("csc.updated_datetime","desc");

		return $this->db->get("com_srv_catalog csc");

	}

	public function getSrvCatalogActive($id = ""){
		$this->db->where("status !=","N");
		return $this->getSrvCatalog($id);
	}

	public function getMatGroup($id = ""){

		if(!empty($id)){

			$this->db->where("group_code = '$id'");

		}
		
		$this->db->select("group_code as mat_group_code, group_name as mat_group_name, group_parent as mat_group_parent, group_status as mat_group_status, updated_datetime, group_code as code_group, group_name as name_group, group_type as type_group");

		$this->db->where("group_type","M");

		$this->db->order_by("group_code,group_parent","asc");

		$this->db->order_by("updated_datetime","desc");

		return $this->db->get("com_group");

	}
	
	public function getMatGroupAll($level = ""){

		if(!empty($level)){
			
			$this->db->group_start();
			$this->db->where("CHAR_LENGTH(group_code)", $level*2, false);
			$this->db->or_where("CHAR_LENGTH(group_code)", ($level*2)+1, false);
			if($level == 4){
				$this->db->or_where("CHAR_LENGTH(group_code)", ($level*2)+2, false);
			}
			$this->db->group_end();

		}
		
		$this->db->select("group_code as mat_group_code, group_name as mat_group_name, group_parent as mat_group_parent, group_status as mat_group_status, updated_datetime, group_code as code_group, group_name as name_group, group_type as type_group");

		$this->db->where("group_type","M");

		$this->db->order_by("group_code","asc");

		return $this->db->get("com_group");

	}
	
	public function getSrvGroupAll($level = ""){

		if(!empty($level)){
			
			$this->db->group_start();
			$this->db->where("CHAR_LENGTH(group_code)", $level*2, false);
			$this->db->or_where("CHAR_LENGTH(group_code)", ($level*2)+1, false);
			if($level == 4){
				$this->db->or_where("CHAR_LENGTH(group_code)", ($level*2)+2, false);
			}
			$this->db->group_end();

		}
		
		$this->db->select("group_code as srv_group_code, group_name as srv_group_name, group_parent as srv_group_parent, group_status as srv_group_status, updated_datetime, group_code as code_group, group_name as name_group, group_type as type_group");

		$this->db->where("group_type","S");

		$this->db->order_by("group_code","asc");

		return $this->db->get("com_group");

	}

	public function getMatGroupActive($id = ""){

		$this->db->where("group_status","A");

		return $this->getMatGroup($id);

	}

	public function getSrvGroup($id = ""){

		if(!empty($id)){

			$this->db->where("group_code = '$id'");

		}
		
		$this->db->select("group_code as srv_group_code, group_name as srv_group_name, group_parent as srv_group_parent, group_status as srv_group_status, updated_datetime, group_code as code_group, group_name as name_group, group_type as type_group");

		$this->db->where("group_type","S");

		$this->db->order_by("group_code,group_parent","asc");

		$this->db->order_by("updated_datetime","desc");

		return $this->db->get("com_group");

	}

	public function getSrvGroupActive($id = ""){

		$this->db->where("group_status","A");

		return $this->getSrvGroup($id);

	}

	public function getSrvPrice($id = ""){

		$this->db->select("A.*,vw_com_group.*,C.sourcing_name,CASE A.status WHEN 'A' THEN 'Aktif' WHEN 'R' THEN 'Revisi' WHEN 'N' THEN 'Nonaktif' ELSE 'Belum Disetujui' END AS status_name");

		if(!empty($id)){

			$this->db->where("A.srv_price_id",$id);

		}

		$this->db->join("com_sourcing C","A.sourcing_id = C.sourcing_id","left");

		$this->db->join("com_srv_catalog B","A.srv_catalog_code = B.srv_catalog_code","left");

		$this->db->join("vw_com_group","vw_com_group.code_group = B.srv_group_code","inner");

		$this->db->where("type_group","S");

		$this->db->order_by("A.updated_datetime","desc");

		return $this->db->get("com_srv_price A");

	}


	public function getMatPrice($id = ""){

		$this->db->select("A.*,vw_com_group.*,C.sourcing_name,CASE A.status WHEN 'A' THEN 'Aktif' WHEN 'R' THEN 'Revisi' WHEN 'N' THEN 'Nonaktif' ELSE 'Belum Disetujui' END AS status_name");

		if(!empty($id)){

			$this->db->where("A.mat_price_id",$id);

		}

		$this->db->join("com_sourcing C","A.sourcing_id = C.sourcing_id","left");

		$this->db->join("com_mat_catalog B","A.mat_catalog_code = B.mat_catalog_code","left");

		$this->db->join("vw_com_group","vw_com_group.code_group = B.mat_group_code","inner");

		$this->db->where("type_group","M");

		$this->db->order_by("A.updated_datetime","desc");

		return $this->db->get("com_mat_price A");

	}

	public function getUrutSrvCatalog($code = ""){

		$kode = "";

		if(!empty($code)){
			$this->db->where("srv_group_code ='".$code."'");
		}

		$urut = $this->getSrvCatalog()->num_rows();

		$this->db->where("srv_group_status",null);

		$group = $this->getSrvGroup($code)->row_array();

		//$kode .= $group['srv_group_code'];

		//$kode .= urut_id($urut+1,6);

		return $urut;

	}

	public function getUrutMatCatalog($code = ""){

		$kode = "";

		if(!empty($code)){
			$this->db->where("mat_group_code ='".$code."'");
		}

		$urut = $this->getMatCatalog()->num_rows();

		$this->db->where("mat_group_status",null);

		$group = $this->getMatGroup($code)->row_array();

		//$kode .= $group['mat_group_code'];

		//$kode .= urut_id($urut+1,6);

		return $urut;

	}
	
	public function getUrutMatGroup($code = ""){
		if(strlen($code) == 4){
			$this->db->select("CAST(SUBSTR(max(group_code) FROM 5 FOR 2) AS INT)+1 as urut", false);
		}
		else if(strlen($code) == 6){
			$this->db->select("CAST(SUBSTR(max(group_code) FROM 7 FOR 2) AS INT)+1 as urut", false);
		}
		else{
			$this->db->select("CAST(SUBSTR(max(group_code) FROM 8 FOR 2) AS INT)+1 as urut", false);
		}
		
		if(!empty($code)){
			$this->db->where("group_parent ='".$code."'");
		}
		
		$this->db->where("group_type", "M");
		
		$urut = $this->db->get("com_group")->row()->urut;
		
		if(empty($urut)) $urut = 1;
		
		return urut_id($urut,2);
	}
	
	public function getUrutSrvGroup($code = ""){
		if(strlen($code) == 4){
			$this->db->select("CAST(SUBSTR(max(group_code) FROM 5 FOR 2) AS INT)+1 as urut", false);
		}
		else if(strlen($code) == 6){
			$this->db->select("CAST(SUBSTR(max(group_code) FROM 7 FOR 2) AS INT)+1 as urut", false);
		}
		else{
			$this->db->select("CAST(SUBSTR(max(group_code) FROM 8 FOR 2) AS INT)+1 as urut", false);
		}
		
		if(!empty($code)){
			$this->db->where("group_parent ='".$code."'");
		}
		
		$this->db->where("group_type", "S");
		
		$urut = $this->db->get("com_group")->row()->urut;
		
		if(empty($urut)) $urut = 1;
		
		return urut_id($urut,2);
	}


	public function getUrutCatalog($code = ""){
		$this->db->where("group_code", $code);
		$this->db->where("group_type", "M");
		$mat = $this->db->get("com_group")->num_rows();
		
		$panjang = strlen($code)+1;
		
		if($mat){
			$this->db->where("mat_group_code ='".$code."'");
			
			$this->db->select("CAST(SUBSTRING(max(mat_catalog_code) FROM ".$panjang." FOR 6) AS INT)+1 as urut", false);
			
			$urut = $this->db->get("com_mat_catalog")->row()->urut;
		}
		else{
			$this->db->where("srv_group_code ='".$code."'");
			
			$this->db->select("CAST(SUBSTR(max(srv_catalog_code) FROM ".$panjang." FOR 6) AS INT)+1 as urut", false);
			
			$urut = $this->db->get("com_srv_catalog")->row()->urut;
		}
		
		if($urut < 1){
			$urut = 1;
		}

		$kode = $code.urut_id($urut,6);

		return $kode;

	}

	public function insertDataMatCatalog($input=array()){

		if (!empty($input)){

			$input['mat_catalog_code'] = $this->getUrutCatalog($input['mat_group_code']);
			$input['updated_datetime'] = date("Y-m-d H:i:s");

			$this->db->insert("com_mat_catalog",$input);

			if($this->db->affected_rows()){
				return $input['mat_catalog_code'];
			}

		}
		
	}

	public function insertDataMatGroup($input=array()){

		if (!empty($input)){
			
			$input["group_code"] = $input["mat_group_parent"].$this->getUrutMatGroup($input["mat_group_parent"])."A";
			
			$input["group_name"] = $input["mat_group_name"];
			unset($input["mat_group_name"]);
			
			$input["group_parent"] = $input["mat_group_parent"];
			unset($input["mat_group_parent"]);
			
			$input["group_status"] = "A";
			
			$input["group_type"] = "M";

			$input['updated_datetime'] = date("Y-m-d H:i:s");

			$this->db->insert("com_group",$input);

			return $this->db->affected_rows();
		}
	}

	public function insertDataSrvCatalog($input=array()){

		if (!empty($input)){

			$input['srv_catalog_code'] = $this->getUrutCatalog($input['srv_group_code']);
			$input['updated_datetime'] = date("Y-m-d H:i:s");

			$this->db->insert("com_srv_catalog",$input);

			if($this->db->affected_rows()){
				return $input['srv_catalog_code'];
			}

		}
	}

	public function insertDataSrvGroup($input=array()){

		if (!empty($input)){

			$input["group_code"] = $input["srv_group_parent"].$this->getUrutSrvGroup($input["srv_group_parent"])."A";
			
			$input["group_name"] = $input["srv_group_name"];
			unset($input["srv_group_name"]);
			
			$input["group_parent"] = $input["srv_group_parent"];
			unset($input["srv_group_parent"]);
			
			$input["group_status"] = "A";
			
			$input["group_type"] = "S";
			
			$input['updated_datetime'] = date("Y-m-d H:i:s");

			$this->db->insert("com_group",$input);

			return $this->db->affected_rows();
		}
	}

	public function insertDataMatPrice($input=array()){

		if (!empty($input)){

			$input['updated_datetime'] = date("Y-m-d H:i:s");

			$this->db->insert("com_mat_price",$input);

			$last_id = $this->db->insert_id();

			if($this->db->affected_rows()){
				return $last_id;
			}
			
		}
	}

	public function insertDataSrvPrice($input=array()){

		if (!empty($input)){

			$input['updated_datetime'] = date("Y-m-d H:i:s");

			$this->db->insert("com_srv_price",$input);

			$last_id = $this->db->insert_id();

			if($this->db->affected_rows()){
				return $last_id;
			}
		}
	}

	public function insertDataSourcing($input=array()){

		if (!empty($input)){

			$this->db->insert("com_sourcing",$input);

			return $this->db->affected_rows();
		}
	}


	public function updateDataMatCatalog($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$input['updated_datetime'] = date("Y-m-d H:i:s");
			
			if(isset($input['mat_group_code'])){
				$input['mat_catalog_code'] = $this->getUrutCatalog($input['mat_group_code']);
			}

			$this->db->where("mat_catalog_code = '".$id."'")->update('com_mat_catalog',$input);

			if(isset($input['mat_group_code'])){
				return $input['mat_catalog_code'];
			}
			else{
				return $this->db->affected_rows();
			}

		}

	}

	public function updateDataSrvCatalog($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$input['updated_datetime'] = date("Y-m-d H:i:s");
			
			if(isset($input['srv_group_code'])){
				$input['srv_catalog_code'] = $this->getUrutCatalog($input['srv_group_code']);
			}

			$this->db->where("srv_catalog_code = '".$id."'")->update('com_srv_catalog',$input);

			if(isset($input['srv_group_code'])){
				return $input['srv_catalog_code'];
			}
			else{
				return $this->db->affected_rows();
			}

		}

	}

	public function updateDataMatGroup($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$input['updated_datetime'] = date("Y-m-d H:i:s");

			$this->db->where("group_code = '$id'")->update('com_group',$input);

			return $this->db->affected_rows();

		}

	}

	public function updateDataSrvGroup($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$input['updated_datetime'] = date("Y-m-d H:i:s");

			$this->db->where("group_code = '$id'")->update('com_group',$input);

			return $this->db->affected_rows();

		}

	}

	public function updateDataMatPrice($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$input['updated_datetime'] = date("Y-m-d H:i:s");

			$this->db->where('mat_price_id',$id)->update('com_mat_price',$input);

			return $this->db->affected_rows();

		}

	}
	
	public function updateDataSrvPrice($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$input['updated_datetime'] = date("Y-m-d H:i:s");

			$this->db->where('srv_price_id',$id)->update('com_srv_price',$input);

			return $this->db->affected_rows();

		}

	}

	public function updateDataSourcing($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('sourcing_id',$id)->update('com_sourcing',$input);

			return $this->db->affected_rows();

		}

	}
	
	public function deleteDataMatCatalog($id = ""){

		if (!empty($id)){
			
			//$this->db->where('mat_catalog_code',$id)->delete('com_mat_catalog');

			$this->db->where("mat_catalog_code = '$id'")->update('com_mat_catalog',array("status"=>"N"));
			
			return $this->db->affected_rows();
		}
	}

	public function deleteDataSrvCatalog($id = ""){

		if (!empty($id)){
			
			//$this->db->where('srv_catalog_code',$id)->delete('com_srv_catalog');
			
			$this->db->where("srv_catalog_code = '$id'")->update('com_srv_catalog',array("status"=>"N"));

			return $this->db->affected_rows();
		}

	}

	public function deleteDataMatGroup($id = ""){

		if (!empty($id)){
			
			$this->db->where("group_code = '$id'")->delete('com_group');
			
			return $this->db->affected_rows();
		}
		
	}

	public function deleteDataSrvPrice($id = ""){

		if (!empty($id)){
			
			$this->db->where('srv_price_id',$id)->delete('com_srv_price');
			
			return $this->db->affected_rows();
		}
		
	}

	public function deleteDataSourcing($id = ""){

		if (!empty($id)){
			
			$this->db->where('sourcing_id',$id)->delete('com_sourcing');
			
			return $this->db->affected_rows();
		}
		
	}

	public function getSrvGroupName($id){

		$data = $this->db->where("group_code = '$id'")->get("com_group")->row_array();

		return (isset($data['group_name'])) && (!empty($data['group_name'])) ? $data['group_name'] : "";
		
	}

	public function getMatGroupName($id){

		$data = $this->db->where("group_code = '$id'")->get("com_group")->row_array();

		return (isset($data['group_name'])) && (!empty($data['group_name'])) ? $data['group_name'] : "";
		
	}
	
	public function getSourcingName($id){

		$data = $this->db->where("sourcing_id",$id)->get("com_sourcing")->row_array();

		return (isset($data['sourcing_name'])) && (!empty($data['sourcing_name'])) ? $data['sourcing_name'] : "";
		
	}

	public function getMatLevelGroupList($id){

		$data = array();

		while (!empty($id)) {
			$group = $this->getMatGroup($id)->row_array();
			$data[] = $group;
			$id = $group['mat_group_parent'];
		}

		return array_reverse($data);

	}

	public function getMatLevelName($id){
		$data = $this->getMatLevelGroupList($id);
		$name = "";
		foreach ($data as $key => $value) {
			$name .= $value['mat_group_name'];
			$name .= ($key == count($data)-1) ? "" : " > ";
		}
		return $name;
	}

	public function getSrvLevelGroupList($id){

		$data = array();

		while (!empty($id)) {
			$group = $this->getSrvGroup($id)->row_array();
			$data[] = $group;
			$id = $group['srv_group_parent'];
		}

		return array_reverse($data);

	}

	public function getSrvLevelName($id){
		$data = $this->getSrvLevelGroupList($id);
		$name = "";
		foreach ($data as $key => $value) {
			$name .= $value['srv_group_name'];
			$name .= ($key == count($data)-1) ? "" : " > ";
		}
		return $name;
	}


}