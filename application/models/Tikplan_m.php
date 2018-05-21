<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tikplan_m extends CI_Model {

	public function __construct(){

		parent::__construct();

	}

	public function getUrutPT($tahun = ""){

		$tahun = (empty($tahun)) ? date("Y") : $tahun;

		if(!empty($tahun)){
			$this->db->where("EXTRACT(YEAR FROM tpm_created_date) =", $tahun,false);
		}

		$this->db->select("COUNT(tpm_number) as urut");

		$get = $this->db->get("tik_plan_main")->row()->urut;

		return "TIK/".date("m.Y")."/".urut_id($get+1,5);

	}
	
	public function getPermintaanTiket($id = ""){

		if(!empty($id)){

			$this->db->where("tpm_id",$id);		

		}

		//$this->db->where("tpm_status !=",3);
		
		return $this->db->get("tik_plan_main");

	}
	
	public function insertDataPT($input=array()){

		if (!empty($input)){

			$this->db->insert("tik_plan_main",$input);

			return $this->db->affected_rows();
		}
		
	}
	
	
	public function updateDataPT($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('tpm_id',$id)->update('tik_plan_main',$input);

			return $this->db->affected_rows();

		}

	}
	
	public function updateStatusPT($id, $status){

		if(!empty($id) && !empty($input)){

			$this->db->where('tpm_id',$id)->update('tpm_status',$status);

			return $this->db->affected_rows();

		}

	}
	
	public function getItemPT($kodeitem = "",$kodepermintaan = ""){

		if(!empty($kodeitem)){

			$this->db->where("tpi_id",$kodeitem);

		}

		if(!empty($kodepermintaan)){

			$this->db->where("tpm_id",$kodepermintaan);

		}
		
		$this->db->order_by("tpi_id","asc");

		return $this->db->get("tik_plan_item");

	}
	
	public function insertItemPT($input=array()){

		if (!empty($input)){

			unset($input['tpi_id']);

			$this->db->insert("tik_plan_item",$input);

			return $this->db->affected_rows();
		}


	}
	
	public function updateItemPT($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('tpi_id',$id)->update('tik_plan_item',$input);

			return $this->db->affected_rows();

		}

	}
	
	public function replaceItemPT($id,$input){

		if(!empty($input)){

			if(!empty($id)){

				$this->db->where(array("tpm_id"=>$input['tpm_id'],"tpi_id"=>$id));
				$check = $this->getItemPT()->row_array();
				if(!empty($check)){
					$last_id = $check['tpi_id'];
					$this->updateItemPT($last_id,$input);
				} else {
					$this->insertItemPT($input);
					$last_id = $this->db->insert_id();
				}

			} else {
				$this->insertItemPT($input);
				$last_id = $this->db->insert_id();
			}
			
			return $last_id;

		}
	}	

	
	public function deleteIfNotExistItemPT($id,$deleted){
		if(!empty($id) && !empty($deleted)){
			$this->db->where_not_in("tpi_id",$deleted)->where("tpm_id",$id)->delete("tik_plan_item");
			return $this->db->affected_rows();
		}
	}
	
	public function getHarbourPT($id = ""){
		
		$this->db->select("*,CONCAT(origin_lane,' - ',destination_lane, ' ',roundtrip_name) AS lintasan", false);
		
		if(!empty($id)){
					
			$this->db->where("lane_id",$id);
			
		}
		
		$this->db->where("lane_active",1);
		
		return $this->db->get("vw_lane");

	}
	
	
	public function getHarbourDistrictPT($kodecabang = ""){
		
		$this->db->select("*,CONCAT(origin_lane,' - ',destination_lane, ' ',roundtrip_name) AS lintasan", false);
		
		if(!empty($kodecabang)){
					
			$this->db->where("district_id",$kodecabang);
			
		}
		
		$this->db->where("lane_active",1);
		
		return $this->db->get("vw_lane");

	}
	

	public function getPengirimanTiket($id = ""){

		if(!empty($id)){

			$this->db->where("tdm_id",$id);

		}
		
		//$this->db->where("tpm_status",3);
		
		return $this->db->get("tik_del_main");

	}
	
	
	public function getInsertPengirimanTiket($id = ""){

		if(!empty($id)){

			$this->db->where("tdm_id",$id);

		}
		
		return $this->db->get("tik_del_main");

	}
	
	public function insertDataPengirimanTiket($input=array()){

		if (!empty($input)){

			$this->db->insert("tik_del_main",$input);

			return $this->db->affected_rows();
		}
		
	}
	
	public function insertItemPengirimanTiket($input=array()){

		if (!empty($input)){

			//unset($input['tri_id']);

			$this->db->insert("tik_del_item",$input);

			return $this->db->affected_rows();
		}


	}
	
	public function getItemPengirimanTiket($kodeitem = "",$kodepengiriman = ""){

		if(!empty($kodeitem)){

			$this->db->where("tdi_id",$kodeitem);

		}

		if(!empty($kodepengiriman)){

			$this->db->where("tdm_id",$kodepengiriman);

		}
		
		$this->db->order_by("tdi_id","asc");

		return $this->db->get("tik_del_item");

	}
	
	public function getItemDT($kodeitem = "",$id = ""){

		if(!empty($kodeitem)){

			$this->db->where("tdi_id",$kodeitem);

		}

		if(!empty($id)){

			$this->db->where("tpm_id",$id);

		}
		
		$this->db->join("tik_del_main","tik_del_item.tdm_id=tik_del_main.tdm_id");
		
		$this->db->order_by("tdi_id","asc");

		return $this->db->get("tik_del_item");

	}
	
	public function getPenerimaanTiket($id = ""){

		if(!empty($id)){

			$this->db->where("trm_id",$id);

		}
		
		//$this->db->where("tpm_status",3);
		
		return $this->db->get("tik_rec_main");

	}
	
	
	public function getInsertPenerimaanTiket($id = ""){

		if(!empty($id)){

			$this->db->where("tpm_id",$id);

		}
		
		return $this->db->get("tik_rec_main");

	}
	
	public function insertDataPenerimaanTiket($input=array()){

		if (!empty($input)){

			$this->db->insert("tik_rec_main",$input);

			return $this->db->affected_rows();
		}
		
	}
	
	public function insertItemPenerimaanTiket($input=array()){

		if (!empty($input)){

			//unset($input['tri_id']);

			$this->db->insert("tik_rec_item",$input);

			return $this->db->affected_rows();
		}


	}
	
	public function getItemPenerimaanTiket($kodeitem = "",$kodepenerimaan = ""){

		if(!empty($kodeitem)){

			$this->db->where("tri_id",$kodeitem);

		}

		if(!empty($kodepenerimaan)){

			$this->db->where("trm_id",$kodepenerimaan);

		}
		
		$this->db->order_by("tri_id","asc");

		return $this->db->get("tik_rec_item");

	}
	
	
}