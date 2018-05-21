<?php 

$post = $this->input->post();

$view = 'procurement/proses_pengadaan/ubah_lampiran_v';

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

$this->session->set_userdata("rfq_id",$ptm_number);

if($activity['awa_finish'] == 1){

	echo "<center><h1>Pengadaan tidak dapat diubah</h1></center>";

} else {

	$data['doc_category'] = $this->Procurement_m->getKategoriDokumen()->result_array();

	$data['document'] = $this->Procrfq_m->getDokumenRFQ("",$ptm_number)->result_array();

	$data['prep'] = $this->Procrfq_m->getPrepRFQ($ptm_number)->row_array();

	$permintaan = $this->Procrfq_m->getRFQ($ptm_number)->row_array();

	$data['permintaan'] = $permintaan;

	$this->load->view($view,$data);

}