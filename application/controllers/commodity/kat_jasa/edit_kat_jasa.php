<?php 

$this->data['dir'] = COMMODITY_KATALOG_JASA_FOLDER;

$_SESSION["RF"]["subfolder"] = $this->data['dir'];

$position = $this->Administration_m->getPosition("PENGELOLA KOMODITI");

if(!$position){
  $this->noAccess("Hanya PENGELOLA KOMODITI yang dapat mengubah katalog jasa komoditi");
}

$data = array();

$list_group = $this->Commodity_m->getSrvGroup()->result_array();

  /*

foreach ($list_group as $key => $value) {

  $level = count($this->Commodity_m->getSrvLevelGroupList($value['srv_group_code']));

  if($level-1 != COMMODITY_GROUP_MAX_LEVEL){
      //unset($list_group[$key]);
  }

}

*/

$data['list_group'] = $list_group;

$post = $this->input->post();

$selection = $this->data['selection_srv_catalog'];

if(empty($selection)){

  $this->setMessage("Pilih data yang ingin diubah");
  redirect(site_url('commodity/katalog/katalog_jasa'));

}

$data["srv_catalog"] = array();

foreach($selection as $k => $v){

  $getdata = $this->Commodity_m->getSrvCatalog($v)->row_array();

  $status = (isset($getdata['status'])) ? $getdata['status'] : "";

  if(!in_array($status,array("A","N"))){

    if(!empty($getdata)){
      $data["srv_catalog"][] = $getdata;
    }

    $getdata = $this->Comment_m->getCommodity($v)->result_array();

    if(!empty($getdata)){
      $data["comment_list"][$v] = $getdata;
    }

  }

}

if(empty($data["srv_catalog"])){

  $this->setMessage("Pilih data yang ingin diubah");
  redirect(site_url('commodity/katalog/katalog_jasa'));

}

$view = 'commodity/kat_jasa/form_edit_kat_jasa_v';

$this->template($view,"Ubah Katalog Jasa",$data);