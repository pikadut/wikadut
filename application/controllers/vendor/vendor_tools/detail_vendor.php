<?php 

$table = "vw_bidder_list";
$field_vnd = "pvs_vendor_code";

switch ($type) {
	case 'invited':
	/*$this->db->where_in("pvs_status",array(1,-1,-2,2));*/ //hlmifzi;
	$this->db->where("ptp_tender_method <",2);// hlmifzi
	break;
	case 'win':
	$this->db->where("pvs_is_winner",1);
	break;
	case 'reg':
	/*$this->db->where("pvs_status",2);*/ //hlmifzi
	$this->db->where('pvs_status is NOT NULL', NULL, FALSE); //hlmifzi
	$this->db->where("ptp_tender_method <",2);//hlmifzi
	break;
	case 'quote':
	$table = "prc_tender_quo_main";
	$field_vnd = "ptv_vendor_code";
	break;

	default:
			# code...
	break;
}
$this->db->select("a.ptm_number,ptm_buyer,ptm_buyer_pos_name,");
$this->db->where($field_vnd, $id);
$this->db->join("prc_tender_main","prc_tender_main.ptm_number=a.ptm_number","left");
$query = $this->db->get($table." a");

$data = array(
	'controller_name'=>"vendor",
	);

$data['vendor'] = $this->db->where("vendor_id",$id)->get("vnd_header")->row_array();

$data['item'] = $query->result_array();
$data['id'] = $id;

$this->template('vendor/vendor_tools/detail_vendor',"Daftar Penawaran",$data);