<?php 

$tambah= $this->input->post();

if(!empty($tambah)){

    foreach (array('email_employee_inp','firstname_employee_inp','lastname_employee_inp','offc_ext_employee_inp','phone_employee_inp') as $key => $value) {
        $tambah[$value] = $this->security->xss_clean($tambah[$value]);
    }

    $data = array(
        'npp' =>$tambah['npp_employee_inp'],
        'adm_salutation_id'=>$tambah['salutation_employee_inp'],
        'firstname' => $tambah['firstname_employee_inp'] ,
        'lastname' => $tambah['lastname_employee_inp'],
        'fullname' => $tambah['firstname_employee_inp']." ".$tambah['lastname_employee_inp'],
        'phone' => $tambah['phone_employee_inp'],
        'email' => $tambah['email_employee_inp'],
        'status' => $tambah['status_inp'],
        'employee_type_id' => $tambah['type_employee_inp'],
        'officeextension' => $tambah['offc_ext_employee_inp'],
        );
    
    $insert = $this->db->insert('adm_employee', $data);
    
    if($insert){
        $insert_id = $this->db->insert_id();
        $this->setMessage("Berhasil menambahkan employee");
        redirect(site_url('administration/user_management/employee/ubah/'.$insert_id));
    }

} else {

    redirect(site_url('administration/user_management/employee'));

}