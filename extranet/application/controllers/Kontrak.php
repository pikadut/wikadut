<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kontrak extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at httprocess_bastp://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	
	public function __construct() {
		parent::__construct();
		$this->load->helper("general");
	}

	public function addendum(){

		$data['message'] = $this->session->userdata("message");

		$data['list'] = $this->db->select("a.contract_id, ptm_number, a.contract_number, vendor_name, a.start_date, a.end_date, a.subject_work, a.contract_type, a.currency, a.contract_amount, awa_name as status_name,a.status")
		->join("adm_wkf_activity","awa_id=status")
		->join("ctr_ammend_header b","a.contract_id=b.contract_id","left")
		->where(array("vendor_id"=>$this->session->userdata("userid"),"awa_id"=>2901,"COALESCE(b.ammend_id,'')"=>"","COALESCE(b.ammended_date,'')"=>""))
		->get("ctr_contract_header a")->result_array();

		$data['title'] = "List Kontrak Addendum";

		$this->layout->view('listaddendum', $data);

	}

	public function submit_addendum(){

		$nextActivity = 2901;

		$contract_id = $this->input->post("contract_id");

		if(!empty($contract_id)){

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

			$nextPosCode = $contract['ctr_spe_pos'];
			$nextPosName = $contract['ctr_spe_pos_name'];

			$post = $this->input->post();

			$insert = array(
				"contract_id"=>$contract_id,
				"start_date"=>$contract['start_date'],
				"end_date"=>$contract['end_date'],
				"currency"=>$contract['currency'],
				"contract_amount"=>$contract['contract_amount'],
				"status"=>3000,
				"contract_number"=>$contract['contract_number'],
				"subject_work"=>$contract['subject_work'],
				"scope_work"=>$contract['scope_work'],
				"current_approver_pos"=>$nextPosCode,
				"contract_type"=>$contract['contract_type'],
				"contract_type_2"=>$contract['contract_type_2'],
				"ammend_reason"=>$post['reason_inp'],
				"ammend_description"=>$post['desc_inp'],
				);

			$this->db->insert("ctr_ammend_header",$insert);

			$ammend_id = $this->db->insert_id();

			if(!empty($ammend_id)){

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
					"cac_position"=>"VENDOR",
					"cac_name"=>$contract['vendor_name'],
					"cac_response"=>"Mengajukan Addendum",
					"cac_comment"=>$post['komentar_inp'],
					"cac_pos_code"=>null,
					"cac_start_date"=>date("Y-m-d H:i:s"),
					"cac_end_date"=>date("Y-m-d H:i:s"),
					"cac_user"=>null
					));

				$this->db->insert("ctr_ammend_comment",array(
					"ammend_id"=>$ammend_id,
					"contract_id"=>$contract_id,
					"cac_activity"=>3000,
					"cac_position"=>$nextPosName,
					"cac_pos_code"=>$nextPosCode,
					"cac_start_date"=>date("Y-m-d H:i:s"),
					"cac_user"=>null
					));

				$this->session->set_userdata("message","Berhasil mengajukan addendum. Proses dilanjutkan pihak internal");
				redirect(site_url("kontrak/addendum"));

			} else {

				$this->session->set_userdata("message","Gagal mengajukan addendum. Silahkan coba lagi.");
				redirect(site_url("kontrak/form_addendum"));

			}

		} else {

			$this->session->set_userdata("message","Kontrak tidak terdaftar");
			redirect(site_url("kontrak/form_addendum"));

		}

	}

	public function form_addendum(){

		$data['title'] = "List Kontrak Addendum";

		$contractid = $this->input->post("ids");

		if(!empty($contractid)){

			$data['id'] = $contractid;

			$data['header'] = $this->db->select("contract_id,vendor_id, ptm_number, contract_number, fullname as ctr_spe_complete_name, vendor_name, sign_date, start_date, end_date, subject_work, scope_work, contract_type, currency, contract_amount, pf_amount, pf_bank, pf_number, pf_start_date, pf_end_date, pf_attachment")->join("adm_employee","adm_employee.id=ctr_spe_employee")
			->where("contract_id",$contractid)->get("ctr_contract_header")->row_array();

			$data["item"] = $this->db->query("select tit_id, item_code, short_description, price, uom, qty from ctr_contract_item where contract_id = ".$contractid)->result_array();

			$data["milestone"] = $this->db->query("select description, target_date, progress_percentage from ctr_contract_milestone where contract_id = ".$contractid)->result_array();

			$data["lampiran"] = $this->db->query("select doc_id, category, description, filename from ctr_contract_doc where contract_id = ".$contractid)->result_array();

			$this->layout->view('form_addendum', $data);

		}

	}

	public function index(){

		$data["list_milestone"] = $this->db
		->select("contract_number,a.description,a.percentage,a.target_date,progress_percentage,a.milestone_id, 
			CASE a.progress_status 
			WHEN 1 THEN 'Persetujuan Progress Milestone' 
			WHEN 2 THEN 'Persetujuan Progress Milestone' 
			WHEN 3 THEN 'Persetujuan Progress Milestone' 
			WHEN 4 THEN 'Persetujuan Progress Milestone' 
			WHEN 5 THEN 'Persetujuan Progress Milestone' 
			WHEN 6 THEN 'Persetujuan Progress Milestone' 
			WHEN 99 THEN 'Revisi'
			ELSE 'Aktif' END AS activity")
		->where(array("c.vendor_id"=>$this->session->userdata("userid"),"COALESCE(a.progress_status,null)"=>99))
		->join("ctr_contract_header c","c.contract_id=a.contract_id","left")
		->get("ctr_contract_milestone a")
		->result_array();

		//start code hlmifzi
		$data["list_wo"] = $this->db
		->select("a.po_id,po_number,contract_number,po_notes,subject_work,contract_type,awa_name,
			CASE e.status 
			WHEN 1 THEN 'Persetujuan Progress WO'  
			WHEN 2 THEN 'Persetujuan Progress WO' 
			WHEN 3 THEN 'Persetujuan Progress WO' 
			WHEN 4 THEN 'Persetujuan Progress WO' 
			WHEN 5 THEN 'Persetujuan Progress WO' 
			WHEN 6 THEN 'Persetujuan Progress WO' 
			WHEN 99 THEN 'Revisi'
			ELSE 'Aktif' END AS activity")
		->where(array("a.vendor_id"=>$this->session->userdata("userid"),"cwo_end_date"=>null,"cwo_activity"=>2013,"COALESCE(e.status,null)"=>99))
		->join("ctr_po_header a","a.po_id=b.po_id")
		->join("ctr_contract_header c","c.contract_id=a.contract_id")
		->join("adm_wkf_activity d","d.awa_id=b.cwo_activity")
		->join("ctr_po_progress_header e","e.po_id=a.po_id","left")
		->get("ctr_po_comment b")
		->result_array();

		//endcode

		$data['list_bast'] = $this->db
		->query("SELECT po_id as id, contract_number,po_notes as description,b.vendor_name,progress_percentage, 'WO' as type FROM ctr_po_header b
			LEFT JOIN ctr_contract_header a ON a.contract_id=b.contract_id 
			WHERE b.vendor_id='".$this->session->userdata("userid")."' AND progress_percentage='100' AND COALESCE(bastp_status,0) IN (0,99) AND bastp_number IS NULL
			UNION ALL 
			SELECT milestone_id as id, contract_number,b.description,vendor_name,progress_percentage, 'LUMPSUM' as type FROM ctr_contract_milestone b
			LEFT JOIN ctr_contract_header a ON a.contract_id=b.contract_id 
			WHERE a.vendor_id='".$this->session->userdata("userid")."' AND progress_percentage='100' AND COALESCE(bastp_status,0) IN (0,99) AND bastp_number IS NULL")
		->result_array();

		//start code hlmifzi

		$data['list_invoice'] = $this->db
		->query("
			SELECT invoice_id as id,b.contract_number,invoice_notes as description,b.vendor_name, 'WO' as type FROM ctr_invoice_header b
			LEFT JOIN ctr_contract_header a ON a.contract_id=b.contract_id 
			WHERE b.vendor_id='".$this->session->userdata("userid")."' AND invoice_status is null AND invoice_number is null

			UNION ALL

			SELECT b.milestone_id as id,b.contract_number,c.description as description,b.vendor_name, 'LUMPSUM' as type FROM ctr_invoice_milestone_header b
			LEFT JOIN ctr_contract_header a ON a.contract_id=b.contract_id 
			LEFT JOIN ctr_contract_milestone c on c.milestone_id = b.milestone_id 
			WHERE b.vendor_id='".$this->session->userdata("userid")."' AND invoice_status is null AND invoice_number is null


			")
		->result_array();

		//end

		$this->layout->view('listpekerjaankontrak', $data);

	}

	public function monitor_bast(){

		$data['list'] = $this->db
		->query("SELECT po_id as id, contract_number,po_notes as description,b.vendor_name,progress_percentage, 'WO' as type,bastp_number,CASE bastp_status 
			WHEN 1 THEN 'Persetujuan BAST WO'  
			WHEN 2 THEN 'Persetujuan BAST WO' 
			WHEN 3 THEN 'Persetujuan BAST WO' 
			WHEN 4 THEN 'Persetujuan BAST WO' 
			WHEN 5 THEN 'Persetujuan BAST WO' 
			WHEN 6 THEN 'Persetujuan BAST WO' 
			WHEN 99 THEN 'Revisi'
			ELSE 'Aktif' END AS activity FROM ctr_po_header b
			LEFT JOIN ctr_contract_header a ON a.contract_id=b.contract_id 
			WHERE b.vendor_id='".$this->session->userdata("userid")."' AND progress_percentage='100'
			UNION ALL 
			SELECT milestone_id as id, contract_number,b.description,vendor_name,progress_percentage, 'LUMPSUM' as type,bastp_number,CASE bastp_status 
			WHEN 1 THEN 'Persetujuan BAST Milestone'  
			WHEN 2 THEN 'Persetujuan BAST Milestone' 
			WHEN 3 THEN 'Persetujuan BAST Milestone' 
			WHEN 4 THEN 'Persetujuan BAST Milestone' 
			WHEN 5 THEN 'Persetujuan BAST Milestone' 
			WHEN 6 THEN 'Persetujuan BAST Milestone' 
			WHEN 99 THEN 'Revisi'
			ELSE 'Aktif' END AS activity FROM ctr_contract_milestone b
			LEFT JOIN ctr_contract_header a ON a.contract_id=b.contract_id 
			WHERE a.vendor_id='".$this->session->userdata("userid")."' AND progress_percentage='100'")
		->result_array();

		$this->layout->view('listbast', $data);
	}

	public function monitor()
	{

		$data['list'] = $this->db->select("contract_id, ptm_number, contract_number, vendor_name, start_date, end_date, subject_work, contract_type, currency, contract_amount, awa_name as status")
		->join("adm_wkf_activity","awa_id=status")
		->where(array("vendor_id"=>$this->session->userdata("userid")))
		->get("ctr_contract_header")->result_array();

		$data['title'] = "List Kontrak";
		$this->layout->view('listkontrak', $data);

	}

	public function view(){

		$contractid = $this->input->post("ids");

		$data['header'] = $this->db->select("contract_id,vendor_id, ptm_number, contract_number, fullname as ctr_spe_complete_name, vendor_name, sign_date, start_date, end_date, subject_work, scope_work, contract_type, currency, contract_amount, pf_amount, pf_bank, pf_number, pf_start_date, pf_end_date, pf_attachment")->join("adm_employee","adm_employee.id=ctr_spe_employee")->where("contract_id",$contractid)->get("ctr_contract_header")->row_array();

		$data["item"] = $this->db->query("select tit_id, item_code, short_description, price, uom, qty from ctr_contract_item where contract_id = ".$contractid)->result_array();

		$data["milestone"] = $this->db->query("select description, target_date, progress_percentage from ctr_contract_milestone where contract_id = ".$contractid)->result_array();

		$data["lampiran"] = $this->db->query("select doc_id, category, description, filename from ctr_contract_doc where contract_id = ".$contractid)->result_array();

		$this->layout->view('kontrak', $data);

	}

	public function process_bast(){

		$post = $this->input->post();
		$id = $post['ids'];

		if($post['type'] == "LUMPSUM"){

			$this->session->set_userdata("milestone_id",$id);

			$data["header"] = $this->db
			->select("contract_number,subject_work,description,target_date,percentage,progress_percentage,bastp_number,bastp_status,bastp_description,bastp_title,bastp_attachment,bastp_created_date,bastp_status,bastp_date")
			->where(array("a.milestone_id"=>$id))
			->join("ctr_contract_header c","c.contract_id=a.contract_id","left")
			->get("ctr_contract_milestone a")
			->row_array();

			$data['viewer'] = (!empty($data['header']['bastp_number']) && empty($data['header']['bastp_status']));

			$done = $this->db
			->select("b.*")
			->where(array("vendor_id"=>$this->session->userdata("userid"),
				"COALESCE(b.percentage,0)"=>100,"b.milestone_id"=>$id))
			->join("ctr_contract_milestone e","e.milestone_id=b.milestone_id","left")
			->join("ctr_contract_header c","c.contract_id=e.contract_id","left")
			->order_by("progress_id","desc")
			->get("ctr_contract_milestone_progress b")
			->row_array();

			$data['current'] = $done;

			$data["item"] = $this->db
			->where(array("a.milestone_id"=>$id))
			->get("ctr_contract_milestone_progress a")
			->result_array();

			$data["comment_list"] = $this->db->order_by("comment_id","desc")
			->where("milestone_id",$id)->get("ctr_contract_milestone_comment")->result_array();

			$this->layout->view('milestone_bast', $data);

		} else {

			$this->session->set_userdata("po_id",$id);

			$data["header"] = $this->db
			->join("ctr_contract_header a","b.contract_id=a.contract_id","left")
			->join("prc_tender_main c","c.ptm_number=a.ptm_number","left")
			->join("adm_employee d","d.id=b.creator_employee","left")
			->join("ctr_po_progress_header e","e.po_id=b.po_id","left")
			->where("b.po_id",$id)
			->get("ctr_po_header b")->row_array();

			$data['viewer'] = (!empty($data['header']['bastp_number']) && empty($data['header']['bastp_status']));

			$this->db->select("b.*,a.min_qty,a.max_qty,c.progress_qty,c.approved_qty")
			->where("po_id",$id)
			->join("ctr_contract_item a","a.contract_item_id=b.contract_item_id","left")
			->order_by("b.po_item_id","desc")
			->join("ctr_po_progress_item c","c.po_item_id=b.po_item_id","left");
			$data["item"] = $this->db->get("ctr_po_item b")->result_array();

			$data["comment_list"] = $this->db->order_by("comment_date","asc")
			->join("ctr_po_progress_header a","a.progress_id=b.progress_id","left")
			->where("po_id",$data['header']['po_id'])->get("ctr_po_progress_comment b")->result_array();

			$this->layout->view('wo_bast', $data);

		}

	}

//start code hlmifzi
	public function process_tagihan(){

		$post = $this->input->post();
		$id = $post['ids'];

		if($post['type'] == "LUMPSUM"){

			$this->session->set_userdata("milestone_id",$id);

			$data["header"] = $this->db
			->select("a.milestone_id,contract_number,subject_work,description,target_date,percentage,progress_percentage,bastp_number,bastp_status,bastp_description,bastp_title,bastp_attachment,bastp_created_date,bastp_status,bastp_date")
			->where(array("a.milestone_id"=>$id))
			->join("ctr_contract_header c","c.contract_id=a.contract_id","left")
			->get("ctr_contract_milestone a")
			->row_array();

			
			$data['viewer'] = (!empty($data['header']['invoice_number']) && empty($data['header']['invoice_status']));

			$url_ws = "http://vendor.pengadaan.com:8888/RESTSERVICE";
			$data['url_ws'] = $url_ws;

			$bank = json_decode(file_get_contents($url_ws."/vndbank.json?token=123456&vendorId=1018&act=1"), true);
			if(!empty($bank)){
			  $data['bank'] = $bank["listVndBank"];
			}

			$done = $this->db
			->select("b.*")
			->where(array("vendor_id"=>$this->session->userdata("userid"),
				"COALESCE(b.percentage,0)"=>100,"b.milestone_id"=>$id))
			->join("ctr_contract_milestone e","e.milestone_id=b.milestone_id","left")
			->join("ctr_contract_header c","c.contract_id=e.contract_id","left")
			->order_by("progress_id","desc")
			->get("ctr_contract_milestone_progress b")
			->row_array();

			$data['current'] = $done;

			$data["item"] = $this->db
			->where(array("a.milestone_id"=>$id))
			->get("ctr_contract_milestone_progress a")
			->result_array();

			$data["comment_list"] = $this->db->order_by("comment_id","desc")
			->where("milestone_id",$id)->get("ctr_contract_milestone_comment")->result_array();

			$this->layout->view('milestone_invoice', $data);

		} else {

			$this->session->set_userdata("po_id",$id);

			$data["header"] = $this->db
			->join("ctr_contract_header a","b.contract_id=a.contract_id","left")
			->join("prc_tender_main c","c.ptm_number=a.ptm_number","left")
			->join("adm_employee d","d.id=b.creator_employee","left")
			->join("ctr_po_progress_header e","e.po_id=b.po_id","left")
			->where("b.invoice_id",$id)
			->get("ctr_invoice_header b")->row_array();

			$data['viewer'] = (!empty($data['header']['invoice_number']) && empty($data['header']['status']));


			$url_ws = "http://vendor.pengadaan.com:8888/RESTSERVICE";
			$data['url_ws'] = $url_ws;

			$bank = json_decode(file_get_contents($url_ws."/vndbank.json?token=123456&vendorId=1018&act=1"), true);
			if(!empty($bank)){
			  $data['bank'] = $bank["listVndBank"];
			}

			$this->db->select("b.*,a.min_qty,a.max_qty,c.progress_qty,c.approved_qty")
			->where("po_id",$id)
			->join("ctr_contract_item a","a.contract_item_id=b.contract_item_id","left")
			->order_by("b.po_item_id","desc")
			->join("ctr_po_progress_item c","c.po_item_id=b.po_item_id","left");
			$data["item"] = $this->db->get("ctr_po_item b")->result_array();

			$data["comment_list"] = $this->db->order_by("comment_id","desc")
			->join("ctr_po_progress_header a","a.progress_id=b.progress_id","left")
			->where("po_id",$data['header']['po_id'])->get("ctr_po_progress_comment b")->result_array();

			$this->layout->view('wo_invoice', $data);

		}

	}

	//end code

	public function submit_bast_wo(){

		$post = $this->input->post();

		$sess = $this->session->all_userdata();

		$po_id = $sess["po_id"];

		$upload = $this->do_upload('lampiran_bast', $sess["userid"], "bast_wo");

		$urut = $this->getUrutBASTWO();

		$contract = $this->db->where("po_id",$po_id)
		->get("ctr_po_header")->row_array();

		$getdata = $this->db
		->where("contract_id",$contract['contract_id'])
		->join("prc_tender_main a","a.ptm_number=b.ptm_number")
		->get("ctr_contract_header b")->row_array();

		$pos = $getdata['ptm_requester_pos_code'];
		//$employee = $this->db->where("id",$getdata['ptm_requester_id'])->get("adm_user")->row()->employeeid;
		$employee = $getdata['ptm_requester_id'];

		$input = array(
			"bastp_number"=>$urut,
			"bastp_date"=>$post['tgl_bast'],
			"bastp_title"=>$post['judul_bast'],
			"bastp_description"=>$post['berita_bast'],
			"bastp_created_date"=>date("Y-m-d H:i:s"),
			"bastp_status"=>1,
			"current_approver_pos"=>$pos,
			"current_approver_id"=>$employee,
			);

		if(!empty($upload) && !is_array($upload) && !is_array($upload)){
  			$input["bastp_attachment"] = $upload;
		}

		$this->db->where("po_id",$po_id)->update("ctr_po_header",$input);

		$progress_latest = $this->db
		->where(array("po_id"=>$po_id,"progress_percentage"=>100))
		->get("ctr_po_progress_header")->row_array();

		$progress_id = $progress_latest['progress_id'];

		$input = array(
			"progress_id"=>$progress_id,
			"comment_name"=>$sess['nama_vendor'],
			"comment_date"=>date("Y-m-d H:i:s"),
			"comments"=>$post['komentar_inp'],
			"comment_type"=>1,
			"user_id"=>$sess['userid'],
			"comment_activity"=>"Mengajukan BAST WO",
			);

		$this->db->insert("ctr_po_progress_comment",$input);

		redirect("kontrak");

	}

	public function getUrutBASTWO($tahun = ""){

		$tahun = (empty($tahun)) ? date("Y") : $tahun;

		if(!empty($tahun)){
			$this->db->where("EXTRACT(YEAR FROM created_date) =", $tahun,false);
		}

		$this->db->select("COUNT(bastp_number) as urut");

		$get = $this->db->get("ctr_po_header")->row()->urut;
		$type = "BAST";

		return $type.".".date("Ym").".".urut_id($get+1,5);

	}

	//start code hlmifzi
		public function submit_invoice_wo(){

			$post = $this->input->post();

			$sess = $this->session->all_userdata();

			$po_id = $post["po_id"];

			$upload = $this->do_upload('lampiran_invoice_wo', $sess["userid"], "invoice_wo");

			$urut = $this->getUrutInvoiceWO();

			$contract = $this->db->where("po_id",$po_id)
			->get("ctr_invoice_header")->row_array();

			$getdata = $this->db
			->where("contract_id",$contract['contract_id'])
			->join("prc_tender_main a","a.ptm_number=b.ptm_number")
			->get("ctr_contract_header b")->row_array();

			$pos =$this->db->select("pos_id")->where("pos_name","CONTRACT SPECIALIST")->get("adm_pos")->row_array();
			//$employee = $this->db->where("id",$getdata['ptm_requester_id'])->get("adm_user")->row()->employeeid;
			$employee = $getdata['ptm_requester_id'];

			$input = array(
				"invoice_number"=>$urut,
				"invoice_date"=>$post['tgl_invoice'],
				"invoice_title"=>$post['judul_invoice'],
				"invoice_description"=>$post['desk_invoice'],
				"bank_account" => $post['bank_inp'],
				"created_date"=>date("Y-m-d H:i:s"),
				"invoice_status"=>1,
				"current_approver_pos"=>$pos['pos_id'],
				"current_approver_id"=>$employee
				);

			if(!empty($upload) && !is_array($upload) && !is_array($upload)){
	  			$input["invoice_attachment"] = $upload;
			}

			$this->db->where("po_id",$po_id)->update("ctr_invoice_header",$input);

			$progress_latest = $this->db
			->where(array("po_id"=>$po_id,"progress_percentage"=>100))
			->get("ctr_po_progress_header")->row_array();

			$progress_id = $progress_latest['progress_id'];

			$input = array(
				"progress_id"=>$progress_id,
				"comment_name"=>$sess['nama_vendor'],
				"comment_date"=>date("Y-m-d H:i:s"),
				"comments"=>$post['komentar_inp'],
				"comment_type"=>1,
				"user_id"=>$sess['userid'],
				"comment_activity"=>"Mengajukan Invoice WO",
				);

			$this->db->insert("ctr_po_progress_comment",$input);


			redirect("kontrak");

		}

		public function getUrutInvoiceWO($tahun = ""){

			$tahun = (empty($tahun)) ? date("Y") : $tahun;

			if(!empty($tahun)){
				$this->db->where("EXTRACT(YEAR FROM created_date) =", $tahun,false);
			}

			$this->db->select("COUNT(invoice_number) as urut");

			$get = $this->db->get("ctr_invoice_header")->row()->urut;
			$type = "INVOICE";

			return $type.".".date("Ym").".".urut_id($get+1,5);

		}

	//end
	//start code invoice milestone

		public function submit_invoice_milestone(){

			$post = $this->input->post();

			$sess = $this->session->all_userdata();

			$milestone_id = $post["milestone_id"];

			$upload = $this->do_upload('lampiran_milestone_invoice', $sess["userid"], "invoice_milestone");

			$urut = $this->getUrutInvoiceMilestone();

			$contract = $this->db->where("milestone_id",$milestone_id)
			->get("ctr_contract_milestone")->row_array();

			$getdata = $this->db
			->where("contract_id",$contract['contract_id'])
			->join("prc_tender_main a","a.ptm_number=b.ptm_number")
			->get("ctr_contract_header b")->row_array();

			$pos =$this->db->select("pos_id")->where("pos_name","CONTRACT SPECIALIST")->get("adm_pos")->row_array();
			//$employee = $this->db->where("id",$getdata['ptm_requester_id'])->get("adm_user")->row()->employeeid;
			$employee = $getdata['ptm_requester_id'];

		/*	$pos = $getdata['ptm_requester_pos_code'];
			//$employee = $this->db->where("id",$getdata['ptm_requester_id'])->get("adm_user")->row()->employeeid;
			$employee = $getdata['ptm_requester_id'];*/

			$input = array(
				"invoice_number"=>$urut,
				"invoice_date"=>$post['tgl_invoice'],
				"invoice_title"=>$post['judul_invoice'],
				"invoice_description"=>$post['desk_invoice'],
				"bank_account" => $post['bank_inp'],
				"created_date"=>date("Y-m-d H:i:s"),
				"invoice_status"=>1,
				"current_approver_pos"=>$pos['pos_id'],
				"current_approver_id"=>$employee
				);

			if(!empty($upload) && !is_array($upload)){
				$input["invoice_attachment"] = $upload;
			}

			$this->db->where("milestone_id",$milestone_id)->update("ctr_invoice_milestone_header",$input);

			$input = array(
				"milestone_id"=>$milestone_id,
				"comment_name"=>$sess['nama_vendor'],
				"comment_date"=>date("Y-m-d H:i:s"),
				"comments"=>$post['komentar_inp'],
				"comment_type"=>1,
				"user_id"=>$sess['userid'],
				"comment_activity"=>"Mengajukan Invoice Milestone",
				);

			$this->db->insert("ctr_contract_milestone_comment",$input);

			redirect("kontrak");

		}

		public function getUrutInvoiceMilestone($tahun = ""){

			$tahun = (empty($tahun)) ? date("Y") : $tahun;

			if(!empty($tahun)){
				$this->db->where("EXTRACT(YEAR FROM created_date) =", $tahun,false);
			}

			$this->db->select("COUNT(invoice_number) as urut");

			$get = $this->db->get("ctr_invoice_milestone_header")->row()->urut;
			$type = "INVOICE";

			return $type.".".date("Ym").".".urut_id($get+1,5);

		}
		//end


	public function getUrutBASTMilestone($tahun = ""){

		$tahun = (empty($tahun)) ? date("Y") : $tahun;

		if(!empty($tahun)){
			$this->db->where("EXTRACT(YEAR FROM target_date) =", $tahun,false);
		}

		$this->db->select("COUNT(bastp_number) as urut");

		$get = $this->db->get("ctr_contract_milestone")->row()->urut;
		$type = "BAST";

		return $type.".".date("Ym").".".urut_id($get+1,5);

	}


	public function submit_bast_milestone(){

		$post = $this->input->post();

		$sess = $this->session->all_userdata();

		$milestone_id = $sess["milestone_id"];

		$upload = $this->do_upload('lampiran_bast', $sess["userid"], "bast_milestone");

		$urut = $this->getUrutBASTMilestone();

		$contract = $this->db->where("milestone_id",$milestone_id)
		->get("ctr_contract_milestone")->row_array();

		$getdata = $this->db
		->where("contract_id",$contract['contract_id'])
		->join("prc_tender_main a","a.ptm_number=b.ptm_number")
		->get("ctr_contract_header b")->row_array();

		$pos = $getdata['ptm_requester_pos_code'];
		//$employee = $this->db->where("id",$getdata['ptm_requester_id'])->get("adm_user")->row()->employeeid;
		$employee = $getdata['ptm_requester_id'];

		$input = array(
			"bastp_number"=>$urut,
			"bastp_date"=>$post['tgl_bast'],
			"bastp_title"=>$post['judul_bast'],
			"bastp_description"=>$post['berita_bast'],
			"bastp_created_date"=>date("Y-m-d H:i:s"),
			"bastp_status"=>1,
			"current_approver_pos"=>$pos,
			"current_approver_id"=>$employee,
			);

		if(!empty($upload) && !is_array($upload)){
			$input["bastp_attachment"] = $upload;
		}

		$this->db->where("milestone_id",$milestone_id)->update("ctr_contract_milestone",$input);

		$input = array(
			"milestone_id"=>$milestone_id,
			"comment_name"=>$sess['nama_vendor'],
			"comment_date"=>date("Y-m-d H:i:s"),
			"comments"=>$post['komentar_inp'],
			"comment_type"=>1,
			"user_id"=>$sess['userid'],
			"comment_activity"=>"Mengajukan BAST Milestone",
			);

		$this->db->insert("ctr_contract_milestone_comment",$input);

		redirect("kontrak");

	}

	public function wo(){
		$data["list"] = $this->db
		->select("a.po_id,po_number,contract_number,po_notes,contract_type,awa_name,
			CASE e.status 
			WHEN 1 THEN 'Persetujuan Progress WO'   
			WHEN 2 THEN 'Persetujuan Progress WO'  
			WHEN 3 THEN 'Persetujuan Progress WO'  
			WHEN 4 THEN 'Persetujuan Progress WO'  
			WHEN 5 THEN 'Persetujuan Progress WO'  
			WHEN 6 THEN 'Persetujuan Progress WO'  
			WHEN 99 THEN 'Revisi'
			ELSE 'Aktif' END AS activity")
		->where(array("a.vendor_id"=>$this->session->userdata("userid"),"cwo_end_date"=>null,"cwo_activity"=>2013,"COALESCE(e.status,null)"=>null,
			"COALESCE(e.progress_percentage,0) !="=>100))
		->join("ctr_po_header a","a.po_id=b.po_id")
		->join("ctr_contract_header c","c.contract_id=a.contract_id")
		->join("adm_wkf_activity d","d.awa_id=b.cwo_activity")
		->join("ctr_po_progress_header e","e.po_id=a.po_id","left")
		->get("ctr_po_comment b")
		->result_array();
		//echo $this->db->last_query();
		$data['judul'] = "List Progress WO";
		$this->layout->view('listwo', $data);
	}

	public function monitor_wo(){
		$data["list"] = $this->db
		->select("a.po_id,po_number,contract_number,po_notes,contract_type,awa_name,
			CASE e.status 
			WHEN 1 THEN 'Persetujuan Progress WO'  
			WHEN 2 THEN 'Persetujuan Progress WO' 
			WHEN 3 THEN 'Persetujuan Progress WO' 
			WHEN 4 THEN 'Persetujuan Progress WO' 
			WHEN 5 THEN 'Persetujuan Progress WO' 
			WHEN 6 THEN 'Persetujuan Progress WO' 
			WHEN 99 THEN 'Revisi'
			ELSE 'Aktif' END AS activity")
		->where(array("a.vendor_id"=>$this->session->userdata("userid"),"cwo_end_date"=>null,"cwo_activity"=>2013))
		->join("ctr_po_header a","a.po_id=b.po_id")
		->join("ctr_contract_header c","c.contract_id=a.contract_id")
		->join("adm_wkf_activity d","d.awa_id=b.cwo_activity")
		->join("ctr_po_progress_header e","e.po_id=a.po_id","left")
		->get("ctr_po_comment b")
		->result_array();
		$data['judul'] = "List Monitor WO";
		$this->layout->view('listwo', $data);
	}

	public function monitor_milestone(){
		$data["list"] = $this->db
		->select("contract_number,a.description,a.percentage,a.target_date,progress_percentage,a.milestone_id, 
			CASE a.progress_status 
			WHEN 1 THEN 'Persetujuan Progress Milestone'  
			WHEN 2 THEN 'Persetujuan Progress Milestone' 
			WHEN 3 THEN 'Persetujuan Progress Milestone' 
			WHEN 4 THEN 'Persetujuan Progress Milestone' 
			WHEN 5 THEN 'Persetujuan Progress Milestone' 
			WHEN 6 THEN 'Persetujuan Progress Milestone' 
			WHEN 99 THEN 'Revisi'
			ELSE 'Aktif' END AS activity")
		->where(array("c.vendor_id"=>$this->session->userdata("userid")))
		->join("ctr_contract_header c","c.contract_id=a.contract_id","left")
		->get("ctr_contract_milestone a")
		->result_array();
		$data['judul'] = "List Monitor Milestone";
		$this->layout->view('listmilestone', $data);
	}

	public function milestone(){
		$data["list"] = $this->db
		->select("contract_number,a.description,a.percentage,a.target_date,progress_percentage,a.milestone_id, 
			CASE a.progress_status 
			WHEN 1 THEN 'Persetujuan Progress Milestone'  
			WHEN 2 THEN 'Persetujuan Progress Milestone' 
			WHEN 3 THEN 'Persetujuan Progress Milestone' 
			WHEN 4 THEN 'Persetujuan Progress Milestone' 
			WHEN 5 THEN 'Persetujuan Progress Milestone' 
			WHEN 6 THEN 'Persetujuan Progress Milestone' 
			WHEN 99 THEN 'Revisi'
			ELSE 'Aktif' END AS activity")
		->where(array("c.vendor_id"=>$this->session->userdata("userid"),
			"COALESCE(a.progress_status,0)"=>0,
			"COALESCE(progress_percentage,0) !="=>100))
		->join("ctr_contract_header c","c.contract_id=a.contract_id","left")
		->get("ctr_contract_milestone a")
		->result_array();
		$data['judul'] = "List Progress Milestone";
		$this->layout->view('listmilestone', $data);
	}


	public function submit_progress_wo(){

		$this->db->trans_begin();

		$post = $this->input->post();

		$sess = $this->session->all_userdata();

		$po_id = $sess["po_id"];

		$po = $this->db
		->join("ctr_contract_header b","a.contract_id=b.contract_id")
		->join("prc_tender_main c","c.ptm_number=b.ptm_number")
		->where("po_id",$po_id)->get("ctr_po_header a")->row_array();

		//$employee = $this->db->where("id",$po['ptm_requester_id'])->get("adm_user")->row()->employeeid;
		$employee = $po['ptm_requester_id'];

		$input = array(
			"po_id"=>$po_id,
			"progress_description"=>$post['progress_inp'],
			"progress_date"=>$post['tanggal_inp'],
			"created_date"=>date("Y-m-d H:i:s"),
			"creator_id"=>$sess['userid'],
			"creator_name"=>$sess['nama_vendor'],
			"status"=>1,
			"progress_percentage"=>$post['presentase_inp'],
			"current_approver_pos"=>$po['ptm_requester_pos_code'],
			"current_approver_id"=>$employee,
			);

		$header = $this->db->where("po_id",$po_id)->get("ctr_po_progress_header")->row_array();

		if(empty($header)){
			$do = $this->db->insert('ctr_po_progress_header',$input);
			$progress_id = $this->db->insert_id();
		} else {
			$do = $this->db->where("po_id",$po_id)->update('ctr_po_progress_header',$input);
			$progress_id = $header['progress_id'];
		}

		$input = array(
			"progress_id"=>$progress_id,
			"comment_name"=>$sess['nama_vendor'],
			"comment_date"=>date("Y-m-d H:i:s"),
			"comments"=>$post['komentar_inp'],
			"comment_type"=>1,
			"user_id"=>$sess['userid'],
			"comment_activity"=>"Mengajukan Progress WO",
			);

		$this->db->insert("ctr_po_progress_comment",$input);

		$error = false;

		foreach ($post['send'] as $key => $value) {

			if($value > -1){

				$input = array(
					"progress_id"=>$progress_id,
					"po_item_id"=>$key,
					"progress_qty"=>$value,
					);

				$check = $this->db->where(array("po_item_id"=>$key))
				->get("ctr_po_progress_item")
				->row_array();

				$po_item = $this->db->where(array("po_item_id"=>$key))
				->get("ctr_po_item")
				->row_array();

				$total_terkirim = $check['approved_qty']+$value;

				if($total_terkirim <= $po_item['qty']){

					if(empty($check)){
						$act = $this->db->insert("ctr_po_progress_item",$input);
					} else {
						$act = $this->db->where(array("po_item_id"=>$key))->update("ctr_po_progress_item",$input);
					}

				} else {
					$this->session->set_userdata("msg","Qty tidak boleh lebih besar dari");
					if(!$error){
						$error = true;
					}
				}

			} else {
				$this->session->set_userdata("msg","Qty tidak boleh minus");
				if(!$error){
					$error = true;
				}
			}

		}

		if ($this->db->trans_status() === FALSE || $error)
		{

			$this->db->trans_rollback();
			$this->process_wo();
		}
		else
		{

			$this->db->trans_commit();
			redirect("kontrak/wo");

		}


	}

	public function process_milestone(){

		$id = $this->input->post('ids');
		$this->session->set_userdata("milestone_id",$id);

		$isprogress = $this->db
		->select("b.*")
		->where(array("vendor_id"=>$this->session->userdata("userid"),"COALESCE(b.status,0)"=>0,"b.milestone_id"=>$id))
		->join("ctr_contract_milestone e","e.milestone_id=b.milestone_id","left")
		->join("ctr_contract_header c","c.contract_id=e.contract_id","left")
		->order_by("progress_id","desc")
		->get("ctr_contract_milestone_progress b")
		->row_array();

		$done = $this->db
		->select("b.*")
		->where(array("vendor_id"=>$this->session->userdata("userid"),"COALESCE(b.percentage,0)"=>100,"b.milestone_id"=>$id))
		->join("ctr_contract_milestone e","e.milestone_id=b.milestone_id","left")
		->join("ctr_contract_header c","c.contract_id=e.contract_id","left")
		->order_by("progress_id","desc")
		->get("ctr_contract_milestone_progress b")
		->row_array();

		$data["header"] = $this->db
		->select("contract_number,subject_work,description,target_date,percentage,progress_percentage")
		->where(array("a.milestone_id"=>$id))
		->join("ctr_contract_header c","c.contract_id=a.contract_id","left")
		->get("ctr_contract_milestone a")
		->row_array();

		$data['viewer'] = (!empty($isprogress) || $data['header']['progress_percentage'] == 100) ? true : false;

		$data['current'] = ($data['header']['progress_percentage'] == 100) ? $done : $isprogress;

		$data["item"] = $this->db
		->where(array("a.milestone_id"=>$id))
		->get("ctr_contract_milestone_progress a")
		->result_array();

		$data["comment_list"] = $this->db->order_by("comment_id","desc")
		->where("milestone_id",$id)->get("ctr_contract_milestone_comment")->result_array();

		$this->layout->view('milestone', $data);

	}

	public function submit_progress_milestone(){

		$post = $this->input->post();

		$sess = $this->session->all_userdata();

		$milestone_id = $sess["milestone_id"];

		$milestone = $this->db
		->join("ctr_contract_header b","a.contract_id=b.contract_id")
		->join("prc_tender_main c","c.ptm_number=b.ptm_number")
		->where("milestone_id",$milestone_id)->get("ctr_contract_milestone a")->row_array();

		//$employee = $this->db->where("id",$milestone['ptm_requester_id'])->get("adm_user")->row()->employeeid;
		$employee = $getdata['ptm_requester_id'];

		$input = array(
			"milestone_id"=>$milestone_id,
			"description"=>$post['progress_inp'],
			"percentage"=>$post['presentase_inp'],
			"progress_date"=>$post['tanggal_inp'],
			"created_date"=>date("Y-m-d H:i:s"),
			"status"=>0,
			);

		$do = $this->db->insert('ctr_contract_milestone_progress',$input);

		$input = array(
			"milestone_id"=>$milestone_id,
			"comment_name"=>$sess['nama_vendor'],
			"comment_date"=>date("Y-m-d H:i:s"),
			"comments"=>$post['komentar_inp'],
			"comment_type"=>1,
			"user_id"=>$sess['userid'],
			"comment_activity"=>"Mengajukan Progress Milestone",
			);

		$this->db->insert("ctr_contract_milestone_comment",$input);

		$this->db->where("milestone_id",$milestone_id)->update("ctr_contract_milestone",array(
			"progress_status"=>1,"progress_description"=>$post['progress_inp'],
			"current_approver_pos"=>$milestone['ptm_requester_pos_code'],
			"current_approver_id"=>$employee,
			));

		redirect(site_url("kontrak/milestone"));

	}

	public function process_wo(){

		$id = $this->input->post('ids');

		$this->session->set_userdata("po_id",$id);

		$isprogress = $this->db
		->where(array("vendor_id"=>$this->session->userdata("userid"),
			"COALESCE(e.status,null) !="=>null,"e.po_id"=>$id))
		->join("ctr_po_header b","e.po_id=b.po_id","left")
		->get("ctr_po_progress_header e")
		->row_array();

		$data["header"] = $this->db
		->join("ctr_contract_header a","b.contract_id=a.contract_id","left")
		->join("prc_tender_main c","c.ptm_number=a.ptm_number","left")
		->join("adm_employee d","d.id=b.creator_employee","left")
		->join("ctr_po_progress_header e","e.po_id=b.po_id","left")
		->where("b.po_id",$id)
		->get("ctr_po_header b")
		->row_array();


		$data['viewer'] = (!empty($isprogress) || $data['header']['progress_percentage'] == 100) ? true : false;
		$data['viewer'] = ($data['header']['status'] == 99) ? false : $data['viewer'];

		$this->db->select("b.*,a.min_qty,a.max_qty,c.progress_qty,c.approved_qty")
		->where("po_id",$id)
		->join("ctr_contract_item a","a.contract_item_id=b.contract_item_id","left")
		->order_by("b.po_item_id","desc")
		->join("ctr_po_progress_item c","c.po_item_id=b.po_item_id","left");
		$data["item"] = $this->db->get("ctr_po_item b")->result_array();

		$data["comment_list"] = $this->db->order_by("comment_id","desc")->where("progress_id",$data['header']['progress_id'])->get("ctr_po_progress_comment")->result_array();

		$this->layout->view('wo', $data);

	}

	public function view_invoice(){

		$invoiceid = $this->input->post("ids");
		$type = $this->input->post("type");
		$ctr_milestone = $this->db->select("*")->where("invoice_id",$invoiceid)->get("ctr_invoice_milestone_header")->row_array();
		$id = $ctr_milestone['milestone_id'];

		if ($type == "LUMPSUM"){
			$id = $this->db->query("select po_id from ctr_invoice_header where invoice_id = ".$invoiceid)->row_array();

			$data["header"] = $this->db->query("select contract_number, invoice_number,invoice_title,denda_invoice,acc_invoice, invoice_date, bank_account, vendor_name,po_id from ctr_invoice_header where invoice_id = ".$invoiceid)->row_array();
			/*$data["item"] = $this->db->query("select bastp_number, bastp_description, bastp_amount, bastp_currency from ctr_invoice_item where invoice_id = ".$invoiceid)->result_array();
			$data["komentar"] = $this->db->order_by("comment_id","desc")->where("a.po_id",$invoiceid)
			->join("ctr_po_progress_header a","a.progress_id=b.progress_id")->get("ctr_po_progress_comment b")->result_array();*/

			$data['viewer'] = (empty($data['header']['denda_invoice']) && !empty($data['header']['invoice_status']));

			$this->db->select("b.*,a.min_qty,a.max_qty,c.progress_qty,c.approved_qty")
			->where("po_id",$id['po_id'])
			->join("ctr_contract_item a","a.contract_item_id=b.contract_item_id","left")
			->order_by("b.po_item_id","desc")
			->join("ctr_po_progress_item c","c.po_item_id=b.po_item_id","left");
			$data["item"] = $this->db->get("ctr_po_item b")->result_array();

			$data["comment_list"] = $this->db->order_by("comment_id","desc")
			->join("ctr_po_progress_header a","a.progress_id=b.progress_id","left")
			->where("po_id",$data['header']['po_id'])->get("ctr_po_progress_comment b")->result_array();


			$data["lampiranList"] = $this->db->query("select doc_id, category, description, filename from ctr_invoice_doc where invoice_id = ".$invoiceid)->result_array();
			$this->layout->view('invoice', $data);
		} else {
			

			$data["header"] = $this->db->query("select contract_number, invoice_number,invoice_title,denda_invoice,acc_invoice, invoice_date, bank_account, vendor_name,milestone_id from ctr_invoice_milestone_header where invoice_id = ".$invoiceid)->row_array();
			/*$data["item"] = $this->db->query("select bastp_number, bastp_description, bastp_amount, bastp_currency from ctr_invoice_item where invoice_id = ".$invoiceid)->result_array();
			$data["komentar"] = $this->db->order_by("comment_id","desc")->where("a.po_id",$invoiceid)
			->join("ctr_po_progress_header a","a.progress_id=b.progress_id")->get("ctr_po_progress_comment b")->result_array();*/

			$data['viewer'] = (empty($data['header']['denda_invoice']) && !empty($data['header']['invoice_status']));

			/*$this->db->select("b.*,a.min_qty,a.max_qty,c.progress_qty,c.approved_qty")
			->where("milestone_id",$id['milestone_id'])
			->join("ctr_contract_item a","a.contract_item_id=b.contract_item_id","left")
			->order_by("b.po_item_id","desc")
			->join("ctr_po_progress_item c","c.po_item_id=b.po_item_id","left");
			$data["item"] = $this->db->get("ctr_po_item b")->result_array();

			$data["comment_list"] = $this->db->order_by("comment_id","desc")
			->join("ctr_po_progress_header a","a.progress_id=b.progress_id","left")
			->where("po_id",$data['header']['po_id'])->get("ctr_po_progress_comment b")->result_array();*/

			$data['header_invoice'] = $this->db->query("SELECT *, b.percentage,b.progress_percentage,c.contract_amount, b.description,a.denda_invoice,a.acc_invoice
				from ctr_invoice_milestone_header a
				join ctr_contract_milestone b on b.milestone_id=a.milestone_id
				join ctr_contract_header c on c.contract_id = a.contract_id
				where a.milestone_id ='".$id."'")->row_array();

			$data['viewer'] = (empty($data['header_invoice']['denda_invoice']) && !empty($data['header_invoice']['invoice_status']));


			$data["comment_list"] = $this->db->order_by("comment_id","desc")->where("milestone_id",$id)->get("ctr_contract_milestone_comment")->result_array();



			$data["lampiranList"] = $this->db->query("select doc_id, category, description, filename from ctr_invoice_milestone_doc where invoice_id = ".$invoiceid)->result_array();
			$this->layout->view('monitor_invoice_milestone', $data);
		}
		
	}

	public function tagihan(){
		$data["list"] = $this->db->query("select invoice_id, contract_number, invoice_number, created_date, invoice_date, bank_account, 
			case invoice_status
			when 1 then 'Persetujuan INVOICE WO'
			when 2 then 'Persetujuan INVOICE WO'
			WHEN 99 THEN 'Revisi'
			ELSE 'Aktif' END AS status,'LUMPSUM' AS type from ctr_invoice_header where vendor_id = '".$this->session->userdata("userid")."'

			UNION ALL

			select invoice_id, contract_number, invoice_number, created_date, invoice_date, bank_account, 
			case invoice_status
			when 1 then 'Persetujuan INVOICE WO'
			when 2 then 'Persetujuan INVOICE WO'
			WHEN 99 THEN 'Revisi'
			ELSE 'Aktif' END AS status,'MILESTONE' AS type from ctr_invoice_milestone_header where vendor_id = '".$this->session->userdata("userid")."'

			")->result_array();


		$this->layout->view('listinvoice', $data);
	}
}
