<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Procplan_m extends CI_Model {

	public function __construct(){

		parent::__construct();

	}

	public function getPerencanaanPengadaan($id = ""){

		if(!empty($id)){

			$this->db->where("ppm_id",$id);

		}

		return $this->db->get("vw_prc_plan_main");

	}

	public function insertDataPerencanaanPengadaan($input=array()){

		if (!empty($input)){

			$this->db->insert("prc_plan_main",$input);

			return $this->db->affected_rows();
		}
		
	}

	public function updateDataPerencanaanPengadaan($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('ppm_id',$id)->update('prc_plan_main',$input);

			return $this->db->affected_rows();

		}

	}

	public function getDokumenPerencanaan($code = "",$plan = ""){

		if(!empty($code)){

			$this->db->where("ppd_id",$code);

		}

		if(!empty($plan)){

			$this->db->where("ppm_id",$plan);

		}

		$this->db->order_by("ppd_id","asc");

		return $this->db->get("prc_plan_doc");

	}

	public function insertDokumenPerencanaan($input){

		if (!empty($input)){

			$this->db->insert("prc_plan_doc",$input);

			return $this->db->affected_rows();

		}

	}

	public function updateDokumenPerencanaan($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('ppd_id',$id)->update('prc_plan_doc',$input);

			return $this->db->affected_rows();

		}

	}

}