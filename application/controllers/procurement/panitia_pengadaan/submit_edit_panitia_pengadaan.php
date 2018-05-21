<?php 

$ubah = $this->input->post();

if(!empty($ubah)){

	$id = $ubah['id'];

	foreach (array('committee_name_inp','panitia_file_inp') as $key => $value) {
		$ubah[$value] = $this->security->xss_clean($ubah[$value]);
	}

	$data = array(
		'committee_name' => $ubah['committee_name_inp'],
		'committee_doc'=> $ubah['panitia_file_inp']
		);

	$update = $this->db->where('id', $id)->update('adm_committee', $data); 

	if($update){
		$this->setMessage("Berhasil mengubah data panitia pengadaan");
	}

	redirect(site_url('procurement/procurement_tools/panitia_pengadaan/ubah/'.$id));

} else {

	redirect(site_url('procurement/procurement_tools/panitia_pengadaan'));

}