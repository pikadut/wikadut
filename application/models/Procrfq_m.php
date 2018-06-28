<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Procrfq_m extends CI_Model {

	public function __construct(){

		parent::__construct();

	}

	public function insertMessageRFQ($input=array()){

		if (!empty($input)){

			$this->db->insert("prc_bidder_message",$input);

			return $this->db->affected_rows();
		}
		
	}

	public function getMessageRFQ($code = "",$activity = ""){

		//$this->db->select("prc_bidder_message.*,vendor_name,awa_name,DATE_FORMAT(pbm_date,'%d-%m-%Y / %T') as pbm_date_format");
		$this->db->select("prc_bidder_message.*,vendor_name,awa_name,TO_CHAR(pbm_date,'YYYY-MM-DD HH24:MI:SS') as pbm_date_format");

		if(!empty($code)){

			$this->db->where("ptm_number",$code);

		}

		if(!empty($activity)){

			$this->db->where("prc_bidder_message.awa_id",$activity);

		}

		$this->db->join("vnd_header","pbm_vendor_code=vendor_id","left");

		$this->db->join("adm_wkf_activity","adm_wkf_activity.awa_id=prc_bidder_message.awa_id","left");

		$this->db->order_by("vendor_name","asc");

		return $this->db->get("prc_bidder_message");

	}

	public function getClaimRFQ($code = ""){

		$this->db->select("prc_tender_claim.*,vendor_name");

		if(!empty($code)){

			$this->db->where("ptm_number",$code);

		}

		$this->db->join("vnd_header","pcl_vendor_id=vendor_id","left");

		$this->db->order_by("vendor_name","asc");

		return $this->db->get("prc_tender_claim");

	}

	public function getVendorBidderRFQ($code = ""){

		if(!empty($code)){

			$this->db->where("ptm_number",$code);

		}

		return $this->db->get("vw_prc_bidder_list");

	}

	public function getPrepRFQ($id){

		if(!empty($id)){

			$this->db->where("ptm_number",$id);

		}

		return $this->db->get("prc_tender_prep");

	}

	public function getRFQ($id = ""){

		if(!empty($id)){

			$this->db->where("ptm_number",$id);

		}

		return $this->db->get("prc_tender_main");

	}

	public function getMonitorRFQ($id = ""){

		if(!empty($id)){

			$this->db->where("ptm_number",$id);

		}

		return $this->db->get("vw_prc_monitor");

	}

	public function getHPSRFQ($id = ""){

		if(!empty($id)){

			$this->db->where("ptm_number",$id);

		}

		return $this->db->get("vw_prc_tender_hps");

	}

	public function getUrutRFQ($tahun = ""){

		$tahun = (empty($tahun)) ? date("Y") : $tahun;

		if(!empty($tahun)){
			$this->db->where("EXTRACT(YEAR FROM ptm_created_date) =", $tahun,false);
		}

		$this->db->select("COUNT(ptm_number) as urut");

		$get = $this->db->get("prc_tender_main")->row()->urut;

		return "RFQ.".date("Ym").".".urut_id($get+1,5);

	}

	public function insertDataRFQ($input=array()){

		if (!empty($input)){

			$this->db->insert("prc_tender_main",$input);

			return $this->db->affected_rows();
		}
		
	}

	public function insertItemRFQ($input=array()){

		if (!empty($input)){

			unset($input['tit_id']);

			$this->db->insert("prc_tender_item",$input);

			return $this->db->affected_rows();
		}
		
	}

	public function insertPrepRFQ($input=array()){

		if (!empty($input)){

			unset($input['ptp_id']);

			$this->db->insert("prc_tender_prep",$input);

			return $this->db->affected_rows();
		}
		
	}

	public function updateItemRFQ($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('tit_id',$id)->update('prc_tender_item',$input);

			return $this->db->affected_rows();

		}

	}

	public function updateDataRFQ($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('ptm_number',$id)->update('prc_tender_main',$input);

			return $this->db->affected_rows();

		}

	}
