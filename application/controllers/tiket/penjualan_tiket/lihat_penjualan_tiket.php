<?php 

//$post = $this->input->post();

$this->data['dir'] = TIKET_PERMINTAAN_TIKET_FOLDER;

  $view = 'tiket/penjualan_tiket/detail_penjualan_tiket_v';

  $data = array();

  $id = $this->uri->segment(5, 0);

  $data['penjualan'] = $this->Tiksale_m->getPenjualanTiket($id)->row_array();

  //$data['document'] = $this->Procplan_m->getDokumenPerencanaan("",$id)->result_array();

  $data["comment_list"][0] = $this->Comment_m->getTiketSold($id)->result_array();
  
  $data['item'] = $this->Tiksale_m->getItemST("",$id)->result_array();

  $this->template($view,"Detail Penjualan Tiket",$data);