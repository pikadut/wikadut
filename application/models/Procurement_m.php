<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Procurement_m extends CI_Model {

	public function __construct(){

		parent::__construct();

	}

	public function getKategoriDokumen($id = ""){

		if(!empty($id)){

			$this->db->where("ldc_id",$id);

		}

		$this->db->order_by("ldc_id","asc");

		return $this->db->get("prc_lkpdoc");

	}

		public function getPekerjaan($id = ""){

		$where = " WHERE A.ppc_name IS NULL AND A.ppc_end_date IS NULL ";

		$where2 = " WHERE C.ptc_name IS NULL AND C.ptc_end_date IS NULL ";

		$sql = "SELECT A.ppc_id,B.pr_number,A.ppc_name,A.ppc_position,B.pr_subject_of_work FROM prc_pr_comment A 
		INNER JOIN prc_pr_main B ON B.pr_number = A.pr_number
		$where
		UNION ALL
		SELECT C.ptc_id,D.ptm_number,C.ptc_name,C.ptc_position,D.ptm_subject_of_work FROM prc_tender_comment C
		INNER JOIN prc_tender_main D ON C.ptm_number = D.ptm_number	
		$where2";

		return $this->db->query($sql);

	}

}