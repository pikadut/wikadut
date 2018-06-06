<?php 

$ubah = $this->input->post();
$id = $ubah['id'];

	$query = $this->db->where('vendor_id', $id)->get('vnd_header')->row_array();

	$vnd_name = substr($query['vendor_name'],0,1);
    $year = date("y");
    $getnumber = $this->db->select('customer_code')->where('customer_code is NOT NULL', NULL)->get('vnd_header')->num_rows();
    $number =$getnumber+1;
    $fixnum = str_pad($number, 3, "0", STR_PAD_LEFT);  
    $codefication= $vnd_name.$year.$fixnum;




if($ubah['reg_isactivate_inp'] == '1' && $query['customer_code'] == NULL){

	$data = array(
		'reg_isactivate' =>$ubah['reg_isactivate_inp'],
		'status' => 9,
		'reg_status_id' => 8,
		'district_id'=> $ubah['district_inp'],
		'customer_code'=> $codefication,
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

} 
elseif($ubah['reg_isactivate_inp'] == '1' && ($query['customer_code'] !=NULL)){
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

}
else {

	$data = array(
		'reg_isactivate' =>$ubah['reg_isactivate_inp'],
		'status' => null,
		'reg_status_id' => null,
		'district_id'=> $ubah['district_inp'],
		);	

}
//var_dump($data); die();
$update = $this->db->where('vendor_id', $id)->update('vnd_header', $data);



if($update){
	$this->setMessage("Berhasil mengubah status aktivasi");
}

redirect(site_url('vendor/vendor_tools/aktivasi_vendor'));


