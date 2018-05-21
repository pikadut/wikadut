<?php 
$view = 'laporan/lap_proc_value_v';
$data = array();
$m = $this->db
->join("prc_tender_prep a","a.ptm_number=b.ptm_number")
->join("ctr_contract_header c","c.ptm_number=b.ptm_number")->select("ptp_tender_method,
ptp_submission_method,
	SUM(ptm_pagu_anggaran) as total,SUM(contract_amount) as total_contract,COUNT(a.ptm_number) as jumlah")->group_by("ptp_tender_method,ptp_submission_method")->get("prc_tender_main b")->result_array();
foreach ($m as $key => $value) {
	$data['total'][$value['ptp_tender_method'].$value['ptp_submission_method']] = array("oe"=>$value['total'],"kontrak"=>$value['total_contract'],"jumlah"=>$value['jumlah']);
}

$metode = array(0=>"Penunjukkan Langsung",1=>"Pemilihan Langsung",2=>"Pelelangan");
$sampul = array(0=>"1 Sampul",1=>"2 Sampul",2=>"2 Tahap");
$label = array();
foreach ($metode as $key => $value) {
	foreach ($sampul as $key2 => $value2) {
		$label[$key.$key2] = ($key == 1) ? $value." ".$value2 : $value;
	}
}
$data['label'] = $label;

$this->template($view,"Laporan Procurement Value",$data);
?>