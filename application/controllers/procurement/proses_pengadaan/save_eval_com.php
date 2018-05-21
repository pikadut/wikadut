<?php 

$this->load->model("Vendor_m");

$post = $this->input->post();

if(!empty($post)){

$input = array();

$userdata = $this->Administration_m->getLogin();

$ptm_number = $this->session->userdata("rfq_id");
$vendor_id = $post['vendor_eval_inp'];
$vendor_name = $this->Vendor_m->getVendor($vendor_id)->row()->vendor_name;

$input = array(
	"ptm_number"=>$ptm_number,
	"pec_name"=>$userdata['complete_name'],
	"pec_vendor_code"=>$vendor_id,
	"pec_vendor_name"=>$vendor_name,
	"pec_datetime"=>date("Y-m-d H:i:s"),
	"pec_comment"=>$post['comment_eval_inp'],
	"pec_mode"=>$post['type_eval_inp']
);

$this->Procrfq_m->insertEvalComRFQ($input);

}