<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Procpanitia_m extends CI_Model {

	public function __construct(){

		parent::__construct();

	}

	public function getPanitia($id = ""){

		if(!empty($id)){

			$this->db->where("id",$id);

		}

		return $this->db->get("vw_adm_committee");

	}

		public function getPanitiaAnggota($id = ""){

		if(!empty($id)){

			$this->db->where("committee_id",$id);

		}

		$this->db->order_by("committee_type","asc");

		return $this->db->get("vw_adm_bid_committee");

	}


}