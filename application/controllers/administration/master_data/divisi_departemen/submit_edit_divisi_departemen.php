<?php 

$post = $this->input->post();

if(!empty($post)){

	$id = $post['id'];

	$post['dist_id_divbirnit_inp'] = $this->security->xss_clean($post['dist_id_divbirnit_inp']);

	$nama = $this->Administration_m->get_divbirnit_dept_name($post['dist_id_divbirnit_inp']);

	$data = array(
		'dep_code' =>$this->security->xss_clean($post['dep_code_divbirnit_inp']),
		'dept_name' => $this->security->xss_clean($post['dept_name_divbirnit_inp']),
		'district_id' => $post['dist_id_divbirnit_inp'],
		'district_name' => $nama,
		'dept_type'=>$post['tipe_inp'],
		'gambar_maps' => $post['gambar_attachment'],
        // 'no_sertifikat' => $post['no_sertifikat_inp'],
        // 'tgl_penerbitan' => isset($post['tgl_penerbitan_inp']) ? $post['tgl_penerbitan_inp'] : null,
        // 'luas' => $post['luas_inp'],
        // 'nama_pemegang_hak' => $post['nama_pemegang_hak_inp'],
        //'status_operasional' => $post['status_operasional_inp']
        );
  
		   

	$update = $this->db->where('dept_id', $id)->update('adm_dept', $data);

	if($update){
		$this->setMessage("Berhasil mengubah divisi/departemen");
	}

}

redirect(site_url('administration/master_data/divisi_departemen'));