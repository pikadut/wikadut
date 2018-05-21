<?php 

$jumlah = ($this->input->post('jumlah')) ? $this->input->post('jumlah') : 1;

$data['jumlah'] = $this->security->xss_clean($jumlah);

if(empty($jumlah)){

	$this->setMessage("Isi banyaknya data yang ingin ditambah");
	redirect(site_url("commodity/data_referensi/sumber"));

}

$view = 'commodity/sumber/form_add_sumber_v';

$this->template($view,"Tambah Sumber",$data);