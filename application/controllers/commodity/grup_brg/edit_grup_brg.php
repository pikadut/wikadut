<?php

$data = array();

$data['list_group'] = $this->Commodity_m->getMatGroupActive()->result_array();

$post = $this->input->post();

$selection = $this->data['selection_mat_group'];

if(empty($selection)){

  $this->setMessage("Pilih data yang ingin diubah");
  redirect(site_url('commodity/katalog/grup_barang'));

}

$position = $this->Administration_m->getPosition("PENGELOLA KOMODITI");

if(!$position){
  $this->noAccess("Hanya PENGELOLA KOMODITI yang dapat mengubah grup barang komoditi");
}

$data["mat_group"] = array();

foreach($selection as $k => $v){

  $getdata = $this->Commodity_m->getMatGroup($v)->row_array();

  $status = (isset($getdata['mat_group_status'])) ? $getdata['mat_group_status'] : "";

  if($status != "A"){

    if(!empty($getdata)){
      $level = $this->Commodity_m->getMatLevelGroupList($getdata['mat_group_code']);
      $getdata['level'] = $level;
      $data["mat_group"][] = $getdata;
    }

    $getdata = $this->Comment_m->getCommodity("","",$getdata['mat_group_code'],"MATERIAL")->result_array();

    if(!empty($getdata)){
      $data["comment_list"][$v] = $getdata;
    }

  }

}

if(empty($data['mat_group'])){

  $this->setMessage("Tidak bisa mengubah data yang statusnya aktif");
  redirect(site_url('commodity/katalog/grup_barang'));

}


$view = 'commodity/grup_brg/form_edit_grup_brg_v';

$this->template($view,"Ubah Grup Barang",$data);
