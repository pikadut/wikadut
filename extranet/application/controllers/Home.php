<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends MY_Controller {

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
		$this->load->model("profile");
	}
	
	public function index()
	{


		$userid = $this->session->userdata("userid");
		$data["undangan"] = $this->db->query("select count(a.ptm_number) as jumlah from prc_tender_vendor_status a join prc_tender_prep b on a.ptm_number = b.ptm_number where a.pvs_vendor_code = '".$userid."' and a.pvs_status = '1' and b.ptp_reg_closing_date > now()")->row_array();
		$data["negosiasi"] = $this->db->query("select count(prc_tender_vendor_status.ptm_number) as jumlah from prc_tender_vendor_status
			LEFT JOIN prc_tender_main ON prc_tender_main.ptm_number=prc_tender_vendor_status.ptm_number
			where pvs_vendor_code = '".$userid."' and pvs_status = '10' AND ptm_status=1140")->row_array();
		$data["penawaran_dikirim"] = $this->db->query("select count(ptm_number) as jumlah from prc_tender_vendor_status where pvs_vendor_code = '".$userid."' and pvs_status in (3, 21)")->row_array();

		$data["award"] = $this->db->query("select count(ptm_number) as jumlah from prc_tender_vendor_status where pvs_vendor_code = '".$userid."' and pvs_status = '11'")->row_array();
		//start code hlmifzi
		$data["menunggu_penawaran"] = $this->db->query("select count(a.ptm_number) as jumlah from prc_tender_vendor_status a join prc_tender_prep b on a.ptm_number = b.ptm_number where a.pvs_vendor_code = '".$userid."' and pvs_status in (2, 20, 12) and b.ptp_quot_closing_date > now()")->row_array();
		//end code
		$data["penawaran_dievaluasi"] = $this->db->query("select count(ptm_number) as jumlah from prc_tender_vendor_status where pvs_vendor_code = '".$userid."' and pvs_status in (-5,-8,-7,-4,4,5,7,22,23,25,26)")->row_array();
		$data["aanwijzing_online"] = $this->db->query("select count(A.ptm_number) as jumlah from prc_tender_vendor_status A
			INNER JOIN prc_tender_main B ON A.ptm_number = B.ptm_number
			INNER JOIN prc_tender_prep C ON A.ptm_number = C.ptm_number
			where C.ptp_aanwijzing_online=1 AND A.pvs_vendor_code = '".$userid."'  AND ptp_prebid_date < NOW() AND ptp_quot_opening_date > NOW() ")->row()->jumlah;
		$data["eauction"] = $this->db->query("select count(A.vendor_id) as jumlah from prc_eauction_vendor A
			INNER JOIN prc_eauction_header B ON A.PPM_ID = B.PPM_ID
			where NOW() BETWEEN TANGGAL_MULAI AND TANGGAL_BERAKHIR AND A.vendor_id = '".$userid."'")->row()->jumlah;
		$data['bast'] = $this->db
		->query("SELECT po_id as id, contract_number,po_notes as description,b.vendor_name,progress_percentage, 'WO' as type FROM ctr_po_header b
			LEFT JOIN ctr_contract_header a ON a.contract_id=b.contract_id 
			WHERE b.vendor_id='".$userid."' AND progress_percentage='100' AND COALESCE(bastp_status::integer,0) IN (0,99) AND bastp_number IS NULL
			UNION ALL 
			SELECT milestone_id as id, contract_number,b.description,vendor_name,progress_percentage, 'LUMPSUM' as type FROM ctr_contract_milestone b
			LEFT JOIN ctr_contract_header a ON a.contract_id=b.contract_id 
			WHERE a.vendor_id='".$userid."' AND progress_percentage='100' AND COALESCE(bastp_status::integer,0) IN (0,99) AND bastp_number IS NULL")
		->num_rows();

		//start code hlmifzi
		$data['tagihan'] = $this->db
		->query("SELECT invoice_id as id,b.contract_number,invoice_notes as description,b.vendor_name, 'WO' as type FROM ctr_invoice_header b
			LEFT JOIN ctr_contract_header a ON a.contract_id=b.contract_id 
			WHERE b.vendor_id='".$userid."' AND invoice_status is null AND invoice_number is NULL

			UNION ALL 

			SELECT invoice_id as id,b.contract_number,invoice_notes as description,b.vendor_name, 'WO' as type FROM ctr_invoice_milestone_header b
			LEFT JOIN ctr_contract_header a ON a.contract_id=b.contract_id 
			WHERE b.vendor_id='".$userid."' AND invoice_status is null AND invoice_number is NULL




			")->num_rows();

		$this->layout->view('home', $data);
	}
	
	public function profile(){
		$data = $this->profile->datavendor($this->session->userdata("userid"));
		$this->layout->view('profile', $data);
	}
}
