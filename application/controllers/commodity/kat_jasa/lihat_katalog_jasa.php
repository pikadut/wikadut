<?php 

$view = 'commodity/kat_jasa/lihat_katalog_jasa_v';
$data['v'] = $this->Commodity_m->getSrvCatalog($id)->row_array();
$getdata = $this->Comment_m->getCommodity($id)->result_array();
if(!empty($getdata)){
	$data["comment_list"][0] = $getdata;
}
$this->template($view,"Lihat Katalog Jasa",$data);