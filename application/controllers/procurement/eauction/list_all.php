<?php 

  $userdata = $this->session->all_userdata();
  $tenderid = $this->input->post("tenderid");

  $lowest_bid = $this->db
  ->where(array("PPM_ID"=>$tenderid))
  ->order_by("TGL_BID","DESC")
  ->limit(1)->get("prc_eauction_history")->row_array();

  $batas_atas = $this->db
        ->where("PPM_ID",$tenderid)
        ->get("prc_eauction_header")
        ->row()->BATAS_ATAS;
        
  $data['lowest_bid'] = (isset($lowest_bid['JUMLAH_BID'])) ? inttomoney($lowest_bid['JUMLAH_BID']) : inttomoney($batas_atas);

  echo json_encode($data);