<?php 

$post = $this->input->post();

$view = 'contract/proses_progress/proses_invoice_milestone_v';

$position = $this->Administration_m->getPosition("PIC USER");

/*
if(!$position){
  $this->noAccess("Hanya PIC USER yang dapat membuat tender pengadaan");
}
*/

$milestone_id = (int) $id;
$data['id'] = $milestone_id;


$data["header"] = $this->db
->select("*,CASE e.bastp_status 
	WHEN 1 THEN 'Persetujuan INVOICE Milestone'  
	WHEN 2 THEN 'Persetujuan INVOICE Milestone' 
	WHEN 99 THEN 'Revisi'
	ELSE 'Aktif' END AS activity")
->where(array("milestone_id"=>$id))
->join("ctr_contract_header c","c.contract_id=e.contract_id","left")
->get("ctr_contract_milestone e")
->row_array();

$data['header_invoice'] = $this->db->query("SELECT *, b.percentage,b.progress_percentage,c.contract_amount, b.description,a.denda_invoice,a.acc_invoice
	from ctr_invoice_milestone_header a
	join ctr_contract_milestone b on b.milestone_id=a.milestone_id
	join ctr_contract_header c on c.contract_id = a.contract_id
	where a.milestone_id ='".$id."'")->row_array();

$data['viewer'] = (empty($data['header_invoice']['denda_invoice']) && !empty($data['header_invoice']['invoice_status']));

//lampiran
$this->db->select("*")
->where("invoice_id",$data['header_invoice']['invoice_id']);
$data['lampiranList'] = $this->db->get("ctr_invoice_milestone_doc")->result_array();


$this->db->select("*")
->where("invoice_id",$data['header_invoice']['invoice_id']);
$data['document'] = $this->db->get("ctr_invoice_milestone_doc")->row_array();

$data['lampiran'] = (empty($data['document']['invoice_id']));	


$data["item"] = $this->db
->where(array("a.milestone_id"=>$milestone_id))
->get("ctr_contract_milestone_progress a")
->result_array();

$data["comment_list"] = $this->db->order_by("comment_id","desc")
->where("milestone_id",$milestone_id)->get("ctr_contract_milestone_comment")->result_array();

$this->template($view,"Milestone - ".$data['header']['activity'],$data);