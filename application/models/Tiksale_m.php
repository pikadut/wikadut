<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tiksale_m extends CI_Model {

	public function __construct(){

		parent::__construct();

	}

	public function getUrutPT($tahun = ""){

		$tahun = (empty($tahun)) ? date("Y") : $tahun;

		if(!empty($tahun)){
			$this->db->where("EXTRACT(YEAR FROM tsm_created_date) =", $tahun,false);
		}

		$this->db->select("COUNT(tsm_number) as urut");

		//$get = $this->db->get("tik_sale_main")->row()->urut;

		return date("F Y");

	}
	
	public function getTahunST($id = ""){

		if(!empty($id)){
			$this->db->select("*,EXTRACT(YEAR FROM tsm_periode)");
		}

		return $this->db->get("tik_sale_main");

	}
	
	public function getStokTiketCabang($id = ""){

		if(!empty($id)){

			$this->db->where("trm_district_id",$id);

			$this->db->select("*,EXTRACT(YEAR FROM tsm_periode)");			

		}
		
		return $this->db->get("vw_tiket_cabang");

	}
	
	public function getPenjualanTiket($id = ""){

		if(!empty($id)){

			$this->db->where("tsm_id",$id);		

		}
		
		return $this->db->get("tik_sale_main");

	}
	
	public function getInputPenjualanTiket($id = ""){

		if(!empty($id)){

			$this->db->where("tsm_id",$id);		

		}
		
		$this->db->where("tsm_status",999);	
		
		return $this->db->get("tik_sale_main");

	}
	
	public function insertDataST($input=array()){

		if (!empty($input)){

			$this->db->insert("tik_sale_main",$input);

			return $this->db->affected_rows();
		}
		
	}
	
	
	public function updateDataST($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('tsm_id',$id)->update('tik_sale_main',$input);

			return $this->db->affected_rows();

		}

	}
	
	public function updateStatusST($id, $status){

		if(!empty($id) && !empty($input)){

			$this->db->where('tsm_id',$id)->update('tsm_status',$status);

			return $this->db->affected_rows();

		}

	}
	
	public function getItemST($kodeitem = "",$kodepermintaan = ""){

		if(!empty($kodeitem)){

			$this->db->where("tsi_id",$kodeitem);

		}

		if(!empty($kodepermintaan)){

			$this->db->where("tsm_id",$kodepermintaan);

		}
		
		$this->db->order_by("tsi_id","asc");

		return $this->db->get("tik_sale_item");

	}
	
	public function insertItemST($input=array()){

		if (!empty($input)){

			//unset($input['tsi_id']);

			$this->db->insert("tik_sale_item",$input);

			return $this->db->affected_rows();
		}


	}
	
	public function updateItemST($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('tsi_id',$id)->update('tik_sale_item',$input);

			return $this->db->affected_rows();

		}

	}
	
	public function replaceItemST($id,$input){

		if(!empty($input)){

			if(!empty($id)){

				$this->db->where(array("tsm_id"=>$input['tsm_id'],"tsi_id"=>$id));
				$check = $this->getItemST()->row_array();
				if(!empty($check)){
					$last_id = $check['tsi_id'];
					$this->updateItemST($last_id,$input);
				} else {
					$this->insertItemST($input);
					$last_id = $this->db->insert_id();
				}

			} else {
				$this->insertItemST($input);
				$last_id = $this->db->insert_id();
			}
			
			return $last_id;

		}
	}	

	
	public function deleteIfNotExistItemST($id,$deleted){
		if(!empty($id) && !empty($deleted)){
			$this->db->where_not_in("tsi_id",$deleted)->where("tsm_id",$id)->delete("tik_sale_item");
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
	
	public function getTiketCabang($kodecabang = ""){//,$lane_name = ""){
		
		$this->db->select("lane_name,ticket_code,ticket_description,SUM(ticket_stock_branch) as ticket_stock_branch, ticket_unit, district_name");

		/*
		if(!empty($lane_name)){

			$this->db->where("lane_name",$lane_name);

		}
		*/
		
		if(!empty($kodecabang)){

			$this->db->where("district_id",$kodecabang);

		}
		
		$this->db->group_by("ticket_code");

		//$this->db->order_by("lane_name","desc");
		
		return $this->db->get("vw_tiket_cabang");

	}
	
	
}