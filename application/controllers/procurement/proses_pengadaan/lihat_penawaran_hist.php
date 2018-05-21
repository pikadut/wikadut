<?php 
$main = $this->db->select("a.*,b.vendor_name")->join("vnd_header b","a.ptv_vendor_code=b.vendor_id","left")
->where("a.pqm_hist_id",$id)->get("prc_tender_quo_main_hist a")->row_array();
$view = "procurement/proses_pengadaan/penawaran_vendor_v";
$tenderid = $main['ptm_number'];
$vendor_id = $main['ptv_vendor_code'];
$data['vendor_id'] = $vendor_id;
$this->session->set_userdata("tenderid", $tenderid);

$this->load->library(array('Umum',"encryption"));

$key = bin2hex($this->encryption->create_key(16));

$this->encryption->initialize(
	array(
		'cipher' => 'aes-128',
		'mode' => 'cbc',
		'key' => hex2bin($key),
		'hmac_digest' => 'sha256',
		'hmac_key' => $main['vendor_name']
		)
	);

$data["tenderid"] = $tenderid;
$data["pajak"] = $this->db->query("select case npwp_pkp WHEN 'YA' THEN '1' ELSE '0' END as pajak from vnd_header where vendor_id = '".$vendor_id."'")->row_array();
$data["pajak"] = $data["pajak"]["pajak"];
$data["header"] = $main;
$data["template"] = $this->db->query("select * from prc_tender_quo_tech where pqm_id = '".$data["header"]["pqm_id"]."'")->result_array();
$data["item"] = $this->db->query("select * from prc_tender_quo_item_hist join prc_tender_item on prc_tender_quo_item_hist.tit_id = prc_tender_item.tit_id where pqm_hist_id = '".$id."'")->result_array();
$data["readonly"] = "1";
$this->template($view,"Detail Penawaran Vendor",$data);

?>