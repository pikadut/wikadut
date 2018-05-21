<?php

require_once(APPPATH . 'libraries/jqSuitePHP/jqUtils.php');

class MY_Model extends CI_Model {

	  public function sendEmail($to = "",$title = "",$message = ""){
//start code hlmifzi
    $config['protocol'] = 'smtp';
    $config['smtp_host'] = 'ssl://smtp.googlemail.com';
    //haqim
    // $config['smtp_user'] = 'e.procasdp@indonesiaferry.co.id';
    // $config['smtp_pass'] = "eproc@asdp";
    $config['smtp_user'] = 'eprocurement@jakartamrt.com';
    $config['smtp_pass'] = "eproc@mrt";
    //end
    $config['smtp_port'] = 465;
    $config['mailtype'] = 'html';
    $config['wordwrap'] = TRUE;
    $config['useragent'] = COMPANY_NAME;
    //$config['charset'] = 'utf8';
    $config['crlf'] = "\r\n";
    $config['newline'] = "\r\n";
//end

    $this->load->library(array('email','parser'));

    $this->email->initialize($config);

    $email_cont = $this->load->view("email/alert","",true);

    $content = trim($email_cont);

    $data['message'] = $message;

    $data['title'] = $title;

    $html = $this->parser->parse_string($content,$data,true);

    $this->email->from(COMPANY_EMAIL, COMPANY_NAME);
    $this->email->to($to); 

    $this->email->subject($title);
    $this->email->message($html);  

    $email = $this->email->send();

    //$this->email->clear();

    if($email){

      $this->setMessage("Success to send email to ".$to."!");

    }

    return $html;

  }

}

?>
