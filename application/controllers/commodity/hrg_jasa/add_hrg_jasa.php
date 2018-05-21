<?php 

$this->data['dir'] = COMMODITY_KATALOG_JASA_FOLDER;

$_SESSION["RF"]["subfolder"] = $this->data['dir'];

$jumlah = ($this->input->post('jumlah')) ? $this->input->post('jumlah') : 1;

$data['jumlah'] = $jumlah;

if(empty($jumlah)){

	$this->setMessage("Isi banyaknya data yang ingin ditambah");
	redirect(site_url('commodity/daftar_harga/daftar_harga_jasa'));

}

$position = $this->Administration_m->getPosition("PENGELOLA KOMODITI");

if(!$position){
  $this->noAccess("Hanya PENGELOLA KOMODITI yang dapat membuat harga jasa komoditi");
}

$data['list_sourcing'] = $this->Commodity_m->getSourcing()->result_array();


// matikan ini -shan

// $data['list_del_point'] = $this->Administration_m->getDelPoint()->result_array();

// end matikan -shan


// tambahkan ini
$data['list_del_point'] = $this->Administration_m->getDistrict()->result_array();

// end tambahkan

$data['list_catalog'] = $this->Commodity_m->getSrvCatalog()->result_array();

$view = 'commodity/hrg_jasa/form_add_hrg_jasa_v';

$this->template($view,"Tambah Harga Jasa",$data);