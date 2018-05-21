<?php

$post = $this->input->post();
  $last_id = $post['id'];

$input = array();

$key2 = 0;

$userdata = $this->data['userdata'];

$this->form_validation->set_rules("status_inp[$key2]", "lang:status #$key2", 'required');
$this->form_validation->set_rules("comment_inp[$key2]", "lang:comment #$key2", 'required|max_length['.DEFAULT_MAXLENGTH_TEXT.']');

$status = $post['status_inp'];

if($status == 2 || $status == 3){
  $input['ppm_approved_date'] = date("Y-m-d H:i:s");
  $input['ppm_approved_pos_code'] = $userdata['pos_id'];
  $input['ppm_approved_pos_name'] = $userdata['pos_name'];
}

$status = $post['status_inp'][$key2];

$get = $this->Procplan_m->getPerencanaanPengadaan($last_id)->row_array();

$wkf = array(1=>"Ditolak",2=>"Setuju",3=>"Setuju",4=>"Tolak");

$activity_list = array(1=>"Permintaan Persetujuan VP",2=>"Permintaan Persetujuan PIC Anggaran", 3=>"Permintaan Persetujuan PIC Anggaran");

$response = $wkf[$status];

$activity = $activity_list[$get['ppm_status']];

$com = $post['comment_inp'][$key2];

$input['ppm_status']=$status;

$input_comment = array();


if ($this->form_validation->run() == FALSE){

  $this->renderMessage("error");

  //$this->approval_perencanaan_pengadaan();

} else {

  $this->db->trans_begin();

  $act = $this->Procplan_m->updateDataPerencanaanPengadaan($last_id,$input);

  //echo $this->db->last_query();

  if($act){
    $dateopen = $this->input->post('dateopen');

    $this->Comment_m->insertProcurementPlan($last_id,$com,$response,$activity,$dateopen);

    //haqim mail drp send

      $this->Procedure_m->prc_plan_comment_complete($last_id,$get['ppm_dept_name'],$get['ppm_planner_pos_name'],"APPROVAL PERENCANAAN PENGADAAN",$get['ppm_planner'],$status[0]);
    
    //end

    //echo $this->db->last_query();

  }

  if ($this->db->trans_status() === FALSE)
  {
    $this->setMessage("Gagal approve data");
    $this->db->trans_rollback();
  }
  else
  {
    $this->setMessage("Sukses approve data");
    $this->db->trans_commit();
  }

  $this->renderMessage("success",site_url("procurement/perencanaan_pengadaan/rekapitulasi_perencanaan_pengadaan"));

}
