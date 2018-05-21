<?php 

$ubah= $this->input->post();

if(!empty($ubah)){

    $id = $ubah['id'];
    
    $password = $ubah['password_inp'];

    foreach (array('user_name_inp','complete_name_inp') as $key => $value) {
        $ubah[$value] = $this->security->xss_clean($ubah[$value]);
    }

    $useravailable = $this->db->where(array('id !='=>$id,"user_name"=>$ubah['user_name_inp']))->get('adm_user')->num_rows(); 

    if(empty($useravailable)){

        $data = array(
            'employeeid' => $ubah['employeeid_inp'],
            'user_name' => $ubah['user_name_inp'],
            'complete_name' => $ubah['complete_name_inp'],
            'is_locked' => (isset ($ubah['is_locked_inp'])) ? 1 : 0,
            'is_contract' => (isset ($ubah['is_contract_inp'])) ? 1 : 0,
            'is_commodity' => (isset ($ubah['is_commodity_inp'])) ? 1 : 0,
            'is_amendcontract' => (isset ($ubah['is_amendcontract_inp'])) ? 1 : 0,
            'is_po' =>(isset ($ubah['is_po_inp'])) ? 1 : 0,
            );   

        if(!empty($password)){
            $data['password'] = strtoupper(do_hash($password,'sha1'));
        }

        $update = $this->db->where('id', $id)->update('adm_user', $data); 

        if($update){
            $this->setMessage("Berhasil mengubah user");
        }

        redirect(site_url('administration/user_management/user_access'));

    } else {
        $this->session->set_userdata("message","Username telah digunakan");
        $this->edit_user_access($id);
    }

} else {
    redirect(site_url('administration/user_management/user_access'));
}