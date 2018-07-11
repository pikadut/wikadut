<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
  
  class Sinkron_m extends CI_Model {
    
    public function do_sinkron(){
      
      $login = "http://vendor.pengadaan.com:8888/RESTSERVICE/vndheader.json?token=123456&act=1&buyerId=8";
       
      $jsonfile = file_get_contents($login);
      $arrays = json_decode($jsonfile, true);
       
       
       $temp=0;
       
        foreach($arrays as $array){
        for($temp = 0; $temp < 24; $temp++){
          $create_date = ($arrays["listVndHeader"][$temp]["creationDate"]["time"]/1000);
          $addressDomisiliExpDate = ($arrays["listVndHeader"][$temp]["addressDomisiliExpDate"]["time"]/1000);
          $modified_date = ($arrays["listVndHeader"][$temp]["modifiedDate"]["time"]/1000);

          if($arrays["listVndHeader"][$temp]["finClass"] == '1'){
              $klasifikasi = 'K';
            }
            else if($arrays["listVndHeader"][$temp]["finClass"] == '2'){
              $klasifikasi = 'M';
            }
            else if($arrays["listVndHeader"][$temp]["finClass"] == '3'){
              $klasifikasi = 'B';
            }
            else{
              if(strtolower($arrays["listVndHeader"][$temp]["siupType"]) == 'kecil'){
                $klasifikasi = 'K';
              }
              else if(strtolower($arrays["listVndHeader"][$temp]["siupType"]) == 'menengah'){
                $klasifikasi = 'M';
              }
              else if(strtolower($arrays["listVndHeader"][$temp]["siupType"]) == 'besar'){
                $klasifikasi = 'B';
              }
              else{
                $klasifikasi = 'undefined';
              }
            }

        $check = $this->db->query("select vendor_id from vnd_header where vendor_id=".$arrays["listVndHeader"][$temp]["vendorId"]."");
        if($check->num_rows() > 0){ 
          $query = "UPDATE vnd_header set 
          vendor_name = '".$arrays["listVndHeader"][$temp]["vendorName"]."', 
          email_address = '".$arrays["listVndHeader"][$temp]["emailAddress"]."', 
          npwp_pkp = '".$arrays["listVndHeader"][$temp]["npwpPkp"]."', 
          fin_class = '".$klasifikasi."', 
          creation_date = '".date("Y-m-d H:i:s",$create_date)."', 
          modified_date = '".date("Y-m-d H:i:s",$modified_date)."', 
          reg_isactivate = $temp, 
          address_street = '".$arrays["listVndHeader"][$temp]["addressStreet"]."' where vendor_id = ".$arrays["listVndHeader"][$temp]["vendorId"];
          // var_dump($check); die();
            $result = $this->db->query($query); //update header vendor
        }
        $check2 = $this->db->query("select vendor_id from vnd_header where vendor_id=".$arrays["listVndHeader"][$temp]["vendorId"]."");
        if($check2->num_rows() < 1){
          // $delete = "DELETE FROM  vnd_header";
          // $del = $this->db->query($delete);

          $query = "INSERT into vnd_header (vendor_id, vendor_name, email_address, npwp_pkp, creation_date, modified_date,reg_status_id,fin_class,reg_isactivate,status,address_street, address_domisili_exp_date,login_id,password) values(".$arrays["listVndHeader"][$temp]["vendorId"].", '".$arrays["listVndHeader"][$temp]["vendorName"]."', '".$arrays["listVndHeader"][$temp]["emailAddress"]."', '".strtoupper($arrays["listVndHeader"][$temp]["npwpPkp"])."', '".date("Y-m-d H:i:s",$create_date)."', '".date("Y-m-d H:i:s",$modified_date)."',0,'".$klasifikasi."',0,0,'".$arrays["listVndHeader"][$temp]["addressStreet"]."', '".date("Y-m-d H:i:s",$addressDomisiliExpDate)."','".$arrays["listVndHeader"][$temp]["emailAddress"]."','".$arrays["listVndHeader"][$temp]["password"]."')";
          
          $result = $this->db->query($query);
        }
    }

    $error = $this->db->error();

    // If an error occurred, $error will now have 'code' and 'message' keys...
    if (isset($error['message'])) {
        return $error['message'];
    }

    // No error returned by the DB driver... 
    return null;
    }
  }
}