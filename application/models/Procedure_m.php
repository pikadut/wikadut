
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Procedure_m extends MY_Model {

	public function __construct(){

		parent::__construct();

	}

	public function setMessage($message){

		$current_message = $this->session->userdata("message");


		if(!empty($message)){
			if(is_array($message)){
				$message = implode("<br/>", $message);
			} 
			$this->session->set_userdata("message",$message."<br/>".$current_message);
		}

	}

	public function renderMessage($message,$status,$redirect = ""){

		$this->form_validation->set_error_delimiters('<p>', '</p>');

		$this->output
		->set_content_type('application/json')
		->set_output(json_encode(array('message' => $message, "status"=>$status, "redirect"=>$redirect)));

	}

	public function batalkanPermintaan($pr_number){

	}

	public function selesaiPengadaan($ptm_number){
		
		$this->db->trans_begin();

		$this->db->where("ptm_number",$ptm_number)
		->update("prc_tender_main",array("ptm_completed_date"=>date("Y-m-d H:i:s")));

		$this->db
		->where("ptm_number",$ptm_number)
		->where("pvs_is_winner !=",1)
		->update("prc_tender_vendor_status",array("pvs_status"=>24));

		$this->db
		->where("ptm_number",$ptm_number)
		->where("pvs_is_winner",1)
		->update("prc_tender_vendor_status",array("pvs_status"=>11));

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return false;
		}
		else
		{
			$this->db->trans_commit();
			return true;
		}

	}

	public function batalkanPengadaan($ptm_number){

		$this->db->trans_begin();

		$this->db
		->where("ptm_number",$ptm_number)
		->update("prc_tender_main",array("ptm_completed_date"=>date("Y-m-d H:i:s")));

		$this->db
		->where("ptm_number",$ptm_number)
		->update("prc_tender_vendor_status",array("pvs_status"=>26));

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return false;
		}
		else
		{
			$this->db->trans_commit();
			return true;
		}

	}

	public function getNextJobTitle($nextPosCode){
		return $this->db->where("pos_id",$nextPosCode)->get("adm_pos")->row()->job_title;
	}

	public function ulangiPengadaan($ptm_number){

		$this->load->helper('string');

		$this->db->trans_begin();

		$this->db
		->where("ptm_number",$ptm_number)
		->update("prc_tender_vendor_status",array("pvs_status"=>25));

		$tender = $this->db
		->where("ptm_number",$ptm_number)
		->order_by('ptm_created_date','desc')
		->get("prc_tender_main")
		->row_array();

		$new = increment_string($tender['ptm_number'],"-");

		$tender['ptm_number'] = $new;
		$tender['ptm_status'] = 1040;

		$this->db->insert("prc_tender_main",$tender);

		$table_list = array(
			"prc_tender_doc"=>"ptd_id",
			"prc_tender_item"=>"tit_id",
		);

		foreach ($table_list as $k => $v) {

			$x = $this->db
			->where("ptm_number",$ptm_number)
			->get($k)
			->result_array();

			foreach ($x as $key => $value) {
				$value['ptm_number'] = $new;
				unset($value[$v]);
				$this->db->insert($k,$value);
			}

		}

		$prep = $this->db
		->where("ptm_number",$ptm_number)
		->get("prc_tender_prep")
		->row_array();

		$prep['ptm_number'] = $new;
		unset($prep['ptp_id']);

		$this->db->insert("prc_tender_prep",$prep);

		$this->db->where("ptm_number",$ptm_number)->update("prc_tender_main",array("ptm_downreff"=>$new));
		$this->db->where("ptm_number",$new)->update("prc_tender_main",array("ptm_upreff"=>$ptm_number));

		$last_comment = $this->db
		->where(array("ptm_number"=>$ptm_number,"ptc_activity"=>1040))
		->get("prc_tender_comment")->row_array();

		$last_comment['ptc_start_date'] = date("Y-m-d H:i:s");
		$last_comment['ptm_number'] = $new;
		unset($last_comment['ptc_id']);
		unset($last_comment['ptc_name']);
		unset($last_comment['ptc_end_date']);
		unset($last_comment['ptc_user']);
		unset($last_comment['ptc_response']);
		unset($last_comment['ptc_comment']);
		unset($last_comment['ptc_attachment']);

		$this->db->insert("prc_tender_comment",$last_comment);

		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return false;
		}
		else
		{
			$this->db->trans_commit();
			return $new;
		}

	}

	public function movePRtoRFQ($pr_number){

		$this->load->model(array("Procrfq_m","Procpr_m"));

		$get_pr = $this->Procpr_m->getPR($pr_number)->row_array();

		$ptm_number = $this->Procrfq_m->getUrutRFQ();

		$input['ptm_number'] = $ptm_number;

		$input['ptm_created_date'] = date("Y-m-d H:i:s");

		$field = array(
			'subject_of_work',
			'scope_of_work',
			'district_id',
			'district_name',
			'requester_name',
			'requester_pos_code',
			'requester_pos_name',
			'delivery_point_id',
			'delivery_point',
			'currency',
			'contract_type',
			'dept_id',
			'dept_name',
			'mata_anggaran',
			'nama_mata_anggaran',
			'sub_mata_anggaran',
			'nama_sub_mata_anggaran',
			'pagu_anggaran',
			'sisa_anggaran',
			'pagu_anggaran',	
			'requester_id',
			'type_of_plan',
			'project_name'
		);

		foreach ($field as $key => $value) {
			$input['ptm_'.$value] = $get_pr['pr_'.$value];
		}

		$input['pr_number'] = $pr_number;
		$input['pr_type'] = $get_pr['pr_type'];

		//$input['ptm_status'] = 1030;
		$input['ptm_status'] = 1040; //y ubah workflow dari 1020->1040

		$act = $this->Procrfq_m->insertDataRFQ($input);

		$input = array("ptm_number"=>$ptm_number);

		$act = $this->Procrfq_m->insertPrepRFQ($input);

		$get_dok = $this->Procpr_m->getDokumenPR("",$pr_number)->result_array();

		foreach ($get_dok as $key => $value) {

			$input = array();

			$field = array(
				'category',
				'description',
				'file_name',
			);

			foreach ($field as $k => $v) {
				$input['ptd_'.$v] = $value['ppd_'.$v];
			}

			$input['ptm_number'] = $ptm_number;

			$this->Procrfq_m->insertDokumenRFQ($input);

		}

		$get_item = $this->Procpr_m->getItemPR("",$pr_number)->result_array();

		foreach ($get_item as $key => $value) {

			$input = array();

			$field = array(
				'code',
				'description',
				'quantity',
				'unit',
				'price',
				'currency',
				'type',
				'ppn',
				'pph'
			);

			foreach ($field as $k => $v) {
				$input['tit_'.$v] = $value['ppi_'.$v];
			}

			$input['ptm_number'] = $ptm_number;

			$this->Procrfq_m->insertItemRFQ($input);

		}

		return $ptm_number;

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

		$this->db->order_by("awr_sequence","asc");

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
		->get($table)->row_array();

		if(empty($getdata)){
			//$this->setMessage("ERROR : PROSES TIDAK NAIK. SEGERA CEK POSISI DAN USER YANG TERLIBAT");
		}

		return $getdata;

	}

	//haqim 

	public function getNextJobTitlePlan($pos_id,$anggaran="",$plan_type){

		// $this->db->where('hap_pos_code', $pos_id);
		// if (!empty($anggaran)) {
		// 	$this->db->where('hap_amount >=', floatval(str_replace(",00", '', str_replace(".", "", $anggaran))));
		// }
		// if ($plan_type == 'rkp') {
		// 	$table = 'vw_prc_hierarchy_approval_5';
		// } elseif ($plan_type == 'rkap') {
		// 	$table = 'vw_prc_hierarchy_approval_6';
		// }

		// return $this->db->get($table)->result_array();

		if ($plan_type == 'rkp') {
			$table = 'vw_prc_hierarchy_approval_5';
		} elseif ($plan_type == 'rkap') {
			$table = 'vw_prc_hierarchy_approval_6';
		}

	$this->db->select('hap_amount');
    $this->db->where('hap_pos_code', $pos_id);
	$last_pos = $this->db->get($table)->result_array();
    $min_amount = $last_pos[0]['hap_amount'];

    if (floatval(str_replace(",00", '', str_replace(".", "", $anggaran))) > $min_amount) {
        $this->db->select('hap_pos_parent');
        $this->db->where('hap_pos_code', $pos_id);
        $parents = $this->db->get($table)->result_array();

        // var_dump($parents);

        if (count($parents) > 0) {
           foreach ($parents as $key => $value) {
            
            $this->db->select('hap_pos_code');
            $this->db->where('hap_pos_code', $value['hap_pos_parent']);
            // $this->db->where('hap_amount >=', 1000000000);
            $parents = $this->db->get($table)->result_array();
            if (count($parents) == 1) {
              $next_pos_id = $parents[0]['hap_pos_code'];
              break;
            }

          }
        } else {
          $next_pos_id = null;
      }
    } else{
      $next_pos_id = null;
    }

		return $next_pos_id;
	}

	//send drp mail

	public function prc_plan_comment_complete(
		$ppm_id="",
		$dept_name="",
		$ppm_planner_pos_name="",
		$nama_proses = "",
		$job_title="",
		$next_pos_id=""
		) {
		
		$msg = "Selamat datang di eSCM,
		<br/>
		<br/>
		Perencanaan Pengadaan Berikut : <br/>
		Proses : $nama_proses<br/>
		Sebagai : ".$ppm_planner_pos_name."<br/>
		Membutuhkan Response. 
		Silahkan login di ".COMPANY_WEBSITE." untuk melanjutkan proses pekerjaan.";

	
		
		$this->db->distinct();
		$this->db->select("email");
		$this->db->where("dept_name", $dept_name);
		$this->db->where('pos_id', $next_pos_id);
		// $this->db->where('employee_id', $nextjobtitle);
		// ->where("job_title like %$nextjobtitle% AND dept_name like $dept_name")
		$email_list = $this->db->get("vw_user_access")->result_array();

				$e = array();

				foreach ($email_list as $key => $value) {
					$e[] = $value['email'];
				}


			    $this->load->helper('url');

			    $msg = auto_link($msg);
			   

				$email = $this->sendEmail(implode(",", $e),"Pemberitahuan Perencanaan Pengadaan Nomor $ppm_id",$msg);
				return false;

	}

	//end

	public function prc_pr_comment_complete(
		$pr_number = "",
		$name = "",
		$activity = 0,
		$response = "",
		$comment = "",
		$attachment = "",
		$ptcId = 0,
		$perencanaan_id = 0,
		$user_id = null,
		$isSwakelola="",
		$type_of_plan
	) {

		if ($type_of_plan =='rkap') {
			$tbl = "adm_auth_hie_pr_non_proyek";
			$view = "vw_prc_hierarchy_approval";
		} elseif ($type_of_plan =='rkp') {
			$tbl = "adm_auth_hie_pr_proyek";
			$view = "vw_prc_hierarchy_approval_7";
		}

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
		$nextjobtitle = "";

		$anyIncompleteComment = $this->db
		->where(array("ppc_id"=>$ptcId,"ppc_name"=>null))
		->get("prc_pr_comment")
		->num_rows();

		if($anyIncompleteComment > 0){

			$this->db->where(array(
				"pr_number"=>$pr_number,
				"ppc_name"=>null
			));

			$this->db->where("ppc_activity",$activity,false);

			$table = "prc_pr_comment";

			$code_field = "ppc_pos_code";

			$name_field = "ppc_position";

			$getdata = $this->db
			->select($code_field." as lastPosCode,".$name_field." as lastPosName, ppc_activity as activity")
			->get($table)->row_array();

			if(empty($getdata)){
				$getdata = $this->db
				->select("pr_requester_pos_code as lastPosCode,pr_requester_pos_name as lastPosName,
					ppc_activity as activity")
				->where("pr_number",$pr_number)->get("prc_pr_main")->row_array();
			}

			$lastPosName = $getdata['lastPosName'];
			$lastPosCode = $getdata['lastPosCode'];
			$lastActivity = $getdata['activity'];

			$nextPosCode = $lastPosCode;
			$nextPosName = $lastPosName;
			
				//completing tender comment

			$totalOE = $this->db
			->select("sum((ppi_price*ppi_quantity)*(1+(COALESCE(ppi_pph,0)/100)+(COALESCE(ppi_ppn,0)/100))) as total")
			->from("prc_pr_item")
			->where("pr_number",$pr_number)
			->get()->row()->total;

			$amount = $this->db
			->select("max_amount")
			// ->from("adm_auth_hie_pr_non_proyek")
			->from($tbl)
			// ->from("adm_auth_hie")
			->where("pos_id",$lastPosCode)
			->get()->row_array();
			if(!empty($amount)){
				$max_amount = $amount['max_amount'];
			} else {
				$max_amount = 0;
			}

			$update = $this->db
			->where(array("ppc_id"=>$ptcId))
			->update("prc_pr_comment",array(
				"ppc_response" => $response_real,
				"ppc_name" => $name,
				"ppc_end_date" => date("Y-m-d H:i:s"),
				"ppc_comment" => $comment,
				"ppc_attachment" => $attachment,
				"ppc_user" => $user_id,
			));


			if($activity == 1000){

				if($response == url_title('Lanjutkan',"_",true)){

					// $getdata = $this->getNextState(
					// 	"hap_pos_code",
					// 	"hap_pos_name",
					// 	"vw_prc_hierarchy_approval",
					// 	"hap_pos_code = (select distinct hap_pos_parent 
					// 		from vw_prc_hierarchy_approval where hap_pos_code = ".$lastPosCode." AND hap_pos_parent IS NOT NULL)");
					$getdata = $this->getNextState(
						"hap_pos_code",
						"hap_pos_name",
						$view,
						"hap_pos_code = (select distinct hap_pos_parent 
							from ".$view." where hap_pos_code = ".$lastPosCode." AND hap_pos_parent IS NOT NULL)");

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$nextActivity = 1010;

				} else if($response == url_title('Simpan Sebagai Draft',"_",true)) {
					$nextActivity = 1000;
				} else if($response == url_title('Batalkan Permintaan Pengadaan',"_",true)) {
					$nextActivity = 1904;
					$this->batalkanPermintaan($pr_number);
				}

			} else if($activity == 1010){

				if($response == url_title('Setuju',"_",true)){

					//$this->setMessage("OE : ".$totalOE." = MAX : ".$max_amount);

					// $getdata = $this->getNextState(
					// 	"hap_pos_code",
					// 	"hap_pos_name",
					// 	"vw_prc_hierarchy_approval",
					// 	"hap_pos_code = (select distinct hap_pos_parent 
					// 		from vw_prc_hierarchy_approval where hap_pos_code = ".$lastPosCode." AND hap_pos_parent IS NOT NULL)");

					$getdata = $this->getNextState(
						"hap_pos_code",
						"hap_pos_name",
						$view,
						"hap_pos_code = (select distinct hap_pos_parent 
							from ".$view." where hap_pos_code = ".$lastPosCode." AND hap_pos_parent IS NOT NULL)");

					$hap = $this->db->select('hap_amount')->where('hap_pos_code',$lastPosCode)
					// ->get('vw_prc_hierarchy_approval')
					->get($view)
					->row_array();

					$next_hap = 0;

					if(!empty($hap)){
						$next_hap = $hap['hap_amount'];
					}

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];
					
					if($totalOE > $next_hap){

						$nextActivity = 1010;

					} else {

						// $nextjobtitle = 'PIC ANGGARAN';
						
						// $getdata = $this->getNextState(
						// 	"pos_id",
						// 	"pos_name",
						// 	"adm_pos",
						// 	array("job_title"=>$nextjobtitle));

						// $nextPosCode = $getdata['nextPosCode'];
						// $nextPosName = $getdata['nextPosName'];


						// $nextActivity = 1020;

						$newNumber = $this->movePRtoRFQ($pr_number);

						if(!empty($newNumber)){

							//$nextjobtitle = 'VP PENGADAAN';
							// $nextjobtitle = 'PELAKSANA PENGADAAN'; //y rfq kembali ke pic user (PR[approval PR] -> RFQ[PIC User PR as Buyer])


						//=======================================================
							//y get pr planner sebagai rfq buyer

							if ($type_of_plan == 'rkap') {
								$buyers = $this->getNextState(
								"pr_requester_id",
								"pr_requester_name",
								"prc_pr_main",
								array("pr_number"=>$pr_number));

								$buyerdata = $this->getNextState(
									"pos_id",
									"pos_name",
									"vw_employee",
									array("pos_name"=>"BUYER NON PROYEK"));

								$inputbuyer['ptm_buyer_id'] = $buyers['nextPosCode'];
								$inputbuyer['ptm_buyer'] = $buyers['nextPosName'];
							    $inputbuyer['ptm_buyer_pos_code'] = $buyerdata['nextPosCode'];
							    $inputbuyer['ptm_buyer_pos_name'] = $buyerdata['nextPosName'];

							    $nextPosCode = $buyerdata['nextPosCode'];
								$nextPosName = $buyerdata['nextPosName'];

							    //haqim
							} elseif($type_of_plan == 'rkp') {


								$this->db->where('pos_name','BUYER PROYEK');
								if (isset($dept_id)) {
									$this->db->where('dept_id', $dept_id);
								}
								$buyer = $this->db->get('vw_employee')->row_array();
								$inputbuyer['ptm_buyer_id'] = $buyer['id'];
								$inputbuyer['ptm_buyer'] = $buyer['fullname'];
							    $inputbuyer['ptm_buyer_pos_code'] = $buyer['pos_id'];
							    $inputbuyer['ptm_buyer_pos_name'] = $buyer['pos_name'];
							    $nextPosCode = $buyer['pos_id'];
								$nextPosName = $buyer['pos_name'];
							}

							// $getdata = $this->getNextState(
							// 	"pos_id",
							// 	"pos_name",
							// 	"adm_pos",
							// 	array("job_title"=>$nextjobtitle));

							// $nextPosCode = $getdata['nextPosCode'];
							// $nextPosName = $getdata['nextPosName'];

							$nextActivity = 1040;
								//end
							
							$this->db->where('ptm_number', $newNumber)->update('prc_tender_main', $inputbuyer);
							
							//y end
						//======================================================
						} 

					}

				} else if($response == url_title('Revisi',"_",true)){

					$getdata = $this->getNextState(
						"pr_requester_pos_code",
						"pr_requester_pos_name",
						"prc_pr_main",
						array("pr_number"=>$pr_number));

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$nextActivity = 1000;

				} else if($response == url_title('Batalkan Permintaan Pengadaan',"_",true)) {
					$nextActivity = 1904;
					$this->batalkanPermintaan($pr_number);
				}

			} else if($activity == 1020){

			//PERSETUJUAN ANGGARAN
				//hlmifzi
				if($response == url_title('Setuju',"_",true) && $isSwakelola == null){

					$newNumber = $this->movePRtoRFQ($pr_number);

					if(!empty($newNumber)){

						//$nextjobtitle = 'VP PENGADAAN';
						$nextjobtitle = 'PELAKSANA PENGADAAN'; //y rfq kembali ke pic user (PR[approval PR] -> RFQ[PIC User PR as Buyer])

						$getdata = $this->getNextState(
							"pos_id",
							"pos_name",
							"adm_pos",
							array("job_title"=>$nextjobtitle));

						$nextPosCode = $getdata['nextPosCode'];
						$nextPosName = $getdata['nextPosName'];

						$nextActivity = 1040; //1029

					//=======================================================
						//y get pr planner sebagai rfq buyer
						$buyers = $this->getNextState(
							"pr_requester_id",
							"pr_requester_name",
							"prc_pr_main",
							array("pr_number"=>$pr_number));

						$buyerdata = $this->getNextState(
							"pos_id",
							"pos_name",
							"vw_employee",
							array("pos_name"=>"BUYER"));
						
					    $inputbuyer['ptm_buyer_id'] = $buyers['nextPosCode'];
						$inputbuyer['ptm_buyer'] = $buyers['nextPosName'];
					    $inputbuyer['ptm_buyer_pos_code'] = $buyerdata['nextPosCode'];
					    $inputbuyer['ptm_buyer_pos_name'] = $buyerdata['nextPosName'];
						
						$this->db->where('ptm_number', $newNumber)->update('prc_tender_main', $inputbuyer);
						
						//y end
					//======================================================
					} 


				} else if($response == url_title('Setuju',"_",true) && $isSwakelola != null){
					
						$nextjobtitle = 'PIC ANGGARAN';
						
						$getdata = $this->getNextState(
							"pos_id",
							"pos_name",
							"adm_pos",
							array("job_title"=>$nextjobtitle));

						$nextPosCode = $getdata['nextPosCode'];
						$nextPosName = $getdata['nextPosName'];

						$nextActivity = 1028;

				} else if($response == url_title('Revisi',"_",true)){

					$getdata = $this->getNextState(
						"pr_requester_pos_code",
						"pr_requester_pos_name",
						"prc_pr_main",
						array("pr_number"=>$pr_number));

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$nextActivity = 1000;

				}

			}


			if(!empty($nextActivity)){
				$this->db->where("pr_number",$pr_number)->update("prc_pr_main",array("pr_status"=>$nextActivity));
			}

			$ret = array();

			if(!empty($nextPosCode)){

				$nama_proses = $this->db->select("awa_name")->where("awa_id",$nextActivity)->get("adm_wkf_activity")->row()->awa_name;

				$tender_name = $this->db->select("pr_subject_of_work")->where("pr_number",$pr_number)->get("prc_pr_main")->row()->pr_subject_of_work;

				$email_list = $this->db->distinct()->select("email")->where("pos_id",$nextPosCode)->get("vw_user_access")->result_array();

				$e = array();

				foreach ($email_list as $key => $value) {
					$e[] = $value['email'];
				}

				$msg = "Selamat datang di eSCM,
				<br/>
				<br/>
				Permintaan Pengadaan Berikut : <br/>
				Nomor : <strong>$pr_number - $tender_name</strong> <br/>
				Proses : $nama_proses<br/>
				Sebagai : ".$nextPosName."<br/>
				Membutuhkan Response. 
				Silahkan login di ".COMPANY_WEBSITE." untuk melanjutkan proses pekerjaan.";

				//haqim
				$this->load->helper('url');

			    $msg = auto_link($msg);
				//end

				$email = $this->sendEmail(implode(",", $e),"Pemberitahuan Permintaan Pengadaan Nomor $pr_number",$msg);


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

			} else {
				//$this->setMessage("Tidak ada posisi beriikutnya");
			}

			return $ret;

		}
	}



	public function prc_tender_comment_complete(
		$ptm_number = "",
		$name = "",
		$activity = 0,
		$response = "",
		$comment = "",
		$attachment = "",
		$ptcId = 0,
		$user_id = null,
		$type_of_plan
	) {

		if ($type_of_plan == 'rkp') {
			$tbl = 'adm_auth_hie_rfq_proyek';
			$tbl_pemenang = 'adm_auth_hie_pemenang_proyek';
			$tbl_pr = 'adm_auth_hie_pr_proyek';
			$tbl_kontrak = 'adm_auth_hie_kontrak_proyek';
			$view = 'vw_prc_hierarchy_approval_8';
			$view_pemenang = 'vw_prc_hierarchy_approval_9';
			$view_kontrak = 'vw_prc_hierarchy_approval_10';
		}elseif ($type_of_plan == 'rkap'){
			$tbl = 'adm_auth_hie_rfq_non_proyek';
			$tbl_pemenang = 'adm_auth_hie_pemenang_non_proyek';
			$tbl_pr = 'adm_auth_hie_pr_non_proyek';
			$tbl_kontrak = 'adm_auth_hie_kontrak_non_proyek';
			$view = 'vw_prc_hierarchy_approval_2';
			$view_pemenang = 'vw_prc_hierarchy_approval_3';
			$view_kontrak = 'vw_prc_hierarchy_approval_11';
		}

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
		$nextActivity = 0;
		$nextjobtitle = "";
		$plan_num = 0;

		$anyIncompleteComment = $this->db
		->where(array("ptc_id"=>$ptcId,"ptc_name"=>null))
		->get("prc_tender_comment")
		->num_rows();

		if($anyIncompleteComment > 0){
/*
			echo "<br/>";
		echo "WKF START";
*/

		$this->db->where(array(
			"ptm_number"=>$ptm_number,
			"ptc_name"=>null
		));

		$this->db->where("ptc_activity",$activity,false);

		$table = "prc_tender_comment";

		$code_field = "ptc_pos_code";

		$name_field = "ptc_position";

		$getdata = $this->db
		->select($code_field." as lastPosCode,".$name_field." as lastPosName, ptc_activity as activity")
		->get($table)->row_array();

		$lastPosName = $getdata['lastPosName'];
		$lastPosCode = $getdata['lastPosCode'];
		$lastActivity = $getdata['activity'];
		$nextPosCode = $lastPosCode;
		$nextPosName = $lastPosName;
		
				//completing tender comment

		$totalOE = $this->db->select("sum((tit_price*tit_quantity)*(1+(COALESCE(tit_pph::integer,0)/100)+(COALESCE(tit_ppn::integer,0)/100))) as total")->from("prc_tender_item")
		->where("ptm_number",$ptm_number)->get()->row()->total;

		// $max_amount = $this->db->select("max_amount")->from("adm_auth_hie")
		// $max_amount = $this->db->select("max_amount")->from("adm_auth_hie_pr_non_proyek")
		$max_amount = $this->db->select("max_amount")->from($tbl)
		->where("pos_id",$lastPosCode)->get()->row();

		//start code hlmifzi
		// $max_amount_2 = $this->db->select("max_amount")->from("adm_auth_hie_rfq_non_proyek")
		$max_amount_2 = $this->db->select("max_amount")->from($tbl_pemenang)
		->where("pos_id",$lastPosCode)->get()->row();
// ubah $pr_number jadi ptm_number
		$totalOE_2 = $this->db
		->select("sum((tit_price*tit_quantity)*(1+(COALESCE(tit_pph::integer,0)/100)+(COALESCE(tit_ppn::integer,0)/100))) as total")
		->from("prc_tender_item")
		->where("ptm_number",$ptm_number)
		->get()->row()->total;
		//end

		$max_amount = (isset($max_amount->max_amount)) ? $max_amount->max_amount : 0;

		$update = $this->db
		->where(array("ptc_id"=>$ptcId))
		->update("prc_tender_comment",array(
			"ptc_response" => $response_real,
			"ptc_name" => $name,
			"ptc_end_date" => date("Y-m-d H:i:s"),
			"ptc_comment" => $comment,
			"ptc_attachment" => $attachment,
			"ptc_user" => $user_id,
		));

		$update = $this->db
		->where(array("ptm_number"=>$ptm_number))
		->update("prc_tender_main",array(
			"ptm_status" => $lastActivity,
		));

		if($activity == 1029){

			if($response == url_title('Lanjutkan',"_",true)){

				$nextjobtitle = 'MANAJER PENGADAAN';

				$getdata = $this->getNextState(
					"pos_id",
					"pos_name",
					"adm_pos",
					array("job_title"=>$nextjobtitle));

				$nextPosCode = $getdata['nextPosCode'];
				$nextPosName = $getdata['nextPosName'];

				$nextActivity = 1030;

			}

		} else if($activity == 1030){

			//Penunjukkan Pelaksana Pengadaan


			if($response == url_title('Lanjutkan',"_",true)){

				$getdata = $this->getNextState(
					"ptm_buyer_pos_code",
					"ptm_buyer_pos_name",
					"prc_tender_main",
					array("ptm_number"=>$ptm_number));

				$nextPosName = $getdata['nextPosName'];
				$nextPosCode = $getdata['nextPosCode'];

				$nextActivity = 1040;

			}

		} else if($activity == 1040){

			//Pembuatan Dokumen Pengadaan

			if($response == url_title('Simpan Sebagai Draft',"_",true)){

				$nextActivity = 1040;

			} else if($response == url_title('Lanjutkan ke Persetujuan',"_",true)){

				$hap = $this->db->select('hap_amount')->where('hap_pos_code',$lastPosCode)
				// ->get('vw_prc_hierarchy_approval_2')
				->get($view)
				->row_array();

				$next_hap = 0;

				if(!empty($hap)){
					$next_hap = $hap['hap_amount'];
				}

				if($totalOE > $next_hap){

					// $getdata = $this->getNextState(
					// 	"hap_pos_code",
					// 	"hap_pos_name",
					// 	"vw_prc_hierarchy_approval_2",
					// 	"hap_pos_code = (select distinct hap_pos_parent 
					// 		from vw_prc_hierarchy_approval_2 where hap_pos_code = ".$lastPosCode." AND hap_pos_parent IS NOT NULL)");
					$getdata = $this->getNextState(
						"hap_pos_code",
						"hap_pos_name",
						$view,
						"hap_pos_code = (select distinct hap_pos_parent 
							from ".$view." where hap_pos_code = ".$lastPosCode." AND hap_pos_parent IS NOT NULL)");

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$nextjobtitle = $this->getNextJobTitle($nextPosCode);


					$nextActivity = 1041;

				} else {

					$nextjobtitle = 'VP PENGADAAN';

					$this->db->join($view_pemenang." a", 'a.hap_pos_code = b.pos_id');
					$getdata = $this->getNextState(
						"a.hap_pos_code",
						"a.hap_pos_name",
						"adm_pos b",
						array("b.job_title"=>$nextjobtitle));

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					// $getdata = $this->getNextState(
					// 	"pos_id",
					// 	"pos_name",
					// 	"adm_pos",
					// 	array("job_title"=>$nextjobtitle));

					// $nextPosCode = $getdata['nextPosCode'];
					// $nextPosName = $getdata['nextPosName'];

					$nextActivity = 1050;	
					
				}

			}

		} else if($activity == 1041){

			if($response == url_title('Setuju',"_",true)){

				$getdata = $this->db
				->select("adm_bid_committee")
				->where("ptm_number",$ptm_number)
				->get("prc_tender_prep")->row_array();

				$committee_id = $getdata['adm_bid_committee'];

				if(!empty($committee_id)){

					//TAMBAH COMMENT KE KETUA

					$getdata = $this->db
					->where(array("committee_id"=>$committee_id))
					->get("vw_adm_bid_committee")
					->result_array();

					foreach ($getdata as $key => $value) {
						$type = $value['committee_type'];
						$next = ($type == 1) ? 1051 : 1052;
						$comment = $this->Comment_m->insertProcurementRFQ($ptm_number,$next,"","","",$value['pos_id'],$value['pos_name'],$value['employee_id']);
					}

				} else {

					$hap = $this->db->select('hap_amount')->where('hap_pos_code',$lastPosCode)
					// ->get('vw_prc_hierarchy_approval_2')
					->get($view)
					->row_array();

					$next_hap = 0;

					if(!empty($hap)){
						$next_hap = $hap['hap_amount'];
					}

					if($totalOE > $next_hap){

						// $getdata = $this->getNextState(
						// 	"hap_pos_code",
						// 	"hap_pos_name",
						// 	"vw_prc_hierarchy_approval_2",
						// 	"hap_pos_code = (select distinct hap_pos_parent 
						// 		from vw_prc_hierarchy_approval_2 where hap_pos_code = ".$lastPosCode." AND hap_pos_parent IS NOT NULL)");
						$getdata = $this->getNextState(
							"hap_pos_code",
							"hap_pos_name",
							$view,
							"hap_pos_code = (select distinct hap_pos_parent 
								from ".$view." where hap_pos_code = ".$lastPosCode." AND hap_pos_parent IS NOT NULL)");

						$nextPosName = $getdata['nextPosName'];
						$nextPosCode = $getdata['nextPosCode'];

						//y rfq dari buyer ke staff scm
						if($nextPosCode == NULL){
							$getdatastaf = $this->getNextState(
								"ptm_requester_pos_code",
								"ptm_requester_pos_name",
								"prc_tender_main",
									array("ptm_number"=>$ptm_number));

							$nextPosName = $getdatastaf['nextPosName'];
							$nextPosCode = $getdatastaf['nextPosCode'];
						}
						//y end

						$nextjobtitle = $this->getNextJobTitle($nextPosCode);

						$nextActivity = 1041;

					} else {

						$proc = $this->db
						->where(array("ptm_number"=>$ptm_number))
						->get("prc_tender_prep")->row_array();

						$getdata = $this->getNextState(
							"ptm_buyer_pos_code",
							"ptm_buyer_pos_name",
							"prc_tender_main",
							array("ptm_number"=>$ptm_number));

						$nextPosName = $getdata['nextPosName'];
						$nextPosCode = $getdata['nextPosCode'];

						if($proc['ptp_prequalify'] == 2){
							//start code hlmifzi
							$nextActivity = 1060;
							//end code
						} else if($proc['ptp_tender_method'] == 2){

							$nextActivity = 1070;

						} else {

							$nextActivity = 1060;	

						}
						
					}
					

				}



			} else if($response == url_title('Revisi',"_",true)){

				$getdata = $this->getNextState(
					"ptm_buyer_pos_code",
					"ptm_buyer_pos_name",
					"prc_tender_main",
					array("ptm_number"=>$ptm_number));

				$nextPosName = $getdata['nextPosName'];
				$nextPosCode = $getdata['nextPosCode'];

				$nextActivity = 1040;

			}

		} else if($activity == 1050){

			//Persetujuan Dokumen Pengadaan Non Panitia

			if($response == url_title('Revisi',"_",true)){

				$getdata = $this->getNextState(
					"ptm_buyer_pos_code",
					"ptm_buyer_pos_name",
					"prc_tender_main",
					array("ptm_number"=>$ptm_number));

				$nextPosName = $getdata['nextPosName'];
				$nextPosCode = $getdata['nextPosCode'];

				$nextActivity = 1040;

			} else if($response == url_title('Setuju',"_",true)){

				$getdata = $this->db
				->select("ptp_tender_method")
				->where("ptm_number",$ptm_number)
				->get("prc_tender_prep")->row_array();

				$tender_method = $getdata['ptp_tender_method'];

				$hap = $this->db->select('hap_amount')->where('hap_pos_code',$lastPosCode)
				// ->get('vw_prc_hierarchy_approval_2')
				->get($view)
				->row_array();

				$next_hap = 0;

				if(!empty($hap)){
					$next_hap = $hap['hap_amount'];
				}

				if(($totalOE > $next_hap) && !empty($getdata) && !($tender_method != 0 && $getdata['hap_pos_job'] == "DIREKTUR USER")){

					// $getdata = $this->db
					// ->where("hap_pos_code = (select distinct hap_pos_parent from vw_prc_hierarchy_approval_2 where hap_pos_code = ".$lastPosCode." AND hap_pos_parent IS NOT NULL)")
					// ->get("vw_prc_hierarchy_approval_2")
					// ->row_array();
					$getdata = $this->db
					->where("hap_pos_code = (select distinct hap_pos_parent from ".$view." where hap_pos_code = ".$lastPosCode." AND hap_pos_parent IS NOT NULL)")
					->get($view)
					->row_array();

					$nextPosCode = $getdata['hap_pos_code'];
					$nextPosName = $getdata['hap_pos_name'];

					$nextjobtitle = $this->getNextJobTitle($nextPosCode);

					$nextActivity = 1050;

				} else {

					$getdata = $this->getNextState(
						"ptm_buyer_pos_code",
						"ptm_buyer_pos_name",
						"prc_tender_main",
						array("ptm_number"=>$ptm_number));

					$nextPosName = $getdata['nextPosName'];
					$nextPosCode = $getdata['nextPosCode'];
					//$newNumber = $this->movePRtoRFQ($pr_number);

					$nextActivity = (!empty($tender_method) && $tender_method == 2) ? 1070 : 1060;

				}

			}

		} else if($activity == 1051){

			//Persetujuan Dokumen Pengadaan Ketua

			if($response == url_title('Revisi',"_",true)){

				$getdata = $this->getNextState(
					"ptm_buyer_pos_code",
					"ptm_buyer_pos_name",
					"prc_tender_main",
					array("ptm_number"=>$ptm_number));

				$nextPosName = $getdata['nextPosName'];
				$nextPosCode = $getdata['nextPosCode'];

				$nextActivity = 1040;

			} else if($response == url_title('Setuju',"_",true)){

				//CEK REVIEW SUDAH DIISI SUDAH SEMUA ATAU BELUM
				$check = $this->db->where(array("ptc_end_date"=>null,"ptc_name"=>null,"ptm_number
					"=>$ptm_number,"ptc_activity"=>1052))->get("prc_tender_comment")->num_rows();

				if(empty($check)){
					//SUDAH DIREVIEW SEMUA

					$getdata = $this->getNextState(
						"ptm_buyer_pos_code",
						"ptm_buyer_pos_name",
						"prc_tender_main",
						array("ptm_number"=>$ptm_number));

					$nextActivity = (!empty($tender_method) && $tender_method == 2) ? 1070 : 1060;

					$nextPosName = $getdata['nextPosName'];
					$nextPosCode = $getdata['nextPosCode'];

				} else {
					$message = "Review belum dikerjakan oleh anggota pani

					tia";
					$update = $this->db
					->where(array("ptc_id"=>$ptcId))
					->update("prc_tender_comment",array(
						"ptc_response" => null,
						"ptc_name" => null,
						"ptc_end_date" => null,
						"ptc_comment" => "",
						"ptc_attachment" => "",
					));
				}

			}

		} else if($activity == 1052){

			//Persetujuan Dokumen Pengadaan Non Ketua

			$nextActivity = 0;

		} else if($activity == 1060){

			//if($response == url_title('Kirim Undangan',"_",true)){

				/*

				$getdata = $this->db
				->select("adm_bid_committee,ptp_tender_method")
				->where("ptm_number",$ptm_number)
				->get("prc_tender_prep")->row_array();

				$nextActivity = (!empty($getdata['ptp_tender_method']) && $getdata['ptp_tender_method'] == 2) ? 1080 : 1080;

				if(!empty($getdata['adm_bid_committee'])){

					$getdata = $this->getNextState(
						"pos_id",
						"committee_pos",
						"adm_bid_committee",
						array("committee_id"=>$getdata['adm_bid_committee'],"committee_type"=>2));

					$nextPosName = $getdata['nextPosName'];
					$nextPosCode = $getdata['nextPosCode'];

				} else {

					*/

					$getdata = $this->getNextState(
						"ptm_buyer_pos_code",
						"ptm_buyer_pos_name",
						"prc_tender_main",
						array("ptm_number"=>$ptm_number));

					$nextPosName = $getdata['nextPosName'];
					$nextPosCode = $getdata['nextPosCode'];

					$nextActivity = 1080;

				//}

				//}

				} else if($activity == 1070){


					$proc = $this->db
					->where(array("ptm_number"=>$ptm_number))
					->get("prc_tender_prep")->row_array();

					$getdata = $this->getNextState(
						"ptm_buyer_pos_code",
						"ptm_buyer_pos_name",
						"prc_tender_main",
						array("ptm_number"=>$ptm_number));

					$nextPosName = $getdata['nextPosName'];
					$nextPosCode = $getdata['nextPosCode'];

					if($proc['ptp_prequalify'] == 1){
						
						$nextActivity = 1071;

					} else {

						$nextActivity = 1080;

					}

				}  else if($activity == 1071){

					if($response == url_title('Simpan dan Lanjut',"_",true)){

						$nextjobtitle = 'MANAJER PENGADAAN';

						$getdata = $this->getNextState(
							"pos_id",
							"pos_name",
							"adm_pos",
							array("job_title"=>$nextjobtitle));

						$nextPosCode = $getdata['nextPosCode'];
						$nextPosName = $getdata['nextPosName'];
						
						$nextActivity = 1072;

					}else if($response == url_title('Batalkan Pengadaan',"_",true)) {

						$this->batalkanPengadaan($ptm_number);
						$nextActivity = 1902;

					} else {
						
						$this->ulangiPengadaan($ptm_number);	
						$nextActivity = 1903;

					}

				} else if($activity == 1072){


					if($response == url_title('Setuju',"_",true)){

						$nextjobtitle = 'VP PENGADAAN';
						
						// $getdata = $this->getNextState(
						// 	"pos_id",
						// 	"pos_name",
						// 	"adm_pos",
						// 	array("job_title"=>$nextjobtitle));

						// $nextPosCode = $getdata['nextPosCode'];
						// $nextPosName = $getdata['nextPosName'];

						$this->db->join($view." a", 'a.hap_pos_code = b.pos_id');
						$getdata = $this->getNextState(
							"a.hap_pos_code",
							"a.hap_pos_name",
							"adm_pos b",
							array("b.job_title"=>$nextjobtitle));

						$nextPosCode = $getdata['nextPosCode'];
						$nextPosName = $getdata['nextPosName'];
						
						$nextActivity = 1073;

					} else {

						$getdata = $this->getNextState(
							"ptm_buyer_pos_code",
							"ptm_buyer_pos_name",
							"prc_tender_main",
							array("ptm_number"=>$ptm_number));

						$nextPosName = $getdata['nextPosName'];
						$nextPosCode = $getdata['nextPosCode'];

						$nextActivity = 1071;

					}

				} else if($activity == 1073){

					$getdata = $this->getNextState(
						"ptm_buyer_pos_code",
						"ptm_buyer_pos_name",
						"prc_tender_main",
						array("ptm_number"=>$ptm_number));

					$nextPosName = $getdata['nextPosName'];
					$nextPosCode = $getdata['nextPosCode'];

					if($response == url_title('Setuju',"_",true)){
						
						$nextActivity = 1074;

					} else {
						
						$nextActivity = 1071;

					}

				} else if($activity == 1074){

					$getdata = $this->getNextState(
						"ptm_buyer_pos_code",
						"ptm_buyer_pos_name",
						"prc_tender_main",
						array("ptm_number"=>$ptm_number));

					$nextPosName = $getdata['nextPosName'];
					$nextPosCode = $getdata['nextPosCode'];

					if($response == url_title('Simpan dan Lanjut',"_",true)){
						
						$this->db->where("ptm_number",$ptm_number)->update("prc_tender_prep",array("ptp_prequalify"=>2));
						$nextActivity = 1040;

					} else if($response == url_title('Ulangi Pengadaan',"_",true)){
						
						$this->ulangiPengadaan($ptm_number);	
						$nextActivity = 1903;

					} else {
						
						$nextActivity = 1902;

						$this->batalkanPengadaan($ptm_number);

					}

				} else if($activity == 1080){

					if($response == url_title('Lanjutkan ke Pembukaan Penawaran',"_",true)){

						$getdata = $this->getNextState(
							"ptm_buyer_pos_code",
							"ptm_buyer_pos_name",
							"prc_tender_main",
							array("ptm_number"=>$ptm_number));

						$nextPosName = $getdata['nextPosName'];
						$nextPosCode = $getdata['nextPosCode'];

						$nextActivity = 1090;


					} else if($response == url_title('Ulangi Proses Pengadaan',"_",true)) {
						$this->ulangiPengadaan($ptm_number);
						$nextActivity = 1903;
					}

				} else if($activity == 1090){

					if($response == url_title('Lanjutkan ke Evaluasi Penawaran',"_",true)){

						$getdata = $this->getNextState(
							"ptm_buyer_pos_code",
							"ptm_buyer_pos_name",
							"prc_tender_main",
							array("ptm_number"=>$ptm_number));

						$nextPosName = $getdata['nextPosName'];
						$nextPosCode = $getdata['nextPosCode'];

						$getdata = $this->db
						->select("ptp_submission_method")
						->where("ptm_number",$ptm_number)
						->get("prc_tender_prep")->row_array();

						switch ($getdata['ptp_submission_method']) {
							case 1:
							$nextActivity = 1110;
							break;
							case 2:
							$nextActivity = 1112;
							break;

							default:
							$nextActivity = 1100;
							break;
						}


					} else if($response == url_title('Ulangi Proses Pengadaan',"_",true)){
						$this->ulangiPengadaan($ptm_number);
						$nextActivity = 1903;
					}

				} else if($activity == 1100){

					if($response == url_title('Lanjutkan ke Persetujuan Evaluasi',"_",true)){

						$getdata = $this->db
						->select("adm_bid_committee")
						->where("ptm_number",$ptm_number)
						->get("prc_tender_prep")->row_array();

						if(!empty($getdata['adm_bid_committee'])){

							$committee_id = $getdata['adm_bid_committee'];

							$getdata = $this->db
							->where(array("committee_id"=>$committee_id))
							->get("vw_adm_bid_committee")
							->result_array();

							foreach ($getdata as $key => $value) {
								$type = $value['committee_type'];
								$next = ($type == 1) ? 1131 : 1132;
								$comment = $this->Comment_m->insertProcurementRFQ($ptm_number,$next,"","","",$value['pos_id'],$value['pos_name'],$value['employee_id']);
							}

						} else {

							// // $nextjobtitle = 'MANAJER PENGADAAN';

							// $getdata = $this->getNextState(
							// 	"pos_id",
							// 	"pos_name",
							// 	"adm_pos",
							// 	array("job_title"=>$nextjobtitle));

							$getdata = $this->getNextState(
							"hap_pos_code",
							"hap_pos_name",
							$view,
							"hap_pos_code = (select distinct hap_pos_parent 
								from ".$view." where hap_pos_code = ".$lastPosCode." AND hap_pos_parent IS NOT NULL)");

							$nextPosCode = $getdata['nextPosCode'];
							$nextPosName = $getdata['nextPosName'];

							$nextjobtitle = $this->getNextJobTitle($nextPosCode);

							$nextPosCode = $getdata['nextPosCode'];
							$nextPosName = $getdata['nextPosName'];

							$nextActivity = 1101;	

						}

					} else if($response == url_title('Ulangi Proses Pengadaan',"_",true)){
						$this->ulangiPengadaan($ptm_number);
						$nextActivity = 1903;
					}

				} else if($activity == 1101){


					if($response == url_title('Setuju',"_",true)){
						//haqim
						$this->db->select('hap_pos_parent');
						$this->db->where('hap_pos_code', $lastPosCode);
						$check_parent = $this->db->get($view)->row_array();
						if ($check_parent['hap_pos_parent'] != null) {

							$nextjobtitle = 'VP PENGADAAN';
						
							$getdata = $this->getNextState(
								"pos_id",
								"pos_name",
								"adm_pos",
								array("job_title"=>$nextjobtitle));

							$nextPosCode = $getdata['nextPosCode'];
							$nextPosName = $getdata['nextPosName'];
							
							$nextActivity = 1102;
						} else {
							//haqim --sama seperti activity 1102
							$getdata = $this->getNextState(
							"ptm_buyer_pos_code",
							"ptm_buyer_pos_name",
							"prc_tender_main",
							array("ptm_number"=>$ptm_number));

							$nextPosName = $getdata['nextPosName'];
							$nextPosCode = $getdata['nextPosCode'];

							if($response == url_title('Setuju',"_",true)){
								
								$nextActivity = 1140;

							} else {

								$nextActivity = 1100;

							}
						}

						//end

						

					} else {

						$getdata = $this->getNextState(
							"ptm_buyer_pos_code",
							"ptm_buyer_pos_name",
							"prc_tender_main",
							array("ptm_number"=>$ptm_number));

						$nextPosName = $getdata['nextPosName'];
						$nextPosCode = $getdata['nextPosCode'];

						$nextActivity = 1100;

					}

				}else if($activity == 1102){

					$getdata = $this->getNextState(
						"ptm_buyer_pos_code",
						"ptm_buyer_pos_name",
						"prc_tender_main",
						array("ptm_number"=>$ptm_number));

					$nextPosName = $getdata['nextPosName'];
					$nextPosCode = $getdata['nextPosCode'];

					if($response == url_title('Setuju',"_",true)){
						
						$nextActivity = 1140;

					} else {

						$nextActivity = 1100;

					}

				} else if($activity == 1110){

					if($response == url_title('Lanjutkan ke Evaluasi Penawaran Harga',"_",true)){

						$getdata = $this->getNextState(
							"ptm_buyer_pos_code",
							"ptm_buyer_pos_name",
							"prc_tender_main",
							array("ptm_number"=>$ptm_number));

						$nextPosName = $getdata['nextPosName'];
						$nextPosCode = $getdata['nextPosCode'];

						$getdata = $this->db
						->select("ptp_submission_method")
						->where("ptm_number",$ptm_number)
						->get("prc_tender_prep")->row_array();

						$nextActivity = 1120;

					} else if($response == url_title('Jumlah yang Lulus Tidak Kuorum',"_",true)) {
						$this->ulangiPengadaan($ptm_number);
						$nextActivity = 1903;	
					}

				} else if($activity == 1112){

					if($response == url_title('Lanjutkan ke Undang Vendor Tahap 2',"_",true)){

						$getdata = $this->getNextState(
							"ptm_buyer_pos_code",
							"ptm_buyer_pos_name",
							"prc_tender_main",
							array("ptm_number"=>$ptm_number));

						$nextPosName = $getdata['nextPosName'];
						$nextPosCode = $getdata['nextPosCode'];

						$nextActivity = 1113;

					} else if($response == url_title('Jumlah yang Lulus Tidak Kuorum',"_",true)) {
						$this->ulangiPengadaan($ptm_number);
						$nextActivity = 1903;	
					}

				} else if($activity == 1113){

					$getdata = $this->getNextState(
						"ptm_buyer_pos_code",
						"ptm_buyer_pos_name",
						"prc_tender_main",
						array("ptm_number"=>$ptm_number));

					$nextPosName = $getdata['nextPosName'];
					$nextPosCode = $getdata['nextPosCode'];

					$nextActivity = 1114;

				}else if($activity == 1114){

					if($response == url_title('Lanjutkan ke Pembukaan Penawaran',"_",true)){

						$getdata = $this->getNextState(
							"ptm_buyer_pos_code",
							"ptm_buyer_pos_name",
							"prc_tender_main",
							array("ptm_number"=>$ptm_number));

						$nextPosName = $getdata['nextPosName'];
						$nextPosCode = $getdata['nextPosCode'];

						$nextActivity = 1120;


					} else if($response == url_title('Ulangi Proses Pengadaan',"_",true)) {
						$this->ulangiPengadaan($ptm_number);
						$nextActivity = 1903;
					}

			} /* else if($activity == 1115){

				$getdata = $this->getNextState(
					"ptm_buyer_pos_code",
					"ptm_buyer_pos_name",
					"prc_tender_main",
					array("ptm_number"=>$ptm_number));

				$nextPosName = $getdata['nextPosName'];
				$nextPosCode = $getdata['nextPosCode'];

				$nextActivity = 1120;

			} */ else if($activity == 1120){

				if($response == url_title('Lanjutkan ke Persetujuan Evaluasi',"_",true)){

					$nextjobtitle = 'MANAJER PENGADAAN';

					$this->db->join($view." a", 'a.hap_pos_code = b.pos_id');
					$getdata = $this->getNextState(
						"a.hap_pos_code",
						"a.hap_pos_name",
						"adm_pos b",
						array("b.job_title"=>$nextjobtitle));

					// $getdata = $this->getNextState(
					// 	"pos_id",
					// 	"pos_name",
					// 	"adm_pos",
					// 	array("job_title"=>$nextjobtitle));

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$nextActivity = 1121;

				} else if($response == url_title('Ulangi Proses Pengadaan',"_",true)) {
					$this->ulangiPengadaan($ptm_number);
					$nextActivity = 1903;	
				}

			} else if($activity == 1121){

				if($response == url_title('Lanjutkan',"_",true)){

					$getdata = $this->db
					->select("adm_bid_committee")
					->where("ptm_number",$ptm_number)
					->get("prc_tender_prep")->row_array();

					if(!empty($getdata['adm_bid_committee'])){

/*
						$committee_id = $getdata['adm_bid_committee'];

						$getdata = $this->db
						->where(array("committee_id"=>$committee_id))
						->get("vw_adm_bid_committee")
						->result_array();

						foreach ($getdata as $key => $value) {
							$type = $value['committee_type'];
							$next = ($type == 1) ? 1131 : 1132;
							$comment = $this->Comment_m->insertProcurementRFQ($ptm_number,$next,"","","",$value['pos_id'],$value['pos_name'],$value['employee_id']);
						}
						*/

					} else {

						$nextjobtitle = 'VP PENGADAAN';
						
						$getdata = $this->getNextState(
							"pos_id",
							"pos_name",
							"adm_pos",
							array("job_title"=>$nextjobtitle));

						$nextPosCode = $getdata['nextPosCode'];
						$nextPosName = $getdata['nextPosName'];

						$nextActivity = 1122;	

					}

				} else if($response == url_title('Ulangi Proses Pengadaan',"_",true)) {
					$this->ulangiPengadaan($ptm_number);
					$nextActivity = 1903;	
				}

			}else if($activity == 1122){

				if($response == url_title('Lanjutkan',"_",true)){

					$getdata = $this->db
					->select("adm_bid_committee")
					->where("ptm_number",$ptm_number)
					->get("prc_tender_prep")->row_array();

					if(!empty($getdata['adm_bid_committee'])){

/*
						$committee_id = $getdata['adm_bid_committee'];

						$getdata = $this->db
						->where(array("committee_id"=>$committee_id))
						->get("vw_adm_bid_committee")
						->result_array();

						foreach ($getdata as $key => $value) {
							$type = $value['committee_type'];
							$next = ($type == 1) ? 1131 : 1132;
							$comment = $this->Comment_m->insertProcurementRFQ($ptm_number,$next,"","","",$value['pos_id'],$value['pos_name'],$value['employee_id']);
						}
						*/

					} else {

						$getdata = $this->getNextState(
							"ptm_buyer_pos_code",
							"ptm_buyer_pos_name",
							"prc_tender_main",
							array("ptm_number"=>$ptm_number));

						$nextPosCode = $getdata['nextPosCode'];
						$nextPosName = $getdata['nextPosName'];

						$nextActivity = 1140;	

					}

				} else if($response == url_title('Ulangi Proses Pengadaan',"_",true)) {
					$this->ulangiPengadaan($ptm_number);
					$nextActivity = 1903;	
				}

			} else if($activity == 1130){

			//Persetujuan Evaluasi

				if($response == url_title('Revisi',"_",true)){

					$getdata = $this->getNextState(
						"ptm_buyer_pos_code",
						"ptm_buyer_pos_name",
						"prc_tender_main",
						array("ptm_number"=>$ptm_number));

					$nextPosName = $getdata['nextPosName'];
					$nextPosCode = $getdata['nextPosCode'];

					$getdata = $this->db
					->select("ptp_submission_method")
					->where("ptm_number",$ptm_number)
					->get("prc_tender_prep")->row_array();

					$nextActivity = ($getdata['ptp_submission_method'] == 0) ? 1100 : 1110;

				} else if($response == url_title('Setuju',"_",true)){

					if($totalOE > $max_amount){

						// $getdata = $this->getNextState(
						// 	"hap_pos_code",
						// 	"hap_pos_name",
						// 	"vw_prc_hierarchy_approval_2",
						// 	"hap_pos_code = (select distinct hap_pos_parent 
						// 		from vw_prc_hierarchy_approval_2 where hap_pos_code = ".$lastPosCode." AND hap_pos_parent IS NOT NULL)");
						$getdata = $this->getNextState(
							"hap_pos_code",
							"hap_pos_name",
							$view,
							"hap_pos_code = (select distinct hap_pos_parent 
								from ".$view." where hap_pos_code = ".$lastPosCode." AND hap_pos_parent IS NOT NULL)");

						$nextPosCode = $getdata['nextPosCode'];
						$nextPosName = $getdata['nextPosName'];

						$nextjobtitle = $this->getNextJobTitle($nextPosCode);

						$nextActivity = 1130;

					} else {

						$getdata = $this->getNextState(
							"ptm_buyer_pos_code",
							"ptm_buyer_pos_name",
							"prc_tender_main",
							array("ptm_number"=>$ptm_number));

						$nextPosName = $getdata['nextPosName'];
						$nextPosCode = $getdata['nextPosCode'];
					//$newNumber = $this->movePRtoRFQ($pr_number);

						$nextActivity = 1140;

					}

				}

			} else if($activity == 1131){

			//Persetujuan Evaluasi Ketua

				if($response == url_title('Revisi',"_",true)){

					$getdata = $this->getNextState(
						"ptm_buyer_pos_code",
						"ptm_buyer_pos_name",
						"prc_tender_main",
						array("ptm_number"=>$ptm_number));

					$nextPosName = $getdata['nextPosName'];
					$nextPosCode = $getdata['nextPosCode'];

					$getdata = $this->db
					->select("ptp_submission_method")
					->where("ptm_number",$ptm_number)
					->get("prc_tender_prep")->row_array();

					$nextActivity = ($getdata['ptp_submission_method'] == 0) ? 1100 : 1110;

				} else if($response == url_title('Setuju',"_",true)){

				//CEK REVIEW SUDAH DIISI SUDAH SEMUA ATAU BELUM
					$check = $this->db->where(array("ptc_end_date"=>null,"ptc_name"=>null,"ptm_number
						"=>$ptm_number,"ptc_activity"=>1132))->get("prc_tender_comment")->num_rows();

					if(empty($check)){
					//SUDAH DIREVIEW SEMUA
						$getdata = $this->db
						->select("adm_bid_committee,ptp_tender_method")
						->where("ptm_number",$ptm_number)
						->get("prc_tender_prep")->row_array();

						$nextActivity = 1140;

						if(!empty($getdata['adm_bid_committee'])){

							$getdata = $this->getNextState(
								"pos_id",
								"pos_name",
								"vw_adm_bid_committee",
								array("committee_id"=>$getdata['adm_bid_committee'],"committee_type"=>2));

							$nextPosName = $getdata['nextPosName'];
							$nextPosCode = $getdata['nextPosCode'];

						} else {

							$getdata = $this->getNextState(
								"ptm_buyer_pos_code",
								"ptm_buyer_pos_name",
								"prc_tender_main",
								array("ptm_number"=>$ptm_number));

							$nextPosName = $getdata['nextPosName'];
							$nextPosCode = $getdata['nextPosCode'];

						}

					} else {
						$message = "Review belum dikerjakan oleh anggota panitia pengadaan";
						$update = $this->db
						->where(array("ptc_id"=>$ptcId))
						->update("prc_tender_comment",array(
							"ptc_response" => null,
							"ptc_name" => null,
							"ptc_end_date" => null,
							"ptc_comment" => "",
							"ptc_attachment" => "",
						));
					}

				}

			} else if($activity == 1132){

			//Persetujuan Evaluasi Non Ketua

				$nextActivity = 0;

			} else if($activity == 1140){

				if($response == url_title('Lanjutkan ke Persetujuan Calon Pelaksana Pekerjaan',"_",true)){

					/*

					$getdata = $this->getNextState(
						"pos_id",
						"pos_name",
						"adm_pos",
						array("job_title"=>"VP PENGADAAN"));

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

	*/
					// $getdata = $this->getNextState(
					// 	"hap_pos_code",
					// 	"hap_pos_name",
					// 	"vw_prc_hierarchy_approval_2",
					// 	"hap_pos_code = (select distinct hap_pos_parent 
					// 		from vw_prc_hierarchy_approval_2 where hap_pos_code = ".$lastPosCode." AND hap_pos_parent IS NOT NULL)");

					$getdata = $this->getNextState(
						"hap_pos_code",
						"hap_pos_name",
						$view,
						"hap_pos_code = (select distinct hap_pos_parent 
							from ".$view." where hap_pos_code = ".$lastPosCode." AND hap_pos_parent IS NOT NULL)");

					$nextPosName = $getdata['nextPosName'];
					$nextPosCode = $getdata['nextPosCode'];

					$nextjobtitle = $this->db->where("pos_id",$nextPosCode)->get("adm_pos")->row()->job_title;

					$nextActivity = 1141;

				} else if($response == url_title('Buka Negosiasi',"_",true)) {
					$nextActivity = 1140;	
				} else if($response == url_title('Ulangi Proses Pengadaan',"_",true)) {
					$this->ulangiPengadaan($ptm_number);
					$nextActivity = 1903;	
				}

			} else if($activity == 1141){

				if($response == url_title('Lanjutkan ',"_",true)){

					$getdata = $this->db
					->select("adm_bid_committee")
					->where("ptm_number",$ptm_number)
					->get("prc_tender_prep")->row_array();

					if(!empty($getdata['adm_bid_committee'])){

						echo "ADA KOMITE";

						$committee_id = $getdata['adm_bid_committee'];

						$getdata = $this->db
						->where(array("committee_id"=>$committee_id))
						->get("vw_adm_bid_committee")
						->result_array();

						foreach ($getdata as $key => $value) {
							$type = $value['committee_type'];
							$next = ($type == 1) ? 1151 : 1152;
							$comment = $this->Comment_m->insertProcurementRFQ($ptm_number,$next,"","","",$value['pos_id'],$value['pos_name'],$value['employee_id']);
						}

					} else {

						$hap = $this->db->select('hap_amount')->where('hap_pos_code',$lastPosCode)
						// ->get('vw_prc_hierarchy_approval_3')
						->get($view_pemenang)
						->row_array();

						$next_hap = 0;

						if(!empty($hap)){
							$next_hap = $hap['hap_amount'];
						}

						// $x = $this->db->query("select distinct hap_pos_parent 
						// 	from vw_prc_hierarchy_approval_3 where hap_pos_code = ".$lastPosCode." AND hap_pos_parent IS NOT NULL")->result_array();
						$x = $this->db->query("select distinct hap_pos_parent 
							from ".$view_pemenang." where hap_pos_code = ".$lastPosCode." AND hap_pos_parent IS NOT NULL")->result_array();

						$y = $this->db->where('pos_id',$lastPosCode)
						->get('vw_adm_pos')
						->row_array();

						$poscode = null;

						if(count($x) > 1){
							foreach ($x as $key => $value) {
								if(!$poscode){
									$get_user = $this->db->where("pos_id",$value['hap_pos_parent'])->get("vw_adm_pos")->row_array();
									if($get_user['dept_id'] == $y['dept_id']){
										$poscode = $get_user['pos_id'];
									}
								}
							}
						} else {
							$poscode = $x[0]['hap_pos_parent'];
						}

						// $getdata = $this->getNextState(
						// 	"hap_pos_code",
						// 	"hap_pos_name",
						// 	"vw_prc_hierarchy_approval_3",
						// 	"hap_pos_code = $poscode");
						$getdata = $this->getNextState(
							"hap_pos_code",
							"hap_pos_name",
							$view_pemenang,
							"hap_pos_code = $poscode");

						$nextPosName = $getdata['nextPosName'];
						$nextPosCode = $getdata['nextPosCode'];

						if($totalOE > $next_hap){

							$nextActivity = 1141;

						} else {

							$nextActivity = 1150;

						}

					}

				} else if($response == url_title('Ulangi Proses Pengadaan',"_",true)) {

					$this->ulangiPengadaan($ptm_number);
					$nextActivity = 1903;	

				} else if($response == url_title('Kembali ke Negosiasi',"_",true)){

					$getdata = $this->getNextState(
						"ptm_buyer_pos_code",
						"ptm_buyer_pos_name",
						"prc_tender_main",
						array("ptm_number"=>$ptm_number));

					$nextPosName = $getdata['nextPosName'];
					$nextPosCode = $getdata['nextPosCode'];
					$nextActivity = 1140;

				}

			} else if($activity == 1150){

			//Persetujuan Calon Pemenang Evaluasi

				if($response == url_title('Tidak Setuju',"_",true)){

					$getdata = $this->getNextState(
						"ptm_buyer_pos_code",
						"ptm_buyer_pos_name",
						"prc_tender_main",
						array("ptm_number"=>$ptm_number));

					$nextPosName = $getdata['nextPosName'];
					$nextPosCode = $getdata['nextPosCode'];

					$nextActivity = 1140;

				} else if($response == url_title('Setuju',"_",true)){

					if($totalOE_2 > $max_amount_2){

						// $getdata = $this->getNextState(
						// 	"hap_pos_code",
						// 	"hap_pos_name",
						// 	"vw_prc_hierarchy_approval_2",
						// 	"hap_pos_code = (select distinct hap_pos_parent 
						// 		from vw_prc_hierarchy_approval_2 where hap_pos_code = ".$lastPosCode." AND hap_pos_parent IS NOT NULL)");

						$getdata = $this->getNextState(
							"hap_pos_code",
							"hap_pos_name",
							$view_pemenang,
							"hap_pos_code = (select distinct hap_pos_parent 
								from ".$view_pemenang." where hap_pos_code = ".$lastPosCode." AND hap_pos_parent IS NOT NULL)");

						$nextPosCode = $getdata['nextPosCode'];
						$nextPosName = $getdata['nextPosName'];

						$nextjobtitle = $this->getNextJobTitle($nextPosCode);

						$nextActivity = 1150;

					} else {

						$getdata = $this->getNextState(
							"ptm_buyer_pos_code",
							"ptm_buyer_pos_name",
							"prc_tender_main",
							array("ptm_number"=>$ptm_number));

						$nextPosName = $getdata['nextPosName'];
						$nextPosCode = $getdata['nextPosCode'];
					//$newNumber = $this->movePRtoRFQ($pr_number);

						$getdata = $this->db
						->select("ptp_tender_method")
						->where("ptm_number",$ptm_number)
						->get("prc_tender_prep")->row_array();

						if($getdata['ptp_tender_method'] == 0){

							$nextjobtitle = 'VP PENGADAAN';
							// $getdata = $this->getNextState(
							// 	"pos_id",
							// 	"pos_name",
							// 	"adm_pos",
							// 	array("job_title"=>$nextjobtitle));

							$this->db->join($view_pemenang." a", 'a.hap_pos_code = b.pos_id');
							$getdata = $this->getNextState(
								"a.hap_pos_code",
								"a.hap_pos_name",
								"adm_pos b",
								array("b.job_title"=>$nextjobtitle));

							$nextPosCode = $getdata['nextPosCode'];
							$nextPosName = $getdata['nextPosName'];

							$nextActivity = 1180;

						} else {

							$getdata = $this->getNextState(
								"ptm_buyer_pos_code",
								"ptm_buyer_pos_name",
								"prc_tender_main",
								array("ptm_number"=>$ptm_number));

							$nextPosName = $getdata['nextPosName'];
							$nextPosCode = $getdata['nextPosCode'];
							$nextActivity = 1160;
						}

					}

				}

			} else if($activity == 1151){

			//Persetujuan Calon Pemenang Ketua

				if($response == url_title('Revisi',"_",true)){

					$getdata = $this->getNextState(
						"ptm_buyer_pos_code",
						"ptm_buyer_pos_name",
						"prc_tender_main",
						array("ptm_number"=>$ptm_number));

					$nextPosName = $getdata['nextPosName'];
					$nextPosCode = $getdata['nextPosCode'];

					$getdata = $this->db
					->select("ptp_submission_method")
					->where("ptm_number",$ptm_number)
					->get("prc_tender_prep")->row_array();

					$nextActivity = ($getdata['ptp_submission_method'] == 0) ? 1100 : 1110;

				} else if($response == url_title('Setuju',"_",true)){

				//CEK REVIEW SUDAH DIISI SUDAH SEMUA ATAU BELUM
					$check = $this->db->where(array("ptc_end_date"=>null,"ptc_name"=>null,"ptm_number
						"=>$ptm_number,"ptc_activity"=>1152))->get("prc_tender_comment")->num_rows();

					if(empty($check)){
					//SUDAH DIREVIEW SEMUA

						$getdata = $this->db
						->select("adm_bid_committee,ptp_tender_method")
						->where("ptm_number",$ptm_number)
						->get("prc_tender_prep")->row_array();

						$nextActivity = 1160;

						if(!empty($getdata['adm_bid_committee'])){

							$getdata = $this->getNextState(
								"pos_id",
								"pos_name",
								"vw_adm_bid_committee",
								array("committee_id"=>$getdata['adm_bid_committee'],"committee_type"=>2));

							$nextPosName = $getdata['nextPosName'];
							$nextPosCode = $getdata['nextPosCode'];

						} else {

							$getdata = $this->getNextState(
								"ptm_buyer_pos_code",
								"ptm_buyer_pos_name",
								"prc_tender_main",
								array("ptm_number"=>$ptm_number));

							$nextPosName = $getdata['nextPosName'];
							$nextPosCode = $getdata['nextPosCode'];

						}

					} else {
						$message = "Review belum dikerjakan oleh anggota panitia pengadaan";
						$update = $this->db
						->where(array("ptc_id"=>$ptcId))
						->update("prc_tender_comment",array(
							"ptc_response" => null,
							"ptc_name" => null,
							"ptc_end_date" => null,
							"ptc_comment" => "",
							"ptc_attachment" => "",
						));
					}

				}

			} else if($activity == 1152){

			//Persetujuan Calon Pemenang Non Ketua

				$nextActivity = 0;

			} else if($activity == 1160){

				if($response == url_title('Umumkan Peringkat',"_",true)){

					$getdata = $this->getNextState(
						"ptm_buyer_pos_code",
						"ptm_buyer_pos_name",
						"prc_tender_main",
						array("ptm_number"=>$ptm_number));

					$nextPosName = $getdata['nextPosName'];
					$nextPosCode = $getdata['nextPosCode'];

					$nextActivity = 1170;

				} 

			} else if($activity == 1170){

				if($response == url_title('Terbukti dan Ulangi Pengadaan',"_",true)){

					$this->ulangiPengadaan($ptm_number);

					$nextActivity = 1903;

				} else if($response == url_title('Terbukti dan Batalkan Pengadaan',"_",true)){

					$nextActivity = 1902;

					$this->batalkanPengadaan($ptm_number);

				} else {
					/*
					$getdata = $this->getNextState(
						"ptm_buyer_pos_code",
						"ptm_buyer_pos_name",
						"prc_tender_main",
						array("ptm_number"=>$ptm_number));

					$nextPosName = $getdata['nextPosName'];
					$nextPosCode = $getdata['nextPosCode'];
					*/

					$nextjobtitle = 'VP PENGADAAN';

					$getdata = $this->getNextState(
						"pos_id",
						"pos_name",
						"adm_pos",
						array("job_title"=>$nextjobtitle));

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$nextActivity = 1180;

				} 

			} else if($activity == 1180){

				if($response == url_title('Tunjuk Pelaksana Pekerjaan',"_",true)){

					$nextjobtitle = 'VP PENGADAAN';

					$getdata = $this->getNextState(
						"pos_id",
						"pos_name",
						"adm_pos",
						array("job_title"=>$nextjobtitle));

					$nextPosCode = $getdata['nextPosCode'];
					$nextPosName = $getdata['nextPosName'];

					$nextActivity = 1901;

					$this->selesaiPengadaan($ptm_number);

					//haqim
					//move rfq to contract

					$this->load->model('Contract_m');

					$check = $this->db
					->query("SELECT * FROM vw_prc_monitor WHERE ptm_number = '".$ptm_number."' AND ptm_number NOT IN (SELECT ptm_number FROM ctr_contract_header) AND last_status = 1180 AND vendor_id IS NOT NULL")
					->row_array();

					// haqim
					$this->db->join($view_kontrak." a", 'a.hap_pos_code = b.pos_id');
					$getdata = $this->db->select("a.hap_pos_code as pos_id,a.hap_pos_name as pos_name")
					->where(array("b.job_title"=>"PENGELOLA KONTRAK")) //vp pengadaan
					->get("adm_pos b")->row_array();
					// end
					// $getdata = $this->db->select("pos_id,pos_name")
					// ->where(array("job_title"=>"PENGELOLA KONTRAK")) //vp pengadaan
					// ->get("adm_pos")->row_array();

					//y manager kontrak
					//haqim		
					$this->db->join($view_kontrak." a", 'a.hap_pos_code = b.pos_id');
					$getpos = $this->db->select('a.hap_pos_code as pos_id, a.hap_pos_name as pos_name')
					->where(array('b.job_title'=>'MANAJER PENGADAAN'))
					->get('adm_pos b')->row_array();

					$this->db->select('pos_id, pos_name, employee_id');
					$this->db->where('pos_id', $getpos['pos_id']);
					$getman = $this->db->get('adm_employee_pos')->row_array();

					// end
					// $getman = $this->db->select("pos_id, pos_name, employee_id")
					// ->where(array("job_title"=>"MANAJER PENGADAAN",
					// "user_name NOT LIKE" => '%proyek%'))
					// ->get("user_login_rule")->row_array();

					//y pengelola kontrak
					//haqim
					$this->db->join($view_kontrak." a", 'a.hap_pos_code = b.pos_id');
					$getpos = $this->db->select('a.hap_pos_code as pos_id, a.hap_pos_name as pos_name')
					->where(array('b.job_title'=>'PENGELOLA KONTRAK'))
					->get('adm_pos b')->row_array();

					$this->db->select('pos_id, pos_name, employee_id');
					$this->db->where('pos_id', $getpos['pos_id']);
					$getspe = $this->db->get('adm_employee_pos')->row_array();
					//end
					// $getspe = $this->db->select("pos_id, pos_name, employee_id")
					// ->where(array("job_title"=>"PENGELOLA KONTRAK"))
					// ->get("user_login_rule")->row_array();
					
					// foreach ($check as $key => $value) {

						$input['ptm_number'] = $check['ptm_number'];
						$input['currency'] = $check['pqm_currency'];
						$input['vendor_id'] = $check['vendor_id'];
						$input['vendor_name'] = $check['vendor_name'];
						$input['subject_work'] = $check['ptm_subject_of_work'];
						$input['scope_work'] = $check['ptm_scope_of_work'];
						$input['contract_type'] = $check['ptm_contract_type'];
						$input['completed_tender_date'] = $check['ptm_completed_date'];
						$input['contract_amount'] = $check['total_contract'];

						//y insert manager kontrak dan pengelola kontrak
						$input['ctr_spe_employee'] = $getspe['employee_id'];
						$input['ctr_spe_pos'] = $getspe['pos_id'];
						$input['ctr_spe_pos_name'] = $getspe['pos_name'];

						$input['ctr_man_employee'] = $getman['employee_id'];
						$input['ctr_man_pos'] = $getman['pos_id'];
						$input['ctr_man_pos_name'] = $getman['pos_name'];
						//y end

						$this->db->insert("ctr_contract_header",$input);

						$contract_id = $this->db->insert_id();

						$vendor_id = $check['vendor_id'];

						$this->db->where("vendor_id",$vendor_id);

						$quo_item = $this->Procrfq_m->getViewVendorQuoComRFQ("","",$check['ptm_number'])->result_array();

						

					// }

					foreach ($quo_item as $key => $value) {

							$short = (!empty($value['short_description'])) ? $value['short_description'] : $value['pqi_description'];

							$inp = array(
								"tit_id"=>$value['tit_id'],
								"contract_id"=>$contract_id,
								"item_code"=>$value['tit_code'],
								"short_description"=>$short,
								"long_description"=>$value['pqi_description'],
								"price"=>$value['pqi_price'],
								"qty"=>$value['pqi_quantity'],
								"uom"=>$value['tit_unit'],
								"min_qty"=>1,
								"max_qty"=>$value['pqi_quantity'],
								"ppn"=>$value['pqi_ppn'],
								"pph"=>$value['pqi_pph'],
								);
							
							$act = $this->Contract_m->insertItem($inp);

						}

					$this->db->insert("ctr_contract_comment",array(
							"ptm_number"=>$check['ptm_number'],
							"contract_id"=>$contract_id,
							"ccc_activity"=>2010, //2000
							"ccc_position"=>$getdata['pos_name'],
							"ccc_pos_code"=>$getdata['pos_id'],
							"ccc_start_date"=>date("Y-m-d H:i:s"),
							));
				
				

					//end


				} else if($response == url_title('Batalkan Pengadaan',"_",true)){

					$nextActivity = 1902;

					$this->batalkanPengadaan($ptm_number);

				} else if($response == url_title('Ulangi Proses Negosiasi',"_",true)){

					$getdata = $this->getNextState(
						"ptm_buyer_pos_code",
						"ptm_buyer_pos_name",
						"prc_tender_main",
						array("ptm_number"=>$ptm_number));

					$nextPosName = $getdata['nextPosName'];
					$nextPosCode = $getdata['nextPosCode'];

					$nextActivity = 1140;

				} 

			}

			if(!empty($getdata['nextPosCode'])){//====tambah=====

				$nama_proses = $this->db->select("awa_name")->where("awa_id",$nextActivity)->get("adm_wkf_activity")->row()->awa_name;

				$tender_name = $this->db->select("ptm_subject_of_work")->where("ptm_number",$ptm_number)->get("prc_tender_main")->row()->ptm_subject_of_work;

				// $email_list = $this->db->distinct()->select("email")->where("pos_id",$getdata['nextPosCode'])->get("vw_user_access")->result_array();
				$email_list = $this->db->distinct()->select("email")->where("pos_id",$nextPosCode)->get("vw_user_access")->result_array();


				$e = array();

				foreach ($email_list as $key => $value) {
					$e[] = $value['email'];
				}


				$msg = "Selamat datang di eSCM,
				<br/>
				<br/>
				Permintaan Pengadaan Berikut : <br/>
				Nomor : <strong>$ptm_number - $tender_name</strong> <br/>
				Proses : $nama_proses<br/>
				Sebagai : ".$nextPosName."<br/>
				Membutuhkan Response. 
				Silahkan login di ".COMPANY_WEBSITE." untuk melanjutkan proses pekerjaan.";

				//haqim
				//$this->load->helper('url'); di komen

			    //$msg = auto_link($msg); di komen
				//end

				$email = $this->sendEmail(implode(",", $e),"Pemberitahuan Pengadaan Nomor $ptm_number",$msg);

			}//==================================

			if(empty($nextjobtitle) && !empty($nextPosCode)){
				$nextjobtitle = $this->getNextJobTitle($nextPosCode);
			}

			$ret = array(
				"nextjobtitle"=>$nextjobtitle,
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