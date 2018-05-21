<?php

$jumlah = ($this->input->post('jumlah')) ? $this->input->post('jumlah') : 1;

$data['jumlah'] = $jumlah;

if(empty($jumlah)){

	$this->setMessage("Isi banyaknya data yang ingin ditambah");
	redirect(site_url('commodity/katalog/grup_barang'));

}

$position = $this->Administration_m->getPosition("PENGELOLA KOMODITI");

if(!$position){
  $this->noAccess("Hanya PENGELOLA KOMODITI yang dapat membuat grup barang komoditi");
}

$data['list_group'] = $this->Commodity_m->getMatGroupActive()->result_array();

$view = 'commodity/grup_brg/form_add_grup_brg_v';

$this->template($view,"Tambah Grup Barang",$data);