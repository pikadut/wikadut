<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Telescoope_Controller extends CI_Controller {

  var $error_page = false;

  function __construct(){

    parent::__construct();

    //$this->output->enable_profiler(TRUE);

    $this->load->model(array('globalparam_m','Administration_m'));
    
    $this->lang->load(array('form_validation','custom'), 'indonesian');

    $this->load->helper('language');

    $this->data["picker"] = $this->session->userdata("picker");

    $default_currency = array();

    $currency = $this->db->get("adm_curr")->result_array();

    foreach ($currency as $key => $value) {
      $default_currency[$value['curr_code']] = $value['curr_code']." - ".$value['curr_name'];
    }

    $this->data['default_currency'] = $default_currency;

    $validation_key = array("required",
      "isset",
      "valid_email",
      "valid_emails",
      "valid_url",
      "valid_ip",
      "min_length",
      "max_length",
      "exact_length",
      "alpha",
      "alpha_numeric",
      "alpha_numeric_spaces",
      "alpha_dash",
      "numeric",
      "is_numeric",
      "integer",
      "regex_match",
      "matches",
      "differs",
      "is_unique",
      "is_natural",
      "is_natural_no_zero",
      "decimal",
      "less_than",
      "less_than_equal_to",
      "greater_than",
      "greater_than_equal_to",
      "error_message_not_set",
      "in_list");

    foreach ($validation_key as $key => $value) {

      $translate = $this->lang->line('form_validation_'.$value);
      $this->form_validation->set_message($value, $translate);

    }


  }

  public function setMessage($message){

    $current_message = $this->session->userdata("message");


    if(!empty($message)){
      if(is_array($message)){
        $message = implode("<br/>", $message);
      } 
      $this->session->set_userdata("message",$message."<br/>".$current_message);
    }

  }

  public function renderMessage($status,$redirect = ""){

    $this->form_validation->set_error_delimiters('<p>', '</p>');

    $message = validation_errors();
    $message .= $this->session->userdata("message");

    if($this->input->is_ajax_request()){

      $this->output
      ->set_content_type('application/json')
      ->set_output(json_encode(array('message' => $message, "status"=>$status, "redirect"=>$redirect)));

      $this->session->unset_userdata("message");

    } else {
      $this->template("","Sorry",array());
    }

  }

  public function sendEmail($to = "",$title = "",$message = ""){

    $config['protocol'] = 'smtp';
    $config['smtp_host'] = 'ssl://smtp.googlemail.com';
    $config['smtp_user'] = 'eprocurement@jakartamrt.com';
    $config['smtp_pass'] = "eproc@mrt";
    $config['smtp_port'] = 465;
    $config['mailtype'] = 'html';
    $config['wordwrap'] = TRUE;
    $config['useragent'] = COMPANY_NAME;
    //$config['charset'] = 'utf8';
    $config['crlf'] = "\r\n";
    $config['newline'] = "\r\n";


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

  public function noAccess($message = ""){
    $msg = (empty($message)) ? "Sorry you dont have access to this menu" : $message;
    $this->setMessage($msg);
    $this->renderMessage("error","");
    $this->error_page = true;
    //$this->template("","Sorry",array());

  }

  public function selection($selector){

    $get = $this->input->get();

    $filter_add = array();
    $filter_del = array();

    $selection = $this->data[$selector];

    foreach ($get as $key => $value) {
      if($value == 1){
        $filter_add[] = $key;
      } else {
        $filter_del[] = $key;
      }
    }

    foreach ($filter_add as $key => $value) {
      if(!empty($selection)){
        if(!in_array($value, $selection)){
          $selection[] = $value;
        } 
      } else {
        $selection[] = $value;
      }
    }

    if(!empty($filter_del) && is_array($selection)){
      $selection = array_intersect($selection, $filter_del);
    }

    if(empty($get)){
      $selection = array();
    } else {

    }

    $selection = @array_unique($selection);

    $this->session->set_userdata($selector,$selection);

  }

  public function set_session($key = "",$val = ""){
    if(!empty($key)){
      $this->session->set_userdata($key,$val);
    }
  }

  public function picker(){

    $selector = "picker";

    $get = $this->input->get();

    if(!empty($get)){

      $this->session->unset_userdata($selector);

      $filter_add = array();
      $filter_del = array();

      foreach ($get as $key => $value) {
        $selection = $key;
      }

      $this->session->set_userdata($selector,$selection);

    } else {
      $data = $this->session->userdata($selector);
      echo json_encode($data);
    }

  }

  public function template($view =  "",$title = "",$data = array()){

    $user = $this->Administration_m->getLogin();

    //print_r($user);
    
    $mymenu = $this->Administration_m->getMenuUser($user['employee_id']);

    $data['position'] = $this->Administration_m->getEmployeePos($user['employee_id'])->result_array();
    
    $menu = array();

    if(!empty($mymenu)){

      foreach ($mymenu[0] as $key => $value) {

        $menu[$value['url_path']] = array(
          "icon"=>$value['icon'],
          "label"=>$value['menu_name'],
          "child"=>array()
          );

        if(isset($mymenu[$value['menu_id']]) && !empty($mymenu[$value['menu_id']])){

          $sub = $mymenu[$value['menu_id']];

          $child = array();

          foreach ($sub as $key2 => $value2) {

            $subsub = array();

            $child2 = array();

            if(isset($mymenu[$value2['menu_id']]) && !empty($mymenu[$value2['menu_id']])){

              $subsub = $mymenu[$value2['menu_id']];

              foreach ($subsub as $key3 => $value3) {

                $child2[$value['url_path']."/".$value2['url_path']."/".$value3['url_path']] = array("label"=>$value3['menu_name'],"icon"=>$value3['icon'],"child"=>array());

              }

            }

            $child[$value['url_path']."/".$value2['url_path']] = array("label"=>$value2['menu_name'],"icon"=>$value2['icon'],"child"=>$child2);

          }

          $menu[$value['url_path']]['child'] = $child;

        }

      }

    }

    $data['main_menu'] = $menu;

    $data['mytitle'] = $title;

    $setting = $this->globalparam_m->getData();

    if(empty($view)){
     $view = "default_v";
   }

   if(!empty($title)){
     $title = $setting['site_name']." - ".$title;
   } else {
     $title = $setting['site_name'];
   }

   $data['body'] = $view;
   $data['judul'] = $title;
   $data['user_login'] = $user;

   $data = array_merge($this->data, $data, $setting);

   if(!$this->error_page){

     $this->load->view("template",$data);
     
   }

 }

}