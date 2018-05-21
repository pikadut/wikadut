<?php 

$post= $this->input->post();
$id=$post['id'];


$userdata = $this->data['userdata'];
$vc_position = $userdata['pos_id'];
$vc_name = $userdata['complete_name'];
$vc_activity = "Menunggu Approval Pembukaan Suspend Vendor";
$vendor = $this->db->where('vendor_id',$id)->get('vnd_header')->row_array();
$stat = $vendor['reg_status_id'];
$status = $post['status_inp'][0];
$vc_start_date = date("Y-m-d");
$vc_end_date = NULL;
$vc_response = "Diaktifkan";
$vc_comment = $post['comment_inp'][0];


$data = array(
	'status' =>9,
	'reg_status_id' => NULL,
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

redirect(site_url('vendor/kinerja_vendor/aktivasi_suspend_vendor'));