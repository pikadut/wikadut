<?php 

  $this->data['dir'] = COMMODITY_KATALOG_BARANG_FOLDER;

  $_SESSION["RF"]["subfolder"] = $this->data['dir'];

  $data = array();

  $post = $this->input->post();

   $selection = array(0=>$this->uri->segment(4, 0));
   
   $data['list_group'] = $this->Commodity_m->getMatGroup(substr($this->uri->segment(4, 0), 0, 8))->result_array();

   $position = $this->Administration_m->getPosition("APPROVAL KOMODITI");

if(!$position){
  $this->noAccess("Hanya APPROVAL KOMODITI yang dapat approve katalog barang komoditi");
}

  foreach($selection as $k => $v){

    $getdata = $this->Commodity_m->getMatCatalog($v)->row_array();

    if(!empty($getdata)){
      $data["mat_catalog"][] = $getdata;
    }

     $getdata = $this->Comment_m->getCommodity($v)->result_array();

    if(!empty($getdata)){
      $data["comment_list"][$v] = $getdata;
    }

  }

  $view = 'commodity/daftar_pekerjaan/approval_kat_brg_v';

  $this->template($view,"Approval Katalog Barang",$data);