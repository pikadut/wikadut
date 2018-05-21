<?php

$current_hie = $this->Administration_m->getParentId($id,$type)->row_array();
$parent_hie = $this->Administration_m->getParentId($current_hie['parent_id'],$type)->row_array();

$parent_id=$this->Administration_m->getParentId("",$type)->result_array();
$pos_id=$this->Administration_m->get_pos_id()->result_array();
$curr_id=$this->Administration_m->get_currency()->result_array();

$data = array(
    'controller_name'=>"administration",
    'parent_id' =>$parent_id,
    'pos_id' =>$pos_id,
    'curr_id' =>$curr_id,
    'hie'=>$current_hie,
    'hie_parent'=>$parent_hie,
    );

$data['id'] = $id;
$data['act'] = $act;
$data['type'] = $type;

$this->template('administration/admin_tools/hierarchy_position/hierarchy_position_form_v',"Form Hierarchy Position",$data);