// haqim
	public function getPekerjaanRFQ($id = "",$user = null,$buyer = null){

		if(!empty($id)){

			$this->db->where("ptm_number",$id);
			// $this->db->where("A.ptm_number",$id);

		}

		if(!empty($buyer)){

			$this->db->where("ptm_buyer_id",$buyer);
			
		}

		// $this->db->join("prc_tender_main B","B.ptm_number = A.ptm_number","left");

		// $this->db->join("adm_wkf_activity C","C.awa_id = A.ptc_activity","left");

		// $this->db->where(array("A.ptc_name"=>null,"A.ptc_end_date"=>null));

		// $this->db->where_not_in("A.ptc_activity",array(1901,1903));

		// $this->db->group_start();
		// $this->db->where("A.ptc_user",null);
		// $this->db->or_where("A.ptc_user",$user);
		// $this->db->group_end();
		$this->db->where("ptc_user",null);
		$this->db->or_where("ptc_user",$user);

		return $this->db->get("vw_daftar_pekerjaan_rfq");
		// return $this->db->get("prc_tender_comment A");



	}
//end
	public function getDokumenRFQ($code = "",$tender = ""){

		if(!empty($code)){

			$this->db->where("ptd_id",$code);

		}

		if(!empty($tender)){

			$this->db->where("ptm_number",$tender);

		}

		$this->db->order_by("ptd_id","asc");

		return $this->db->get("prc_tender_doc");

	}


	public function getItemRFQ($code = "",$tender = ""){

		if(!empty($code)){

			$this->db->where("tit_id",$code);

		}

		if(!empty($tender)){

			$this->db->where("ptm_number",$tender);

		}

		$this->db->order_by("tit_id","asc");

		return $this->db->get("prc_tender_item");

	}

	public function replaceItemRFQ($id,$input){

		if(!empty($input)){

			if(!empty($id)){

				$this->db->where(array("ptm_number"=>$input['ptm_number'],"tit_id"=>$id));
				$check = $this->getItemRFQ()->row_array();
				if(!empty($check)){
					$last_id = $check['tit_id'];
					$this->updateItemRFQ($last_id,$input);
				} else {
					$this->insertItemRFQ($input);
					$last_id = $this->db->insert_id();
				}

			} else {
				$this->insertItemRFQ($input);
				$last_id = $this->db->insert_id();
			}
			
			return $last_id;

		}

	}

	public function deleteIfNotExistItemRFQ($id,$deleted){
		if(!empty($id) && !empty($deleted)){
			$this->db->where_not_in("tit_id",$deleted)->where("ptm_number",$id)->delete("prc_tender_item");
			return $this->db->affected_rows();
		}
	}


	public function insertDokumenRFQ($input){

		if (!empty($input)){

			unset($input['ptd_id']);

			$this->db->insert("prc_tender_doc",$input);

			return $this->db->affected_rows();

		}

	}

	public function replaceDokumenRFQ($id,$input){

		if(!empty($input)){

			if(!empty($id)){

				$this->db->where(array("ptm_number"=>$input['ptm_number'],"ptd_id"=>$id));
				$check = $this->getDokumenRFQ()->row_array();
				if(!empty($check)){
					$last_id = $check['ptd_id'];
					$input['ptd_id'] = $last_id;
					$this->updateDokumenRFQ($last_id,$input);
				} else {
					$this->insertDokumenRFQ($input);
					$last_id = $this->db->insert_id();
				}

			} else {
				$this->insertDokumenRFQ($input);
				$last_id = $this->db->insert_id();
			}
			
			return $last_id;

		}

	}

	public function deleteIfNotExistDokumenRFQ($id,$deleted){
		if(!empty($id) && !empty($deleted)){
			$this->db->where(array("ptd_file_name"=>"","ptm_number"=>$id))->delete("prc_tender_doc");
			$this->db->where_not_in("ptd_id",$deleted)->where("ptm_number",$id)->delete("prc_tender_doc");
			return $this->db->affected_rows();
		}
	}

	public function updateDokumenRFQ($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('ptd_id',$id)->update('prc_tender_doc',$input);

			return $this->db->affected_rows();

		}

	}

	public function updatePrepRFQ($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('ptm_number',$id)->update('prc_tender_prep',$input);

			return $this->db->affected_rows();

		}

	}


	public function getVendorRFQ($code = "",$tender = ""){

		$this->db->select("prc_tender_vendor.*,vnd_header.vendor_name");

		if(!empty($code)){

			$this->db->where("ptv_vendor_code",$code);

		}

		if(!empty($tender)){

			$this->db->where("ptm_number",$tender);

		}

		$this->db->join("vnd_header","ptv_vendor_code=vendor_id","left");

		$this->db->order_by("vendor_name","asc");

		return $this->db->get("prc_tender_vendor");

	}

	public function insertVendorRFQ($input){

		if (!empty($input)){

			unset($input['ptv_id']);

			$this->db->insert("prc_tender_vendor",$input);

			return $this->db->affected_rows();

		}

	}

	public function updateVendorRFQ($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('ptv_id',$id)->update('prc_tender_vendor',$input);

			return $this->db->affected_rows();

		}

	}

	public function replaceVendorRFQ($input){

		if(!empty($input)){

			$this->db->where(array("ptm_number"=>$input['ptm_number'],"ptv_vendor_code"=>$input['ptv_vendor_code']));
			$check = $this->getVendorRFQ()->row_array();
			if(!empty($check)){
				$last_id = $check['ptv_id'];
				$this->updateVendorRFQ($last_id,$input);
			} else {
				$this->insertVendorRFQ($input);
				$last_id = $this->db->insert_id();
			}
			
			return $last_id;

		}

	}

	public function deleteIfNotExistVendorRFQ($id,$deleted){
		if(!empty($id) && !empty($deleted)){
			$this->db->where_not_in("ptv_id",$deleted)->where("ptm_number",$id)->delete("prc_tender_vendor");
			return $this->db->affected_rows();
		}
	}

	public function getVendorStatusRFQ($code = "",$tender = ""){

		$this->db->select("prc_tender_vendor_status.*,vnd_header.vendor_name,vnd_header.email_address");

		if(!empty($code)){

			$this->db->where("pvs_vendor_code",$code);

		}

		if(!empty($tender)){

			$this->db->where("ptm_number",$tender);

		}

		$this->db->join("vnd_header","pvs_vendor_code=vendor_id","left");

		$this->db->order_by("vendor_name","asc");

		return $this->db->get("prc_tender_vendor_status");

	}

	public function insertVendorStatusRFQ($input){

		if (!empty($input)){

			unset($input['pvs_id']);

			$this->db->insert("prc_tender_vendor_status",$input);

			return $this->db->affected_rows();

		}

	}

	public function replaceVendorStatusRFQ($input){

		if(!empty($input)){
			$statusSendUndangan = array(1, null);
			$this->db->where(array("ptm_number"=>$input['ptm_number'],"pvs_vendor_code"=>$input['pvs_vendor_code']));
			$this->db->or_where_in("pvs_pq_passed", $statusSendUndangan);
			$check = $this->getVendorStatusRFQ()->row_array();
			if(!empty($check)){
				$last_id = $check['pvs_id'];
				$this->updateVendorStatusRFQ($last_id,$input);
			} else {
				$this->insertVendorStatusRFQ($input);
				$last_id = $this->db->insert_id();
			}
			
			return $last_id;

		}

	}

	public function updateVendorStatusRFQ($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('pvs_id',$id)->update('prc_tender_vendor_status',$input);

			return $this->db->affected_rows();

		}

	}

	public function deleteIfNotExistVendorStatusRFQ($id,$deleted){
		if(!empty($id) && !empty($deleted)){
			$this->db->where_not_in("pvs_id",$deleted)->where("ptm_number",$id)->delete("prc_tender_vendor_status");
			return $this->db->affected_rows();
		}
	}

	public function getVendorQuoMainRFQ($code = "",$tender = ""){

		if(!empty($code)){

			$this->db->where("ptv_vendor_code",$code);

		}

		if(!empty($tender)){

			$this->db->where("ptm_number",$tender);

		}

		$this->db->join("vnd_header","ptv_vendor_code=vendor_id","left");

		$this->db->order_by("vendor_name","asc");

		return $this->db->get("prc_tender_quo_main");

	}

	public function getVendorPriceRFQ($code = "",$tender = ""){

		if(!empty($code)){

			$this->db->where("vendor_id",$code);

		}

		if(!empty($tender)){

			$this->db->where("ptm_number",$tender);

		}

		//$this->db->order_by("pqm_id","asc");

		return $this->db->get("vw_prc_quotation_vendor_sum");

	}

	public function getVendorQuoRFQ($code = "",$tender = ""){

		if(!empty($code)){

			$this->db->where("ptv_vendor_code",$code);

		}

		if(!empty($tender)){

			$this->db->where("ptm_number",$tender);

		}

		$this->db->order_by("pqm_id","asc");

		return $this->db->get("vw_prc_vnd_quo");

	}

		public function getVendorQuoHistRFQ($code = "",$tender = ""){

			$this->db->select("vw_prc_quo_vnd_hist.*,DATE_FORMAT(pqm_created_date,'%d-%m-%Y / %T') as pqm_created_date_format");

		if(!empty($code)){

			$this->db->where("ptv_vendor_code",$code);

		}

		if(!empty($tender)){

			$this->db->where("ptm_number",$tender);

		}

		$this->db->order_by("pqm_id","asc");

		return $this->db->get("vw_prc_quo_vnd_hist");

	}

	public function insertVendorQuoMainRFQ($input){

		if (!empty($input)){

			unset($input['pqm_id']);

			$this->db->insert("prc_tender_quo_main",$input);

			return $this->db->affected_rows();

		}

	}

	public function updateVendorQuoMainRFQ($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('pqm_id',$id)->update('prc_tender_quo_main',$input);

			return $this->db->affected_rows();

		}

	}

	public function replaceVendorQuoMainRFQ($input){

		if(!empty($input)){

			$this->db->where(array("ptm_number"=>$input['ptm_number'],"ptv_vendor_code"=>$input['ptv_vendor_code']));
			$check = $this->getVendorQuoMainRFQ()->row_array();
			if(!empty($check)){
				$last_id = $check['pqm_id'];
				$this->updateVendorQuoMainRFQ($last_id,$input);
			} else {
				$this->insertVendorQuoMainRFQ($input);
				$last_id = $this->db->insert_id();
			}
			
			return $last_id;

		}

	}

	public function deleteIfNotExistVendorQuoMainRFQ($id,$deleted){
		if(!empty($id) && !empty($deleted)){
			$this->db->where_not_in("pqm_id",$deleted)->where("ptm_number",$id)->delete("prc_tender_quo_main");
			return $this->db->affected_rows();
		}
	}

	public function getEvalViewRFQ($code = "",$tender = ""){

		if(!empty($code)){

			$this->db->where("ptv_vendor_code",$code);

		}

		if(!empty($tender)){

			$this->db->where("ptm_number",$tender);

		}

		$this->db->order_by("total","desc");

		return $this->db->get("vw_prc_evaluation");

	}


	public function updateVendorStatusByGrade($ptm_number = "",$activity = ""){

		$check = $this->getEvalViewRFQ("",$ptm_number)->result_array();

		foreach ($check as $key => $value) {

			$vnd_id = $value['ptv_vendor_code'];
			$last_status = 0;

			if($activity == "admin"){
				if($value['adm'] == "Lulus"){
					$last_status = 7;
				} else {
					$last_status = -7;
				}
			}
			if($activity == "teknis"){
				if($value['pass'] == "Lulus"){
					if($value['adm'] == "Lulus"){
						$last_status = 5;
					} else {
						$last_status = -7;
					}
				} else {
					$last_status = -5;
				}
			}
			if($activity == "harga"){
				if($value['adm'] == "Lulus" && $value['pass'] == "Lulus"){
					$last_status = 8;
				} else {
					$last_status = -8;
				}
			}

			if(!empty($last_status)){
				$this->db
				->where(
					array(
						"ptm_number"=>$ptm_number,
						"pvs_vendor_code"=>$vnd_id
						)
					)
				->update("prc_tender_vendor_status",
					array("pvs_status"=>$last_status)
					);
			}

		}

	}

	public function getEvalRFQ($code = "",$tender = ""){

		$this->db->select("PTE.*,VND.vendor_name");

		if(!empty($code)){

			$this->db->where("PTE.ptv_vendor_code",$code);

		}

		if(!empty($tender)){

			$this->db->where("PTE.ptm_number",$tender);

		}

		$this->db->order_by("vendor_name","asc");

		$this->db->join("vnd_header VND","PTE.ptv_vendor_code=VND.vendor_id","left");

		//$this->db->join("prc_tender_vendor_status PTVS","PTVS.pvs_vendor_code=PTE.ptv_vendor_code AND PTVS.ptm_number=PTE.ptm_number ","left");

		return $this->db->get("prc_tender_eval PTE");

	}

	public function getEvalComRFQ($code = "",$tender = "",$type = ""){

		if(!empty($code)){

			$this->db->where("pec_vendor_code",$code);

		}

		if(!empty($tender)){

			$this->db->where("ptm_number",$tender);

		}

		if(!empty($type)){

			$this->db->where("pec_mode",$type);

		}

		$this->db->order_by("pec_datetime","desc");

		return $this->db->get("prc_tender_eval_comment");

	}

	public function insertEvalComRFQ($input){

		if (!empty($input)){

			unset($input['pec_id']);

			$this->db->insert("prc_tender_eval_comment",$input);

			return $this->db->affected_rows();

		}

	}

	public function insertEvalRFQ($input){

		if (!empty($input)){

			unset($input['pte_id']);

			$this->db->insert("prc_tender_eval",$input);

			return $this->db->affected_rows();

		}

	}

	public function updateEvalRFQ($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('pte_id',$id)->update('prc_tender_eval',$input);

			return $this->db->affected_rows();

		}

	}

	public function replaceEvalRFQ($input){

		if(!empty($input)){

			$this->db->where(array("ptm_number"=>$input['ptm_number'],"ptv_vendor_code"=>$input['ptv_vendor_code']));
			$check = $this->getEvalRFQ()->row_array();
			if(!empty($check)){
				$last_id = $check['pte_id'];
				$this->updateEvalRFQ($last_id,$input);
			} else {
				$this->insertEvalRFQ($input);
				$last_id = $this->db->insert_id();
			}

			return $last_id;

		}

	}

	public function deleteIfNotExistEvalRFQ($id,$deleted){
		if(!empty($id) && !empty($deleted)){
			$this->db->where_not_in("pte_id",$deleted)->where("ptm_number",$id)->delete("prc_tender_eval");
			return $this->db->affected_rows();
		}
	}


	public function getVendorQuoTechRFQ($code = "",$pqm = ""){

		if(!empty($code)){

			$this->db->where("pqt_id",$code);

		}

		if(!empty($pqm)){

			$this->db->where("pqm_id",$pqm);

		}

		return $this->db->get("prc_tender_quo_tech");

	}

	public function getViewVendorQuoTechRFQ($code = "",$pqm = ""){

		if(!empty($code)){

			$this->db->where("pqt_id",$code);

		}

		if(!empty($pqm)){

			$this->db->where("pqm_id",$pqm);

		}

		$this->db->order_by("vendor_name","asc");

		return $this->db->get("vw_prc_tender_quo_tech");

	}

	public function getViewVendorQuoComRFQ($code = "",$pqm = "", $ptm_number = ""){

		if(!empty($code)){

			$this->db->where("tit_id",$code);

		}

		if(!empty($pqm)){

			$this->db->where("pqm_id",$pqm);

		}

		if(!empty($ptm_number)){

			$this->db->where("ptm_number",$ptm_number);

		}

		$this->db->order_by("vendor_name","asc");

		return $this->db->get("vw_prc_quotation_item");

	}

	public function updateQuoTechRFQ($id,$input){

		if(!empty($id) && !empty($input)){

			$this->db->where('pqt_id',$id)->update('prc_tender_quo_tech',$input);

			return $this->db->affected_rows();

		}

	}

	public function updateStatusVendorByQuo($ptm_number,$vendor_id){
		$pqm = $this->db
		->where(array("ptv_vendor_code"=>$vendor_id,"ptm_number"=>$ptm_number))
		->get("prc_tender_quo_main")->row_array();
		$pqm_id = (!empty($pqm)) ? $pqm['pqm_id'] : "";
		if(!empty($pqm_id)){
			$quo_tech = $this->db->where("pqm_id",$pqm_id)->get("prc_tender_quo_tech")->result_array();
			$point = 0;
			$passing_grade = count($quo_tech)*2;
			foreach ($quo_tech as $key => $value) {
				if($value['pqt_check'] == 1){
					$point++;
				}
				if($value['pqt_check_vendor'] == 1){
					$point++;
				}
			}

			if($point == $passing_grade){
				$update = array("pvs_status"=>4);
			} else {
				$update = array("pvs_status"=>-4);
			}

			$this->db
			->where(array("pvs_vendor_code"=>$vendor_id,"ptm_number"=>$ptm_number))
			->update("prc_tender_vendor_status",$update);

		}
	}

	//haqim
	public function do_upload($name) {
		
        /*
			menggunakan config upload di construct controller
        */
 		
        if(!$this->upload->do_upload($name)) //upload and validate
        {

            $this->upload->display_errors(); //show ajax error

        }
        return $this->upload->data('file_name');
    }

	public function chat_rfq($rfq_number,$ybs){

		$this->db->select('rfq_number,employee_from,employee_to,employee_cc,pesan,date,attach');
		$this->db->where('rfq_number', $rfq_number);
		$this->db->group_start();
		$this->db->like('employee_from', $ybs);
		$this->db->or_like('employee_to', $ybs);
		$this->db->or_like('employee_cc', $ybs);
		$this->db->group_end();
		$this->db->order_by('status', 'desc');
		$this->db->order_by('date', 'desc');

		return $this->db->get('prc_chat_rfq')->result_array();
	}

	public function submit_chat_rfq($data){
		$this->db->insert('prc_chat_rfq', $data);
		return $this->db->affected_rows();
	}
	//end

}