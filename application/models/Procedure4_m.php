
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Procedure2_m extends CI_Model {

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

	public function ctr_contract_comment_complete(
		$ptm_number = "",
		$name = "",
		$activity = 0,
		$response = "",
		$comment = "",
		$attachment = "",
		$cccId = 0,
		$contract_id = 0,
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
		->where(array("ccc_id"=>$cccId,"ccc_name"=>null))
		->get("ctr_contract_comment")
		->num_rows();

		if($anyIncompleteComment > 0){

			$this->db->where(array(
				"contract_id"=>$contract_id,
				"ccc_name"=>null
				));

			$this->db->where("ccc_activity",$activity,false);

			$table = "ctr_contract_comment";

			$code_field = "ccc_pos_code";

			$name_field = "ccc_position";

			$getdata = $this->db
			->select($code_field." as lastPosCode,".$name_field." as lastPosName, ccc_activity as activity")
			->get($table)->row_array();

			$lastPosName = $getdata['lastPosName'];
			$lastPosCode = $getdata['lastPosCode'];
			$nextPosCode = $lastPosCode;
			$nextPosName = $lastPosName;
			$lastActivity = $getdata['activity'];
				//completing tender comment

			$update = $this->db
			->where(array("ccc_id"=>$cccId))
			->update("ctr_contract_comment",array(
				"ccc_response" => $response_real,
				"ccc_name" => $name,
				"ccc_end_date" => date("Y-m-d H:i:s"),
				"ccc_comment" => $comment,
				"ccc_attachment" => $attachment,
				"ccc_user" => $user_id,
				));

			$update = $this->db
			->where(array("contract_id"=>$contract_id))
			->update("ctr_contract_header",array(
				"status" => $lastActivity,
				));

			if($activity == 2000){

				if($response == url_title('Lanjutkan',"_",true)){

					$getdata = $this->getNextState(
						"ctr_man_pos",
						"ctr_man_pos_name",
						"ctr_contract_header",
						array("ptm_number"=>$ptm_number));

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$nextActivity = 2001;

				}

			} else if($activity == 2001){

				if($response == url_title('Lanjutkan',"_",true)){

					$getdata = $this->getNextState(
						"ctr_spe_pos",
						"ctr_spe_pos_name",
						"ctr_contract_header",
						array("ptm_number"=>$ptm_number));

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$nextActivity = 2010;

				} else if($response == url_title('Revisi',"_",true)){

					$getdata = $this->getNextState(
						"pos_id",
						"pos_name",
						"adm_pos",
						array("job_title"=>"VP PENGADAAN"));

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$nextActivity = 2000;

				}

			} else if($activity == 2010){

				if($response == url_title('Simpan dan Lanjutkan',"_",true)){

					$getdata = $this->getNextState(
						"ctr_spe_pos",
						"ctr_spe_pos_name",
						"ctr_contract_header",
						array("contract_id"=>$contract_id));

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$nextActivity = 2030;

				} else if($response == url_title('Revisi Pelaksana',"_",true)){

					$getdata = $this->getNextState(
						"ctr_spe_pos",
						"ctr_spe_pos_name",
						"ctr_contract_header",
						array("contract_id"=>$contract_id));

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$nextActivity = 2000;

				} else if($response == url_title('Simpan Sebagai Draft',"_",true)) {
					$nextActivity = 2010;
				}

			} else if($activity == 2020){

				if($response == url_title('Setuju',"_",true)){

					$contract = $this->db->where(array("contract_id"=>$contract_id))
					->get("ctr_contract_header")->row_array();

					$contract_amount = $contract['contract_amount'];
					$contract_type = $contract['contract_type_2'];

					switch ($contract['current_approver_level']) {

						case 0:

						//DIAPPROVE OLEH PROCUREMENT HEAD

						if($contract_amount <= 50*1000000){

							$nextActivity = 2030;

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
							->where("hap_pos_code = (select hap_pos_parent from vw_prc_hierarchy_approval where hap_pos_code = ".$userPos.")")
							->get("vw_prc_hierarchy_approval")
							->row_array();

							$nextPosCode = $getdata['hap_pos_code'];
							$nextPosName = $getdata['hap_pos_name'];

							$nextActivity = 2020;

							$current_approver_level = 2;

						}

						break;

						case 1:

						//DIAPPROVE OLEH KEPALA DIVISI USER

						if(in_array($contract_type,array("SPK","KONTRAK"))){

							$nextActivity = 2020;

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

							$nextActivity = 2020;

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

						$nextActivity = 2020;

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

						$nextActivity = 2020;

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

							$nextActivity = 2030;

							$getdata = $this->getNextState(
								"ctr_spe_pos",
								"ctr_spe_pos_name",
								"ctr_contract_header",
								array("contract_id"=>$contract_id));

							$nextPosCode = $getdata['nextPosCode'];
							$nextPosName = $getdata['nextPosName'];

							$current_approver_level = 6;

						} else {

							$nextActivity = 2020;

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

						$nextActivity = 2030;

						$getdata = $this->getNextState(
							"ctr_spe_pos",
							"ctr_spe_pos_name",
							"ctr_contract_header",
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

					$nextActivity = 2010;

				}

				$this->db->where(array("contract_id"=>$contract_id))->update("ctr_contract_header",
					array("current_approver_pos"=>$current_approver_pos,
						"current_approver_level"=>$current_approver_level));

			} else if($activity == 2030){

				if($response == url_title('Simpan dan Aktifkan',"_",true)){

					$getdata = $this->getNextState(
						"ctr_spe_pos",
						"ctr_spe_pos_name",
						"ctr_contract_header",
						array("contract_id"=>$contract_id));

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$nextActivity = 2901;


				} else {

					$getdata = $this->getNextState(
						"ctr_spe_pos",
						"ctr_spe_pos_name",
						"ctr_contract_header",
						array("contract_id"=>$contract_id));

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$nextActivity = 2030;

				}

			}else if($activity == 2901){

				if($response == url_title('Kontrak Selesai',"_",true)){

					$getdata = $this->getNextState(
						"ctr_spe_pos",
						"ctr_spe_pos_name",
						"ctr_contract_header",
						array("contract_id"=>$contract_id));

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$nextActivity = 2903;

					$this->db->where(array("contract_id"=>$contract_id))
					->update("ctr_contract_header",array(
						"terminate_notes"=>$comment,
						"terminate_date"=>date("Y-m-d H:i:s"),
						"status"=>2903
						));

				} else if($response == url_title('Kontrak Dibatalkan',"_",true)){

					$getdata = $this->getNextState(
						"ctr_spe_pos",
						"ctr_spe_pos_name",
						"ctr_contract_header",
						array("contract_id"=>$contract_id));

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$nextActivity = 2902;

					$getdata = $this->db->where(array("contract_id"=>$contract_id))
					->update("ctr_contract_header",array(
						"terminate_reason"=>$comment,
						"terminate_date"=>date("Y-m-d H:i:s"),
						"status"=>2902
						));

				} else if($response == url_title('Kontrak Addendum',"_",true)){

					$getdata = $this->getNextState(
						"ctr_spe_pos",
						"ctr_spe_pos_name",
						"ctr_contract_header",
						array("contract_id"=>$contract_id));

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$nextActivity = 2901;

					 $ammend_count = $this->db->where(array("contract_id"=>$contract_id))
					->get("ctr_contract_header")->row()->ammend_count;

					$this->db->where(array("contract_id"=>$contract_id))
					->update("ctr_contract_header",array(
						"terminate_reason"=>$comment,
						"terminate_date"=>date("Y-m-d H:i:s"),
						"ammend_count"=>$ammend_count+1
						));

					$contract = $this->db->where(array("contract_id"=>$contract_id))
					->get("ctr_contract_header")->row_array();

					$insert = array(
						"contract_id"=>$contract_id,
						"start_date"=>$contract['start_date'],
						"end_date"=>$contract['end_date'],
						"currency"=>$contract['currency'],
						"contract_amount"=>$contract['contract_amount'],
						"status"=>3000,
						"current_approver_pos"=>$nextPosCode,
						"contract_type"=>$contract['contract_type'],
						"contract_type_2"=>$contract['contract_type_2'],
						//"contract_number"=>$contract['contract_number'],
						);

					$this->db->insert("ctr_ammend_header",$insert);

					$ammend_id = $this->db->insert_id();

					$contract_item = $this->db->where(array("contract_id"=>$contract_id))
					->get("ctr_contract_item")->result_array();

					foreach ($contract_item as $key => $value) {
						$insert = array(
							"ammend_id"=>$ammend_id,
							"contract_item_id"=>$value['contract_item_id'],
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

						$this->db->insert("ctr_ammend_item",$insert);
						
					}

					$contract_milestone = $this->db->where(array("contract_id"=>$contract_id))
					->get("ctr_contract_milestone")->result_array();

					foreach ($contract_milestone as $key => $value) {
						$insert = array(
							"ammend_id"=>$ammend_id,
							"contract_milestone_id"=>$value['milestone_id'],
							"description"=>$value['description'],
							"percentage"=>$value['percentage'],
							"target_date"=>$value['target_date'],
							);
						$this->db->insert("ctr_ammend_milestone",$insert);
					}

					$this->db->insert("ctr_ammend_comment",array(
						"ammend_id"=>$ammend_id,
						"contract_id"=>$contract_id,
						"cac_activity"=>3000,
						"cac_position"=>$getdata['nextPosName'],
						"cac_pos_code"=>$getdata['nextPosCode'],
						"cac_start_date"=>date("Y-m-d H:i:s"),
						"cac_user"=>null
						));

				} else {
					$nextActivity = 2901;
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