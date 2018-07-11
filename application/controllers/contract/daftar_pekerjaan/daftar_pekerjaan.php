<?php 

// $check = $this->db
// ->query("SELECT * FROM vw_prc_monitor WHERE ptm_number NOT IN (SELECT ptm_number FROM ctr_contract_header) AND last_status = 1901 AND vendor_id IS NOT NULL")
// ->result_array();

// $getdata = $this->db->select("pos_id,pos_name")
// ->where(array("job_title"=>"PENGELOLA KONTRAK")) //vp pengadaan
// ->get("adm_pos")->row_array();

// //y manager kontrak
// $getman = $this->db->select("pos_id, pos_name, employee_id")
// ->where(array("job_title"=>"MANAJER PENGADAAN",
// "user_name NOT LIKE" => '%proyek%'))
// ->get("user_login_rule")->row_array();

// //y pengelola kontrak
// $getspe = $this->db->select("pos_id, pos_name, employee_id")
// ->where(array("job_title"=>"PENGELOLA KONTRAK"))
// ->get("user_login_rule")->row_array();

// foreach ($check as $key => $value) {

// 	$input['ptm_number'] = $value['ptm_number'];
// 	$input['currency'] = $value['pqm_currency'];
// 	$input['vendor_id'] = $value['vendor_id'];
// 	$input['vendor_name'] = $value['vendor_name'];
// 	$input['subject_work'] = $value['ptm_subject_of_work'];
// 	$input['scope_work'] = $value['ptm_scope_of_work'];
// 	$input['contract_type'] = $value['ptm_contract_type'];
// 	$input['completed_tender_date'] = $value['ptm_completed_date'];
// 	$input['contract_amount'] = $value['total_contract'];

// 	//y insert manager kontrak dan pengelola kontrak
// 	$input['ctr_spe_employee'] = $getspe['employee_id'];
// 	$input['ctr_spe_pos'] = $getspe['pos_id'];
// 	$input['ctr_spe_pos_name'] = $getspe['pos_name'];

// 	$input['ctr_man_employee'] = $getman['employee_id'];
// 	$input['ctr_man_pos'] = $getman['pos_id'];
// 	$input['ctr_man_pos_name'] = $getman['pos_name'];
// 	//y end

// 	$this->db->insert("ctr_contract_header",$input);

// 	$contract_id = $this->db->insert_id();

// 	$vendor_id = $value['vendor_id'];

// 	$this->db->where("vendor_id",$vendor_id);

// 	$quo_item = $this->Procrfq_m->getViewVendorQuoComRFQ("","",$value['ptm_number'])->result_array();

// 	foreach ($quo_item as $key => $value) {

// 		$short = (!empty($value['short_description'])) ? $value['short_description'] : $value['pqi_description'];

// 		$inp = array(
// 			"tit_id"=>$value['tit_id'],
// 			"contract_id"=>$contract_id,
// 			"item_code"=>$value['tit_code'],
// 			"short_description"=>$short,
// 			"long_description"=>$value['pqi_description'],
// 			"price"=>$value['pqi_price'],
// 			"qty"=>$value['pqi_quantity'],
// 			"uom"=>$value['tit_unit'],
// 			"min_qty"=>1,
// 			"max_qty"=>$value['pqi_quantity'],
// 			"ppn"=>$value['pqi_ppn'],
// 			"pph"=>$value['pqi_pph'],
// 			);
		
// 		$act = $this->Contract_m->insertItem($inp);

// 	}

// 	$this->db->insert("ctr_contract_comment",array(
// 		"ptm_number"=>$value['ptm_number'],
// 		"contract_id"=>$contract_id,
// 		"ccc_activity"=>2010, //2000
// 		"ccc_position"=>$getdata['pos_name'],
// 		"ccc_pos_code"=>$getdata['pos_id'],
// 		"ccc_start_date"=>date("Y-m-d H:i:s"),
// 		));
// }


$view = 'contract/daftar_pekerjaan/daftar_pekerjaan_v';
$data = array();
$this->template($view,"Daftar Kontrak",$data);
?>