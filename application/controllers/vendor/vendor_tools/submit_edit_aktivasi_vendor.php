<?php 

$ubah = $this->input->post();
$id = $ubah['id'];

if($ubah['reg_isactivate_inp'] == '1'){

	$data = array(
		'reg_isactivate' =>$ubah['reg_isactivate_inp'],
		'status' => 9,
		'reg_status_id' => 8,
		'district_id'=> $ubah['district_inp'],
		);

	$msg = "Dengan hormat,
	<br/>
	<br/>
	Bersama ini kami sampaikan bahwa ".COMPANY_NAME." telah mengaktifkan akun vendor login anda.
	untuk dapat berpartisipasi dalam pengadaan dapat diakses melalui <a href='".EXTRANET_URL."' target='_blank'>eSCM ".COMPANY_NAME."</a>. Akun ini terintegrasi dengan <a href='http://vendor.pengadaan.com' target='_blank'>vendor.pengadaan.com</a>.
	<br/>
	<br/>
	Salam,
	<br/>
	".COMPANY_NAME;

	$mail = "adwmrt@adw.co.id";

	$email = $this->sendEmail($mail,"Pemberitahuan Aktivasi Vendor",$msg);

} else {

	$data = array(
		'reg_isactivate' =>$ubah['reg_isactivate_inp'],
		'status' => null,
		'reg_status_id' => null,
		'district_id'=> $ubah['district_inp'],
		);	

}

$update = $this->db->where('vendor_id', $id)->update('vnd_header', $data);

if($update){
	$this->setMessage("Berhasil mengubah status aktivasi");
}

redirect(site_url('vendor/vendor_tools/aktivasi_vendor'));