
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Procedure3_m extends CI_Model {

	public function __construct(){

		parent::__construct();

	}


	public function renderMessage($message,$status,$redirect = ""){

		$this->form_validation->set_error_delimiters('<p>', '</p>');

		$this->output
		->set_content_type('application/json')
		->set_output(json_encode(array('message' => $message, "status"=>$status, "redirect"=>$redirect)));

	}

	public function getActivity($id = ""){

		if(!empty($id)){

			$this->db->where("awa_id",$id);

		}

		return $this->db->get("adm_wkf_activity");

	}

	public function getResponse($awr = "",$awa = ""){
		
		if(!empty($awr)){

			$this->db->where("awr_id",$awr);

		}

		if(!empty($awa)){

			$this->db->where("awa_id",$awa);

		}

		return $this->db->get("adm_wkf_response");
	}


	public function getResponseList($code){
		$data = $this->getResponse("",$code)->result_array();
		$ret = array();
		foreach ($data as $key => $value) {
			$ret[$value['awr_id']] = $value['awr_name'];
		}
		return $ret;
	}

	public function getResponseName($code = ""){
		$response = "";
		if(!empty($code)){
			$response = $this->getResponse($code)->row_array();
			$response = (!empty($response['awr_name'])) ? $response['awr_name'] : "";
		}
		return $response;
	}

	public function getNextState($code_field,$name_field,$table,$where = array()){
		
		if(!empty($where)){
			$this->db->where($where);
		}

		$getdata = $this->db
		->select($code_field." as nextPosCode,".$name_field." as nextPosName")
		->get($table);

		if(empty($getdata->num_rows()) && !empty($where)){

			if(isset($where['dept_id'])){
				unset($where['dept_id']);
			}

			$getdata = $this->db
			->select($code_field." as nextPosCode,".$name_field." as nextPosName")
			->where($where)
			->get($table);

		}

		return $getdata->row_array();

	}

	public function ctr_ammend_comment_complete(
		$ptm_number = "",
		$name = "",
		$activity = 0,
		$response = "",
		$comment = "",
		$attachment = "",
		$cacId = 0,
		$contract_id = 0,
		$ammend_id = 0,
		$user_id = null
		) {

		if(is_numeric($response)){
			$response_real = $this->getResponseName($response);
			$response = url_title($response_real,"_",true);
		}
/*
		echo "ACTIVITY : ".$activity;
		echo "<br/>";
		echo "RESPONSE : ".$response;
*/
		$message = "";
		$nextPosCode = "";
		$nextPosName = "";
		$lastPosCode = "";
		$lastPosName = "";
		$nextActivity = 0;
		$anyIncompleteComment = 0;
		$tenderMethod = 0;
		$submissionMethod = 0;
		$justification = "";
		$totalOE = 0.0;
		$tmpPosition = "";
		$newNumber = 0;

		$plan_num = 0;

		$anyIncompleteComment = $this->db
		->where(array("cac_id"=>$cacId,"cac_name"=>null))
		->get("ctr_ammend_comment")
		->num_rows();

		if($anyIncompleteComment > 0){

			$this->db->where(array(
				"contract_id"=>$contract_id,
				"cac_name"=>null
				));

			$this->db->where("cac_activity",$activity,false);

			$table = "ctr_ammend_comment";

			$code_field = "cac_pos_code";

			$name_field = "cac_position";

			$getdata = $this->db
			->select($code_field." as lastPosCode,".$name_field." as lastPosName, cac_activity as activity")
			->get($table)->row_array();

			$lastPosName = $getdata['lastPosName'];
			$lastPosCode = $getdata['lastPosCode'];
			$nextPosCode = $lastPosCode;
			$nextPosName = $lastPosName;
			$lastActivity = $getdata['activity'];
				//completing tender comment

			$update = $this->db
			->where(array("cac_id"=>$cacId))
			->update("ctr_ammend_comment",array(
				"cac_response" => $response_real,
				"cac_name" => $name,
				"cac_end_date" => date("Y-m-d H:i:s"),
				"cac_comment" => $comment,
				"cac_attachment" => $attachment,
				"cac_user" => $user_id,
				));

			$update = $this->db
			->where(array("contract_id"=>$contract_id))
			->update("ctr_ammend_header",array(
				"status" => $lastActivity,
				));

			if($activity == 3000){

				if($response == url_title('Simpan dan Lanjutkan',"_",true)){

					$getdata = $this->getNextState(
						"pos_id",
						"pos_name",
						"adm_pos",
						array("job_title"=>"VP PENGADAAN"));

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$nextActivity = 3010;

				} else if($response == url_title('Revisi Pelaksana',"_",true)){

					$getdata = $this->getNextState(
						"ctr_spe_pos",
						"ctr_spe_pos_name",
						"ctr_contract_header",
						array("contract_id"=>$contract_id));

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$nextActivity = 3000;

				} else if($response == url_title('Simpan Sebagai Draft',"_",true)) {
					$nextActivity = 3000;
				}

			} else if($activity == 3010){

				if($response == url_title('Setuju',"_",true)){

					$contract = $this->db->where(array("ammend_id"=>$ammend_id))
					->get("ctr_ammend_header")->row_array();

					$contract_amount = $contract['contract_amount'];
					$contract_type = $contract['contract_type_2'];

					switch ($contract['current_approver_level']) {

						case 0:

						//DIAPPROVE OLEH PROCUREMENT HEAD

						if($contract_amount <= 50*1000000){

							$nextActivity = 3020;

							$getdata = $this->getNextState(
								"ctr_spe_pos",
								"ctr_spe_pos_name",
								"ctr_contract_header",
								array("contract_id"=>$contract_id));

							$nextPosCode = $getdata['nextPosCode'];
							$nextPosName = $getdata['nextPosName'];

							$current_approver_level = 6;

						} else {

							$getdata = $this->getNextState(
								"ptm_requester_pos_code",
								"ptm_requester_pos_name",
								"prc_tender_main",
								array("ptm_number"=>$ptm_number));

							$userPos = $getdata['nextPosCode'];

							$getdata = $this->db
							->join("vw_pos","pos_id=hap_pos_code",'inner')
							->from("vw_prc_hierarchy_approval")
							->where("hap_pos_code = (select hap_pos_parent from vw_prc_hierarchy_approval where hap_pos_code = ".$userPos.")")
							->get()->row_array();
							$nextPosCode = $getdata['hap_pos_code'];
							$nextPosName = $getdata['hap_pos_name'];

							$nextActivity = 3010;

							$current_approver_level = 2;

						}

						break;

						case 1:

						//DIAPPROVE OLEH KEPALA DIVISI USER

						if(in_array($contract_type,array("SPK","KONTRAK"))){

							$nextActivity = 3010;

							$getdata = $this->getNextState(
								"pos_id",
								"pos_name",
								"adm_pos",
								array("job_title"=>"MANAJER USER"));

							$nextPosCode = $getdata['nextPosCode'];
							$nextPosName = $getdata['nextPosName'];

							$current_approver_level = 3;

						} else {

						//LANGSUNG KE DIREKTUR USER

							$nextActivity = 3010;

							$getdata = $this->getNextState(
								"ptm_requester_pos_code",
								"ptm_requester_pos_name",
								"prc_tender_main",
								array("ptm_number"=>$ptm_number));

							$userPos = $getdata['nextPosCode'];

							$user = $this->db->where("pos_id",$userPos)->get("position_departement")->row_array();

							$this->db->where_in("job_title",array("DIREKTUR USER"));

							$getdata = $this->getNextState(
								"pos_id",
								"pos_name",
								"adm_pos",
								array("dept_id"=>$user['dept_id'],"district_id"=>$user['district_id']
									));

							$nextPosCode = $getdata['nextPosCode'];
							$nextPosName = $getdata['nextPosName'];

							$current_approver_level = 4;

						}

						break;

						case 2:

						//DIAPPROVE OLEH RISK MANAGEMENT

						$nextActivity = 3010;

						$getdata = $this->getNextState(
							"pos_id",
							"pos_name",
							"adm_pos",
							array("job_title"=>"SPESIALIS LEGAL"));

						$nextPosCode = $getdata['nextPosCode'];
						$nextPosName = $getdata['nextPosName'];

						$current_approver_level = 3;

						break;

						case 3:

						//DIAPPROVE OLEH LEGAL SPECIALIST

						$nextActivity = 3010;

						$getdata = $this->getNextState(
							"ptm_requester_pos_code",
							"ptm_requester_pos_name",
							"prc_tender_main",
							array("ptm_number"=>$ptm_number));

						$userPos = $getdata['nextPosCode'];

						$jabatan = "";

						while ($jabatan != "DIREKTUR USER") {

							$getdata = $this->db
							->join("vw_pos","pos_id=hap_pos_code",'inner')
							->from("vw_prc_hierarchy_approval")
							->where("hap_pos_code = (select hap_pos_parent 
								from vw_prc_hierarchy_approval where hap_pos_code = ".$userPos.")")
							->get()->row_array();

							$nextPosCode = $getdata['hap_pos_code'];
							$nextPosName = $getdata['hap_pos_name'];

							$userPos = $nextPosCode;
							$jabatan = $getdata['job_title'];

						}

						$current_approver_level = 4;
						
						break;

						case 4:

						//DIAPPROVE OLEH DIREKTUR USER

						if($contract_amount <= 1000*1000000){

							$nextActivity = 3020;

							$getdata = $this->getNextState(
								"ctr_spe_pos",
								"ctr_spe_pos_name",
								"ctr_contract_header",
								array("contract_id"=>$contract_id));

							$nextPosCode = $getdata['nextPosCode'];
							$nextPosName = $getdata['nextPosName'];

							$current_approver_level = 6;

						} else {

							$nextActivity = 3010;

							$getdata = $this->getNextState(
								"pos_id",
								"pos_name",
								"adm_pos",
								array("dept_id"=>1));

							$nextPosCode = $getdata['nextPosCode'];
							$nextPosName = $getdata['nextPosName'];

							$current_approver_level = 5;

						}
						
						break;

						case 5:

						//DIAPPROVE OLEH DIREKTUR UTAMA

						$nextActivity = 3020;

						$getdata = $this->getNextState(
							"ctr_spe_pos",
							"ctr_spe_pos_name",
							"ctr_ammend_header",
							array("contract_id"=>$contract_id));

						$nextPosCode = $getdata['nextPosCode'];
						$nextPosName = $getdata['nextPosName'];

						$current_approver_level = 6;
						
						break;
						
						default:
							# code...
						break;
					}

					$current_approver_pos = $lastPosCode;

				} else {

					$current_approver_level = 0;

					$current_approver_pos = 0;

					$getdata = $this->getNextState(
						"ctr_spe_pos",
						"ctr_spe_pos_name",
						"ctr_contract_header",
						array("contract_id"=>$contract_id));

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$nextActivity = 3000;

				}

				$this->db->where(array("ammend_id"=>$ammend_id))
				->update("ctr_ammend_header",
					array("current_approver_pos"=>$current_approver_pos,
						"current_approver_level"=>$current_approver_level));

			} else if($activity == 3020){

				if($response == url_title('Simpan dan Aktifkan',"_",true)){

					$getdata = $this->getNextState(
						"ctr_spe_pos",
						"ctr_spe_pos_name",
						"ctr_contract_header",
						array("contract_id"=>$contract_id));

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$nextActivity = 3901;

					$this->db->where(array("contract_id"=>$contract_id))
					->update("ctr_contract_header",array(
						"status"=>2902,
						));

					$this->db->where(array("ammend_id"=>$ammend_id))
					->update("ctr_ammend_header",array(
						"status"=>3901,
						));

					$contract = $this->db->where(array("contract_id"=>$contract_id))
					->get("ctr_contract_header")->row_array();

					$ammend = $this->db->where(array("ammend_id"=>$ammend_id))
					->get("ctr_ammend_header")->row_array();

					$insert = array(
						"ptm_number"=>$contract['ptm_number'],
						"contract_number"=>$ammend['contract_number'],
						"ctr_spe_pos_name"=>$contract['ctr_spe_pos_name'],
						"ctr_spe_complete_name"=>$contract['ctr_spe_complete_name'],
						"ctr_spe_pos"=>$contract['ctr_spe_pos'],
						"vendor_id"=>$contract['vendor_id'],
						"vendor_name"=>$contract['vendor_name'],
						"start_date"=>$ammend['start_date'],
						"end_date"=>$ammend['end_date'],
						"start_date"=>$ammend['start_date'],
						"subject_work"=>$ammend['subject_work'],
						"scope_work"=>$ammend['scope_work'],
						"contract_type"=>$contract['contract_type'],
						"contract_type_2"=>$ammend['contract_type_2'],
						"contract_amount"=>$contract['contract_amount'],
						"status"=>2901,
						"current_approver_pos"=>$contract['current_approver_pos'],
						"contract_amount"=>$ammend['contract_amount'],
						"completed_tender_date"=>$contract['completed_tender_date'],
						"currency"=>$contract['currency'],
						"pf_amount"=>$contract['pf_amount'],
						"pf_bank"=>$contract['pf_bank'],
						"pf_number"=>$contract['pf_number'],
						"pf_start_date"=>$contract['pf_start_date'],
						"pf_end_date"=>$contract['pf_end_date'],
						"pf_attachment"=>$contract['pf_attachment'],
						"current_approver_level"=>$contract['current_approver_level'],
						);

$this->db->insert("ctr_contract_header",$insert);

$new_contract_id = $this->db->insert_id();

$contract_item = $this->db->where(array("contract_id"=>$contract_id))
->get("ctr_contract_item")->result_array();

foreach ($contract_item as $key => $value) {
	$insert = array(
		"contract_id"=>$new_contract_id,
		"tit_id"=>$value['tit_id'],
		"item_code"=>$value['item_code'],
		"short_description"=>$value['short_description'],
		"long_description"=>$value['long_description'],
		"price"=>$value['price'],
		"qty"=>$value['qty'],
		"min_qty"=>$value['min_qty'],
		"max_qty"=>$value['max_qty'],
		"uom"=>$value['uom'],
		"sub_total"=>$value['sub_total'],
		);

	$this->db->insert("ctr_contract_item",$insert);

}

$contract_item = $this->db->where(array("contract_id"=>$contract_id))
->get("ctr_contract_doc")->result_array();

foreach ($contract_item as $key => $value) {

	$insert = array(
		"contract_id"=>$new_contract_id,
		"category"=>$value['category'],
		"description"=>$value['description'],
		"filename"=>$value['filename'],
		"status"=>$value['status'],
		"publish"=>$value['publish'],
		);

	$this->db->insert("ctr_contract_doc",$insert);

}

$contract_milestone = $this->db->where(array("ammend_id"=>$ammend_id))
->get("ctr_ammend_milestone")->result_array();

foreach ($contract_milestone as $key => $value) {
	$insert = array(
		"contract_id"=>$new_contract_id,
		"description"=>$value['description'],
		"percentage"=>$value['percentage'],
		"target_date"=>$value['target_date'],
		);
	$this->db->insert("ctr_contract_milestone",$insert);
}

$this->db->insert("ctr_contract_comment",array(
	"ptm_number"=>$contract['ptm_number'],
	"contract_id"=>$new_contract_id,
	"ccc_activity"=>2901,
	"ccc_position"=>$getdata['nextPosName'],
	"ccc_pos_code"=>$getdata['nextPosCode'],
	"ccc_start_date"=>date("Y-m-d H:i:s"),
	"ccc_user"=>null
	));

}else if($response == url_title('Batalkan',"_",true)){

	$getdata = $this->getNextState(
		"ctr_spe_pos",
		"ctr_spe_pos_name",
		"ctr_contract_header",
		array("contract_id"=>$contract_id));

	$nextPosCode = $getdata['nextPosCode'];
	$nextPosName = $getdata['nextPosName'];

	$nextActivity = 3902;

	$this->db->where(array("ammend_id"=>$ammend_id))
					->update("ctr_ammend_header",array(
						"status"=>3902,
						));

} else {

	$getdata = $this->getNextState(
		"ctr_spe_pos",
		"ctr_spe_pos_name",
		"ctr_contract_header",
		array("contract_id"=>$contract_id));

	$nextPosCode = $getdata['nextPosCode'];
	$nextPosName = $getdata['nextPosName'];

	$nextActivity = 3020;

}

}

$ret = array(
	"message"=>$message,
	"nextposcode"=>$nextPosCode,
	"nextposname"=>$nextPosName,
	"lastposcode"=>$lastPosCode,
	"lastposname"=>$lastPosName,
	"nextactivity"=>$nextActivity,
	"anyincompletecomment"=>$anyIncompleteComment,
	"tendermethod"=>$tenderMethod,
	"submissionmethod"=>$submissionMethod,
	"justification"=>$justification,
	"totaloe"=>$totalOE,
	"tmpposition"=>$tmpPosition,
	"newnumber"=>$newNumber,
	"nextactivity"=>$nextActivity,
	"response"=>$response
	);

/*
	echo "<pre>";
	print_r($ret);
	echo "</pre>";
*/
	return $ret;

}
}

}