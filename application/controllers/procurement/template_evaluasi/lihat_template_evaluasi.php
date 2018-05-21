<?php 

  $view = 'procurement/template_evaluasi/lihat_template_evaluasi_v';

  $data = array();

   $id = (isset($post['id'])) ? $post['id'] : $this->uri->segment(4, 0);

   $data['id'] = $id;

  $data['data'] = $this->Procevaltemp_m->getTemplateEvaluasi($id)->row_array();

  $data['detail'] = $this->Procevaltemp_m->getTemplateEvaluasiDetail($id)->result_array();

  $this->template($view,"Lihat Template Evaluasi Pengadaan",$data);