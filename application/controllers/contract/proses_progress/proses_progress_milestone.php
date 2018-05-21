<?php 

$post = $this->input->post();

$view = 'contract/proses_progress/proses_progress_milestone_v';

$position = $this->Administration_m->getPosition("PIC USER");

/*
if(!$position){
  $this->noAccess("Hanya PIC USER yang dapat membuat tender pengadaan");
}
*/

$data['id'] = $id;

$data["header"] = $this->db
->select("*,CASE e.progress_status 
	WHEN 1 THEN 'Persetujuan Progress Milestone'  
	WHEN 2 THEN 'Persetujuan Progress Milestone' 
	WHEN 3 THEN 'Persetujuan Progress Milestone' 
	WHEN 4 THEN 'Persetujuan Progress Milestone' 
	WHEN 5 THEN 'Persetujuan Progress Milestone' 
	WHEN 6 THEN 'Persetujuan Progress Milestone' 
	WHEN 99 THEN 'Revisi'
	ELSE 'Aktif' END AS activity,b.percentage as percentage_progress,type_inv,e.progress_status")
->where(array("b.progress_id"=>$id))
->join("ctr_contract_milestone e","e.milestone_id=b.milestone_id","left")
->join("ctr_contract_header c","c.contract_id=e.contract_id","left")
->get("ctr_contract_milestone_progress b")
->row_array();

$milestone_id = (int) $data['header']['milestone_id'];

//lampidan
$this->db->select("*")
->where("milestone_id",$data['header']['milestone_id']);
$data['lampiranList'] = $this->db->get("ctr_contract_milestone_progress_doc")->result_array();

$data['document'] = $this->db->select('*')->where('milestone_id',$data['header']['milestone_id'])->get('ctr_contract_milestone_progress_doc')->row_array();

$data['lampiran'] = (empty($data['document']['milestone_id']));

$data["item"] = $this->db
->where(array("a.milestone_id"=>$milestone_id))
->get("ctr_contract_milestone_progress a")
->result_array();

$data["comment_list"] = $this->db->order_by("comment_id","desc")
->where("milestone_id",$milestone_id)->get("ctr_contract_milestone_comment")->result_array();

$data['progress_type'] = array(""=>"Pilih","INV"=>"Inventory","AST"=>"Aset","BHP"=>"BHP");

$this->template($view,"Progress Milestone - ".$data['header']['activity'],$data);