<?php 

$this->data['dir'] = COMMODITY_KATALOG_BARANG_FOLDER;

$_SESSION["RF"]["subfolder"] = $this->data['dir'];

$data = array();

$data['list_group'] = $this->Commodity_m->getMatGroup()->result_array();

$post = $this->input->post();

$selection = array(0=>$this->uri->segment(4, 0));

$position = $this->Administration_m->getPosition("APPROVAL KOMODITI");

if(!$position){
  $this->noAccess("Hanya APPROVAL KOMODITI yang dapat approve grup barang komoditi");
}

if(empty($selection)){

  $this->setMessage("Pilih data yang ingin diapprove");
  redirect(site_url('commodity/daftar_pekerjaan'));

}

foreach($selection as $k => $v){

  $getdata = $this->Commodity_m->getMatGroup($v)->row_array();

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

$view = 'commodity/daftar_pekerjaan/approval_grup_brg_v';

$this->template($view,"Approval Grup Barang",$data);

