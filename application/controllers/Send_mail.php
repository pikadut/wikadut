
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Send_email extends MY_Model {

	public function __construct(){

        // Call the Model constructor
		parent::__construct();

		$this->load->model(array('Administration_m',"Procpr_m","Procrfq_m","Contract_m","Vendor_m"));

		$this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');

		$userdata = $this->Administration_m->getLogin();

		$this->data['userdata'] = (!empty($userdata)) ? $userdata : array();

	}

	public function send_email(){
        //email hgb 1 tahun 
     $email_hgb = $this->db->query("SELECT 
        a.id, 
        a.nama_aset_berkala as nama_aset_berkala,
        a.nama_barang as nama_barang,
        a.id_barang as id_barang,
        a.akhir_berlaku as akhir_berlaku,
        c.fullname as fullname,
        c.email as email
        
        from ast_aset_berkala_item a 
        LEFT JOIN ast_acquisition_header b on a.acquisition_id = b.id 
        LEFT JOIN adm_employee c on b.created_by = c.id
        where a.akhir_berlaku < DATE_ADD(NOW(),INTERVAL 1 YEAR) and a.id_aset_berkala = 1")->result_array();

     foreach ($email_hgb as $data) {
        $to =  $data['email'];
        $title = "Pemberitahuan Expired Aset Berkala $data[nama_aset_berkala]";
        $msg = "Pemberitahuan ! <br>
                Terdapat Aset yang perizinannya harus diurus segera.<br>
                    Nama Aset       : $data[nama_aset_berkala] $data[nama_barang]<br>
                    Kode            : $data[id_barang]. <br> 
                    Tanggal Expired : $data[akhir_berlaku].<br>
                Silahkan segera diurus perizinannya, kemudian update di <a href='".site_url('aset/daftar_pekerjaan')."'>Daftar Pekerjaan Aset Berkala</a>";
        $this->sendEmail($to,$title,$msg);  
    }

    //email selain hgb 6 bulan
       $email_exhgb = $this->db->query("SELECT 
        a.id, 
        a.nama_aset_berkala as nama_aset_berkala,
        a.nama_barang as nama_barang,
        a.id_barang as id_barang,
        a.akhir_berlaku as akhir_berlaku,
        c.fullname as fullname,
        c.email as email
        
        from ast_aset_berkala_item a 
        LEFT JOIN ast_acquisition_header b on a.acquisition_id = b.id 
        LEFT JOIN adm_employee c on b.created_by = c.id
        where a.akhir_berlaku < DATE_ADD(NOW(),INTERVAL 6 MONTH) and a.id_aset_berkala != 1")->result_array();

     foreach ($email_exhgb as $data) {
        $to =  $data['email'];
        $title = "Pemberitahuan ! <br>
                Terdapat Aset yang perizinannya harus diurus segera.<br>
                    Nama Aset       : $data[nama_aset_berkala] $data[nama_barang]<br>
                    Kode            : $data[id_barang]. <br> 
                    Tanggal Expired : $data[akhir_berlaku].<br>
                Silahkan segera diurus perizinannya, kemudian update di <a href='".site_url('aset/daftar_pekerjaan')."'>Daftar Pekerjaan Aset Berkala</a>";
        $this->sendEmail($to,$title,$msg);  
    }

}