<?php 

$post = $this->input->post();

$input = array();

$message = "";

if(!empty($post) && !empty($post['tgl_progress_inp']) && !empty($post['deskripsi_milestone_inp']) && !empty($post['progress_milestone_inp'])){

	$check = $this->db
	->where(array("milestone_id"=>$post['milestone_id'],"percentage"=>100))
	->get("ctr_contract_milestone_progress")->num_rows();

	if(empty($check)){

		$percentage = moneytoint($post['progress_milestone_inp']);

		if($percentage <= 100){

			$input = array(
				"milestone_id"=>$post['milestone_id'],
				"progress_date"=>$post['tgl_progress_inp'],
				"description"=>$post['deskripsi_milestone_inp'],
				"attachment"=>$post['milestone_file_inp'],
				"percentage"=>$percentage
				);

			$input2 = array(
				"progress_percentage"=>$percentage,
				"progress_description"=>$post['deskripsi_milestone_inp'],
				);

			if($percentage == 100){
				$input['status'] = "A";
				$input2['progress_status'] = "A";
			}

			$act = $this->db->insert("ctr_contract_milestone_progress",$input);

			if($act){

				$this->db
				->where(array("milestone_id"=>$post['milestone_id']))
				->update("ctr_contract_milestone",$input2);

			}

		} else {
			$message = 'Progress tidak boleh lebih dari 100%';
		}

	} else {
		$message = 'Progress tidak dapat diupdate karena progress sudah 100%';
	}

} else {
	$message = "Isi data progress milestone";
}

$this->output
->set_content_type('application/json')
->set_output(json_encode(array('message' => $message)));