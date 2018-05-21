<?php 

  $this->data['dir'] = COMMODITY_KATALOG_JASA_FOLDER;

  $_SESSION["RF"]["subfolder"] = $this->data['dir'];

  $data = array();

  $data['list_sourcing'] = $this->Commodity_m->getSourcing()->result_array();

  $data['list_del_point'] = $this->Administration_m->getDelPoint()->result_array();

  $data['list_catalog'] = $this->Commodity_m->getSrvCatalog()->result_array();

  $post = $this->input->post();

  $selection = array(0=>$this->uri->segment(4, 0));

  $position = $this->Administration_m->getPosition("APPROVAL KOMODITI");

if(!$position){
  $this->noAccess("Hanya APPROVAL KOMODITI yang dapat approve harga jasa komoditi");
}

  foreach($selection as $k => $v){

    $getdata = $this->Commodity_m->getSrvPrice($v)->row_array();

    if(!empty($getdata)){
      $data["srv_price"][] = $getdata;
    }

     $getdata = $this->Comment_m->getCommodity("",$v)->result_array();

    if(!empty($getdata)){
      $data["comment_list"][$v] = $getdata;
    }

  }

  $view = 'commodity/daftar_pekerjaan/approval_hrg_jasa_v';

  $this->template($view,"Approval Harga Jasa",$data);