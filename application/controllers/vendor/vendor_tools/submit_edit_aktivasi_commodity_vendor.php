


<?php 

$ubah = $this->input->post();
$id = $ubah['id'];

if($ubah['reg_isactivate_inp'] == '1'){
$data['aktif'] = 0;

	/*$msg = "Dengan hormat,
	<br/>
	<br/>
	Bersama ini kami sampaikan bahwa ".COMPANY_NAME." telah mengaktifkan akun vendor login anda.
	untuk dapat berpartisipasi dalam pengadaan dapat diakses melalui <a href='".EXTRANET_URL."' target='_blank'>eSCM ".COMPANY_NAME."</a>. Akun ini terintegrasi dengan <a href='http://vendor.pengadaan.com' target='_blank'>vendor.pengadaan.com</a>.
	<br/>
	<br/>
	Salam,
	<br/>
	".COMPANY_NAME;

	$mail = "iprocasdp@asdp.co.id";

	$email = $this->sendEmail($mail,"Pemberitahuan Aktivasi Commodity Vendor",$msg);*/

	$id_commodity = $this->db->get('vnd_suspend_commodity_vendor')->row()->id_commodity;

	$this->db->where('ccp_id_commodity_cat',$id_commodity)->update('ctr_contract_penilaian',$data);

	$update = $this->db->where('ccp_id', $id)->update('vnd_suspend_commodity_vendor', $data);

	if($update){
		$this->setMessage("Berhasil mengubah status aktivasi commodity");
	}

	redirect(site_url('vendor/vendor_tools/aktivasi_vendor'));


} else {

	redirect(site_url('vendor/vendor_tools/aktivasi_vendor_commodity'));
}




