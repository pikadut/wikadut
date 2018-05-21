<?php 

$this->data['dir'] = COMMODITY_KATALOG_BARANG_FOLDER;

$_SESSION["RF"]["subfolder"] = $this->data['dir'];

$jumlah = ($this->input->post('jumlah')) ? $this->input->post('jumlah') : 1;

$data['jumlah'] = $jumlah;

if(empty($jumlah)){

	$this->setMessage("Isi banyaknya data yang ingin ditambah");
	redirect(site_url('commodity/daftar_harga/daftar_harga_barang'));

}

$position = $this->Administration_m->getPosition("PENGELOLA KOMODITI");

if(!$position){
  $this->noAccess("Hanya PENGELOLA KOMODITI yang dapat membuat harga barang komoditi");
}

$data['list_sourcing'] = $this->Commodity_m->getSourcing()->result_array();

$data['list_del_point'] = $this->Administration_m->getDistrict()->result_array();

$data['list_catalog'] = $this->Commodity_m->getMatCatalog()->result_array();

$view = 'commodity/hrg_brg/form_add_hrg_brg_v';

$this->template($view,"Tambah Harga Barang",$data);