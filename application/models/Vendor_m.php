<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Vendor_m extends CI_Model {

	public function __construct(){

		parent::__construct();

	}

	public function getVendorActive($id = ""){

			$this->db->where_in("status",array("5","9"));

		return $this->getVendor($id);

	}


	public function getVendor($code = ""){

		if(!empty($code)){

			$this->db->where("vendor_id",$code);

		}

		return $this->db->get("vw_vnd_header");

	}
	//start code hlmifzi
	public function getVendorCommodity($code = ""){

		if(!empty($code)){

			$this->db->where("vendor_id",$code);

		}

		return $this->db->get("vnd_suspend_commodity_vendor");

	}
	//end

	public function getBidderList($code = ""){

		if(!empty($code)){

			$this->db->where("vendor_id",$code);

		}

		return $this->db->get("vw_vnd_bidder_list");

	}

	public function getDaftarPekerjaan($code = ""){

		if(!empty($code)){

			$this->db->where("vendor_id",$code);

		}

		return $this->db->get("vw_daftar_pekerjaan_vendor");

	}

	public function getDaftarPekerjaanBlacklist($code = ""){

		if(!empty($code)){

			$this->db->where("vendor_id",$code);

		}

		return $this->db->get("vw_daftar_pekerjaan_blacklist_vendor");

	}

	public function getDaftarSuspend($id = ""){

		if(!empty($id)){

			$this->db->where("vendor_id ='".$id."'");

		}

		return $this->db->get("vnd_comment");

	}

	public function getAktivasiSuspend($code = ""){

		if(!empty($code)){

			$this->db->where("vendor_id",$code);

		}

		return $this->db->get("vw_aktivasi_suspend_vendor");

	}

	public function getUnsuspendVendor($code = ""){

		if(!empty($code)){

			$this->db->where("vendor_id",$code);

		}

		return $this->db->get("vw_unsuspend_vendor");

	}

	public function getBlacklistVendor($code = ""){

		if(!empty($code)){

			$this->db->where("vendor_id",$code);

		}

		return $this->db->get("vw_blacklist_vendor");

	}

}