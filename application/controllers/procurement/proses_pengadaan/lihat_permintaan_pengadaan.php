<?php 

$post = $this->input->post();

$this->data['dir'] = PROCUREMENT_PERMINTAAN_PENGADAAN_FOLDER;

  $view = 'procurement/proses_pengadaan/detail_permintaan_pengadaan_v';

  $data = array();

  $id = $this->uri->segment(5, 0);

  $data['permintaan'] = $this->Procpr_m->getPR($id)->row_array();

  $status = ($data['permintaan']['pr_status'] >= 1020) ? 1020 : $data['permintaan']['pr_status'];

  $data['content'] = $this->Workflow_m->getContentByActivity($status)->result_array();

  $data['document'] = $this->Procpr_m->getDokumenPR("",$id)->result_array();

  $data['item'] = $this->Procpr_m->getItemPR("",$id)->result_array();

  $data['redirect_back'] = 'procurement/procurement_tools/monitor_pengadaan';

  $data["comment_list"][0] = $this->Comment_m->getProcurementPRActive($id)->result_array();

  $this->template($view,"Detail SPPBJ",$data);