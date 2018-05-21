
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Addendum_m extends CI_Model {

	public function __construct(){

		parent::__construct();

	}

	public function getammendNew($id = ""){

		if(!empty($id)){

			$this->db->where("ptm_number",$id);

		}

		$this->db->where("ptm_status",1901);

		return $this->db->get("vw_prc_monitor");

	}

	public function getUrut($tahun = "",$type = ""){

		$tahun = (empty($tahun)) ? date("Y") : $tahun;

		if(!empty($tahun)){
			$this->db->where("EXTRACT(YEAR FROM created_date) =", $tahun,false);
		}

		if(!empty($type)){
			$this->db->like("ammend_number",$type);
		}

		$this->db->select("COUNT(ammend_number) as urut");

		$get = $this->db->get("ctr_ammend_header")->row()->urut;

		return $type.".".date("Ym").".".urut_id($get+1,5);

	}

	public function getData($ammend_id = "",$contract_id = ""){

		$this->db->select("ctr_ammend_header.*,ctr_contract_header.vendor_name");

		if(!empty($contract_id)){

			$this->db->where("contract_id",$contract_id);

		}

		if(!empty($ammend_id)){

			$this->db->where("ammend_id",$ammend_id);

		}

		$this->db->join("ctr_contract_header","ctr_contract_header.contract_id=ctr_ammend_header.contract_id");
		$this->db->order_by("ammend_id","desc");

		return $this->db->get("ctr_ammend_header");

	}

	public function getItem($tit_id = "",$ammend_id = ""){

		if(!empty($tit_id)){

			$this->db->where("tit_id",$tit_id);

		}

		if(!empty($ammend_id)){

			$this->db->where("ammend_id",$ammend_id);

		}

		$this->db->order_by("ammend_id","desc");

		return $this->db->get("ctr_ammend_item");

	}

	public function getMilestone($ammend_milestone_id = "",$ammend_id = ""){

		if(!empty($ammend_milestone_id)){

			$this->db->where("ammend_milestone_id",$ammend_milestone_id);

		}

		if(!empty($ammend_id)){

			$this->db->where("ammend_id",$ammend_id);

		}

		$this->db->order_by("ammend_milestone_id","asc");

		return $this->db->get("ctr_ammend_milestone");

	}

	public function getInvoice($invoice_id = "",$ammend_id = ""){

		if(!empty($invoice_id)){

			$this->db->where("invoice_id",$invoice_id);

		}

		if(!empty($ammend_id)){

			$this->db->where("ammend_id",$ammend_id);

		}

		$this->db->order_by("invoice_id","asc");

		return $this->db->get("ctr_invoice_header");

	}

	public function getInvoiceItem($ammend_milestone_id = "",$invoice_id = ""){

		$this->db->select("ctr_invoice_item.*,ctr_ammend_milestone.description,ctr_ammend_milestone.percentage,ctr_ammend_milestone.target_date");

		if(!empty($ammend_milestone_id)){

			$this->db->where("ctr_invoice_item.ammend_milestone_id",$ammend_milestone_id);

		}

		if(!empty($invoice_id)){

			$this->db->where("ctr_invoice_item.invoice_id",$invoice_id);

		}

		$this->db->join("ctr_ammend_milestone","ctr_ammend_milestone.ammend_milestone_id=ctr_invoice_item.ammend_milestone_id","left");

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

		public function getMilestoneProgress($progress_id = "",$ammend_milestone_id = ""){

		if(!empty($progress_id)){

			$this->db->where("progress_id",$progress_id);

		}

		if(!empty($ammend_milestone_id)){

			$this->db->where("ammend_milestone_id",$ammend_milestone_id);

		}

		$this->db->order_by("progress_id","asc");

		return $this->db->get("ctr_ammend_milestone_progress");

	}


		public function getMilestoneComment($comment_id = "",$ammend_milestone_id = ""){

		if(!empty($comment_id)){

			$this->db->where("comment_id",$comment_id);

		}

		if(!empty($ammend_milestone_id)){

			$this->db->where("ammend_milestone_id",$ammend_milestone_id);

		}

		$this->db->order_by("comment_id","asc");

		return $this->db->get("ctr_ammend_milestone_comment");

	}


	public function replaceDoc($id,$input){

		if(!empty($input)){

			if(!empty($id)){

				$this->db->where(array("ammend_id"=>$input['ammend_id'],"doc_id"=>$id));
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

			$this->db->where('doc_id',$id)->update('ctr_ammend_doc',$input);

			return $this->db->affected_rows();

		}

	}


	public function insertDoc($input){

		if (!empty($input)){

			unset($input['doc_id']);

			$this->db->insert("ctr_ammend_doc",$input);

			return $this->db->affected_rows();

		}

	}

	public function deleteIfNotExistDoc($id,$deleted){
		if(!empty($id) && !empty($deleted)){
			$this->db->where(array("filename"=>"","ammend_id"=>$id))->delete("ctr_ammend_doc");
			$this->db->where_not_in("doc_id",$deleted)->where("ammend_id",$id)->delete("ctr_ammend_doc");
			return $this->db->affected_rows();
		}
	}

	public function getDocType(){

		$this->db->order_by("cdt_id","asc");

		return $this->db->get("ctr_doc_type");

	}


	public function insertData($input=array()){

		if (!empty($input)){

			$this->db->insert("ctr_ammend_header",$input);

			return $this->db->affected_rows();
		}
		
	}

	public function insertItem($input=array()){

		if (!empty($input)){

			$this->db->insert("ctr_ammend_item",$input);

			return $this->db->affected_rows();
		}
		
	}

	public function updateData($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('ammend_id',$id)->update('ctr_ammend_header',$input);

			return $this->db->affected_rows();

		}

	}

	public function getPekerjaan($id = ""){

		$this->db->select("B.*,A.cac_id,A.cac_activity");

		if(!empty($id)){

			$this->db->where("A.ammend_id",$id);

		}

		//$this->db->join("prc_tender_main B","B.ptm_number = A.ptm_number","LEFT");

		$this->db->join("vw_ammend_header B","B.ammend_id = A.ammend_id","LEFT");

		$this->db->where(array("A.cac_name"=>null,"A.cac_end_date"=>null));

		$this->db->where_not_in("A.cac_activity",array(3901,3902));

		return $this->db->get("ctr_ammend_comment A");

	}

		public function insertMilestone($input=array()){

		if (!empty($input)){

			unset($input['ammend_milestone_id']);

			$this->db->insert("ctr_ammend_milestone",$input);

			return $this->db->affected_rows();
		}
		
	}

		public function updateMilestone($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('ammend_milestone_id',$id)->update('ctr_ammend_milestone',$input);

			return $this->db->affected_rows();

		}

	}

		public function replaceMilestone($id,$input){

		if(!empty($input)){

			if(!empty($id)){

				$this->db->where(array("ammend_id"=>$input['ammend_id'],"ammend_milestone_id"=>$id));
				$check = $this->getMilestone()->row_array();
				if(!empty($check)){
					$last_id = $check['ammend_milestone_id'];
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

	public function deleteIfNotExistMilestone($id,$deleted){
		if(!empty($id) && !empty($deleted)){
			$this->db->where_not_in("ammend_milestone_id",$deleted)->where("ammend_id",$id)->delete("ctr_ammend_milestone");
			return $this->db->affected_rows();
		}
	}


}