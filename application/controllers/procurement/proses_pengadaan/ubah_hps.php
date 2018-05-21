<?php 

$post = $this->input->post();

$view = 'procurement/proses_pengadaan/ubah_hps_v';

$position = $this->Administration_m->getPosition("PIC USER");

$ptm_number = $this->uri->segment(3, 0);

$data['id'] = $ptm_number;

$data['pos'] = $position;

$data['controller_name'] = "procurement";

$data['dir'] = PROCUREMENT_PERMINTAAN_PENGADAAN_FOLDER;

$this->db->where("ptc_end_date",null);

$latest_comment = $this->Comment_m->getProcurementRFQ($ptm_number,"")->row_array();

$activity_id = $latest_comment['activity'];

$activity = $this->Procedure_m->getActivity($activity_id)->row_array();

$data['activity_id'] = $activity_id;

if($activity['awa_finish'] == 1){

	echo "<center><h1>Pengadaan tidak dapat diubah</h1></center>";

} else {

	$permintaan = $this->Procrfq_m->getRFQ($ptm_number)->row_array();

	$data['doc_category'] = $this->Procurement_m->getKategoriDokumen()->result_array();

	$data['permintaan'] = $permintaan;

	$data['item'] = $this->Procrfq_m->getItemRFQ("",$ptm_number)->result_array();

	$this->session->set_userdata("rfq_id",$ptm_number);

	$this->load->view($view,$data);

}