<?php 
$pcl_id = $this->uri->segment(3, 0);
$view = "procurement/sanggahan/lihat_sanggahan_v";

$this->load->library(array('Umum',"encryption"));

$data["content"] = $this->db->query("select a.ptm_number, pcl_status, pcl_vendor_id, pcl_title, pcl_reason, pcl_supporting_text, pcl_supporting_att, pcl_jam_amount, pcl_jam_bank, pcl_jam_number, pcl_jam_start_date, pcl_jam_end_date, pcl_jwb_judul, pcl_jwb_no, pcl_jwb_isi, pcl_jwb_attachment, pcl_created_date, pcl_completed_date, b.ptm_subject_of_work from prc_tender_claim a join prc_tender_main b on a.ptm_number = b.ptm_number where pcl_id = '".$pcl_id."'")->row_array();
$this->load->view($view,$data);
