<?php

$dept = $this->db->get("adm_dept")->result_array();

$cost_center = $this->db->distinct("subcode_cc,subname_cc")
->where("dept_cc",null)
->get("adm_cost_center")->result_array();

$this->db->where("code_cc !=",null)->delete('adm_cost_center');

foreach ($dept as $key => $value) {
	foreach ($cost_center as $key2 => $value2) {
		$where = array(
			"code_cc"=>$value['dep_code'],
			"dept_cc"=>$value['dept_id'],
			"subcode_cc"=>$value2['subcode_cc']
			);
		$x = $this->db->where($where)->get("adm_cost_center")->num_rows();
		if(empty($x)){
			$insert = array(
				"code_cc"=>$value['dep_code'],
				"name_cc"=>$value['dept_name'],
				"dept_cc"=>$value['dept_id'],
				"subcode_cc"=>$value2['subcode_cc'],
				"subname_cc"=>$value2['subname_cc']
				);
			$this->db->insert("adm_cost_center",$insert);
		}
	}	
}