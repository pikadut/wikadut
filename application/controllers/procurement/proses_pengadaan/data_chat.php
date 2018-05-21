<?php 

$post = $this->input->post();

$employee_id = $this->data['userdata']['employee_id'];

$key = $this->session->userdata("uri_string");

if(isset($post['chat'])){

	$userdata = $this->data['userdata'];

	$where = array("url_ack"=>$key);

	$check = $this->db->where($where)->get("adm_chat_key")->row_array();

	if(empty($check)){
		$this->db->insert("adm_chat_key",$where);
		$last_id = $this->db->insert_id();
	} else {
		$last_id = $check['key_ack'];
	}

	$input = array(
		"datetime_ac"=>date("Y-m-d H:i:s"),
		"key_ac"=>$last_id,
		"employee_ac"=>$userdata['employee_id'],
		"message_ac"=>$post['text']
		);

	$this->db->insert("adm_chat",$input);

}

$chat = $this->db->select("datetime_ac as time,fullname as user,employee_ac as userid,message_ac as chat")
->where("url_ack",$key)
->join("adm_employee","adm_employee.id=adm_chat.employee_ac")
->join("adm_chat_key","adm_chat_key.key_ack=adm_chat.key_ac")
->order_by("datetime_ac","asc")
->get("adm_chat")->result_array();

foreach ($chat as $key => $value) {
	$chat[$key]['type'] = ($value['userid'] == $employee_id) ? 0 : 1;
	$chat[$key]['time'] = date("d/m/y H:i",strtotime($value['time']));
}

$this->output
    ->set_content_type('application/json')
    ->set_output(json_encode($chat));