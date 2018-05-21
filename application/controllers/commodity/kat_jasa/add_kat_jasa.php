<?php 

  $this->data['dir'] = COMMODITY_KATALOG_JASA_FOLDER;

  $_SESSION["RF"]["subfolder"] = $this->data['dir'];

  $jumlah = ($this->input->post('jumlah')) ? $this->input->post('jumlah') : 1;

$data['jumlah'] = $jumlah;

if(empty($jumlah)){

	$this->setMessage("Isi banyaknya data yang ingin ditambah");
	redirect(site_url('commodity/katalog/katalog_jasa'));

}

$position = $this->Administration_m->getPosition("PENGELOLA KOMODITI");

if(!$position){
  $this->noAccess("Hanya PENGELOLA KOMODITI yang dapat membuat katalog jasa komoditi");
}

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

  $view = 'commodity/kat_jasa/form_add_kat_jasa_v';

  $this->template($view,"Tambah Katalog Jasa",$data);