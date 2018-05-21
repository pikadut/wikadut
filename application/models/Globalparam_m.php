<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class globalparam_m extends CI_Model {

    public function __construct(){

        parent::__construct();

    }
    
    public function getData(){
        $result = $this->db->get("global_param")->result_array();
        $filter = array();
        foreach($result as $key => $val){
            $filter[$val['name_gp']] = $val['value_gp'];
        }
        return $filter;
    }

    public function getAllData(){

        return $this->db->order_by("indeks_gp","asc")->get("global_param");
    }

    public function getDataByType($type = "text"){
        return $this->db->where("type_gp",$type)->get("global_param");
    }

    public function getDataById($id){
        $res = array();
        if(!empty($id)){
            $res = $this->db->where('id_gp',$id)->get("global_param");
        }
        return $res;
    }

    public function deleteData($id){
        if(!empty($id)){
            $res = $this->db->where('id_gp',$id)->delete("global_param");
        } else {
            return false;
        }
    }

    public function deleteImg($id = ""){
        if(!empty($id)){
            $img = $this->db->where('id_gp',$id)->get("global_param")->row()->value_gp;
            $this->db->where('id_gp',$id)->update("global_param",array("value_gp"=>""));
            return unlink("../uploads/".$img);
        }
    }

    public function setStatus($id = ""){
        if(!empty($id)){

            $stat = $this->db->where('id_gp',$id)->get("global_param")->row()->status_gp;

            if($stat == 1){
                $upd = 0;
            } else {
                $upd = 1;
            }

            return $this->db->where('id_gp',$id)->update("global_param",array("status_gp"=>$upd));

            
        }
    }

    public function log($log = "",$user = ""){
        if(empty($user)){
            $user = $this->session->userdata('uid');
        }
        return $this->db->insert("log",array("username_log"=>$user,"kegiatan_log"=>$log,"waktu_log"=>date("Y-m-d H:i:s")));
    }

    public function getStatusTrans($detail = ""){
        $data = $this->db->order_by("index_st","asc")->get("status_transaction_ec")->result_array();
        $mydata = array();
        foreach ($data as $key => $value) {
            if($detail == "email"){
                $mydata[$value['label_st']] = $value['email_st'];
            } else if($detail == "end"){

                if($value['endstate_st'] == 1){
                    $mydata[] = $value['label_st'];
                }

            } else if($detail == "start"){

                if($value['startstate_st'] == 1){
                    $mydata[] = $value['label_st'];
                }

            } else {
                $mydata[] = $value['label_st'];
            }
        }
        return $mydata;
    }

    public function getCategoryIDNewest(){

        $query = "SELECT MAX(id) as max from allcategory_ec";
        $result = $this->db->query($query)->row_array();
        return $result['max']+1;
    }

    public function sendEmail($id,$status,$title = "edit"){


        $post = $this->input->post();

        $company = $this->getData();

        //print_r($company);

        $config['mailtype'] = 'html';
        $config['wordwrap'] = TRUE;
        $config['useragent'] = $company['site_title'];
        $config['charset'] = 'utf-8';
        $config['crlf'] = "\r\n";
        $config['newline'] = "\r\n";

        $this->load->library(array('email','parser'));

        $this->email->initialize($config);

        $this->load->model(array('email_m','transaction_m','paymentconfirm_m'));

        $email = $this->email_m->fetchData();

        foreach ($company as $key => $value) {
            $data[$key] = $value;
        }

        $data['logo_image'] = base_url()."backend/uploads/".$data['site_logo'];

        $data['datetime'] = date("d M Y - H:i");

        $data['email_header'] = $email[1];
        $data['email_footer'] = $email[2];
        $data['email_thankyou'] = $email[3];

        $bank_detail = $this->db->select("id_bank as id, name_bank as name, branch_bank as branch, no_bank as bank, user_bank as user")->where("status_bank",1)->get("bank_ec")->result_array();

        if($title == "edit"){

            $transaction = $this->transaction_m->getData($id)->row_array();
            $trans_detail = $this->db->select("sku_dt as sku, 
              name_dt as name, 
              variant_dt as variant, 
              price_dt as price, 
              qty_dt as qty, 
              subtotal_dt as subtotal")->where("trans_dt",$id)->get("transaction_detail_ec")->result_array();

            $this->db
            ->where(array("trans_pc"=>$id))
            ->order_by("id_pc","desc");

            $payment = $this->paymentconfirm_m->getData()->row_array();

            $data['payment_voucher'] = (isset($payment['voucher_pc'])) ? $payment['voucher_pc'] : "";
            $data['payment_change'] = (isset($payment['change_pc'])) ? number_format($payment['change_pc']) : "";
            $data['payment_note'] = (isset($payment['note_pc'])) ? $payment['note_pc'] : "";
            $data['payment_acc_num'] = (isset($payment['acc_no_pc'])) ? $payment['acc_no_pc'] : "";
            $data['payment_acc_name'] = (isset($payment['acc_name_pc'])) ? $payment['acc_name_pc'] : "";
            $data['payment_date'] = (isset($payment['date_pc'])) ? date("d/m/Y",strtotime($payment['date_pc'])) : "";
            $data['customer_first_name'] = $transaction['first_name_trans'];
            $data['customer_last_name'] = $transaction['last_name_trans'];
            $data['customer_name'] = $transaction['first_name_trans']." ".$transaction['last_name_trans'];
            $data['customer_address'] = $transaction['address_trans'];
            $data['customer_phone'] = $transaction['phone_trans'];
            $data['customer_email'] = $transaction['email_trans'];
            $data['customer_city'] = $transaction['city_trans'];
            $data['customer_postal'] = $transaction['postal_trans'];
            $data['transaction_shipping'] = number_format($transaction['shipping_trans']);
            $data['transaction_tax'] = $transaction['tax_trans'];
            $data['transaction_total'] = number_format($transaction['total_trans']);
            $data['transaction_total_tax'] = number_format($transaction['total_tax_trans']-$transaction['total_trans']);
            $discount = $transaction['amount_discount_trans'];
            if(!empty($discount)){
                $data['transaction_with_tax'] = number_format($transaction['total_tax_trans']-$discount)." ( Discount ".number_format($discount)." )";
            } else {
                $data['transaction_with_tax'] = number_format($transaction['total_tax_trans']);
            }
            $data['transaction_method'] = $transaction['method_trans'];
            $data['transaction_ref'] = $transaction['ref_trans'];
            $data['transaction_id'] = $transaction['id_trans'];

        } else {

            $data['payment_voucher'] = "";
            $data['payment_change'] = "";
            $data['payment_note'] = "";
            $data['payment_acc_num'] = "";
            $data['payment_acc_name'] = "";
            $data['payment_date'] = "";
            $data['customer_first_name'] = $post['first_name_inp'];
            $data['customer_last_name'] = $post['last_name_inp'];
            $data['customer_name'] = $post['first_name_inp']." ".$post['last_name_inp'];
            $data['customer_address'] = $post['address_inp'];
            $data['customer_phone'] = $post['phone_inp'];
            $data['customer_email'] = $post['email_inp'];
            $data['customer_city'] = $post['city_inp'];
            $data['customer_postal'] = $post['postal_inp'];
            $data['transaction_shipping'] = number_format($post['shipping_inp']);
            $data['transaction_tax'] = $post['tax_inp'];
            $data['transaction_total'] = number_format($post['total']);
            $data['transaction_total_tax'] = number_format($post['total_tax']-$post['total']);
            $data['transaction_with_tax'] = number_format($post['total_tax']);
            $data['transaction_method'] = "";
            $data['transaction_ref'] = ""; 
            $data['transaction_id'] = "";

        }

        foreach ($trans_detail as $key => $value) {
            $trans_detail[$key]['price'] = number_format($trans_detail[$key]['price']);
            $trans_detail[$key]['subtotal'] = number_format($trans_detail[$key]['subtotal']);
        }

        $data['transaction_detail'] = $trans_detail;

        $data['bank_detail'] = $bank_detail;

        //$header = $this->load->view("email_template","",true);

        $header = "<html><body>";

        $footer = "</body></html>";

        $status_list = $this->getStatusTrans("email");

        //print_r($status_list);

        $email_cont = $email[$status_list[$status]];

        $content = trim($header.$email_cont.$footer);

        $html = $this->parser->parse_string($content,$data,true);

        $this->email->from($company['site_email'], $company['site_title']);
        $this->email->to($data['customer_email']); 

        $this->email->subject("Your transaction status #".$id." - ".$status);
        $this->email->message($html);  

        $this->email->send();

        $this->email->clear();

        //echo $this->email->print_debugger();

        //die();

        //echo $html;

    }
    
}
