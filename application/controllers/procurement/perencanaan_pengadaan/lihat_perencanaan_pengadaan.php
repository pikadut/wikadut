<?php 

$post = $this->input->post();

$this->data['dir'] = PROCUREMENT_PERENCANAAN_PENGADAAN_FOLDER;

  $view = 'procurement/perencanaan_pengadaan/detail_perencanaan_pengadaan_v';

  $data = array();

  $id = $this->uri->segment(5, 0);

  $data['perencanaan'] = $this->Procplan_m->getPerencanaanPengadaan($id)->row_array();

  $data['document'] = $this->Procplan_m->getDokumenPerencanaan("",$id)->result_array();

  $data["comment_list"][0] = $this->Comment_m->getProcurementPlan($id)->result_array();

  $this->template($view,"Detail Perencanaan Pengadaan",$data);