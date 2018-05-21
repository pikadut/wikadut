<?php

$data = array();

$data['list_group'] = $this->Commodity_m->getSrvGroupActive()->result_array();

$post = $this->input->post();

$selection = $this->data['selection_srv_group'];

if(empty($selection)){

  $this->setMessage("Pilih data yang ingin diubah");
  redirect(site_url('commodity/katalog/grup_jasa'));

}

$position = $this->Administration_m->getPosition("PENGELOLA KOMODITI");

if(!$position){
  $this->noAccess("Hanya PENGELOLA KOMODITI yang dapat mengubah grup jasa komoditi");
}

foreach($selection as $k => $v){

  $getdata = $this->Commodity_m->getSrvGroup($v)->row_array();

  $status = (isset($getdata['srv_group_status'])) ? $getdata['srv_group_status'] : "";

  if($status != "A"){

    if(!empty($getdata)){
      $level = $this->Commodity_m->getSrvLevelGroupList($getdata['srv_group_code']);
      $getdata['level'] = $level;
      $data["srv_group"][] = $getdata;
    }

    $getdata = $this->Comment_m->getCommodity("","",$getdata['srv_group_code'],"SERVICE")->result_array();

    if(!empty($getdata)){
      $data["comment_list"][$v] = $getdata;
    }

  }

}

if(empty($data['srv_group'])){

  $this->setMessage("Tidak bisa mengubah data yang statusnya aktif");
  redirect(site_url('commodity/katalog/grup_barang'));

}

$view = 'commodity/grup_jasa/form_edit_grup_jasa_v';

$this->template($view,"Ubah Grup Jasa",$data);
