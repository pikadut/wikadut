<?php 

		$ubah= $this->input->post();
		$id=$ubah['id'];
		
		$data = array(
        'npp' =>$ubah['npp_employee_inp'],
        'adm_salutation_id'=>$ubah['salutation_employee_inp'],
        'firstname' => $ubah['firstname_employee_inp'] ,
        'lastname' => $ubah['lastname_employee_inp'],
        'fullname' => $ubah['firstname_employee_inp']." ".$ubah['lastname_employee_inp'],
        'phone' => $ubah['phone_employee_inp'],
        'status' => $ubah['status_inp'],
        'email' => $ubah['email_employee_inp'],
        'employee_type_id' => $ubah['type_employee_inp'],
        'officeextension' => $ubah['offc_ext_employee_inp'],
  );

		$this->db->where('id', $id);
		$this->db->update('adm_employee', $data); 

		redirect(site_url('administration/user_management/employee'));