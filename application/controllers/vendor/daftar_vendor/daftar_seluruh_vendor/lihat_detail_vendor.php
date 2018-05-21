<?php 

$view = 'vendor/daftar_vendor/daftar_seluruh_vendor/lihat_detail_vendor_v';


$vendor_id = $this->uri->segment(4, 0);
//haqim
// $vendor_id = $this->uri->segment(4, 0);
switch ($this->uri->segment(3,0)) {
  case 'lihat_detail_vendor':
    $vendor_id = $this->uri->segment(4, 0);
    break;
  
  default:
    $vendor_id = $this->uri->segment(3, 0);
    break;
}
// end

$data = array(

  'jumlah' =>1,
  'header'=> array(),
  'alamat'=> array(),
  'tipe'=> array(),
  'akta'=> array(),
  'izin_lain'=> array(),
  'agent_importir'=> array(),
  'board'=> array(),
  'bank'=> array(),
  'financial'=> array(),
  'barang'=> array(),
  'sdm'=> array(),
  'sertifikasi'=> array(),
  'fasilitas'=> array(),
  'pengalaman'=> array(),
  'tambahan'=> array(),
  'dokumen'=> array(),

  );

$url_ws = "http://vendor.pengadaan.com:8888/RESTSERVICE";
$url_doc = "http://vendor.pengadaan.com/Download";
$data['url_ws'] = $url_ws;
$data['url_doc'] = $url_doc;

$vendor = json_decode(file_get_contents($url_ws."/vndheader.json?token=123456&act=1&vndHeader.vendorId=".$vendor_id), true);
if(!empty($vendor)){
  $data['header'] = (isset($vendor["listVndHeader"][0])) ? $vendor["listVndHeader"][0] : array();
}

$alamat = json_decode(file_get_contents($url_ws."/vndaddress.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
if(!empty($alamat)){
  $data['alamat'] = $alamat["listVndAddress"];
  //print_r($data['alamat']);
}

$tipe = json_decode(file_get_contents($url_ws."/vndcompanytype.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
if(!empty($tipe)){
  $tipe = $tipe["listVndCompanyType"];
  $mytipe = array();
  if(!empty($tipe)){
  foreach ($tipe as $key => $value) {
    $mytipe[] = array("company_type"=>$value['id']['companyType']);
  }
}
$data['tipe'] = $mytipe;
}

$akta = json_decode(file_get_contents($url_ws."/vndakta.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
if(!empty($akta)){
  $data['akta'] = $akta["listVndAkta"];
}

$ijin = json_decode(file_get_contents($url_ws."/vndijin.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
if(!empty($ijin)){
  $data['izin_lain'] = $ijin["listVndIjin"];
}

$agent = json_decode(file_get_contents($url_ws."/vndagent.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
if(!empty($agent)){
  $data['agent_importir'] = $agent["listVndAgent"];
}

$board = json_decode(file_get_contents($url_ws."/vndboard.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
if(!empty($board)){
  $data['board'] = $board["listVndBoard"];
}

$bank = json_decode(file_get_contents($url_ws."/vndbank.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
if(!empty($bank)){
  $data['bank'] = $bank["listVndBank"];
}

$financial = json_decode(file_get_contents($url_ws."/vndfinrpt.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
if(!empty($financial)){
  $data['financial'] = $financial["listVndFinRpt"];
}

$data['barang'] = $this->db->query("select distinct group_type as catalog_type, product_name, product_description, brand, vnd_product.source , vnd_product.type from vnd_product left join com_group on product_code = group_code where vendor_id = ".$vendor_id)->result_array();

$sdm = json_decode(file_get_contents($url_ws."/vndsdm.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
if(!empty($sdm)){
  $data['sdm'] = $sdm["listVndSdm"];
}

$sertifikasi = json_decode(file_get_contents($url_ws."/vndcert.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
if(!empty($sertifikasi)){
  $data['sertifikasi'] = $sertifikasi["listVndCert"];
}

$fasilitas = json_decode(file_get_contents($url_ws."/vndequip.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
if(!empty($fasilitas)){
  $data['fasilitas'] = $fasilitas["listVndEquip"];
}

$pengalaman = json_decode(file_get_contents($url_ws."/vndcv.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
if(!empty($pengalaman)){
  $data['pengalaman'] = $pengalaman["listVndCv"];
}

$tambahan = json_decode(file_get_contents($url_ws."/vndadd.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
if(!empty($tambahan)){
  $data['tambahan'] = $tambahan["listVndAdd"];
}

$dokumen = json_decode(file_get_contents($url_ws."/vndsuppdoc.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
if(!empty($dokumen)){
  $data['dokumen'] = $dokumen["listVndSuppDoc"];
}

$mydata = array();

foreach ($data as $key => $value) {
  $k = strtolower(preg_replace('/\B([A-Z])/', '_$1', $key));
  $mydata[$k] = $value;
  if(is_array($value) && !empty($value)){
    foreach ($value as $key2 => $value2) {
      $k2 = strtolower(preg_replace('/\B([A-Z])/', '_$1', $key2));
      $mydata[$k][$k2] = $value2;
      if(is_array($value2) && !empty($value2)){
        foreach ($value2 as $key3 => $value3) {
          $k3 = strtolower(preg_replace('/\B([A-Z])/', '_$1', $key3));
          $mydata[$k][$k2][$k3] = $value3;
          if(is_array($value3) && !empty($value3)){
            foreach ($value3 as $key4 => $value4) {
              $k4 = strtolower(preg_replace('/\B([A-Z])/', '_$1', $key4));
              $mydata[$k][$k2][$k3][$k4] = $value4;
            }
          }
        }
      }
    }
  }
}

//print_r($mydata);

$this->template($view,"Profil Vendor",$mydata);