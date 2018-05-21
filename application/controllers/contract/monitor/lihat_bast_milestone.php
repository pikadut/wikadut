<?php 

$post = $this->input->post();

$view = 'contract/proses_progress/proses_bast_milestone_v';

$position = $this->Administration_m->getPosition("PIC USER");

/*
if(!$position){
  $this->noAccess("Hanya PIC USER yang dapat membuat tender pengadaan");
}
*/

$milestone_id = (int) $id;
$data['id'] = $milestone_id;
$data['readonly'] = true;


$data["header"] = $this->db
->select("*,CASE e.bastp_status 
	WHEN 1 THEN 'Persetujuan BAST Milestone'  
	WHEN 2 THEN 'Persetujuan BAST Milestone' 
	WHEN 3 THEN 'Persetujuan BAST Milestone' 
	WHEN 4 THEN 'Persetujuan BAST Milestone' 
	WHEN 5 THEN 'Persetujuan BAST Milestone' 
	WHEN 6 THEN 'Persetujuan BAST Milestone' 
	WHEN 99 THEN 'Revisi'
	ELSE 'Aktif' END AS activity")
->where(array("milestone_id"=>$id))
->join("ctr_contract_header c","c.contract_id=e.contract_id","left")
->get("ctr_contract_milestone e")
->row_array();

$data["item"] = $this->db
->where(array("a.milestone_id"=>$milestone_id))
->get("ctr_contract_milestone_progress a")
->result_array();

$data["comment_list"] = $this->db->order_by("comment_id","desc")
->where("milestone_id",$milestone_id)->get("ctr_contract_milestone_comment")->result_array();

$this->template($view,"Detail BAST Milestone (".$data['header']['activity'].")",$data);