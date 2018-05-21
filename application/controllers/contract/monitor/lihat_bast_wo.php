<?php 

$post = $this->input->post();

$view = 'contract/proses_progress/proses_bast_wo_v';

$position = $this->Administration_m->getPosition("PIC USER");

/*
if(!$position){
  $this->noAccess("Hanya PIC USER yang dapat membuat tender pengadaan");
}
*/

$data['id'] = $id;
$data['readonly'] = true;

$this->db->select("*,
	CASE bastp_status 
	WHEN 1 THEN 'Persetujuan BAST WO'  
	WHEN 2 THEN 'Persetujuan BAST WO' 
	WHEN 3 THEN 'Persetujuan BAST WO' 
	WHEN 4 THEN 'Persetujuan BAST WO' 
	WHEN 5 THEN 'Persetujuan BAST WO' 
	WHEN 6 THEN 'Persetujuan BAST WO' 
	WHEN 99 THEN 'Revisi'
	ELSE 'Aktif' END AS activity")
->join("ctr_po_header c","c.po_id=b.po_id")
->join("adm_employee d","d.id=c.creator_employee")
->join("ctr_contract_header a","a.contract_id=c.contract_id")
->where("b.po_id",$id);
$data['header'] = $this->db->get("ctr_po_progress_header b")->row_array();

$this->db->select("c.*,a.min_qty,a.max_qty,b.*")
->where("po_id",$id)
->join("ctr_po_item c","c.po_item_id=b.po_item_id")
->join("ctr_contract_item a","a.contract_item_id=c.contract_item_id","left")
->order_by("progress_item_id","desc");
$data["item"] = $this->db->get("ctr_po_progress_item b")->result_array();

$data["comment_list"] = $this->db->order_by("comment_id","desc")->where("a.po_id",$id)
->join("ctr_po_progress_header a","a.progress_id=b.progress_id")->get("ctr_po_progress_comment b")->result_array();
$this->template($view,"Detail BAST Work Order (".$data['header']['activity'].")",$data);