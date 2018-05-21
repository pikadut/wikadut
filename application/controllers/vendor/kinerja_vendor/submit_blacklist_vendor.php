<?php 

$post= $this->input->post();
$id=$post['id'];

$userdata = $this->data['userdata'];

$pos = $this->db->where('job_title', 'PENGELOLA VENDOR')->get('adm_pos')->row_array();
$vc_position = $pos['pos_id'];
$vc_name = $userdata['complete_name'];
$vc_activity = "Menunggu Approval Blacklist Vendor";
$vc_start_date = date("Y-m-d H:i:s");
$vc_end_date = NULL;
$vc_response = "Permintaan Blacklist";
$vc_comment = $post['comment_inp'][0];

$data = array(
	'status' =>6,
	'reg_status_id' => -3,
	);

	$dota = array(
	'vendor_id'=>$id,
	'vc_position'=>$vc_position,
	'vc_name'=>$vc_name,
	'vc_activity'=>$vc_activity,
	'vc_start_date'=>$vc_start_date,
	'vc_end_date'=>$vc_end_date,
	'vc_response'=>$vc_response,
	'vc_comment'=>$vc_comment
	);   

$this->db->where('vendor_id', $id);

$update=$this->db->update('vnd_header', $data);
$tambah=$this->db->insert('vnd_comment', $dota);

if($update){
	$this->setMessage("Berhasil mengirim data");
}

redirect(site_url('vendor/kinerja_vendor/blacklist_vendor'));