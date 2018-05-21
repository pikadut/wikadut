<?php 

$post= $this->input->post();
$id_vw=$post['id'];

$id = $this->db->where('ccp_id',$id_vw)->get('vw_ctr_commodity_suspend')->row_array();

$userdata = $this->data['userdata'];

$pos = $this->db->where('job_title', 'PENGELOLA VENDOR')->get('adm_pos')->row_array();
$vc_position = $pos['pos_id'];
$vc_name = $userdata['complete_name'];
$vc_activity = "Menunggu Approval Suspend Commodity Vendor";
$vc_start_date = date("Y-m-d H:i:s");
$vc_end_date = NULL;
$vc_response = "Permintaan Suspend";
$vc_comment = $post['comment_inp'][0];
$commodity = $id['ccp_id_commodity_cat'];
$mulaitanggal = $post['expiredfrom_inp'];
$selesaitanggal = $post['expiredto_inp'];

$data = array(
	'vendor_id' =>$id['vendor_id'],
	'vendor_name' =>$id['vendor_name'],
	'ccp_id' =>$id['ccp_id'],
	'group_name' =>$id['group_name'],
	'group_type' =>$id['group_type'],
	'id_commodity' =>$commodity,
	'status' =>5,
	'reg_status_id' => -2,
	'expiredfrom'=> $mulaitanggal,
	'expiredto'=> $selesaitanggal
	);

	$dota = array(
	'vendor_id'=>$id['vendor_id'],
	'ccp_id'=>$id['ccp_id'],
	'vc_position'=>$vc_position,
	'vc_name'=>$vc_name,
	'vc_activity'=>$vc_activity,
	'vc_start_date'=>$vc_start_date,
	'vc_end_date'=>$vc_end_date,
	'vc_response'=>$vc_response,
	'vc_comment'=>$vc_comment
	);   

$update=$this->db->insert('vnd_suspend_commodity_vendor', $data);

$this->db->where('ccp_id', $id['ccp_id']);

/*var_dump($commodity);
var_dump($data);
var_dump($dota);
exit();*/


$tambah=$this->db->insert('vnd_comment_commodity', $dota);

if($update){
	$this->setMessage("Berhasil mengirim data");
}

redirect(site_url('vendor/kinerja_vendor/suspend_commodity_vendor'));