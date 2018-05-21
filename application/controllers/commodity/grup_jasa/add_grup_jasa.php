<?php

$jumlah = ($this->input->post('jumlah')) ? $this->input->post('jumlah') : 1;

$data['jumlah'] = $jumlah;

if(empty($jumlah)){

	$this->setMessage("Isi banyaknya data yang ingin ditambah");
	redirect(site_url('commodity/katalog/grup_jasa'));

}

$position = $this->Administration_m->getPosition("PENGELOLA KOMODITI");

if(!$position){
  $this->noAccess("Hanya PENGELOLA KOMODITI yang dapat membuat grup jasa komoditi");
}

$data['list_group'] = $this->Commodity_m->getSrvGroupActive()->result_array();

$view = 'commodity/grup_jasa/form_add_grup_jasa_v';

$this->template($view,"Tambah Grup Jasa",$data);