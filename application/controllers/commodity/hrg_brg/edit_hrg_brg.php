<?php 

  $this->data['dir'] = COMMODITY_KATALOG_BARANG_FOLDER;

  $_SESSION["RF"]["subfolder"] = $this->data['dir'];

  $data = array();

  $data['list_sourcing'] = $this->Commodity_m->getSourcing()->result_array();

  $data['list_del_point'] = $this->Administration_m->getDistrict()->result_array();

  $data['list_catalog'] = $this->Commodity_m->getMatCatalog()->result_array();

  $post = $this->input->post();

  $jumlah = ($this->input->post('jumlah')) ? $this->input->post('jumlah') : 1;

$data['jumlah'] = $jumlah;

  $selection = $this->data['selection_mat_price'];

  if(empty($selection)){

  $this->setMessage("Pilih data yang ingin diubah");
  redirect(site_url('commodity/daftar_harga/daftar_harga_barang'));

}

$position = $this->Administration_m->getPosition("PENGELOLA KOMODITI");

if(!$position){
  $this->noAccess("Hanya PENGELOLA KOMODITI yang dapat mengubah harga barang komoditi");
}

  foreach($selection as $k => $v){

    $getdata = $this->Commodity_m->getMatPrice($v)->row_array();

    if(!empty($getdata)){
      $data["mat_price"][] = $getdata;
    }

     $getdata = $this->Comment_m->getCommodity("",$v)->result_array();

    if(!empty($getdata)){
      $data["comment_list"][$v] = $getdata;
    }

  }

  $view = 'commodity/hrg_brg/form_edit_hrg_brg_v';

  $this->template($view,"Ubah Harga Barang",$data);