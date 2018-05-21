<?php 

$post = $this->input->post();

if(!empty($post)){

	$id = $post['id'];

	$post['lane_id_inp'] = $this->security->xss_clean($post['lane_id_inp']);

	$userdata = $this->data['userdata'];

	$data = array(
        'lane_code' =>$this->security->xss_clean($post['lane_code_divbirnit_inp']),
        'origin_lane' => $this->security->xss_clean($post['origin_lane_inp']),
        'destination_lane' => $this->security->xss_clean($post['destination_lane_inp']),
        'lane_id' => $id,
        //'district_name' => $nama,
        'district_id' => $this->security->xss_clean($post['district_inp']),
        'roundtrip_type'=> $this->security->xss_clean($post['tipe_inp']),
		'lane_active'=> $this->security->xss_clean($post['status_inp']),
		'modified_date'=> date('Y-m-d H:i:s'),
		'modified_by_id'=>$userdata['employee_id']
		);    

	$update = $this->db->where('lane_id', $id)->update('adm_lane', $data);

	if($update){
		$this->setMessage("Berhasil mengubah lintasan");
	}

}

redirect(site_url('administration/master_data/lintasan'));