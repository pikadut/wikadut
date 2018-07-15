<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Procpr_m extends CI_Model {

	public function __construct(){

		parent::__construct();

	}


	public function getPR($id = ""){

		// $this->db->select("prc_pr_main.*,COALESCE(
		// 	(SELECT awa_name FROM adm_wkf_activity WHERE adm_wkf_activity.awa_id = 
		// 		(SELECT ppc_activity FROM prc_pr_comment WHERE prc_pr_comment.pr_number = prc_pr_main.pr_number AND ppc_name IS NULL)
		// 		),'Permintaan dilanjutkan ke RFQ-Undangan') as status, COALESCE((select format(sum(prc_pr_item.ppi_quantity*prc_pr_item.ppi_price*1.1),2) as jumlah from prc_pr_item where prc_pr_item.pr_number = prc_pr_main.pr_number GROUP BY prc_pr_item.pr_number), 0) AS nilai ");


		if(!empty($id)){

			$this->db->where("pr_number",$id);

		}

		 // return $this->db->get("prc_pr_main");
		 return $this->db->get("vw_daftar_pekerjaan_sppbj");

	}

		public function getMonitorPR($id = ""){

		if(!empty($id)){

			$this->db->where("pr_number",$id);

		}

		return $this->db->get("vw_prc_pr_monitor");

	}

	public function getUrutPR($tahun = ""){

		$tahun = (empty($tahun)) ? date("Y") : $tahun;

		if(!empty($tahun)){
			$this->db->where("EXTRACT(YEAR FROM pr_created_date) =", $tahun,false);
		}

		$this->db->select("COUNT(pr_number) as urut");

		$get = $this->db->get("prc_pr_main")->row()->urut;

		return "PR.".date("Ym").".".urut_id($get+1,5);

	}

	public function insertDataPR($input=array()){

		if (!empty($input)){

			$this->db->insert("prc_pr_main",$input);

			return $this->db->affected_rows();
		}
		
	}

	public function insertItemPR($input=array()){

		if (!empty($input)){

			unset($input['ppi_id']);

			$this->db->insert("prc_pr_item",$input);

			return $this->db->affected_rows();
		}
		
	}

	public function updateItemPR($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('ppi_id',$id)->update('prc_pr_item',$input);

			return $this->db->affected_rows();

		}

	}

	public function updateDataPR($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('pr_number',$id)->update('prc_pr_main',$input);

			return $this->db->affected_rows();

		}

	}

	public function getViewPekerjaanPR($id=""){

		if(!empty($id)){

			$this->db->where("pr_number",$id);

		}


		return $this->db->get('vw_daftar_pekerjaan_pr');
	}

	public function getPekerjaanPR($id = ""){

		if(!empty($id)){

			$this->db->where("A.pr_number",$id);

		}

		$this->db->join("prc_pr_main B","B.pr_number = A.pr_number","left");

		$this->db->join("adm_wkf_activity C","C.awa_id = A.ppc_activity","left");

		$this->db->where(array("A.ppc_name"=>null,"A.ppc_end_date"=>null));

		$this->db->where_not_in("A.ppc_activity",array(1904));

		return $this->db->get("prc_pr_comment A");

	}

	public function getDokumenPR($code = "",$tender = ""){

		if(!empty($code)){

			$this->db->where("ppd_id",$code);

		}

		if(!empty($tender)){

			$this->db->where("pr_number",$tender);

		}

		$this->db->order_by("ppd_id","asc");

		return $this->db->get("prc_pr_doc");

	}


	public function getItemPR($code = "",$tender = ""){

		if(!empty($code)){

			$this->db->where("ppi_id",$code);

		}

		if(!empty($tender)){

			$this->db->where("pr_number",$tender);

		}

		$this->db->order_by("ppi_id","asc");

		return $this->db->get("prc_pr_item");

	}

	public function replaceItemPR($id,$input){

		if(!empty($input)){

			if(!empty($id)){

				$this->db->where(array("pr_number"=>$input['pr_number'],"ppi_id"=>$id));
				$check = $this->getItemPR()->row_array();
				if(!empty($check)){
					$last_id = $check['ppi_id'];
					$this->updateItemPR($last_id,$input);
				} else {
					$this->insertItemPR($input);
					$last_id = $this->db->insert_id();
				}

			} else {
				$this->insertItemPR($input);
				$last_id = $this->db->insert_id();
			}
			
			return $last_id;

		}

	}

	public function deleteIfNotExistItemPR($id,$deleted){
		if(!empty($id) && !empty($deleted)){
			$this->db->where_not_in("ppi_id",$deleted)->where("pr_number",$id)->delete("prc_pr_item");
			return $this->db->affected_rows();
		}
	}


	public function insertDokumenPR($input){

		if (!empty($input)){

			unset($input['ppd_id']);

			$this->db->insert("prc_pr_doc",$input);

			return $this->db->affected_rows();

		}

	}

	public function replaceDokumenPR($id,$input){

		if(!empty($input)){

			if(!empty($id)){

				$this->db->where(array("pr_number"=>$input['pr_number'],"ppd_id"=>$id));
				$check = $this->getDokumenPR()->row_array();
				if(!empty($check)){
					$last_id = $id;
					$this->updateDokumenPR($last_id,$input);
				} else {
					$this->insertDokumenPR($input);
					$last_id = $this->db->insert_id();
				}

			} else {
				$this->insertDokumenPR($input);
				$last_id = $this->db->insert_id();
			}

			return $last_id;

		}

	}

	public function deleteIfNotExistDokumenPR($id,$deleted){
		if(!empty($id) && !empty($deleted)){
			$this->db->where_not_in("ppd_id",$deleted)->where("pr_number",$id)->delete("prc_pr_doc");
			return $this->db->affected_rows();
		}
	}

	public function updateDokumenPR($id, $input = array()){

		if(!empty($id) && !empty($input)){

			$this->db->where('ppd_id',$id)->update('prc_pr_doc',$input);

			return $this->db->affected_rows();

		}

	}

	public function do_upload($name) {

        /*
			menggunakan config upload di construct controller
        */
 		
        if(!$this->upload->do_upload($name)) //upload and validate
        {

            $this->upload->display_errors(); //show ajax error

        }
        return $this->upload->data('file_name');
    }

    //haqim
	public function submit_chat_pr($data){
		$this->db->insert('prc_chat_pr', $data);
		return $this->db->affected_rows();
	}

	public function chat_pr($pr_number,$ybs){

		$this->db->select('pr_number,employee_from,employee_to,employee_cc,pesan,date,attach');
		$this->db->where('pr_number', $pr_number);
		$this->db->group_start();
		$this->db->like('employee_from', $ybs);
		$this->db->or_like('employee_to', $ybs);
		$this->db->or_like('employee_cc', $ybs);
		$this->db->group_end();
		$this->db->order_by('status', 'desc');
		$this->db->order_by('date', 'desc');

		return $this->db->get('prc_chat_pr')->result_array();
	}
	//end

}