<?php 

$post = $this->input->post();

$userdata = $this->data['userdata'];

$input = array();
/*
$this->form_validation->set_rules("lane_code_divbirnit_inp", "Kode Lintasan", 'required|xss_clean|is_unique[adm_lane.lane_code]');
$this->form_validation->set_rules("origin_lane_inp", "Asal Lintasan", 'is_unique[adm_lane.origin_lane]');
$this->form_validation->set_rules("destination_lane_inp", "Tujuan Lintasan", 'is_unique[adm_lane.destination_lane]');
*/

//hlmifzi
$jml_kode = count($post['lane_code_divbirnit_inp']);

$district_inp=$post['district_inp'];
$origin_lane_inp=$post['origin_lane_inp'];
$tipe_inp=$post['tipe_inp'];
$status_inp=$post['status_inp'];
$date_added=date('Y-m-d H:i:s');
$employee_id=$userdata['employee_id'];

$input = [];


for($i=0; $i<$jml_kode; $i++){
	$input[$i]['lane_code']=$post['lane_code_divbirnit_inp'][$i];
	$input[$i]['origin_lane']=$post['origin_lane_inp'][$i];
	$input[$i]['destination_lane']=$post['destination_lane_inp'][$i];
	$input[$i]['district_id']=$district_inp;
	$input[$i]['roundtrip_type']=$tipe_inp;
	$input[$i]['lane_active']=$status_inp;
	$input[$i]['created_date']=$date_added; 
	$input[$i]['created_by_id']=$employee_id;
	
}

/*var_dump($jml_kode);
exit();*/

$error = false;



/*if ($this->form_validation->run() == FALSE || $error){

	$this->setMessage("Gagal menambah lintasan : <b>Kode Lintasan</b> atau <b>Asal dan Tujuan</b> yang sama sudah ada");


} else {*/

	foreach ($input as $key => $value) {
		$insert = $this->db->insert('adm_lane', $input[$key]); 
	}
/*}*/



	if($insert){
		$this->setMessage("Berhasil menambah lintasan");
	}

	redirect(site_url('administration/master_data/lintasan'));
