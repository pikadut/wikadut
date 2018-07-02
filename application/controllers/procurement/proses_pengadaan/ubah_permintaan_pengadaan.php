<?php 

$post = $this->input->post();

$view = 'procurement/proses_pengadaan/ubah_permintaan_pengadaan_v';

$position = $this->Administration_m->getPosition("PIC USER");

/*

if(!$position){
  $this->noAccess("Hanya PIC USER yang dapat membuat permintaan pengadaan");
}

*/

$this->db->where("job_title","PELAKSANA PENGADAAN");

$data['pelaksana_pengadaan'] = $this->Administration_m->getUserRule()->result_array();

$id = (isset($post['id'])) ? $post['id'] : $this->uri->segment(4, 0);

$data['id'] = $id;

$data['pos'] = $position;

$this->data['dir'] = PROCUREMENT_PERMINTAAN_PENGADAAN_FOLDER;

//$data['del_point_list'] = $this->Administration_m->getDelPoint()->result_array();
$data['del_point_list'] = $this->Administration_m->get_divisi_departemen()->result_array();

$data['district_list'] = $this->Administration_m->getDistrict()->result_array();

$data['contract_type'] = array("LUMPSUM"=>"LUMPSUM");

$last_comment = $this->Comment_m->getProcurementPR("",$id)->row_array();

$pr_number = $last_comment['tender_id'];

$permintaan = $this->Procpr_m->getPR($pr_number)->row_array();

$data['last_comment'] = $last_comment;

$data['permintaan'] = $permintaan;

$activity_id = (!empty($last_comment['activity'])) ? $last_comment['activity'] : 1001;

$activity = $this->Procedure_m->getActivity($activity_id)->row_array();

$data['content'] = $this->Workflow_m->getContentByActivity($activity_id)->result_array();

$data['workflow_list'] = $this->Procedure_m->getResponseList($activity['awa_id']);

$data["comment_list"][0] = $this->Comment_m->getProcurementPRActive($pr_number)->result_array();

$data['document'] = $this->Procpr_m->getDokumenPR("",$pr_number)->result_array();

$data['item'] = $this->Procpr_m->getItemPR("",$pr_number)->result_array();

$data['penata_perencana'] = $this->Administration_m->getUserByJob("PENATA PERENCANAAN")->result_array();

$data['pr_type'] = array("KONSOLIDASI" => "KONSOLIDASI", "NON KONSOLIDASI" => "NON KONSOLIDASI", "MATERIAL STRATEGIS" => "MATERIAL STRATEGIS"); //y tipe pr

//$this->template($view,$activity['awa_name'],$data);
$this->template($view,$activity['awa_name']." (".$activity['awa_id'].")",$data);