<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Workflow_m extends CI_Model {

	public function __construct(){

		parent::__construct();

	}

	public function getContentByActivity($id = ""){

		if(!empty($id)){

			$this->db->where("awa_id",$id);

		}

		$this->db->order_by("awc_sequence","asc");

		return $this->db->get("adm_wkf_content");

	}


	public function getActivity($id = ""){

		if(!empty($id)){

			$this->db->where("awa_id",$id);

		}

		$this->db->order_by("awa_sequence","asc");

		return $this->db->get("adm_wkf_activity");

	}

	public function getResponse($awr = "",$awa = ""){

		if(!empty($awr)){

			$this->db->where("awr_id",$awr);

		}

		if(!empty($awa)){

			$this->db->where("awa_id",$awa);

		}

		return $this->db->get("adm_wkf_response");
	}


	public function getResponseList($code){
		$this->db->order_by("awr_sequence","asc");
		$data = $this->getResponse("",$code)->result_array();
		$ret = array();
		foreach ($data as $key => $value) {
			$ret[$value['awr_id']] = $value['awr_name'];
		}
		return $ret;
	}

	public function getResponseName($code = ""){
		$response = "";
		if(!empty($code)){
			$response = $this->getResponse($code)->row_array();
			$response = (!empty($response['awr_name'])) ? $response['awr_name'] : "";
		}
		return $response;
	}

	public function fetchArrayData($post = array(),$field = array()){

		$input = array();

		foreach ($post as $key => $value) {

			if(is_array($value)){

				foreach ($value as $key2 => $value2) { 

					$this->form_validation->set_rules($key."[".$key2."]", '', '');

					foreach ($field as $k => $v) {

						if(isset($post[$v['value']][$key2])){

							$cond = array();
							$y = $post[$v['value']][$key2];
							$type = (isset($v['type'])) ? $v['type'] : "";
							
							//echo $type." = ".$y."\n";
							if($type == "number"){
								$cond[] = array(
									'number_validation',
									function($str)
									{
										$num = moneytoint($str);
										if ($num < 0)
										{
											$this->form_validation->set_message("number_validation", '{field} tidak boleh kurang dari 0');
											return FALSE;
										}
										else
										{
											return TRUE;
										}
									}
									);
							} else if($type == "text"){

							} else {
								$cond[] = 'max_length['.DEFAULT_MAXLENGTH.']';
							}
							//print_r($cond);
							$this->form_validation->set_rules($v['value']."[$key2]", 
								$v['label']." #$key2", 
								$cond);

							$x = ($type == "number") ? moneytoint($y) : (empty($y) ? null : $y);
							$input[$key2][$v['field']] = $x;

						}
						
					}

				}

			}

		}

		return $input;

	}

}