<?php

$this->db->select("fullname,id,pos_name,
employee_type_name");
$this->db->where('status', 1);
$rows = $this->Administration_m->employee_view()->result_array();

$data = $rows;

echo json_encode($data);