<?php 

$view = 'commodity/mat_catalog/lihat_katalog_barang_v';
$data['v'] = $this->Commodity_m->getMatCatalog($id)->row_array();
$getdata = $this->Comment_m->getCommodity($id)->result_array();
if(!empty($getdata)){
	$data["comment_list"][0] = $getdata;
}
$this->template($view,"Lihat Katalog Barang",$data);