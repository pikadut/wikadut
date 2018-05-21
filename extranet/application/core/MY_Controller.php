<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {

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
			//date_default_timezone_set('Asia/Jakarta');
				$this->lang->load('bahasa', $this->session->userdata('language'));
				$this->load->helper('download');

			// check login session
				$kode_vendor = $this->session->userdata('userid');
				if(!$kode_vendor){
					if(!empty(uri_string())){
						$uri_string = explode("/", uri_string());
						if($uri_string[0] != "welcome"){
						redirect(site_url());
						}
					}
				}
				else{
					$this->db->query("UPDATE vnd_session SET last_access = NOW() WHERE login_id = '".$this->session->userdata('login_id')."'");
				}
			}

			public function do_upload($filename, $tenderid, $job){
				$config['upload_path']          = './attachment/'.$tenderid.'/'.$job;
				//start code hlmifi
				if($job != "penawaran" || $job != "prakualifikasi"){
					$config['max_size']             = 10250;
				}
				else{
					$config['max_size']             = 10250;
				}
				//endcode
				$config['allowed_types'] = '*';
				$config['encrypt_name'] = true;

				if (!is_dir('attachment'))
				{
					mkdir('./attachment', 0777, true);
				}
				if (!is_dir('attachment/'.$tenderid))
				{
					mkdir('./attachment/'.$tenderid, 0777, true);
				}
				if (!is_dir('attachment/'.$tenderid.'/'.$job))
				{
					mkdir('./attachment/'.$tenderid.'/'.$job, 0777, true);
				}

				$this->load->library('upload', $config);

				$this->upload->initialize($config);

				$upload = $this->upload->do_upload($filename);

				if($upload){
					return $this->upload->data('file_name');
				}
				else{
					return array("0" => "1", "1" => $this->upload->display_errors());
				}
			}

			public function download($job, $filename){
				$filename = $this->encryption->decrypt($this->umum->forbidden($filename, 'dekrip'));
				if(file_exists("./attachment/".$this->session->userdata("userid")."/".$job."/".$filename)){
					force_download('./attachment/'.$this->session->userdata("userid").'/'.$job.'/'.$filename, NULL);
				}else{
					$folder ="procurement";
					$subfolder = array("permintaan","tender","panitia","perencanaan","sanggahan");

					foreach ($subfolder as $key => $value) {
						$file = str_replace("extranet/system/","",BASEPATH)."uploads/".$folder."/".$value."/".$filename;
						if (file_exists($file)) {
							$this->load->helper('download');
							force_download($file, NULL);
							exit;
						}
						
						$file = str_replace("extranet/system/","",BASEPATH)."uploads/comment/".$folder."/".$value."/".$filename;
						
						if (file_exists($file)) {
							$this->load->helper('download');
							force_download($file, NULL);
							exit;
						}
					}

					echo "<script>alert(\"File not Found\");</script>";

				}
			}
		}
