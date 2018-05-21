<?php 

$post= $this->input->post();
$id=$post['id'];
$userdata = $this->data['userdata'];
//$pos = $this->db->where('job_title', 'VP PENGADAAN')->get('adm_pos')->row_array(); 
$vc_position = $userdata['pos_id'];
$vc_name = $userdata['complete_name'];
$status = $post['status_inp'][0];
$vendor = $this->db->where('vendor_id',$id)->get('vnd_header')->row_array();
$stat = $vendor['reg_status_id'];
$vc_activity = "";

if ($stat == -2){

	$vc_activity = 'Vendor telah di suspend';
}

else {

	$vc_activity = 'Vendor batal di suspend';
};

if ($stat == -3){

	$vc_activity = 'Vendor telah di blacklist';
}

else {

	$vc_activity = 'Vendor batal di suspend';
};

$vc_start_date = date("Y-m-d");
$vc_end_date = NULL;
$vc_response = NULL;
$vc_comment = $post['comment_inp'][0];


$mulaitanggal = $post['expiredfrom_inp'];
$selesaitanggal = $post['expiredto_inp'];

$data = array(
	'status' => $stat,
	'reg_status_id' => null,
	'expiredfrom'=> $mulaitanggal,
	'expiredto'=> $selesaitanggal
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
	$this->setMessage("Berhasil mengubah status");
}

redirect(site_url('vendor/daftar_pekerjaan_vendor'));