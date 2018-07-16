<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Log extends Telescoope_Controller {

	var $data;

	public function __construct(){

        // Call the Model constructor
		parent::__construct();

		$this->load->model(array('Administration_m',"Procpr_m","Procrfq_m","Contract_m","Vendor_m"));

		$this->form_validation->set_error_delimiters('<span class="help-block">', '</span>');

		$userdata = $this->Administration_m->getLogin();

		$this->data['userdata'] = (!empty($userdata)) ? $userdata : array();

		$sess = $this->session->all_userdata();


	}

	public function change_role($id = ""){

		$emp = $this->data['userdata'];
		$check = $this->db->where(array("pos_id"=>$id,"employee_id"=>$emp['employee_id']))
		->get("vw_adm_pos")->num_rows();
		if(!empty($check)){
			$this->session->set_userdata(do_hash("ROLE"),$id);
		}

		redirect(site_url());

	}

	// public function download_attachment($folder = "",$filename = ""){
	public function download_attachment($folder = "",$subfolder="",$filename = ""){

		switch ($folder) {
			case 'procurement':
			$subfolders = array("permintaan","chat_sppbj","chat_rfq","tender","panitia","perencanaan","sanggahan");
			break;
			//haqim
			case 'contract':
			$subfolders = array("comment","jaminan","document","milestone");
			break;
			//end
			case 'administration':
				# code...
			break;
			case 'vendor':
				# code...
			break;
			case 'commodity':
			$subfolders = array("barang","jasa");
			break;
			default:
				# code...
			break;
		}

		if(!empty($subfolders)){
			
			foreach ($subfolders as $key => $value) {

				$file = str_replace("system/","",BASEPATH)."uploads/".$folder."/".$value."/".$filename;

				if (file_exists($file)) {
					$this->load->helper('download');
					force_download($file, null);
					exit;
				}

				$file = str_replace("system/","",BASEPATH)."uploads/comment/".$folder."/".$value."/".$filename;

				if (file_exists($file)) {
					$this->load->helper('download');
					force_download($file, NULL);
					exit;
				} 
			}

		} else {
			//haqim
			$file = str_replace("system/","",BASEPATH)."uploads/".$folder."/".$subfolder; 
			//$subfolder (tadinya $filename) adalah nama filenya jika file tidak didalam subfolder manapun
			//end
			if (file_exists($file)) {
				$this->load->helper('download');
				force_download($file, NULL);
				exit;
			} 

		}
		echo "<script>alert(\"File tidak ditemukan.\"); window.history.go(-1);</script>";
	}
	
	public function download_attachment_extranet($folder = "",$vendorid = "",$filename = ""){

		$file = str_replace("system/","",BASEPATH)."extranet/attachment/".$vendorid."/".$folder."/".$filename;
		
		if (file_exists($file)) {

			$this->load->helper('download');
			force_download($file, NULL);
			exit;
		}
		echo "<script>alert(\"File tidak ditemukan.\"); window.history.go(-1);</script>";
		exit;
	}

	public function index(){

		$sess = $this->session->userdata(do_hash(SESSION_PREFIX));

		$data = array();
		if(!empty($sess)){
			

			$data['total_pr'] = $this->Procpr_m->getPR()->num_rows();
			
			$data['total_rfq'] = $this->Procrfq_m->getRFQ()->num_rows();
			//y start
			$this->db->select_sum("b.total_ppn")
			->join("vw_prc_quotation_vendor_sum b", "a.ptm_number = b.ptm_number and a.vendor_id = b.vendor_id")
			->where(array("a.status"=>2901));
			//y end			
			$ctr = $this->Contract_m->getData()->row_array();
			$data['total_contract'] = (isset($ctr['total_ppn'])) ? $ctr['total_ppn'] : 0;
			$data['total_vendor'] = $this->Vendor_m->getVendorActive()->num_rows();
			$data['top_commodity'] = $this->db->limit(5)->get('vw_prc_item_sum')->result_array();
			$method_label = array(0=>"Penunjukkan Langsung",1=>"Pemilihan Langsung",2=>"Pelelangan");
			$method = $this->db->select("count(ptp_id) as total,ptp_tender_method")->where("ptp_tender_method is not null")->group_by("ptp_tender_method")->get('prc_tender_prep')->result_array();
			foreach ($method as $key => $value) {
				$method[$key]['label'] = $method_label[$value['ptp_tender_method']];
			}
			$data['top_proc_method'] = $method;
			$this->load->helper("String");
			//hlmifzi
			$user = $this->Administration_m->getLogin();
			$position = $this->Administration_m->getEmployeePos($user['employee_id'])->row_array();

			//hlmifzi chatting
			// $jml_chat = $this->db
			// ->where('id_employee_to',$user['employee_id'])
			// ->where('status',1)
			// ->get('t_chat_main')->num_rows();
			
			// $session_userdata = [
			// 	'jml_chat' => $jml_chat,
			// 	'user_id'  => $user['employee_id'],
			// 	'pos_id'  => $user['pos_id'],
			// ];
			// $this->session->set_userdata($session_userdata);
			//end

				$this->template("dashboard_v","Dashboard",$data);			

		} else {
			
			$this->load->view("login_v");
		}

	}

	

	public function test_email(){
		$msg = "Dengan hormat,

		Bersama ini kami sampaikan bahwa ".COMPANY_NAME." membuka pendaftaran untuk dapat berpartisipasi dalam pengadaan nomor ........................... dengan Subjek '.....................................................................' (

			Detail mengenai pengadaan ini dapat di lihat melalui ".COMPANY_WEBSITE." 
			Pendaftaran dapat dilakukan melalui e-Procurement dengan memastikan bahwa data perusahaan anda sudah ter-update.";
			$email = $this->sendEmail(COMPANY_EMAIL,"Pemberitahuan Tender Nomor 0003/RFQ/33/01-2016",$msg);

			echo $this->email->print_debugger();
	//echo $email;
		}

		public function remove_file(){
			$post = $this->input->post();
			$loc = str_replace("_", "/", $post['folder']);
			$root = str_replace("application","",APPPATH);
			$dir = $root."/uploads/".$loc;
			$dir = str_replace(array("\\","//"), "/", $dir);
			$file = $post['file'];
			if(unlink($dir."/".$file)){
				echo 1;
			} else {
				echo 0;
			}
		}

		public function doupload(){

			$message = "";

			$loc = $this->session->userdata("dir_upload");
			$module = $this->session->userdata("module");


			$status = "error";

			$url = "";

			if(!empty($loc)){
				$exp = explode("_", $loc);
				$module = $exp[0];
				$loc = str_replace("_", "/", $loc);
				$root = str_replace("application","",APPPATH);
				$dir = $root."/uploads/".$loc;
				$dir = str_replace(array("\\","//"), "/", $dir);
				$config['allowed_types'] = 'jpg|gif|png|doc|docx|xls|xlsx|ppt|pptx|pdf|jpeg|zip|rar|tgz|7zip|tar';
				$config['overwrite'] = false;

				if (!file_exists($dir)){
					mkdir($dir, 0777, true);
				}

				$config['upload_path'] = $dir;
				$config['encrypt_name'] = true;
				$config['max_size'] = 5120; //y max file upload

				$this->load->library('upload', $config);

				if(!empty($_FILES['file']['tmp_name'])){

					if ($this->upload->do_upload('file')){
						$upl = $this->upload->data();
						$message = $upl['file_name'];
						$url = site_url('log/download_attachment/'.$module.'/'.$message);
						$status = "success";
					} else {
						$message = $this->upload->display_errors('', '');
					}

				} else {
					$message = "No file";
				}

			} else {
				$message = "No directory";
			}

			$this->session->unset_userdata("message");

			echo json_encode(array("message"=>$message,"status"=>$status,"url"=>$url));

		}

		private function upload_files($path, $title, $files)
		{

			if (!file_exists($path)){
				mkdir($path, 0777, true);
			}

			$config = array(
				'upload_path'   => $path,
				'allowed_types' => 'jpg|gif|png|doc|docx|xls|xlsx|ppt|pptx|pdf|jpeg|zip|rar|tgz|7zip|tar',
				'overwrite'     => 1,
				'max_size'		=> 5120, //y max file upload                    
			);

			$this->load->library('upload', $config);

			$files = array();

			$return = array();

			foreach ($files['name'] as $key => $file) {

				$_FILES['files[]']['name']= $files['name'][$key];
				$_FILES['files[]']['type']= $files['type'][$key];
				$_FILES['files[]']['tmp_name']= $files['tmp_name'][$key];
				$_FILES['files[]']['error']= $files['error'][$key];
				$_FILES['files[]']['size']= $files['size'][$key];

				$fileName = $file;

				if(!empty($title)){
					$fileName = $title .'_'. $file;
				}

				$files[] = $fileName;

				$config['file_name'] = $fileName;

				$this->upload->initialize($config);

				if ($this->upload->do_upload('files[]')) {
					$return[] = array("data"=>$this->upload->data(),"error"=>false);
				} else {
					$return[] = array("data"=>false,"error"=>$this->upload->display_errors());
				}
			}

			return $return;
		}

		public function logout(){

			$this->session->unset_userdata(do_hash(SESSION_PREFIX));
			$this->session->sess_destroy();
			redirect(site_url('log'));

		}

		public function submit_change_password(){

			$post = $this->input->post();

			if(!empty($post)){

				$u = $this->data['userdata'];
				$oldpass = strtoupper(do_hash($post['password_lama_inp'],'sha1'));
				$check2 = $this->db->where(array("password"=>$oldpass,"id"=>$u['id']))->get("adm_user")->row_array();
				if($post['password_baru_inp'] != $post['password_baru_ulang_inp']){
					$this->setMessage("Password baru dan ulangi password tidak sama","Error");
				} else if(empty($check2)){
					$this->setMessage("Password lama salah","Error");
				} else {
					$pass = strtoupper(do_hash($post['password_baru_inp'],'sha1'));
					$input = array("password"=>$pass);
					$this->db->where("id",$u['id'])->update("adm_user",$input);
					$this->setMessage("Sukses mengubah password","Success");
					redirect(site_url('home'));
				}
			}

			$data['controller_name'] = "log";
			$this->template("change_password_v","Ubah Password",$data);

		}

		public function change_password(){
			$data['controller_name'] = "log";
			$this->template("change_password_v","Ubah Password",$data);
		}

		public function in(){

			$method = "login";
			$post = $this->input->post();

			$this->form_validation->set_rules('username_login', 'Username', 'required');
			$this->form_validation->set_rules('password_login', 'Password', 'required');

			if ($this->form_validation->run() == FALSE){

				$this->index();

			} else {

				$username = $post['username_login'];
				$password = $post['password_login'];

				$data = $this->Administration_m->checkLogin($username,$password)->row_array();

			//$data['id'] = 1;

				if(!empty($data)){
					if(empty($data['is_locked']) && empty($data['status'])){
						// $first_pos = $this->db->where("employee_id",$data['employeeid'])->get("vw_adm_pos")->row()->pos_id;
						$first_pos = $this->db->where("employee_id",$data['employeeid'])->order_by('is_main_job','desc')->get("vw_adm_pos")->row()->pos_id;
						$this->session->set_userdata(do_hash("ROLE"),$first_pos);
						$this->session->set_userdata(do_hash(SESSION_PREFIX),$data['id']);
					} else {
						$this->setMessage("Sorry, your account is suspended","Error");
					}

				} else {
					$this->setMessage("Wrong username and password","Error");
				}

				redirect(site_url('home'));

			}

		}

		public function forgot(){

			$email = $this->input->post('email');

			if(!empty($email)){

				$newpass = generateRandomString();
				$encrypt = do_hash($newpass);
				$update = $this->db->where("email_user",$email)->update("user_ec",array("password_user"=>$encrypt));

				if($this->db->affected_rows() > 0){

					$data = $this->db->where("email_user",$email)->get("user_ec")->row_array();

					$user = $data['username_user'];

					$this->load->library('email');

					$config['mailtype'] = 'html';
					$config['wordwrap'] = TRUE;

					$this->email->initialize($config);

					$company = $this->globalparam_m->getData();

					$email_company = $company['site_email'];
					$name_company = $company['site_name'];

					$this->email->from($email_company, $name_company);
					$this->email->to($email); 

					$this->email->subject($name_company.' - Your new password admin panel');
					$this->email->message("<p>Dear $user,</p>
						<br/>
						<p>Your new password is $newpass. Please login <a href='".site_url('log/in')."' target='_blank'>here</a> with new password.</p>
						<br/>
						<p>Thanks,</p>
						<p>$name_company</p>");	

					$this->email->send();

					$this->session->set_userdata('message',"Success to send email reset password");

				} else {
					$this->session->set_userdata('message',"Invalid email address");
				}

			} else {
				$this->session->set_userdata('message',"Email address cannot be empty");
			}

			redirect(site_url("log/in"));

		}


	}
