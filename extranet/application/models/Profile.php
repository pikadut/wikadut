
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Profile extends CI_Model {

	public function datavendor($vendor_id){

		if(empty($this->session->userdata("header_profile"))){
			$header = json_decode(file_get_contents("http://vendor.pengadaan.com:8888/RESTSERVICE/vndheader.json?token=123456&act=1&vndHeader.vendorId=".$vendor_id), true);
			$this->session->set_userdata('header_profile', $header["listVndHeader"][0]);
		}
		$data['header'][0] = $this->session->userdata("header_profile");

		if(empty($this->session->userdata("alamat_profile"))){
			$alamat = json_decode(file_get_contents("http://vendor.pengadaan.com:8888/RESTSERVICE/vndaddress.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
			$this->session->set_userdata('alamat_profile', $alamat["listVndAddress"]);
		}
		$data['alamat'] = $this->session->userdata("alamat_profile");

		if(empty($this->session->userdata("tipe_profile"))){
			$tipe = json_decode(file_get_contents("http://vendor.pengadaan.com:8888/RESTSERVICE/vndcompanytype.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
			$this->session->set_userdata('tipe_profile', $tipe["listVndCompanyType"]);
		}
		$data['tipe'] = $this->session->userdata("tipe_profile");

		if(empty($this->session->userdata("akta_profile"))){
			$akta = json_decode(file_get_contents("http://vendor.pengadaan.com:8888/RESTSERVICE/vndakta.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
			$this->session->set_userdata('akta_profile', $akta["listVndAkta"]);
		}
		$data['akta'] = $this->session->userdata("akta_profile");

		if(empty($this->session->userdata("ijin_profile"))){
			$ijin = json_decode(file_get_contents("http://vendor.pengadaan.com:8888/RESTSERVICE/vndijin.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
			$this->session->set_userdata('ijin_profile', $ijin["listVndIjin"]);
		}
		$data['izin_lain'] = $this->session->userdata("ijin_profile");

		$url = "http://vendor.pengadaan.com:8888/RESTSERVICE/vndagent.json?token=123456&vendorId=".$vendor_id."&act=1";
		if(empty($this->session->userdata("agent_profile"))){

			$agent = json_decode(file_get_contents($url), true);
			$this->session->set_userdata('agent_profile', $agent["listVndAgent"]);
		}
		$data['agent_importir'] = $this->session->userdata("agent_profile");

		if(empty($this->session->userdata("board_profile"))){
			$board = json_decode(file_get_contents("http://vendor.pengadaan.com:8888/RESTSERVICE/vndboard.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
			$this->session->set_userdata('board_profile', $board["listVndBoard"]);
		}
		$data['board'] = $this->session->userdata("board_profile");

		if(empty($this->session->userdata("bank_profile"))){
			$bank = json_decode(file_get_contents("http://vendor.pengadaan.com:8888/RESTSERVICE/vndbank.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
			$this->session->set_userdata('bank_profile', $bank["listVndBank"]);
		}
		$data['bank'] = $this->session->userdata("bank_profile");

		if(empty($this->session->userdata("financial_profile"))){
			$financial = json_decode(file_get_contents("http://vendor.pengadaan.com:8888/RESTSERVICE/vndfinrpt.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
			$this->session->set_userdata('financial_profile', $financial["listVndFinRpt"]);
		}
		$data['financial'] = $this->session->userdata("financial_profile");

		$data['barang'] = $this->db->query("select distinct group_type as catalog_type, product_name, product_description, brand, vnd_product.source , vnd_product.type from vnd_product left join com_group on product_code = group_code where vendor_id = ".$vendor_id)->result_array();

		if(empty($this->session->userdata("sdm_profile"))){
			$sdm = json_decode(file_get_contents("http://vendor.pengadaan.com:8888/RESTSERVICE/vndsdm.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
			$this->session->set_userdata('sdm_profile', $sdm["listVndSdm"]);
		}
		$data['sdm'] = $this->session->userdata("sdm_profile");

		if(empty($this->session->userdata("sertifikasi_profile"))){
			$sertifikasi = json_decode(file_get_contents("http://vendor.pengadaan.com:8888/RESTSERVICE/vndcert.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
			$this->session->set_userdata('sertifikasi_profile', $sertifikasi["listVndCert"]);
		}
		$data['sertifikasi'] = $this->session->userdata("sertifikasi_profile");

		if(empty($this->session->userdata("fasilitas_profile"))){
			$fasilitas = json_decode(file_get_contents("http://vendor.pengadaan.com:8888/RESTSERVICE/vndequip.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
			$this->session->set_userdata('fasilitas_profile', $fasilitas["listVndEquip"]);
		}
		$data['fasilitas'] = $this->session->userdata("fasilitas_profile");

		if(empty($this->session->userdata("pengalaman_profile"))){
			$pengalaman = json_decode(file_get_contents("http://vendor.pengadaan.com:8888/RESTSERVICE/vndcv.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
			$this->session->set_userdata('pengalaman_profile', $pengalaman["listVndCv"]);
		}
		$data['pengalaman'] = $this->session->userdata("pengalaman_profile");

		if(empty($this->session->userdata("dokumen"))){
			$pengalaman = json_decode(file_get_contents("http://vendor.pengadaan.com:8888/RESTSERVICE/vndsuppdoc.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
			$this->session->set_userdata('dokumen', $pengalaman["listVndSuppDoc"]);
		}

		$data['dokumen'] = $this->session->userdata("dokumen");

		if(empty($this->session->userdata("tambahan_profile"))){
			$tambahan = json_decode(file_get_contents("http://vendor.pengadaan.com:8888/RESTSERVICE/vndadd.json?token=123456&vendorId=".$vendor_id."&act=1"), true);
			$this->session->set_userdata('tambahan_profile', $tambahan["listVndAdd"]);
		}
		$data['tambahan'] = $this->session->userdata("tambahan_profile");

		$url_ws = "http://vendor.pengadaan.com:8888/RESTSERVICE";
$url_doc = "http://vendor.pengadaan.com/Download";
$data['url_ws'] = $url_ws;
$data['url_doc'] = $url_doc;

		return $data;
	}
}