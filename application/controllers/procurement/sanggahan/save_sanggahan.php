<?php 

$userdata = $this->data['userdata'];

$post = $this->input->post();

$input = array();

if(!empty($post)){

	$input['pcl_jwb_no'] = $post['no_jawaban_sanggahan_inp'];
	$input['pcl_jwb_judul'] = $post['judul_jawaban_sanggahan_inp'];
	$input['pcl_jwb_isi'] = $post['jawaban_sanggahan_inp'];
	$input['pcl_status'] = $post['status_sanggahan_inp'];
	$input['pcl_jwb_attachment'] = $post['attachment_sanggahan_inp'];
	$input['current_approver_pos'] = $userdata['pos_id'];
	$input['current_approver_name'] = $userdata['complete_name'];
	$this->db->where("pcl_id",$post['sanggahan_inp'])->update("prc_tender_claim",$input);
}