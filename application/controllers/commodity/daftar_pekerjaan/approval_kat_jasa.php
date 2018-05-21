<?php 

  $this->data['dir'] = COMMODITY_KATALOG_JASA_FOLDER;

  $_SESSION["RF"]["subfolder"] = $this->data['dir'];

  $data = array();

  $data['list_group'] = $this->Commodity_m->getSrvGroup()->result_array();

  $post = $this->input->post();

   $selection = array(0=>$this->uri->segment(4, 0));

   $position = $this->Administration_m->getPosition("APPROVAL KOMODITI");

if(!$position){
  $this->noAccess("Hanya APPROVAL KOMODITI yang dapat approve katalog jasa komoditi");
}

  foreach($selection as $k => $v){

    $getdata = $this->Commodity_m->getSrvCatalog($v)->row_array();

    if(!empty($getdata)){
      $data["srv_catalog"][] = $getdata;
    }

     $getdata = $this->Comment_m->getCommodity($v)->result_array();

    if(!empty($getdata)){
      $data["comment_list"][$v] = $getdata;
    }

  }

  $view = 'commodity/daftar_pekerjaan/approval_kat_jasa_v';

  $this->template($view,"Approval Katalog Jasa",$data);