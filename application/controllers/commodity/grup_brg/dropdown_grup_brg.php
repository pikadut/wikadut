<?php 

$get = $this->input->get();

$parent = (isset($get['parent']) && !empty($get['parent'])) ? $get['parent'] : "";
$level = (isset($get['level']) && !empty($get['level'])) ? $get['level'] : "";

if(!empty($parent)){
	$this->db->where("group_parent", $parent);
}

if(!empty($parent) || !empty($level)){
$rows = $this->Commodity_m->getMatGroupAll($level)->result_array();
}
else{
	$rows = [];
}

echo json_encode($rows);
