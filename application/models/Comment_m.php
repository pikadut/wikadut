
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Comment_m extends CI_Model {

	public function __construct(){

		parent::__construct();

		$this->load->model("Administration_m");

	}

	public function getCommodity($code = "",$price = "",$group = "",$type = ""){

		$this->db->select("comment_date,comment_name,response,comments,pos_name as position,
			CASE response WHEN 'Ubah' THEN 'Menunggu Approval' ELSE 'Approval' END as activity_name");

		if(!empty($code)){

			$this->db->where("catalog_code","'".$code."'",false);

		}

		if(!empty($price)){

			$this->db->where("price_id",$price);

		}

		if(!empty($group)){

			$this->db->where("group_code",$group);

		}

		if(!empty($type)){

			$this->db->like("type",$type);

		}

		$this->db->order_by("comment_date","desc");

		return $this->db->get("com_comment");

	}

	public function insertCommodity($code = "",$type = "",$comment = "",$price = 0,$response = "",$group = ""){

		$userdata = $this->Administration_m->getLogin();

		$input['catalog_code'] = $code;
		$input['group_code'] = $group;
		$input['type'] = $type;
		$input['price_id'] = $price;
		$input['comments'] = $comment;
		$input['comment_date'] = date("Y-m-d H:i:s");
		$input['comment_name'] = $userdata['complete_name'];
		$input['pos_id'] = $userdata['pos_id'];
		$input['pos_name'] = $userdata['pos_name'];
		$input['response'] = $response;

		$this->db->insert("com_comment",$input);

		return $this->db->affected_rows();

	}
	
	public function updateCommodity($code_old, $code_new){
		$this->db->set("catalog_code", $code_new);
		$this->db->where("catalog_code", $code_old);
		$this->db->update("com_comment");
		
		return $this->db->affected_rows();
	}

	public function getProcurementPlan($code = ""){

		$this->db->select("
			comment_date,
			comment_end_date,
			comment_name,
			response,
			comments,
			pos_name as position,
			activity as activity_name");

		if(!empty($code)){

			$this->db->where("ppm_id",$code);

		}

		$this->db->order_by("comment_date","desc");

		return $this->db->get("prc_plan_comment");

	}
//hlmifzi
	public function insertProcurementPlan($code = "",$comment = "",$response = "",$activity = "",$dateopen = "",$nextjobtitle = ""){

		$userdata = $this->Administration_m->getLogin();

		$input['ppm_id'] = $code;
		$input['comments'] = $comment;
		$input['activity'] = $activity;
		$input['comment_date'] = $dateopen;
		$input['comment_end_date'] = date("Y-m-d H:i:s");
		$input['comment_name'] = $userdata['complete_name'];
		$input['response'] = $response;
		$input['pos_id'] = $userdata['pos_id'];
		$input['pos_name'] = $userdata['pos_name'];
		$input['next_pos_id'] = $nextjobtitle;

		$this->db->insert("prc_plan_comment",$input);

		return $this->db->affected_rows();

	}

	public function getProcurementPR($code = "",$id = ""){

		$this->db->select("ppc_id as comment_id,
			pr_number as tender_id,
			ppc_start_date as comment_date,
			ppc_end_date as comment_end_date,
			ppc_name as comment_name,
			ppc_response as response,
			ppc_comment as comments,
			ppc_activity as activity,
			ppc_position as position, 
			ppc_end_date as end_date,
			ppc_attachment as attachment, 
			(SELECT awa_name FROM adm_wkf_activity WHERE awa_id=ppc_activity) as activity_name,
			ppc_user as user_id");

		if(!empty($code)){

			$this->db->where("pr_number = '".$code."'");

		}

		if(!empty($id)){

			$this->db->where("ppc_id",$id);

		}

		$this->db->order_by("ppc_id","desc");

		return $this->db->get("prc_pr_comment");

	}

	
	public function getProcurementPRActive($code = "",$id = ""){
		//$this->db->where(array("ppc_name !="=>null,"ppc_end_date!="=>null));
		return $this->getProcurementPR($code,$id);
	}

	public function insertProcurementPR($code = "",$activity = "",$comment = "",$response = "",$attachment = "",$pos_code = "",$pos_name = "",$user = null){

		$this->load->model("Procedure_m");

		$userdata = $this->Administration_m->getLogin();

		$input['pr_number'] = $code;
		$input['ppc_pos_code'] = (!empty($pos_code)) ? $pos_code : $userdata['pos_id'];
		$input['ppc_position'] = (!empty($pos_name)) ? $pos_name : $userdata['pos_name'];
		$input['ppc_user'] = $user;
		$input['ppc_activity'] = $activity;
		$input['ppc_comment'] = $comment;
		$input['ppc_start_date'] = date("Y-m-d H:i:s");
		$input['ppc_attachment'] = $attachment;
		$input['ppc_response'] = $this->Procedure_m->getResponseName($response);

		$this->db->insert("prc_pr_comment",$input);

		if($this->db->affected_rows()){

			return $input;

		}

	}


	
	public function getProcurementRFQ($code = "",$id = ""){

		$this->db->select("ptc_id as comment_id,
			ptm_number as tender_id,
			ptc_start_date as comment_date,
			ptc_end_date as comment_end_date,
			ptc_name as comment_name,
			ptc_response as response,
			ptc_comment as comments,
			ptc_activity as activity,
			ptc_position as position,
			ptc_end_date as end_date,
			ptc_attachment as attachment, 
			(SELECT awa_name FROM adm_wkf_activity WHERE awa_id=ptc_activity) as activity_name,
			ptc_user as user_id");

		if(!empty($code)){

			$this->db->where("ptm_number = '".$code."'");

		}

		if(!empty($id)){

			$this->db->where("ptc_id",$id);

		}

		$this->db->order_by("ptc_id","desc");

		return $this->db->get("prc_tender_comment");

	}

	public function getProcurementRFQActive($code = "",$id = ""){
		//$this->db->where(array("ptc_name !="=>null,"ptc_end_date!="=>null));
		return $this->getProcurementRFQ($code,$id);
	}

	public function insertProcurementRFQ($code = "",$activity = "",$comment = "",$response = "",$attachment = "",$pos_code = "",$pos_name = "",$user = null){

		$this->load->model("Procedure_m");

		$userdata = $this->Administration_m->getLogin();

		$input['ptm_number'] = $code;
		$input['ptc_pos_code'] = (!empty($pos_code)) ? $pos_code : $userdata['pos_id'];
		$input['ptc_position'] =  (!empty($pos_name)) ? $pos_name : $userdata['pos_name'];
		$input['ptc_user'] = $user;
		$input['ptc_activity'] = $activity;
		$input['ptc_comment'] = $comment;
		$input['ptc_start_date'] = date("Y-m-d H:i:s");
		$input['ptc_attachment'] = $attachment;
		$input['ptc_response'] = $this->Procedure_m->getResponseName($response);

		$this->db->insert("prc_tender_comment",$input);

		if($this->db->affected_rows()){

			return $input;

		}

	}

	public function getContract($code = "",$id = ""){

		$this->db->select("ccc_id as comment_id,
			ptm_number as tender_id,
			contract_id,
			ccc_start_date as comment_date,
			ccc_end_date as comment_end_date,
			ccc_name as comment_name,
			ccc_response as response,
			ccc_comment as comments,
			ccc_activity as activity,
			ccc_position as position,
			ccc_end_date as end_date,
			ccc_attachment as attachment, 
			(SELECT awa_name FROM adm_wkf_activity WHERE awa_id=ccc_activity) as activity_name,
			ccc_user as user_id");

		if(!empty($code)){

			$this->db->where("ptm_number = '".$code."'");

		}

		if(!empty($id)){

			$this->db->where("ccc_id",$id);

		}

		$this->db->order_by("ccc_id","desc");

		return $this->db->get("ctr_contract_comment");

	}


	public function getWO($code = "",$id = ""){

		$this->db->select("cwo_id as comment_id,
			po_id,
			contract_id,
			cwo_start_date as comment_date,
			cwo_end_date as comment_end_date,
			cwo_name as comment_name,
			cwo_response as response,
			cwo_comment as comments,
			cwo_activity as activity,
			cwo_position as position,
			cwo_end_date as end_date,
			cwo_attachment as attachment, 
			(SELECT awa_name FROM adm_wkf_activity WHERE awa_id=cwo_activity) as activity_name,
			cwo_user as user_id");

		if(!empty($code)){

			$this->db->where("po_id = '".$code."'");

		}

		if(!empty($id)){

			$this->db->where("cwo_id",$id);

		}

		$this->db->order_by("cwo_id","desc");

		return $this->db->get("ctr_po_comment");

	}

	public function getContractActive($code = "",$id = ""){
		//$this->db->where(array("ccc_name !="=>null,"ccc_end_date!="=>null));
		return $this->getContract($code,$id);
	}

	public function insertWO($contract_id = "",$activity = "",$comment = "",$response = "",$attachment = "",$pos_code = "",$pos_name = "",$po_id = "",$user = null){

		$this->load->model("Procedure_m");

		$userdata = $this->Administration_m->getLogin();

		$input['contract_id'] = $contract_id;
		$input['po_id'] = $po_id;
		$input['cwo_pos_code'] = (!empty($pos_code)) ? $pos_code : $userdata['pos_id'];
		$input['cwo_position'] =  (!empty($pos_name)) ? $pos_name : $userdata['pos_name'];
		$input['cwo_user'] = $user;
		$input['cwo_activity'] = $activity;
		$input['cwo_comment'] = $comment;
		$input['cwo_start_date'] = date("Y-m-d H:i:s");
		$input['cwo_attachment'] = $attachment;
		$input['cwo_response'] = $this->Procedure_m->getResponseName($response);

		$this->db->insert("ctr_po_comment",$input);

		if($this->db->affected_rows()){

			return $input;

		}

	}


	public function insertContract($ptm_number = "",$activity = "",$comment = "",$response = "",$attachment = "",$pos_code = "",$pos_name = "",$contract_id = "",$user = null){

		$this->load->model("Procedure_m");

		$userdata = $this->Administration_m->getLogin();
		//haqim
		if ($response == '445') {
			$input['ccc_name'] = null;
			$input['ccc_end_date'] = null;
		}
		//end

		$input['ptm_number'] = $ptm_number;
		$input['contract_id'] = $contract_id;
		$input['ccc_pos_code'] = (!empty($pos_code)) ? $pos_code : $userdata['pos_id'];
		$input['ccc_position'] =  (!empty($pos_name)) ? $pos_name : $userdata['pos_name'];
		$input['ccc_user'] = $user;
		$input['ccc_activity'] = $activity;
		$input['ccc_comment'] = $comment;
		$input['ccc_start_date'] = date("Y-m-d H:i:s");
		$input['ccc_attachment'] = $attachment;
		$input['ccc_response'] = $this->Procedure_m->getResponseName($response);
		

		$this->db->insert("ctr_contract_comment",$input);

		if($this->db->affected_rows()){

			return $input;

		}

	}

	
	public function getAddendum($code = "",$id = ""){

		$this->db->select("cac_id as comment_id,
			ammend_id,
			contract_id,
			cac_start_date as comment_date,
			cac_end_date as comment_end_date,
			cac_name as comment_name,
			cac_response as response,
			cac_comment as comments,
			cac_activity as activity,
			cac_position as position,
			cac_end_date as end_date,
			(SELECT awa_name FROM adm_wkf_activity WHERE awa_id=cac_activity) as activity_name,
			cac_user as user_id");

		if(!empty($code)){

			$this->db->where("ammend_id = '".$code."'");

		}

		if(!empty($id)){

			$this->db->where("cac_id",$id);

		}

		$this->db->order_by("cac_id","desc");

		return $this->db->get("ctr_ammend_comment");

	}

	public function getAddendumActive($code = "",$id = ""){
		//$this->db->where(array("cac_name !="=>null,"cac_end_date!="=>null));
		return $this->getAddendum($code,$id);
	}

	public function insertAddendum($ammend_id = "",$activity = "",$comment = "",$response = "",$attachment = "",$pos_code = "",$pos_name = "",$contract_id = "",$user = null){

		$this->load->model("Procedure_m");

		$userdata = $this->Administration_m->getLogin();

		$input['ammend_id'] = $ammend_id;
		$input['contract_id'] = $contract_id;
		$input['cac_pos_code'] = (!empty($pos_code)) ? $pos_code : $userdata['pos_id'];
		$input['cac_position'] =  (!empty($pos_name)) ? $pos_name : $userdata['pos_name'];
		$input['cac_user'] = $user;
		$input['cac_activity'] = $activity;
		$input['cac_comment'] = $comment;
		$input['cac_start_date'] = date("Y-m-d H:i:s");
		$input['cac_attachment'] = $attachment;
		$input['cac_response'] = $this->Procedure_m->getResponseName($response);

		$this->db->insert("ctr_ammend_comment",$input);

		if($this->db->affected_rows()){

			return $input;

		}

	}

		public function getVendor($code = "",$id = ""){

		$this->db->select("vnd_comment_id as comment_id,
			vendor_id,
			vc_start_date as comment_date,
			vc_end_date as comment_end_date,
			vc_name as comment_name,
			vc_response as response,
			vc_comment as comments,
			vc_activity as activity,
			(SELECT pos_name FROM vw_pos WHERE pos_id = vc_position) as position,
			vc_end_date as end_date,
			vc_activity as activity_name");

		if(!empty($code)){

			$this->db->where("vendor_id = '".$code."'");

		}

		if(!empty($id)){

			$this->db->where("vnd_comment_id",$id);

		}

		$this->db->order_by("vnd_comment_id","desc");

		return $this->db->get("vnd_comment");

	}
//start cde hlmifzi
	public function getVendorCommodity($code = "",$id = ""){

		$this->db->select("vnd_comment_id as comment_id,
			vendor_id,
			vc_start_date as comment_date,
			vc_end_date as comment_end_date,
			vc_name as comment_name,
			vc_response as response,
			vc_comment as comments,
			vc_activity as activity,
			(SELECT pos_name FROM vw_pos WHERE pos_id = vc_position) as position,
			vc_end_date as end_date,
			vc_activity as activity_name");

		if(!empty($code)){

			$this->db->where("ccp_id = '".$code."'");

		}

		if(!empty($id)){

			$this->db->where("vnd_comment_id",$id);

		}

		$this->db->order_by("vnd_comment_id","desc");

		return $this->db->get("vnd_comment_commodity");

	}

	//end 

	public function getVendorActive($code = "",$id = ""){
		
		return $this->getVendor($code,$id);
	}

	//start code hlmifzi
		public function getVendorCommodityActive($code = "",$id = ""){
		
		return $this->getVendorCommodity($code,$id);
	}
	// end
	
	
	public function getTiketPlan($code = "", $id = ""){

		$this->db->select("comment_date,
			comment_end_date,
			comment_name,
			response,
			comments,
			tpc_attachment as attachment,
			pos_name as position,
			activity as activity_name");

		if(!empty($code)){

			$this->db->where("tpm_id",$code);

		}
		
		if(!empty($id)){

			$this->db->where("comment_id",$id);

		}

		$this->db->order_by("comment_date","desc");

		return $this->db->get("tik_plan_comment");

	}

	public function insertTiketPlan($code = "",$comment = "",$response = "",$attachment = "",$activity = ""){

		$userdata = $this->Administration_m->getLogin();

		$input['tpm_id'] = $code;
		$input['comments'] = $comment;
		$input['activity'] = $activity;
		$input['comment_date'] = date("Y-m-d H:i:s");
		$input['comment_end_date'] = date("Y-m-d H:i:s");
		$input['comment_name'] = $userdata['complete_name'];
		$input['response'] = $response;
		$input['pos_id'] = $userdata['pos_id'];
		$input['pos_name'] = $userdata['pos_name'];
		$input['tpc_attachment'] = $attachment;

		$this->db->insert("tik_plan_comment",$input);

		if($this->db->affected_rows()){

			return $input;

		}
	}
	
	public function getTiketReceive($code = "", $id = ""){

		$this->db->select("comment_date,
			comment_end_date,
			comment_name,
			response,
			comments,
			trc_attachment as attachment,
			pos_name as position,
			activity as activity_name");

		if(!empty($code)){

			$this->db->where("trm_id",$code);

		}
		
		if(!empty($id)){

			$this->db->where("comment_id",$id);

		}

		$this->db->order_by("comment_date","desc");

		return $this->db->get("tik_rec_comment");

	}

	public function insertTiketReceived($code = "",$comment = "",$response = "",$attachment = "",$activity = ""){

		$userdata = $this->Administration_m->getLogin();

		$input['trm_id'] = $code;
		$input['comments'] = $comment;
		$input['activity'] = $activity;
		$input['comment_date'] = date("Y-m-d H:i:s");
		$input['comment_end_date'] = date("Y-m-d H:i:s");
		$input['comment_name'] = $userdata['complete_name'];
		$input['response'] = $response;
		$input['pos_id'] = $userdata['pos_id'];
		$input['pos_name'] = $userdata['pos_name'];
		$input['trc_attachment'] = $attachment;

		$this->db->insert("tik_rec_comment",$input);

		if($this->db->affected_rows()){

			return $input;

		}
	}


    public function getTiketDeliver($code = "", $id = ""){

        $this->db->select("comment_date,
			comment_end_date,
			comment_name,
			response,
			comments,
			tdc_attachment as attachment,
			pos_name as position,
			activity as activity_name");

        if(!empty($code)){

            $this->db->where("tdm_id",$code);

        }

        if(!empty($id)){

            $this->db->where("comment_id",$id);

        }

        $this->db->order_by("comment_date","desc");

        return $this->db->get("tik_del_comment");

    }

    public function insertTiketDelivered($code = "",$comment = "",$response = "",$attachment = "",$activity = ""){

        $userdata = $this->Administration_m->getLogin();

        $input['tdm_id'] = $code;
        $input['comments'] = $comment;
        $input['activity'] = $activity;
        $input['comment_date'] = date("Y-m-d H:i:s");
        $input['comment_end_date'] = date("Y-m-d H:i:s");
        $input['comment_name'] = $userdata['complete_name'];
        $input['response'] = $response;
        $input['pos_id'] = $userdata['pos_id'];
        $input['pos_name'] = $userdata['pos_name'];
        $input['tdc_attachment'] = $attachment;

        $this->db->insert("tik_del_comment",$input);

        if($this->db->affected_rows()){

            return $input;

        }
    }
	
	
	public function getTiketSold($code = "", $id = ""){

		$this->db->select("comment_date,
			comment_end_date,
			comment_name,
			response,
			comments,
			tsc_attachment as attachment,
			pos_name as position,
			activity as activity_name");

		if(!empty($code)){

			$this->db->where("tsm_id",$code);

		}
		
		if(!empty($id)){

			$this->db->where("comment_id",$id);

		}

		$this->db->order_by("comment_date","desc");

		return $this->db->get("tik_sale_comment");

	}

	public function insertTiketSold($code = "",$comment = "",$response = "",$attachment = "",$activity = ""){

		$userdata = $this->Administration_m->getLogin();

		$input['tsm_id'] = $code;
		$input['comments'] = $comment;
		$input['activity'] = $activity;
		$input['comment_date'] = date("Y-m-d H:i:s");
		$input['comment_end_date'] = date("Y-m-d H:i:s");
		$input['comment_name'] = $userdata['complete_name'];
		$input['response'] = $response;
		$input['pos_id'] = $userdata['pos_id'];
		$input['pos_name'] = $userdata['pos_name'];
		$input['tsc_attachment'] = $attachment;

		$this->db->insert("tik_sale_comment",$input);

		if($this->db->affected_rows()){

			return $input;

		}
	}
	


}