<?php 

$this->data['dir'] = COMMODITY_KATALOG_BARANG_FOLDER;

$_SESSION["RF"]["subfolder"] = $this->data['dir'];

$data = array();

$data['list_group'] = $this->Commodity_m->getSrvGroup()->result_array();

$post = $this->input->post();

$selection = array(0=>$this->uri->segment(4, 0));

$position = $this->Administration_m->getPosition("APPROVAL KOMODITI");

if(!$position){
  $this->noAccess("Hanya APPROVAL KOMODITI yang dapat approve grup jasa komoditi");
}

if(empty($selection)){

  $this->setMessage("Pilih data yang ingin diapprove");
  redirect(site_url('commodity/daftar_pekerjaan'));

}

foreach($selection as $k => $v){

  $getdata = $this->Commodity_m->getSrvGroup($v)->row_array();

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

$view = 'commodity/daftar_pekerjaan/approval_grup_jasa_v';

$this->template($view,"Approval Grup Jasa",$data);

