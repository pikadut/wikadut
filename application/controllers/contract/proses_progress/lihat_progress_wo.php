<?php 

$post = $this->input->post();

$view = 'contract/proses_progress/proses_progress_wo_v';

$position = $this->Administration_m->getPosition("PIC USER");

/*
if(!$position){
  $this->noAccess("Hanya PIC USER yang dapat membuat tender pengadaan");
}
*/

$data['id'] = $id;

$data['readonly'] = true;

$this->db->select("b.*,
	CASE b.status 
	WHEN 1 THEN 'Persetujuan Progress WO'  
	WHEN 2 THEN 'Persetujuan Progress WO' 
	WHEN 3 THEN 'Persetujuan Progress WO' 
	WHEN 4 THEN 'Persetujuan Progress WO' 
	WHEN 5 THEN 'Persetujuan Progress WO' 
	WHEN 6 THEN 'Persetujuan Progress WO' 
	WHEN 99 THEN 'Revisi'
	ELSE 'Aktif' END AS activity,a.contract_number,d.fullname,c.vendor_name,c.start_date,c.end_date,po_notes,c.contract_id,b.status as progress_status")
->join("ctr_po_header c","c.po_id=b.po_id")
->join("adm_employee d","d.id=c.creator_employee")
->join("ctr_contract_header a","a.contract_id=c.contract_id")
->where("progress_id",$id);
$data['header'] = $this->db->get("ctr_po_progress_header b")->row_array();

$this->db->select("c.*,a.min_qty,a.max_qty,b.*")
->where("progress_id",$id)
->join("ctr_po_item c","c.po_item_id=b.po_item_id")
->join("ctr_contract_item a","a.contract_item_id=c.contract_item_id","left")
->order_by("progress_item_id","desc");
$data["item"] = $this->db->get("ctr_po_progress_item b")->result_array();

//lampidan
$this->db->select("*")
->where("progress_id",$data['header']['progress_id']);
$data['lampiranList'] = $this->db->get("ctr_po_progress_doc")->result_array();

$data['document'] = $this->db->select('*')->where('progress_id',$data['header']['progress_id'])->get('ctr_po_progress_doc')->row_array();

$data['lampiran'] = (!empty($data['document']['progress_id']));

$data["comment_list"] = $this->db->order_by("comment_id","desc")
->where("progress_id",$id)->get("ctr_po_progress_comment")
->result_array();

$data['progress_type'] = array(""=>"","INV"=>"Inventory","AST"=>"Aset");

$this->template($view,"Detail Progress Work Order (".$data['header']['activity'].")",$data);