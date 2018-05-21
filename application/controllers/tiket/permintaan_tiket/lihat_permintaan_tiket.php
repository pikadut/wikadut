<?php 

$post = $this->input->post();

$this->data['dir'] = TIKET_PERMINTAAN_TIKET_FOLDER;

  $view = 'tiket/permintaan_tiket/detail_permintaan_tiket_v';

  $data = array();

  $id = $this->uri->segment(5, 0);

  $data['perencanaan'] = $this->Tikplan_m->getPermintaanTiket($id)->row_array();

  //$data['document'] = $this->Procplan_m->getDokumenPerencanaan("",$id)->result_array();

  $data["comment_list"][0] = $this->Comment_m->getTiketPlan($id)->result_array();
  
  $data['item'] = $this->Tikplan_m->getItemPT("",$id)->result_array();

  $this->template($view,"Detail Permintaan Tiket",$data);