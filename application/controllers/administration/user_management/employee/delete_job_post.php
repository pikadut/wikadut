<?php
$data = $this->db->where('employee_pos_id', $id)->get('adm_employee_pos')->row_array(); 
$delete = $this->db->where('employee_pos_id', $id)->delete('adm_employee_pos'); 

if($delete){
    if ($data['is_main_job_inp'] == 1){
	$this->db->where("id",$id)->update("adm_employee",array('adm_pos_id'=>""));
}
    $this->setMessage("Berhasil menghapus posisi employee");
}
redirect(site_url('administration/user_management/employee/ubah/'.$data['employee_id']));
