<?php

$x = $this->session->userdata("selected_progress");

if(!empty($id)){

	$this->session->set_userdata("selected_progress",$id);

	$x = $id;

}

$progress = array();

if(!empty($x)){

	$exp = explode("_", $x);

	$ctr_type = $exp[0];

	$progress_id = $exp[1];

	$progress = $this->Contract_m->getProgress($progress_id,$ctr_type,strtoupper($type));

	$progress['type'] = $ctr_type;


}

echo json_encode($progress);