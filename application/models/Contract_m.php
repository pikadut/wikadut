
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Contract_m extends CI_Model {

	public function __construct(){

		parent::__construct();

	}

	public function getContractNew($id = ""){

		if(!empty($id)){

			$this->db->where("ptm_number",$id);

		}

		$this->db->where("last_status",1901);

		return $this->db->get("vw_prc_monitor");

	}

	public function getProgress($progress_id = "",$type = "",$jenis = ""){

		$data = array();

		if(!empty($progress_id)){

			$data['progress_id'] = $progress_id;

			if($type == "milestone"){

				$data['header'] = $this->getHeaderMilestoneProgress($jenis,$progress_id)->row_array();

				$this->db->select("contract_item_id as id,item_code as kode,long_description as deskripsi,uom as satuan,price as harga_satuan,qty as jumlah,min_qty as order_minimum,max_qty as order_maksimum");

				$data["item"] = $this->getItem(null,$data['header']['contract_id'])->result_array();

			} else {

				$data['header'] = $this->getHeaderWOProgress($jenis,$progress_id)->row_array();

				$data["item"] = $this->getItemWOProgress($progress_id)->result_array();

			}

			if(!empty($data['item'])){

				foreach ($data['item'] as $key => $value) {

					$data['item'][$key]['harga_satuan'] = inttomoney($value['harga_satuan']);
					$data['item'][$key]['jumlah'] = inttomoney($value['jumlah']);
					$data['item'][$key]['order_minimum'] = inttomoney($value['order_minimum']);
					$data['item'][$key]['order_maksimum'] = inttomoney($value['order_maksimum']);
					
				}

			}

			$contract = $this->getData($data['header']['contract_id'])->row_array();
			$data['header']['contract_amount'] = (!empty($contract)) ? inttomoney($contract['contract_amount']) : 0;

		}

		return $data;

	}

	public function getHeaderMilestoneProgress($type = "",$progress_id = ""){

		if(!empty($progress_id)){
			$this->db->where("progress_id",$progress_id);
		}

		if(!empty($type)){
			$this->db->where("type_inv",$type);
		}

		$this->db->select("b.*,a.contract_number,b.description as progress_description,c.contract_id,subject_work,
			CASE c.progress_status 
			WHEN 1 THEN 'Menunggu Persetujuan PIC User' 
			WHEN 2 THEN 'Menunggu Persetujuan Manajer User'
			WHEN 3 THEN 'Menunggu Persetujuan VP USER'
			WHEN 4 THEN 'Menunggu Persetujuan PIC BAST'
			WHEN 5 THEN 'Menunggu Persetujuan Manajer BAST'
			WHEN 6 THEN 'Finalisasi Persetujuan VP BAST'
			WHEN 99 THEN 'Revisi'
			ELSE 'Aktif' END AS activity,vendor_name,progress_id as progress_number,bastp_number,bastp_date
			")
		->join("ctr_contract_milestone c","c.milestone_id=b.milestone_id")
		->join("ctr_contract_header a","a.contract_id=c.contract_id");

		return $this->db->get("ctr_contract_milestone_progress b");
	}

	public function getHeaderWOProgress($type = "",$progress_id = ""){

		if(!empty($progress_id)){
			$this->db->where("progress_id",$progress_id);
		}

		if(!empty($type)){
			$this->db->where("type_inv",$type);
		}

		$this->db->select("b.*,c.po_number,contract_number,progress_description,subject_work,c.vendor_name,progress_id as progress_number,c.contract_id,
			CASE b.status 
			WHEN 1 THEN 'Menunggu Persetujuan PIC User' 
			WHEN 2 THEN 'Menunggu Persetujuan Manajer User'
			WHEN 3 THEN 'Menunggu Persetujuan VP USER'
			WHEN 4 THEN 'Menunggu Persetujuan PIC BAST'
			WHEN 5 THEN 'Menunggu Persetujuan Manajer BAST'
			WHEN 6 THEN 'Finalisasi Persetujuan VP BAST'
			WHEN 99 THEN 'Revisi'
			ELSE 'Aktif' END AS activity,bastp_number,bastp_date
			")
		->join("ctr_po_header c","c.po_id=b.po_id")
		->join("ctr_contract_header a","a.contract_id=c.contract_id");
		return $this->db->get("ctr_po_progress_header b");
		
	}

	public function getItemWOProgress($progress_id = ""){

		if(!empty($progress_id)){
			$this->db->where("progress_id",$progress_id);
		}

		$this->db->select("c.po_item_id as id,c.item_code as kode,c.short_description as deskripsi, c.uom as satuan, c.price as harga_satuan, approved_qty as jumlah, a.min_qty as order_minimum, a.max_qty as order_maksimum")
		->join("ctr_po_item c","c.po_item_id=b.po_item_id")
		->join("ctr_contract_item a","a.contract_item_id=c.contract_item_id","left")
		->order_by("progress_item_id","desc");
		return $this->db->get("ctr_po_progress_item b");
	}

	public function getUrutWO($tahun = ""){

		$tahun = (empty($tahun)) ? date("Y") : $tahun;

		if(!empty($tahun)){
			$this->db->where("EXTRACT(YEAR FROM created_date) =", $tahun,false);
		}

		$this->db->select("COUNT(po_id) as urut");

		$get = $this->db->get("ctr_po_header")->row()->urut;

		return "WO.".date("Ym").".".urut_id($get+1,5);

	}


	public function getUrut($tahun = "",$type = "",$type2 = "",$ishq = "",$divcode = ""){

		$this->load->model("Administration_m");

		$tahun = (empty($tahun)) ? date("Y") : $tahun;

		if(!empty($tahun)){
			$this->db->where("EXTRACT(YEAR FROM created_date) =", $tahun,false);
		}

		if(!empty($type)){
			$this->db->like("contract_number",$type);
		}

		$this->db->select("COUNT(contract_number) as urut");

		$get = $this->db->get("ctr_contract_header")->row()->urut;

		$urut = "";

		$id = urut_id($get+1,4);

		if($type != "HARGA SATUAN"){
			$urut = "SPERJ.".$id."/".$divcode."/WIKA-".$tahun;
		} else {
			if($ishq){
				$urut = "SPB/".$type2.".".$id."/DPBJ-Pusat/".romanic_number(date("m"),true)."/WIKA-".$tahun;
			} else {
				$urut = "SPB/".$type2.".".$id."/DPBJ-".$divcode."/".romanic_number(date("m"),true)."/WIKA-".$tahun;
			}
		}

		return $urut;
		//return $type.".".date("Ym").".".urut_id($get+1,5);

	}

	public function getData($contract_id = "",$ptm_number = ""){

		if(!empty($ptm_number)){

			$this->db->where("ptm_number",$ptm_number);

		}

		if(!empty($contract_id)){

			$this->db->where("contract_id",$contract_id);

		}

		$this->db->order_by("contract_id","desc");

		return $this->db->get("ctr_contract_header");

	}

	public function getDataWO($po_id = "",$contract_id = ""){

		if(!empty($contract_id)){

			$this->db->where("contract_id",$contract_id);

		}

		if(!empty($po_id)){

			$this->db->where("po_id",$po_id);

		}

		$this->db->order_by("po_id","desc");

		return $this->db->get("ctr_po_header");

	}

	public function getWOItem($po_item_id = "",$po_id = ""){

		$this->db->select("b.*,a.min_qty,a.max_qty");

		if(!empty($po_item_id)){

			$this->db->where("po_item_id",$po_item_id);

		}

		if(!empty($po_id)){

			$this->db->where("po_id",$po_id);

		}

		$this->db->join("ctr_contract_item a","a.contract_item_id=b.contract_item_id","left");

		$this->db->order_by("po_item_id","desc");

		return $this->db->get("ctr_po_item b");

	}

	public function getItem($tit_id = "",$contract_id = ""){

		if(!empty($tit_id)){

			$this->db->where("tit_id",$tit_id);

		}

		if(!empty($contract_id)){

			$this->db->where("contract_id",$contract_id);

		}

		$this->db->order_by("contract_id","desc");

		return $this->db->get("ctr_contract_item");

	}

	public function getMilestone($milestone_id = "",$contract_id = ""){

		if(!empty($milestone_id)){

			$this->db->where("milestone_id",$milestone_id);

		}

		if(!empty($contract_id)){

			$this->db->where("contract_id",$contract_id);

		}

		$this->db->order_by("milestone_id","asc");

		return $this->db->get("ctr_contract_milestone");

	}

	public function getInvoice($invoice_id = "",$contract_id = ""){

		if(!empty($invoice_id)){

			$this->db->where("invoice_id",$invoice_id);

		}

		if(!empty($contract_id)){

			$this->db->where("contract_id",$contract_id);

		}

		$this->db->order_by("invoice_id","asc");

		return $this->db->get("ctr_invoice_header");

	}

	public function getInvoiceMilestone($invoice_id = "",$contract_id = ""){

		if(!empty($invoice_id)){

			$this->db->where("invoice_id",$invoice_id);

		}

		if(!empty($contract_id)){

			$this->db->where("contract_id",$contract_id);

		}

		$this->db->order_by("invoice_id","asc");

		return $this->db->get("ctr_invoice_milestone_header");

	}

	public function getInvoiceItem($milestone_id = "",$invoice_id = ""){

		$this->db->select("ctr_invoice_item.*,ctr_contract_milestone.description,ctr_contract_milestone.percentage,ctr_contract_milestone.target_date");

		if(!empty($milestone_id)){

			$this->db->where("ctr_invoice_item.milestone_id",$milestone_id);

		}

		if(!empty($invoice_id)){

			$this->db->where("ctr_invoice_item.invoice_id",$invoice_id);

		}

		$this->db->join("ctr_contract_milestone","ctr_contract_milestone.milestone_id=ctr_invoice_item.milestone_id","left");

		$this->db->order_by("invoice_item_id","asc");

		return $this->db->get("ctr_invoice_item");

	}

	public function getInvoiceDoc($doc_id = "",$invoice_id = ""){

		if(!empty($invoice_id)){

			$this->db->where("invoice_id",$invoice_id);

		}

		if(!empty($doc_id)){

			$this->db->where("doc_id",$doc_id);

		}

		$this->db->order_by("doc_id","asc");

		return $this->db->get("ctr_invoice_doc");

	}

	public function getMilestoneProgress($progress_id = "",$milestone_id = ""){

		if(!empty($progress_id)){

			$this->db->where("progress_id",$progress_id);

		}

		if(!empty($milestone_id)){

			$this->db->where("milestone_id",$milestone_id);

		}

		$this->db->order_by("progress_id","asc");
		$this->db->join("ctr_contract_milestone c","c.milestone_id=a.milestone_id");
		$this->db->join("ctr_contract_header b","b.contract_id=c.contract_id");

		return $this->db->get("ctr_contract_milestone_progress a");

	}


	public function getMilestoneComment($comment_id = "",$milestone_id = ""){

		if(!empty($comment_id)){

			$this->db->where("comment_id",$comment_id);

		}

		if(!empty($milestone_id)){

			$this->db->where("milestone_id",$milestone_id);

		}

		$this->db->order_by("comment_id","asc");

		return $this->db->get("ctr_contract_milestone_comment");

	}

	public function getDoc($doc_id = "",$contract_id = ""){

		if(!empty($doc_id)){

			$this->db->where("doc_id",$doc_id);

		}

		if(!empty($contract_id)){

			$this->db->where("contract_id",$contract_id);

		}

		$this->db->order_by("doc_id","asc");

		return $this->db->get("ctr_contract_doc");

	}

	public function replaceDoc($id,$input){

		if(!empty($input)){

			if(!empty($id)){

				$this->db->where(array("contract_id"=>$input['contract_id'],"doc_id"=>$id));
				$check = $this->getDoc()->row_array();
				if(!empty($check)){
					$last_id = $check['doc_id'];
					$this->updateDoc($last_id,$input);
				} else {
					$this->insertDoc($input);
					$last_id = $this->db->insert_id();
				}

			} else {
				$this->insertDoc($input);
				$last_id = $this->db->insert_id();
			}

			return $last_id;

		}

	}

	public function updateDoc($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('doc_id',$id)->update('ctr_contract_doc',$input);

			return $this->db->affected_rows();

		}

	}


	public function insertDoc($input){

		if (!empty($input)){

			unset($input['doc_id']);

			$this->db->insert("ctr_contract_doc",$input);

			return $this->db->affected_rows();

		}

	}

	public function deleteIfNotExistDoc($id,$deleted){
		if(!empty($id) && !empty($deleted)){
			$this->db->where(array("filename"=>"","contract_id"=>$id))->delete("ctr_contract_doc");
			$this->db->where_not_in("doc_id",$deleted)->where("contract_id",$id)->delete("ctr_contract_doc");
			return $this->db->affected_rows();
		}
	}

	public function getDocType(){

		$this->db->order_by("cdt_id","asc");

		return $this->db->get("ctr_doc_type");

	}


	public function insertData($input=array()){

		if (!empty($input)){

			$this->db->insert("ctr_contract_header",$input);

			return $this->db->affected_rows();
		}

	}

	public function insertItem($input=array()){

		if (!empty($input)){

			$this->db->insert("ctr_contract_item",$input);

			return $this->db->affected_rows();
		}

	}

	public function updateData($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('contract_id',$id)->update('ctr_contract_header',$input);

			return $this->db->affected_rows();

		}

	}

	public function insertWOData($input=array()){

		if (!empty($input)){

			$this->db->insert("ctr_po_header",$input);

			return $this->db->affected_rows();
		}

	}

	public function updateWOData($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('po_id',$id)->update('ctr_po_header',$input);

			return $this->db->affected_rows();

		}

	}

	public function getPekerjaan($id = "",$user = ""){

		//$this->db->select("B.*,A.ccc_id,A.ccc_activity");

		if(!empty($id)){

			$this->db->where("A.contract_id",$id);

		}

		$this->db->join("prc_tender_main D","A.ptm_number = D.ptm_number","LEFT");

		$this->db->join("ctr_contract_header B","B.contract_id = A.contract_id","LEFT");

		$this->db->join("adm_wkf_activity C","C.awa_id = A.ccc_activity","left");

		$this->db->where(array("A.ccc_name"=>null,"A.ccc_end_date"=>null));

		$this->db->where_not_in("A.ccc_activity",array(2902,2903));

		if(!empty($user)){

			$this->db->group_start();

			$this->db->where("A.ccc_user",null);
			
			$this->db->or_where("A.ccc_user",$user);
			
			$this->db->group_end();

		}
		
		return $this->db->get("ctr_contract_comment A");

	}

	public function getPekerjaanWO($id = "",$user = ""){

		if(!empty($id)){

			$this->db->where("A.po_id",$id);

		}

		$this->db->join("ctr_po_header B","B.po_id =". (int)"A.po_id","LEFT");

		$this->db->join("ctr_contract_header D","D.contract_id = A.contract_id","LEFT");

		$this->db->join("adm_wkf_activity C","C.awa_id = A.cwo_activity","left");

		$this->db->where(array("A.cwo_name"=>null,"A.cwo_end_date"=>null));

		$this->db->where_not_in("A.cwo_activity",array(2902,2903));

		$this->db->group_start();
		$this->db->where("A.cwo_user",null);
		$this->db->or_where("A.cwo_user",!empty($user) ? $user : null);
		$this->db->group_end();

		return $this->db->get("ctr_po_comment A");

	}

	public function insertMilestone($input=array()){

		if (!empty($input)){

			unset($input['milestone_id']);

			$this->db->insert("ctr_contract_milestone",$input);

			return $this->db->affected_rows();
		}

	}

	public function updateMilestone($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('milestone_id',$id)->update('ctr_contract_milestone',$input);

			return $this->db->affected_rows();

		}

	}

	public function replaceMilestone($id,$input){

		if(!empty($input)){

			if(!empty($id)){

				$this->db->where(array("contract_id"=>$input['contract_id'],"milestone_id"=>$id));
				$check = $this->getMilestone()->row_array();
				if(!empty($check)){
					$last_id = $check['milestone_id'];
					$this->updateMilestone($last_id,$input);
				} else {
					$this->insertMilestone($input);
					$last_id = $this->db->insert_id();
				}

			} else {
				$this->insertMilestone($input);
				$last_id = $this->db->insert_id();
			}

			return $last_id;

		}

	}

	public function insertWOItem($input=array()){

		if (!empty($input)){

			$this->db->insert("ctr_po_item",$input);

			return $this->db->affected_rows();
		}

	}

	public function updateWOItem($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('po_item_id',$id)->update('ctr_po_item',$input);

			return $this->db->affected_rows();

		}

	}

	public function replaceWOItem($id,$input){

		if(!empty($input)){

			if(!empty($id)){

				$this->db->where(array("po_id"=>$input['po_id'],"po_item_id"=>$id));
				$check = $this->getWOItem()->row_array();
				if(!empty($check)){
					$last_id = $check['po_item_id'];
					$this->updateWOItem($last_id,$input);
				} else {
					$this->insertWOItem($input);
					$last_id = $this->db->insert_id();
				}

			} else {
				$this->insertWOItem($input);
				$last_id = $this->db->insert_id();
			}

			return $last_id;

		}

	}

	public function getMonitor($id = ""){

		if(!empty($id)){

			$this->db->where("contract_id",$id);

		}

		return $this->db->get("vw_ctr_monitor");

	}

	public function deleteIfNotExistWOItem($id,$deleted){
		if(!empty($id) && !empty($deleted)){
			$this->db->where_not_in("po_item_id",$deleted)->where("po_id",$id)->delete("ctr_po_item");
			return $this->db->affected_rows();
		}
	}


	public function deleteIfNotExistMilestone($id,$deleted){
		if(!empty($id) && !empty($deleted)){
			$this->db->where_not_in("milestone_id",$deleted)->where("contract_id",$id)->delete("ctr_contract_milestone");
			return $this->db->affected_rows();
		}
	}


}