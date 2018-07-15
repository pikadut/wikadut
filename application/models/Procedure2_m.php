
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

	public function getContractAmmount($ptm = ""){
		
		if(!empty($ptm)){
	
			$this->db->where("ptm_number", $ptm);
	
		}
	
		return $this->db->get("ctr_contract_header")->row_array();
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

	public function ctr_wo_comment_complete(
		$po_id = "",
		$name = "",
		$activity = 0,
		$response = "",
		$comment = "",
		$attachment = "",
		$comment_id = 0,
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

		$userdata = $this->Administration_m->getLogin();
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
		->where(array("cwo_id"=>$comment_id,"cwo_name"=>null))
		->get("ctr_po_comment")
		->num_rows();

		if($anyIncompleteComment > 0){

			$this->db->where(array(
				"po_id"=>$po_id,
				"cwo_name"=>null
				));

			$this->db->where("cwo_activity",$activity,false);

			$table = "ctr_po_comment";

			$code_field = "cwo_pos_code";

			$name_field = "cwo_position";

			$getdata = $this->db
			->select($code_field." as lastPosCode,".$name_field." as lastPosName, cwo_activity as activity")
			->get($table)->row_array();

			$lastPosName = $getdata['lastPosName'];
			$lastPosCode = $getdata['lastPosCode'];
			$nextPosCode = $lastPosCode;
			$nextPosName = $lastPosName;
			$lastActivity = $getdata['activity'];
				//completing tender comment

			$update = $this->db
			->where(array("cwo_id"=>$comment_id))
			->update("ctr_po_comment",array(
				"cwo_response" => $response_real,
				"cwo_name" => $name,
				"cwo_end_date" => date("Y-m-d H:i:s"),
				"cwo_comment" => $comment,
				"cwo_attachment" => $attachment,
				"cwo_user" => $user_id,
				));

			$update = $this->db
			->where(array("po_id"=>$po_id))
			->update("ctr_po_header",array(
				"status" => $lastActivity,
				));

			if($activity == 2011){

				if($response == url_title('Simpan dan Lanjut',"_",true)){

					$w = array("job_title"=>"MANAJER USER");

					if(!empty($userdata['dept_id'])){
						$w['dept_id'] = $userdata['dept_id'];
					}

					if(!empty($userdata['district_id'])){
						$w['district_id'] = $userdata['district_id'];
					}

					$getdata = $this->getNextState(
						"pos_id",
						"pos_name",
						"adm_pos",
						$w);

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$current_approver_level = 1;
					$current_approver_pos = $lastPosCode;

					$this->db->where(array("po_id"=>$po_id))->update("ctr_po_header",
						array("current_approver_pos"=>$current_approver_pos,
							"current_approver_level"=>$current_approver_level));

					$nextActivity = 2012;

				} else {

					$getdata = $this->db
					->where("contract_id",$contract_id)
					->join("prc_tender_main a","a.ptm_number=b.ptm_number")
					->get("ctr_contract_header b")->row_array();

					$nextPosCode = $getdata['ptm_requester_pos_code'];
					$nextPosName = $getdata['ptm_requester_pos_name'];

					$nextActivity = 2011;

				}

			} else if($activity == 2012){

				if($response == url_title('Setuju',"_",true)){

					$contract = $this->db
					->select("b.current_approver_level,contract_amount,a.contract_id,contract_number")
					->where(array("po_id"=>$po_id))
					->join("ctr_contract_header a","a.contract_id=b.contract_id","left")
					->get("ctr_po_header b")->row_array();

					$nextActivity = 2012;

					switch ($contract['current_approver_level']) {

						case 1:

						$w = array();

						if(!empty($userdata['dept_id'])){
							$w['dept_id'] = $userdata['dept_id'];
						}

						if(!empty($userdata['district_id'])){
							$w['district_id'] = $userdata['district_id'];
						}

						if($contract['contract_amount'] > 200000000){

							$w["job_title"] = "VP USER";

							$getdata = $this->getNextState(
								"pos_id",
								"pos_name",
								"adm_pos",
								$w);

							$nextPosCode = $getdata['nextPosCode'];
							$nextPosName = $getdata['nextPosName'];

							$current_approver_level = 2;

						} else {

							$w["job_title"] = "PENGELOLA KONTRAK";

							$getdata = $this->getNextState(
								"pos_id",
								"pos_name",
								"adm_pos",
								$w);

							$nextPosCode = $getdata['nextPosCode'];
							$nextPosName = $getdata['nextPosName'];

							$current_approver_level = 3;

						}

						break;

						case 2:

						$w = array("job_title"=>"PENGELOLA KONTRAK");

						if(!empty($userdata['dept_id'])){
							$w['dept_id'] = $userdata['dept_id'];
						}

						if(!empty($userdata['district_id'])){
							$w['district_id'] = $userdata['district_id'];
						}

						$getdata = $this->getNextState(
							"pos_id",
							"pos_name",
							"adm_pos",
							$w);

						$nextPosCode = $getdata['nextPosCode'];
						$nextPosName = $getdata['nextPosName'];

						$current_approver_level = 3;

						break;

						case 3:

						$w = array("job_title"=>"MANAJER PENGADAAN");

						if(!empty($userdata['dept_id'])){
							$w['dept_id'] = $userdata['dept_id'];
						}

						if(!empty($userdata['district_id'])){
							$w['district_id'] = $userdata['district_id'];
						}

						$getdata = $this->getNextState(
							"pos_id",
							"pos_name",
							"adm_pos",
							$w);

						$nextPosCode = $getdata['nextPosCode'];
						$nextPosName = $getdata['nextPosName'];

						$current_approver_level = 4;

						break;

						case 4:

						if($contract['contract_amount'] > 500000000){

							$w = array("job_title"=>"VP BAST");

							if(!empty($userdata['dept_id'])){
								$w['dept_id'] = $userdata['dept_id'];
							}

							if(!empty($userdata['district_id'])){
								$w['district_id'] = $userdata['district_id'];
							}

							$getdata = $this->getNextState(
								"pos_id",
								"pos_name",
								"adm_pos",
								$w);

							$nextPosCode = $getdata['nextPosCode'];
							$nextPosName = $getdata['nextPosName'];

							$current_approver_level = 5;

						} else {

							$nextActivity = 2013;
							$getdata = $this->getNextState(
								"ctr_spe_pos",
								"ctr_spe_pos_name",
								"ctr_contract_header",
								array("contract_id"=>$contract_id));

							$nextPosCode = $getdata['nextPosCode'];
							$nextPosName = $getdata['nextPosName'];
							$current_approver_level = 6;

						}

						break;

						case 5:

						$nextActivity = 2013;

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

					$input = array(
						"current_approver_pos"=>$current_approver_pos,
						"current_approver_level"=>$current_approver_level,
						"status"=>$nextActivity
						);

					if ($contract['current_approver_level'] == 5) {
						$input['approved_date'] = date("Y-m-d H:i:s");
					}

					$this->db->where(array("po_id"=>$po_id))->update("ctr_po_header",
						$input);

				} else {

					$getdata = $this->db
					->where("contract_id",$contract_id)
					->join("prc_tender_main a","a.ptm_number=b.ptm_number")
					->get("ctr_contract_header b")->row_array();

					$nextPosCode = $getdata['ptm_requester_pos_code'];
					$nextPosName = $getdata['ptm_requester_pos_name'];

					$nextActivity = 2011;

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

			return $ret;

		}
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

			//y start my code
			// review legal fix
			} else if($activity == 2021){

				if($response == url_title('Lanjutkan',"_",true)){

					$ctrvalue = $this->db->select('price, qty, ppn, pph')
								->where(array('ptm_number'=>$ptm_number))
								->join('ctr_contract_header b', 'b.contract_id = a.contract_id')
								->get('ctr_contract_item a')->result_array();

					$spedept = $this->db->select('ctr_spe_employee')->where(array('ptm_number'=>$ptm_number))->get('ctr_contract_header')->row_array(); 
					$userdept = $this->db->select('dept_id')
								->where(array('employee_id'=>$spedept['ctr_spe_employee']))
								->get('adm_employee_pos')->row_array(); 
					$ctrdept = $this->db->select('pos_id')
								->where(array('job_title' => 'MANAJER PENGADAAN', 'dept_id' => $userdept['dept_id']))
								->get('adm_pos')->row_array(); 

					$getdata = $this->getNextState(
						"hap_pos_code",
						"hap_pos_name",
						"vw_prc_hierarchy_approval_11",
						"hap_pos_code = (select distinct hap_pos_parent 
							from vw_prc_hierarchy_approval_11 where hap_pos_code = ".$lastPosCode." AND hap_pos_parent IS NOT NULL AND hap_pos_parent = ".$ctrdept['pos_id'].")");
				
					foreach ($ctrvalue as $k => $v) {
						$ctrprice[] = $v['price'] * $v['qty'] + ($v['price'] * $v['qty'] * $v['ppn'] / 100) + ($v['price'] * $v['qty'] * $v['pph'] / 100) ;
					}
					
					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];
					
					if(array_sum($ctrprice) <= 2000000000){
						$nextActivity = 2022;
					}else{
						$nextActivity = 2023;
					}

				}

			// review manager terkait
			} else if($activity == 2022){

				if($response == url_title('Lanjutkan',"_",true)){

					$ctrvalue = $this->getContractAmmount($ptm_number);

					$getdata = $this->getNextState(
						"hap_pos_code",
						"hap_pos_name",
						"vw_prc_hierarchy_approval_11",
						"hap_pos_code = (select distinct hap_pos_parent 
							from vw_prc_hierarchy_approval_11 where hap_pos_code = ".$lastPosCode." AND hap_pos_parent IS NOT NULL)");

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];
					
					$nextActivity = 2024;
				}


			// approval manager terkait
			} else if($activity == 2023){

				if($response == url_title('Setuju',"_",true)){

					$getdata = $this->getNextState(
						"hap_pos_code",
						"hap_pos_name",
						"vw_prc_hierarchy_approval_11",
						"hap_pos_code = (select distinct hap_pos_parent 
							from vw_prc_hierarchy_approval_11 where hap_pos_code = ".$lastPosCode." AND hap_pos_parent IS NOT NULL)");

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$nextActivity = 2025;

				} else if($response == url_title('Revisi',"_",true)){

					$getdata = $this->getNextState(
						"ctr_spe_pos",
						"ctr_spe_pos_name",
						"ctr_contract_header",
						array("ptm_number"=>$ptm_number));

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$nextActivity = 2010;
				} 

			// approval gm korporasi
			} else if($activity == 2024){

				if($response == url_title('Setuju',"_",true)){

					$getdata = $this->getNextState(
						"hap_pos_code",
						"hap_pos_name",
						"vw_prc_hierarchy_approval_11",
						"hap_pos_code = (select distinct hap_pos_parent 
							from vw_prc_hierarchy_approval_11 where hap_pos_code = ".$lastPosCode." AND hap_pos_parent IS NOT NULL)");

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$nextActivity = 2030;

				} else if($response == url_title('Revisi',"_",true)){

					$getdata = $this->getNextState(
						"ctr_spe_pos",
						"ctr_spe_pos_name",
						"ctr_contract_header",
						array("ptm_number"=>$ptm_number));

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$nextActivity = 2010;
				}

			// review gm korporasi
			} else if($activity == 2025){

				if($response == url_title('Lanjutkan',"_",true)){

					$getdata = $this->getNextState(
						"hap_pos_code",
						"hap_pos_name",
						"vw_prc_hierarchy_approval_11",
						"hap_pos_code = (select distinct hap_pos_parent 
							from vw_prc_hierarchy_approval_11 where hap_pos_code = ".$lastPosCode." AND hap_pos_parent IS NOT NULL)");

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$nextActivity = 2026;

				}

			// approval direksi
			} else if($activity == 2026){

				if($response == url_title('Setuju',"_",true)){

					$getdata = $this->getNextState(
						"ctr_spe_pos",
						"ctr_spe_pos_name",
						"ctr_contract_header",
						array("ptm_number"=>$ptm_number));

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$nextActivity = 2030;

				} else if($response == url_title('Revisi',"_",true)){

					$getdata = $this->getNextState(
						"ctr_spe_pos",
						"ctr_spe_pos_name",
						"ctr_contract_header",
						array("ptm_number"=>$ptm_number));

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$nextActivity = 2010;
				} 
			
			// approval all proyek
			} else if($activity == 2027){

				if($response == url_title('Setuju',"_",true)){
					
					$hapamount = $this->db->select('hap_amount')->where(array('hap_pos_code'=>$lastPosCode))->get('vw_prc_hierarchy_approval_10')->result_array();
					
					$ctrvalue = $this->db->select('price, qty, ppn, pph')
								->where(array('ptm_number'=>$ptm_number))
								->join('ctr_contract_header b', 'b.contract_id = a.contract_id')
								->get('ctr_contract_item a')->result_array();
					
					foreach ($ctrvalue as $k => $v) {
						$ctrprice[] = $v['price'] * $v['qty'] + ($v['price'] * $v['qty'] * $v['ppn'] / 100) + ($v['price'] * $v['qty'] * $v['pph'] / 100) ;
					}

					if(array_sum($ctrprice) > $hapamount[0]['hap_amount']){
						
						$getdata = $this->getNextState(
							"hap_pos_code",
							"hap_pos_name",
							"vw_prc_hierarchy_approval_10",
							"hap_pos_code = (select distinct hap_pos_parent 
								from vw_prc_hierarchy_approval_10 where hap_pos_code = ".$lastPosCode." AND hap_pos_parent IS NOT NULL)");

						$nextPosCode = $getdata['nextPosCode'];
						$nextPosName = $getdata['nextPosName'];
						
						$nextActivity = 2027;
	
					}else{

						$getdata = $this->getNextState(
							"ctr_spe_pos",
							"ctr_spe_pos_name",
							"ctr_contract_header",
							array("ptm_number"=>$ptm_number));

						$nextPosCode = $getdata['nextPosCode'];
						$nextPosName = $getdata['nextPosName'];
						
						$nextActivity = 2030;	

					}

				} else if($response == url_title('Revisi',"_",true)){

					$getdata = $this->getNextState(
						"ctr_spe_pos",
						"ctr_spe_pos_name",
						"ctr_contract_header",
						array("ptm_number"=>$ptm_number));

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$nextActivity = 2010;
				} 
			//y endy my code


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

					// $getdata = $this->getNextState(
					// 	"ctr_spe_pos",
					// 	"ctr_spe_pos_name",
					// 	"ctr_contract_header",
					// 	array("contract_id"=>$contract_id));
					$typeplan = $this->db->select('ptm_type_of_plan')->where(array('ptm_number' => $ptm_number))->get('prc_tender_main')->row_array();

					if($typeplan['ptm_type_of_plan'] == 'rkap'){
						$view = 'vw_prc_hierarchy_approval_11';
						$nextActivity = 2021;
					}else{
						$view = 'vw_prc_hierarchy_approval_10';
						$nextActivity = 2027;
					}

					$getdata = $this->getNextState(
						"hap_pos_code",
						"hap_pos_name",
						$view,
						"hap_pos_code = (select distinct hap_pos_parent 
							from ".$view. " where hap_pos_code = ".$lastPosCode." AND hap_pos_parent IS NOT NULL)");
					
					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

				} else if($response == url_title('Revisi Pelaksana',"_",true)){

					$getdata = $this->getNextState(
						"ctr_man_pos",
						"ctr_man_pos_name",
						"ctr_contract_header",
						array("ptm_number"=>$ptm_number));

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$nextActivity = 2001;

					/*
					$this->db->where("contract_id",$contract_id)
					->update("ctr_contract_item",array("qty"=>null,"min_qty"=>null,"max_qty"=>null,"ppn"=>null,"pph"=>null));
					*/

					$this->db->where("contract_id",$contract_id)
					->update("ctr_contract_header",array("contract_number"=>null,"ctr_spe_employee"=>null,"contract_type_2"=>null,"start_date"=>null,"end_date"=>null));

					$this->db->where("contract_id",$contract_id)->delete("ctr_contract_doc");

					$this->db->where("contract_id",$contract_id)->delete("ctr_contract_milestone");

				} else if($response == url_title('Simpan Sebagai Draft',"_",true)) {
					$nextActivity = 2010;
				}

			}  else if($activity == 2020){

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
					//haqim
					$update = $this->db
					->where(array("contract_id"=>$contract_id))
					->update("ctr_contract_header",array(
						"status" => $nextActivity,
						));
					//end


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

			return $ret;

		}
	}

}