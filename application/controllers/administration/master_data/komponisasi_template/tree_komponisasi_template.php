<?php 

$rows = $this->db->get("adm_composition_template")->result_array();
$a = array();
$c = array();
foreach ($rows as $key => $value) {
	$d = array(
		"id"=>$value['id'],
		"title"=>$value['code']." - ".$value['name'],
		"nodes"=>array()
		);
	$a[$value['parent_id']][] = $d;
	$c[$value['id']] = ($value['default_value']) ? (double) $value['default_value'] : 0;
}

$b = array();
foreach ($a[0] as $key => $value) {

	if(isset($a[$value['id']])){
		$child = $a[$value['id']];
		foreach ($child as $key2 => $value2) {
			
			if(isset($a[$value2['id']])){
				$child[$key2]['nodes'] = $a[$value2['id']];
				foreach ($a[$value2['id']] as $key3 => $value3) {

					if(isset($a[$value3['id']])){
						$child[$key2]['nodes'][$key3]['nodes'] = $a[$value3['id']];
						foreach ($a[$value3['id']] as $key4 => $value4) {

						}
					}

				}
			}

		}
		$value['nodes'] = $child;
	}
	$b[] = $value;
}
//echo "<pre>";
//print_r($b);
$x =array("tree"=>$b,"value"=>$c);
echo json_encode($x);