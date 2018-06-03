<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Administration_m extends CI_Model {

	public function __construct(){

		parent::__construct();

		$this->load->helper('security');

	}

	public function isHeadQuatersProcurement($ptm_number){
		$getdistrict = $this->db
		->select("district_code")
		->where("b.ptm_number",$ptm_number)
		->join("prc_pr_main a","a.pr_number=b.pr_number")
		->join("prc_plan_main d","a.ppm_id=d.ppm_id")
		->join("adm_district c","c.district_id=d.ppm_district_id")
		->get("prc_tender_main b")->row_array();
		$code = (isset($getdistrict['district_code'])) ? $getdistrict['district_code'] : "";
		return ($code == HEADQUATERS_CODE);
	}

	public function isHeadQuaters($district_id){
		$getdistrict = $this->db
		->select("district_code")
		->where("district_id",$district_id)
		->get("adm_district b")->row_array();
		$code = (isset($getdistrict['district_code'])) ? $getdistrict['district_code'] : "";
		return ($code == HEADQUATERS_CODE);
	}

	public function getProcurementLocation($ptm_number){
		
	}

	public function getDelPoint($id = ""){

		if(!empty($id)){

			$this->db->where("del_point_id",$id);

		}
		
		$this->db->where("del_point_active",'1');

		return $this->db->get("adm_del_point");

	}

	public function getUserRule($id = ""){

		if(!empty($id)){

			$this->db->where("employee_id",$id);

		}

		return $this->db->get("user_login_rule");

	}

	public function getDistrict($id = ""){

		if(!empty($id)){

			$this->db->where("district_id",$id);

		}

		return $this->db->get("adm_district");

	}

	public function getUserData($id = ""){

		if(!empty($id)){

			if(is_numeric($id)){

				$this->db->where('id',$id);

			} else {

				$this->db->where('username_user',$id);

			}

		}

		return $this->db->get('adm_user');

	}


	public function getUserByJob($job = ""){

		$this->db->select("A.employee_id,A.pos_name,C.fullname");

		if(!empty($job)){

			$this->db->where('job_title',$job);

		}

		$this->db->join("adm_pos B","A.pos_id = B.pos_id","INNER");

		$this->db->join("adm_employee C","C.id = A.employee_id","INNER");

		return $this->db->get('adm_employee_pos A');

	}

	public function checkLogin($username,$password){

		$where = array(
			'user_name'=>$username,
			'password'=> strtoupper(do_hash($password,'sha1'))
			);

		$this->db->where($where);

		return $this->db->get('adm_user');

	}


	public function getPos($id = ""){
		if(!empty($id)){
			$this->db->where("pos_id",$id);
		}
		return $this->db->get("adm_pos");
	}

	public function getEmployeePos($employee = ""){
		if(!empty($employee)){
			$this->db->where("employee_id",$employee);
		}
		
		return  $this->db->get("vw_adm_pos A");
	}

	public function getDeptUser($employee_id = ""){
		$position = $this->getPosition($employee_id);
		$data = array();
		foreach ($position as $key => $value) {
			$data[] = $value['dept_id'];
		}
		return $data;
	}

	public function getPosition($job_title = "",$employee_id = ""){

		$employee = $this->getLogin();

		if(empty($employee_id)){
			$employee_id = $employee['employee_id'];
		}
		if(!empty($job_title)){
			if(is_array($job_title)){
				$this->db->where_in("job_title",$job_title);
				$data = $this->getEmployeePos($employee_id)->result_array();
			} else {
				$this->db->where("job_title",$job_title);
				$data = $this->getEmployeePos($employee_id)->row_array();
			}
		} else {
			$data = $this->getEmployeePos($employee_id)->result_array();
		}
		return $data;

	}

	public function getLogin(){

		$id = $this->session->userdata(do_hash(SESSION_PREFIX));

		$login = $this->getUser($id)->row_array();

		$role = $this->session->userdata(do_hash("ROLE"));
		
		if(!empty($role)){
			$this->db->where("pos_id",$role);
			$getrole = $this->getEmployeePos($login['employee_id'])->row_array();
			if(!empty($getrole)){
				$login = array_merge($login,$getrole);
			}
		}

		return $login;

	}

	public function getUser($id = ""){

		if(!empty($id)){
			$this->db->where("A.id",$id);
		}
/*
		$this->db->select("A.*,X.employee_id,X.is_active,X.is_main_job,E.pos_name,E.pos_id,E.job_title,G.district_id,G.district_name,F.dep_code as dept_code,F.dept_name,F.dept_id");
		$this->db->join("adm_employee B","A.employee_id = B.id");
		$this->db->join("adm_gender C","B.adm_gender_id = C.adm_gender_id",'left');
		$this->db->join("adm_employee_pos X","X.employee_id = A.employee_id AND X.is_main_job = '1'",'left');
		$this->db->join("adm_employee_type D","D.employee_type_id = B.employee_type_id",'left');
		$this->db->join("adm_pos E","X.pos_id = E.pos_id",'left');
		$this->db->join("adm_dept F","X.dept_id = F.dept_id","left");
		$this->db->join("adm_district G","G.district_id = F.district_id","left");

		return $this->db->get('adm_user A');

		*/
		return $this->db->get('vw_user_access A');

	}

	public function getMenuUser($employee){

		/*
		Multi posisi
		$pos = $this->getEmployeePos($employee)->result_array();
		$pos_id = array();

		foreach ($pos as $key => $value) {
			$pos_id[] = $value['pos_id'];
		}

		if(!empty($pos_id)){
			$this->db->join("adm_menu","menu_id=menuid","inner");
			$this->db->where_in("pos_id",$pos_id);
		}

		*/



		$role = $this->session->userdata(do_hash("ROLE"));

		if(empty($role)){
			$p = $this->getLogin();
		} else {
			$p = $this->getPos($role)->row_array();
		}
		
		$role = $p['job_title'];

		$this->db->join("adm_menu","menu_id=menuid","inner");
		$this->db->where("jobtitle",$role);

		$parent_menu = $this->db->order_by("menu_code","asc")->get("adm_jobtitle_menu")->result_array();
		$allparent = array();
		$menu = array();
		foreach ($parent_menu as $key => $value) {
			if(!in_array($value['parent_id'], $allparent)){
				$allparent[] = $value['parent_id'];
			}
			$menu[$value['parent_id']][$value['menuid']] = $value;
		}

		if(!empty($allparent)){
			$this->db->where_in("menuid",$allparent);
		}

		$parent_menu = $this->db->join("adm_menu","menu_id=menuid","inner")
		->where("parent_id",0)
		->order_by("menu_code","asc")
		->get("adm_jobtitle_menu")->result_array();

		foreach ($parent_menu as $key => $value) {
			$menu[$value['parent_id']][$value['menuid']] = $value;
		}

		return $menu;
	}

	public function getMenu($jobtitle = ""){

		if(!empty($jobtitle)){
			$this->db->join("adm_jobtitle_menu","menu_id=menuid","inner");
			$this->db->where("jobtitle",$jobtitle);
		}

		$parent_menu = $this->db->order_by("menu_code","asc")->get("adm_menu")->result_array();
		$menu = array();
		foreach ($parent_menu as $key => $value) {

			$menu[$value['parent_id']][$value['menuid']] = $value;
		}

		return $menu;

	}

	public function get_salutation($id = ""){

		if(!empty($id)){

			$this->db->where("adm_salutation_id",$id);

		}

		return $this->db->get("adm_salutation");

	}

	public function get_job_pos($id = ""){

		if(!empty($id)){

			$this->db->where("pos_id",$id);

		}

		return $this->db->get("adm_pos");

	}

	public function get_employee($id = ""){

		if(!empty($id)){

			$this->db->where("id",$id);

		}

		return $this->db->get("adm_employee");

	}

	public function get_employee_type_name($id){

		$data = $this->db->where("employee_type_id = '$id'")->get("adm_employee_type")->row_array();

		return (isset($data['employee_type_name'])) && (!empty($data['employee_type_name'])) ? $data['employee_type_name'] : "";
		
	}

	public function get_divisi_departemen($id = ""){

		$this->db->select("*,
			CASE COALESCE(dept_type,0) 
			WHEN 0 THEN 'Divisi/Departemen'
			WHEN 1 THEN 'Pelabuhan'
			END AS dept_type_name");

		if(!empty($id)){

			$this->db->where("dept_id",$id);

		}

		$this->db->where("dept_active",1);

		return $this->db->get("adm_dept");

	}

	public function get_harbour($id = ""){

		if(!empty($id)){
			
			$this->db->where("dept_id",$id);

		}
		
		$where = "dept_active=1 AND dept_type=1";
		$this->db->where($where);

		return $this->db->get("adm_dept");

	}
	
	public function get_dist_name($id = ""){

		if(!empty($id)){

			$this->db->where("district_id",$id);

		}

		return $this->db->get("adm_district");

	}

	public function get_divbirnit_dept_name($id){

		$data = $this->db->where("district_id",$id)->get("adm_district")->row_array();

		return (isset($data['district_name'])) && (!empty($data['district_name'])) ? $data['district_name'] : "";
		
	}
	
	public function get_lane_name($id){

		$data = $this->db->where("dept_id",$id)->get("adm_dept")->row_array();

		return (isset($data['dept_name'])) && (!empty($data['dept_name'])) ? $data['dept_name'] : "";
		
	}

		
	public function get_delivery_point($id = ""){

		if(!empty($id)){

			$this->db->where("del_point_id",$id);

		}

		$this->db->where("del_point_active",1);

		return $this->db->get("adm_del_point");
	}


	public function get_daftar_kantor($id = ""){

		if(!empty($id)){

			$this->db->where("district_id",$id);

		}

		return $this->db->get("adm_district");

	}

	public function get_currency($id = ""){

		if(!empty($id)){

			$this->db->where("curr_id",$id);

		}

		return $this->db->get("adm_curr");

	}

	public function get_gudang($id = ""){

		if(!empty($id)){

			$this->db->where("id_war",$id);

		}

		return $this->db->get("adm_warehouse");

	}

	public function get_employee_type($id = ""){

		if(!empty($id)){

			$this->db->where("employee_type_id",$id);

		}

		return $this->db->get("adm_employee_type");
	}


	public function get_mata_anggaran($id = ""){

		if(!empty($id)){

			$this->db->where("pag_id",$id);

		}

		return $this->db->get("prc_anggaran");
	}

	//haqim

	public function getHieMenu(){
		return $this->db->get('adm_hierarchy_menu')->result_array();
	}

	public function getParentId($id = "",$type = "pr"){

		switch ($type) {
			case 'rkp':
			$tabel = "adm_auth_hie_5";
			break;

			case 'rkap':
			$tabel = "adm_auth_hie_6"; 
			break;

			case 'pr-proyek':
			$tabel = "adm_auth_hie_7";
			break;

			case "pr-non-proyek":
			$tabel = "adm_auth_hie";
			break;

			case 'rfq-proyek':
			$tabel = "adm_auth_hie_8";
			break;

			case 'rfq-non-proyek':
			$tabel = "adm_auth_hie_2";
			break;

			case 'pemenang-proyek':
			$tabel = "adm_auth_hie_9";
			break;

			case 'pemenang-non-proyek':
			$tabel = "adm_auth_hie_3";
			break;

			case 'kontrak-proyek':
			$tabel = "adm_auth_hie_10";
			break;

			case 'kontrak-non-proyek':
			$tabel = "adm_auth_hie_11";
			break;
			
			// case 'inventory':
			// $tabel = "adm_auth_hie_4";
			// break;
			
			// default:
			// $tabel = "adm_auth_hie";
			// break;
		}


		if(!empty($id)){

			$this->db->where("$tabel.auth_hie_id",$id);

		}
		$this->db->join("adm_pos","$tabel.pos_id=adm_pos.pos_id","left");
		return $this->db->get("$tabel");

	}
	//end

	public function get_pos_id($id = ""){

		if(!empty($id)){

			$this->db->where("pos_id",$id);

		}

		return $this->db->get("vw_pos");
	}

	public function get_job_title($id = ""){

		if(!empty($id)){

			$this->db->where("job_title",$id);

		}

		return $this->db->get("adm_jobtitle");
	}

	public function get_user_data($id = ""){

		if(!empty($id)){

			$this->db->where("id",$id);

		}

		return $this->db->get("adm_user");
	}

	public function user_access_view($id = ""){

		if(!empty($id)){

			$this->db->where("id",$id);

		}

		return $this->db->get("vw_user_access");
	}

	public function employee_view($id = ""){

		if(!empty($id)){

			$this->db->where("id",$id);

		}

		return $this->db->get("vw_employee");
	}

	public function convert_nama_department($id){

		$data = $this->db->where("dept_id = '$id'")->get("adm_dept")->row_array();

		return (isset($data['dept_name'])) && (!empty($data['dept_name'])) ? $data['dept_name'] : "";
		
	}

	public function convert_nama_distrik($id){

		$data = $this->db->where("district_id = '$id'")->get("adm_district")->row_array();

		return (isset($data['district_name'])) && (!empty($data['district_name'])) ? $data['district_name'] : "";
		
	}

	public function convert_posisi($id){

		$data = $this->db->where("pos_id = '$id'")->get("adm_pos")->row_array();

		return (isset($data['pos_name'])) && (!empty($data['pos_name'])) ? $data['pos_name'] : "";
		
	}

	public function convert_nama_employee($id){

		$data = $this->db->where("id = '$id'")->get("adm_employee")->row_array();

		return (isset($data['fullname'])) && (!empty($data['fullname'])) ? $data['fullname'] : "";
		
	}

	public function getCommittee($id = ""){

		if(!empty($id)){

			$this->db->where("id",$id);

		}

		return $this->db->get("adm_committee");
	}

	public function getBidCommittee2($id = "",$committee_id = ""){

		$this->db->select("team_order,fullname,committee_pos,name_abct,(select count(ptp_id) FROM prc_tender_prep WHERE prc_tender_prep.adm_bid_committee = vw_adm_bid_committee.committee_id) as used")->distinct();

		if(!empty($id)){

			$this->db->where("team_order",$id);

		}

		if(!empty($committee_id)){

			$this->db->where("committee_id",$committee_id);

		}

		return $this->db->get("vw_adm_bid_committee");
	}

	public function getCommitteeType($id = ""){

		if(!empty($id)){

			$this->db->where("id_abct",$id);

		}

		return $this->db->get("adm_bid_committee_type");
	}

	public function getExchangeRate($id = ""){

		if(!empty($id)){

			$this->db->where("exchange_rate_id",$id);

		}

		return $this->db->get("adm_exchange_rate");
	}

	public function getCurrency($id = ""){

		if(!empty($id)){

			$this->db->where("curr_id",$id);

		}

		return $this->db->get("adm_curr");
	}

	public function convert_exchange_rate($id){

		$data = $this->db->where("curr_code = '$id'")->get("adm_curr")->row_array();

		return (isset($data['curr_name'])) && (!empty($data['curr_name'])) ? $data['curr_name'] : "";
		
	}

	public function getMasterAnggaran($id = ""){

		if(!empty($id)){

			$this->db->where("pag_mata_anggaran",$id);

		}

		return $this->db->get("prc_anggaran_master");
	}
	
	public function get_lintasan($id = ""){

		$this->db->select("*,
			CASE COALESCE(roundtrip_type,0) 
			WHEN 0 THEN 'Tidak'
			WHEN 1 THEN 'Ya'
			END AS roundtrip_type_name");

		if(!empty($id)){

			$this->db->where("lane_id",$id);

		}

		//$this->db->where("lane_active",1);

		return $this->db->get("vw_lane");

	}

}