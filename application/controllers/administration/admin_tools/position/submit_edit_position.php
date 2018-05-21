<?php 

$ubah= $this->input->post();

if(!empty($ubah)){

  foreach (array('pos_name_inp','job_title_inp') as $key => $value) {
    $ubah[$value] = $this->security->xss_clean($ubah[$value]);
  }

  $id = $ubah['id'];

  $data = array(
    'pos_name' =>$ubah['pos_name_inp'],
    'dept_id' => $ubah['dept_id_inp'],
    'job_title' =>$ubah['job_title_inp'],
    'district_id' => $ubah['district_id_inp'],
    );

  $update = $this->db->where('pos_id', $id)->update('adm_pos', $data);

  if($update){
    $this->setMessage("Berhasil mengubah posisi");
  } 

}

redirect(site_url('administration/admin_tools/position'));