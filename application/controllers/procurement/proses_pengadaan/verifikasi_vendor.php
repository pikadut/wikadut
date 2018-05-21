<?php 

$this->load->model("Vendor_m");

$post = $this->input->post();

$view = 'procurement/proses_pengadaan/form/verifikasi_administrasi_v';

$position = $this->Administration_m->getPosition("PIC USER");

$act = $this->uri->segment(3, 0);

$data['act'] = $act;

$vendor_id = $this->uri->segment(4, 0);

$vendor = $this->Vendor_m->getVendor($vendor_id)->row_array();

$data['vendor'] = $vendor;

$ptm_number = $this->session->userdata("rfq_id");

$data['ptm_number'] = $ptm_number;

$data['status_vendor'] = $this->Procrfq_m->getVendorStatusRFQ($vendor_id,$ptm_number)->row_array();

$prep = $this->Procrfq_m->getPrepRFQ($ptm_number)->row_array();

$evt_id = $prep['evt_id'];

$this->db->where(array("ptm_number"=>$ptm_number,"ptv_vendor_code"=>$vendor_id));

$quo = $this->Procrfq_m->getVendorQuoMainRFQ()->row_array();

if(!empty($quo)){

	$quo_id = $quo['pqm_id'];

	$this->db->where("pqt_weight",null);

	$administrasi = $this->Procrfq_m->getVendorQuoTechRFQ("",$quo_id)->result_array();

//DIGUNAKAN UNTUK TESTER EXTRANTET

/*

$this->db->where("etd_mode","0");

$administrasi = $this->Procevaltemp_m->getTemplateEvaluasiDetail($evt_id)->result_array();

foreach ($administrasi as $key => $value) {
	$check = $this->db->where(array("pqm_id"=>$quo_id,"etd_id"=>$value['etd_id']))->get("prc_tender_quo_tech")->row_array();
	if(empty($check)){

		$this->db->insert("prc_tender_quo_tech",array("pqm_id"=>$quo_id,"etd_id"=>$value['etd_id'],"pqt_item"=>$value['etd_item'],"pqt_weight"=>$value['etd_weight']));
		$administrasi[$key]['pqt_id']  = $this->db->insert_id();
		$administrasi[$key]['pqt_check'] = 0;
		$administrasi[$key]['pqt_check_vendor'] = 0;
		
	} else {
		$administrasi[$key]['pqt_id'] = (isset($check['pqt_id']) && !empty($check['pqt_id'])) ? $check['pqt_id'] : "";
		$administrasi[$key]['pqt_check'] = (isset($check['pqt_check'])) ? $check['pqt_check'] : 0;
		$administrasi[$key]['pqt_check_vendor'] = (isset($check['pqt_check_vendor'])) ? $check['pqt_check_vendor'] : 0;
	}
	
}

*/

//END

$data['administrasi'] = $administrasi;

}

$this->load->view($view,$data);