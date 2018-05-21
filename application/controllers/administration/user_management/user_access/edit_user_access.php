<?php 

$query = $this->db->where('id', $id)->get('adm_user');

$employee_name=$this->Administration_m->employee_view()->result_array();

$data = array(
    'controller_name'=>"administration",
    'employee_name' =>$employee_name,
    );

$data['data'] = $query->row_array();
$data['id'] = $id;

$this->template('administration/user_management/user_access/edit_user_access_v',"Ubah User",$data);