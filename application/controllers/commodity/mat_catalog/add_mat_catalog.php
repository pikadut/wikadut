<?php 

  $this->data['dir'] = COMMODITY_KATALOG_BARANG_FOLDER;

  $_SESSION["RF"]["subfolder"] = $this->data['dir'];

  $jumlah = ($this->input->post('jumlah')) ? $this->input->post('jumlah') : 1;

$data['jumlah'] = $jumlah;

if(empty($jumlah)){

	$this->setMessage("Isi banyaknya data yang ingin ditambah");
	redirect(site_url('commodity/katalog/katalog_barang'));

}

$position = $this->Administration_m->getPosition("PENGELOLA KOMODITI");

if(!$position){
  $this->noAccess("Hanya PENGELOLA KOMODITI yang dapat membuat katalog barang komoditi");
}

  $list_group = $this->Commodity_m->getMatGroup()->result_array();

  /*

  foreach ($list_group as $key => $value) {

  	$level = count($this->Commodity_m->getMatLevelGroupList($value['mat_group_code']));
  	
  	if($level-1 != COMMODITY_GROUP_MAX_LEVEL){
  		//unset($list_group[$key]);
  	}

  }

  */

  $data['list_group'] = $list_group;


  $view = 'commodity/mat_catalog/form_add_mat_catalog_v';

  $this->template($view,"Tambah Katalog Barang",$data);