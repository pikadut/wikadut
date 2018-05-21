<?php 

$post= $this->input->post();
$id=$post['id'];


$userdata = $this->data['userdata'];

//$pos = $this->db->where('job_title', 'VP PENGADAAN')->get('adm_pos')->row_array(); 

$vc_position = $userdata['pos_id'];
$vc_name = $userdata['complete_name'];
$status = $post['status_inp'][0];
$vendor = $this->db->where('ccp_id',$id)->get('vnd_suspend_commodity_vendor')->row_array();
$stat = $vendor['status'];
$vc_activity = "";
$status_next = "";

if ($status == "A"){
	if($stat == 5){
		$vc_activity = 'Approval Suspend Commodity Vendor';
		$status_next = -2;
		$vc_response = "Suspend Commodity Disetujui";
	} else if($stat == 6) {
		$vc_activity = 'Approval Blacklist Commodity Vendor';
		$vc_response = "Blacklist Commodity Disetujui";
		$status_next = -3;
	}
} else {
	if($stat == 5){
		$vc_activity = 'Approval Suspend Commodity Vendor';
		$vc_response = "Suspend Commodity Ditolak";
	} else if($stat == 6) {
		$vc_activity = 'Approval Blacklist Commodity Vendor';
		$vc_response = "Blacklist Commodity Ditolak";
	}
	$status_next = 9;
};


$vc_start_date = date("Y-m-d H:i:s");
$vc_end_date = NULL;

$vc_comment = $post['comment_inp'][0];

$mulaitanggal = (isset($post['expiredfrom_inp'])) ? $post['expiredfrom_inp'] : null;
$selesaitanggal = (isset($post['expiredto_inp'])) ? $post['expiredto_inp'] : null;

$data = array(
	'status' => $status_next,
	'reg_status_id' => null,
	);

if(!empty($mulaitanggal)){
	$data['expiredfrom'] = $mulaitanggal;
}

if(!empty($selesaitanggal)){
	$data['expiredto'] = $selesaitanggal;
}

$dota = array(
	'vendor_id'=>$id,
	'ccp_id'=>$id,
	'vc_position'=>$vc_position,
	'vc_name'=>$vc_name,
	'vc_activity'=>$vc_activity,
	'vc_start_date'=>$vc_start_date,
	'vc_end_date'=>$vc_end_date,
	'vc_response'=>$vc_response,
	'vc_comment'=>$vc_comment
	);   

$this->db->where('ccp_id', $id);

$update=$this->db->update('vnd_suspend_commodity_vendor', $data);
$tambah=$this->db->insert('vnd_comment_commodity', $dota);

if($update){
	$this->setMessage("Berhasil mengubah status");
}

redirect(site_url('vendor/daftar_pekerjaan_vendor'));