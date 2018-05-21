<?php 

$ubah= $this->input->post();
$id=$ubah['id'];

$nama=$this->Administration_m->get_divbirnit_dept_name($ubah['dist_id_divbirnit_inp']);

$data = array(
	'dep_code' =>$ubah['dep_code_divbirnit_inp'],
	'dept_name' => $ubah['dept_name_divbirnit_inp'],
	'district_id' => $ubah['dist_id_divbirnit_inp'],
	'district_name' => $nama,
	);    

$this->db->where('dept_id', $id);
$update=$this->db->update('adm_dept', $data); 
if($update){
	$this->setMessage("Berhasil mengubah divisi/departemen");
}

redirect(site_url('administration/master_data/divisi_biro_unit'));