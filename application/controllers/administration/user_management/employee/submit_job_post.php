<?php 

$tambah= $this->input->post();
$posisi=$this->Administration_m->get_pos_id($tambah['pos_id_inp'])->row_array();
$department=$this->Administration_m->get_divisi_departemen($posisi['dept_id'])->row_array();

$check = $this->db->where(array("employee_id"=>$tambah['employee_id']))
->get("adm_employee_pos")->num_rows();
$check = 0;

if($check > 0){
    $this->setMessage("Posisi utama tidak boleh lebih dari 1");
    $this->add_job_post($tambah['employee_id']);
} else {

$data = array(
    'employee_id' =>$tambah['employee_id'],
    'pos_id' =>$tambah['pos_id_inp'],
    'pos_name'=>$posisi['pos_name'],
    'dept_id'=>$posisi['dept_id'],
    'dept_name'=>$department['dept_name'],
    'is_active' =>(isset ($tambah['is_active_inp'])) ? 1 : 0,
    'is_main_job' => (isset ($tambah['is_main_job_inp'])) ? 1 : 0,
    );

$insert = $this->db->insert('adm_employee_pos', $data);

if($insert){
    if (isset($tambah['is_main_job_inp'])){
        $this->db->where("id",$tambah['employee_id'])
        ->update("adm_employee",array('adm_pos_id'=>$tambah['pos_id_inp']));
    }
    $this->setMessage("Berhasil menambahkan posisi employee");
}

redirect(site_url('administration/user_management/employee/ubah/'.$tambah['employee_id']));

}