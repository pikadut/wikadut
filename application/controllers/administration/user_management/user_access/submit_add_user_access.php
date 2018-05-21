<?php 

$tambah = $this->input->post();

if(!empty($tambah)){

    $password = $tambah['password_inp'];

    foreach (array('user_name_inp','complete_name_inp') as $key => $value) {
        $tambah[$value] = $this->security->xss_clean($tambah[$value]);
    }

    $check = $this->db->where("user_name",$tambah['user_name_inp'])->get("adm_user")->num_rows();

    if(empty($check)){

        $data = array(
            'employeeid' =>$tambah['employeeid_inp'],
            'user_name' => $tambah['user_name_inp'],
            'complete_name' =>$tambah['complete_name_inp'],
            'is_locked' =>(isset ($tambah['is_locked_inp'])) ? 1 : 0,
            'is_contract' =>(isset ($tambah['is_contract_inp'])) ? 1 : 0,
            'is_commodity' =>(isset ($tambah['is_commodity_inp'])) ? 1 : 0,
            'is_amendcontract' =>(isset ($tambah['is_amendcontract_inp'])) ? 1 : 0,
            'is_po' =>(isset ($tambah['is_po_inp'])) ? 1 : 0,
            );

        if(!empty($password)){
            $data['password'] = strtoupper(do_hash($password,'sha1'));
        }

        $insert = $this->db->insert('adm_user', $data);
        
        if($insert){
            $insert_id = $this->db->insert_id();
            $this->setMessage("Berhasil menambah user");
            redirect(site_url('administration/user_management/user_access/ubah/'.$insert_id));
        }
        
    } else {
        $this->session->set_userdata("message","Username telah digunakan");
        $this->add_user_access();
    }

} else {
    redirect(site_url('administration/user_management/user_access'));
}