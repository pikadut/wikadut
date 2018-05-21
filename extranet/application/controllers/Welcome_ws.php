<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome_ws extends MY_Controller {
	
		/**
			* Index Page for this controller.
			*
			* Maps to the following URL
			* 		http://example.com/index.php/welcome
			*	- or -
			* 		http://example.com/index.php/welcome/index
			*	- or -
			* Since this controller is set as the default controller in
			* config/routes.php, it's displayed at http://example.com/
			*
			* So any other public methods not prefixed with an underscore will
			* map to /index.php/welcome/<method_name>
			* @see http://codeigniter.com/user_guide/general/urls.html
		*/
			public function __construct() {
				parent::__construct();
				$this->load->model("login");
			}
			
			public function index()
			{
				if(!empty($this->session->userdata('userid'))){
					redirect(site_url('home'));
				}
				else{
					$this->load->view('logins');
				}
			}
			
			public function lelang_login(){
				$this->load->view('lelang_logins');
			}
			
			public function gambar(){
			// Adapted for The Art of Web: www.the-art-of-web.com
			// Please acknowledge use of this code by including this header.
				
			// initialise image with dimensions of 120 x 30 pixels
				$image = @imagecreatetruecolor(120, 30) or die("Cannot Initialize new GD image stream");
				
			// set background and allocate drawing colours
				$background = imagecolorallocate($image, 0x66, 0x99, 0x66);
				imagefill($image, 0, 0, $background);
				$linecolor = imagecolorallocate($image, 0x99, 0xCC, 0x99);
				$textcolor1 = imagecolorallocate($image, 0x00, 0x00, 0x00);
				$textcolor2 = imagecolorallocate($image, 0xFF, 0xFF, 0xFF);
				
			// draw random lines on canvas
				for($i=0; $i < 6; $i++) {
					imagesetthickness($image, rand(1,3));
					imageline($image, 0, rand(0,30), 120, rand(0,30) , $linecolor);
				}
				
			// add random digits to canvas using random black/white colour
				$digit = '';
				for($x = 15; $x <= 95; $x += 20) {
					$textcolor = (rand() % 2) ? $textcolor1 : $textcolor2;
					$digit .= ($num = rand(0, 9));
					imagechar($image, rand(3, 5), $x, rand(2, 14), $num, $textcolor);
				}
				
			// record digits in session variable
				$this->session->set_userdata("digit", $digit);
				
			// display image and clean up
				header('Content-type: image/png'); 
				imagepng($image,NULL,0,NULL);
				imagedestroy($image);
			}
			
			public function in(){
				$post = $this->input->post();
				
				$username = $post['username_login'];
				$password = $post['password_login'];
				$captcha = $post['captcha'];
				$this->session->set_userdata("language", $post['bahasa']);
				
				if($captcha == $this->session->userdata("digit")){
					$login_status = $this->login->do_login($username, $password);
					
					if($login_status == '1'){
						$data = $this->db->query("select vendor_id, vendor_name, email_address as login_id from vnd_header where email_address = '".$username."'")->row_array();
						
						$session = $this->db->query("select last_access from vnd_session where login_id = '".$data["login_id"]."'")->row_array();
						if(!empty($session)){

							if(strtotime($session["last_access"]) > time()){

								$this->session->set_userdata('message', 'Maaf akun anda sedang login ditempat lain');

							} else {

								$this->session->set_userdata('userid', $data["vendor_id"]);
								$this->session->set_userdata('nama_vendor', $data["vendor_name"]);
								$this->session->set_userdata('login_id', $data["login_id"]);

								$this->db->where("login_id",$data["login_id"])->update("vnd_session",array(
									"last_access"	=> time(),
									"session_id"	=> session_id(),
									"ip_address"	=> $_SERVER['REMOTE_ADDR']
									));

							}
							
						} else {
							$this->session->set_userdata('userid', $data["vendor_id"]);
							$this->session->set_userdata('nama_vendor', $data["vendor_name"]);
							$this->session->set_userdata('login_id', $data["login_id"]);

							$this->db->insert("vnd_session",array(
								"last_access"	=> time(),
								"session_id"	=> session_id(),
								"ip_address"	=> $_SERVER['REMOTE_ADDR'],
								"login_id"		=> $data["login_id"]
								));

						}
					}
					else if($login_status == '2'){
						$this->session->set_userdata('message', 'Selamat, Anda Berhasil Melakukan Update Data. Harap Menunggu Persetujuan dari Pengelola Vendor '.COMPANY_NAME);
					}
					else if($login_status == '3'){
						$this->session->set_userdata('message', 'Gagal Update Barang');
					}
					else if($login_status == '4'){
						$this->session->set_userdata('message', 'Gagal Update Header');
					}
					else if($login_status == '5'){
						$this->session->set_userdata('message', 'Selamat, Anda Berhasil Mendaftar Sebagai Rekanan. Harap Menunggu Persetujuan Aktivasi dari Pengelola Vendor '.COMPANY_NAME);
					}
					else if($login_status == '6'){
						$this->session->set_userdata('message', 'Gagal Tambah Barang');
					}
					else if($login_status == '7'){
						$this->session->set_userdata('message', 'Gagal Tambah Header');
					}
					else if($login_status == '8'){
						$this->session->set_userdata('message', 'Username/Password salah ATAU Status Tidak Aktif ATAU Tidak Terdaftar di iProc '.COMPANY_NAME);
					}
					else if($login_status == '9'){
						$this->session->set_userdata('message', 'Login Gagal. Saat ini Anda Masih Dalam Proses Persetujuan Aktivasi.');
					}
					else if($login_status == '10'){
						$this->session->set_userdata('message', 'Login Gagal. Saat ini Anda Masih Dalam Status SUSPENDED.');
					}
					else if($login_status == '11'){
						$this->session->set_userdata('message', 'Login Gagal. Saat ini Anda Dalam Status BLACKLIST.');
					}
					else if($login_status == '12'){
						$this->session->set_userdata('message', 'Login Gagal. Saat ini Status Anda Tidak Diketahui.');
					}
					else{
						$this->session->set_userdata('message', 'Error');
					}
				}
				else{
					$this->session->set_userdata('message', 'Captcha Salah');
				}
				redirect(site_url());	
			}
			
			public function lelang_in(){
				$post = $this->input->post();
				if($post){
					if(empty($post['picker_id'])){
						$username = $post['username_login'];
						$password = $post['password_login'];
						$captcha = $post['captcha'];
						
						if($captcha == $this->session->userdata("digit")){
							$login_status = $this->login->do_login($username, $password);
							
							if($login_status == '1'){
								$session = $this->db->query("select last_access from vnd_session where login_id = '".$username."'")->row_array();
								$userid = $this->db->query("select vendor_id from vnd_header where email_address = '".$username."'")->row_array();
								if(!empty($session)){
									if(strtotime($session["last_access"])*(1*60*60) > time()){
										echo "0";
										exit();
									}
									else{
										$this->session->set_userdata('userid', $userid["vendor_id"]);
							/*
								$this->session->set_userdata('nama_vendor', $data["vendor_name"]);
								$this->session->set_userdata('login_id', $data["login_id"]);
								$this->db->query("UPDATE vnd_session SET last_access = '".time()."', session_id = '".session_id()."', ip_address = '".$_SERVER['REMOTE_ADDR']."' WHERE login_id = '".$data["login_id"]."'");
							*/
								echo "1";
								exit();
							}
						}
						else{
							$this->session->set_userdata('userid', $userid["vendor_id"]);
						/*
							$this->session->set_userdata('nama_vendor', $data["vendor_name"]);
							$this->session->set_userdata('login_id', $data["login_id"]);
							$this->db->query("INSERT INTO vnd_session (session_id, ip_address, last_access, login_id) VALUES ('".session_id()."', '".$_SERVER['REMOTE_ADDR']."', '".time()."', '".$data["login_id"]."')");
						*/
							echo "1";
							exit();
						}
					}
					else{
						echo "0";
						exit();
					}
				}
				else{
					echo "2";
					exit();
				}
			}
			else{
				$tenderid = $this->security->xss_clean($post['picker_id']);
				$klasifikasi = $this->db->query("select ptp_klasifikasi_peserta from prc_tender_prep where ptm_number = '".$tenderid."'")->row_array();
				$klasifikasi = $klasifikasi["ptp_klasifikasi_peserta"];
				
				$ven_klas = $this->db->query("select fin_class from vnd_header where vendor_id = '".$this->session->userdata("userid")."'")->row_array();
				$ven_klas = $ven_klas["fin_class"];
				
				$cek = $this->db->query("select ptm_number from prc_tender_vendor_status where ptm_number = '".$tenderid."' and pvs_vendor_code = '".$this->session->userdata("userid")."'")->num_rows();
				if($cek < 1 ) {
					if(($ven_klas == 'K' && substr($klasifikasi, 0, 1) == '1') || ($ven_klas == 'M' && substr($klasifikasi, 1, 1) == '1') || ($ven_klas == 'B' && substr($klasifikasi, 2, 1) == '1')){
						$cek_result = $this->db->query("select count(tit_id) as jumlah from prc_tender_item a join vnd_product b on substring(tit_code from 1 for 4) = b.product_code where a.ptm_number = '".$tenderid."' and b.vendor_id = ".$this->session->userdata("userid"))->row_array();
						$master = $this->db->query("select count(tit_id) as jumlah from prc_tender_item a where a.ptm_number = '".$tenderid."'")->row_array();
						if($cek_result["jumlah"] == $master["jumlah"]){
							$data = $this->db->query("select vendor_id, vendor_name, email_address as login_id, reg_isactivate, status, reg_status_id from vnd_header where vendor_id = '".$this->session->userdata("userid")."'")->row_array();
							$this->session->set_userdata('nama_vendor', $data["vendor_name"]);
							$this->session->set_userdata('login_id', $data["login_id"]);
							$this->db->query("INSERT INTO vnd_session (session_id, ip_address, last_access, login_id) VALUES ('".session_id()."', '".$_SERVER['REMOTE_ADDR']."', '".time()."', '".$data["login_id"]."')");
							echo '1';
							exit();
						}
						else{
							$this->session->unset_userdata("userid");
							echo '22';
							exit();
						}
					}
					else{
						$this->session->unset_userdata("userid");
						echo '11';
						exit();
					}
				}
				else{
					$this->session->unset_userdata("userid");
					echo '33';
					exit();
				}
			}
		}
	}
	
	public function lelang_overview($tenderid, $stat){
		$tenderid = $this->encryption->decrypt($this->umum->forbidden($tenderid, 'dekrip'));
		$stat = $this->encryption->decrypt($this->umum->forbidden($stat, 'dekrip'));
		
		$data["header"] = $this->db->query("SELECT ptp_quot_closing_date,ptp_doc_open_date,a.ptm_number, b.ptp_submission_method, a.ptm_subject_of_work, a.ptm_scope_of_work, a.ptm_contract_type, b.ptp_klasifikasi_peserta, a.ptm_currency, b.ptp_reg_opening_date, b.ptp_reg_closing_date, b.ptp_prebid_date, b.ptp_quot_opening_date, b.ptp_prebid_location, b.ptp_bid_opening2, b.ptp_tgl_aanwijzing2, b.ptp_lokasi_aanwijzing2, CASE b.ptp_tender_method WHEN '0' THEN 'PENUNJUKAN LANGSUNG' WHEN '1' THEN 'PEMILIHAN LANGSUNG' WHEN '2' THEN 'LELANG' END AS metode, now() AS waktu, b.ptp_aanwijzing_online, COALESCE (( SELECT sum(tit_quantity * tit_price * 1.1) FROM prc_tender_item WHERE ptm_number = '".$tenderid."' GROUP BY ptm_number ), 0 ) AS nilai from prc_tender_main a join prc_tender_prep b on a.ptm_number = b.ptm_number where b.ptm_number = '".$tenderid."'")->row_array();
		$data["item"] = $this->db->query("select tit_code, tit_description, tit_quantity, tit_unit from prc_tender_item where ptm_number = '".$tenderid."'")->result_array();
		$data["dokumen"] = $this->db->query("select ptd_id, ptd_category, ptd_description, ptd_file_name from prc_tender_doc where ptm_number = '".$tenderid."'")->result_array();
		if($stat == "1"){
			$data["submits"] = true;
		}
		else{
			$data["submits"] = false;
		}
		$data["lelang"] = true;
		if ($data["header"]["ptp_submission_method"] == '2') { 
			$data["tahap2"] = true;
		}
		else{
			$data["tahap2"] = false;
		}
		if($stat == "1"){
			$this->layout->view("pengadaan/overview", $data);
		}
		else{
			$this->load->view("pengadaan/overview", $data);
		}
	}
	
	public function out(){
		$this->db->query("DELETE FROM vnd_session WHERE login_id = '".$this->session->userdata('login_id')."'");
		$this->session->sess_destroy();
		redirect(site_url());
	}
	
	public function lelang(){
		$data["list"] = $this->db->query("SELECT DISTINCT M .ptm_number, M .ptm_subject_of_work, P .ptp_reg_opening_date, P .ptp_reg_closing_date, P .ptp_quot_opening_date AS bid_date FROM prc_tender_main AS M INNER JOIN prc_tender_comment AS C ON M .ptm_number = C .ptm_number INNER JOIN prc_tender_prep AS P ON M .ptm_number = P .ptm_number WHERE (C .ptc_end_date IS NULL) AND ( C .ptc_activity IN (1080, 1090, 1071, 1072)) AND (P .ptp_tender_method = '2') AND ( P .ptp_reg_opening_date <= now()) AND ( P .ptp_reg_closing_date >= now()) order by P.ptp_reg_opening_date desc")->result_array();
			//echo $this->db->last_query();
		$data["past_list"] = $this->db->query("SELECT DISTINCT M .ptm_number, M .ptm_subject_of_work, P .ptp_reg_opening_date, P .ptp_reg_closing_date, P .ptp_quot_opening_date AS bid_date FROM prc_tender_main AS M INNER JOIN prc_tender_comment AS C ON M .ptm_number = C .ptm_number INNER JOIN prc_tender_prep AS P ON M .ptm_number = P .ptm_number WHERE (C .ptc_end_date IS NOT NULL) AND ( C .ptc_activity IN (1080, 1090, 1071, 1072)) AND (P .ptp_tender_method = '2') AND ( P .ptp_reg_opening_date < now()) AND ( P .ptp_reg_closing_date < now()) AND ( P .ptp_quot_opening_date < now()) order by P.ptp_reg_opening_date desc limit 10")->result_array();
			//echo $this->db->last_query();
		$this->load->view("lelang", $data);
	}
	
	public function unduh($filename){
		$this->load->helper('download');
		$filename = $this->encryption->decrypt($this->umum->forbidden($filename, 'dekrip'));
		if(file_exists("../uploads/procurement/permintaan/".$filename)){
			force_download('../uploads/procurement/permintaan/'.$filename, NULL);
		}
		else{
			echo "<script>alert(\"File not Found\"); window.history.go(-1);</script>";
		}
	}
}	