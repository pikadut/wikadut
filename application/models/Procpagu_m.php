<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Procpagu_m extends CI_Model {

	public function __construct(){

		parent::__construct();

	}

	public function getMataAnggaran($id = ""){

		if(!empty($id)){

			$this->db->where("pag_id",$id);

		}

		return $this->db->get("prc_anggaran");

	}

}