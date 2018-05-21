<?php 
	$view = 'tiket/daftar_pekerjaan/daftar_pekerjaan_v';
  
	//$mgr_cabang = $this->Administration_m->getPosition("PIC TIKET");
	$mgr_pusat = $this->Administration_m->getPosition("APPROVAL TIKET");
	
	if($mgr_pusat){
	$data = array("edit"=>false,"approve"=>true);
	} else {
  	$data = array("edit"=>true,"approve"=>false);
	}
	$this->template($view,"Daftar Pekerjaan Tiket",$data);
?>