<?php 

$userdata = $this->data['userdata'];

$post = $this->input->post();

$input = array();

$message = "";

if(!empty($post) && !empty($post['komentar_milestone_inp']) ){

	$input = array(
		"milestone_id"=>$post['milestone_id'],
		"comment_name"=> $userdata['complete_name'],
		"comment_date"=>date("Y-m-d H:i:s"),
		"comments"=>$post['komentar_milestone_inp']
		);

	$this->db->insert("ctr_contract_milestone_comment",$input);

} else {
	$message = "Isi data komentar milestone";
}

$this->output
->set_content_type('application/json')
->set_output(json_encode(array('message' => $message)));