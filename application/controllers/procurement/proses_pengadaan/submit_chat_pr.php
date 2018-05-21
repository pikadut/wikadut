<?php
	
	$data['pr_number'] = $this->input->post('pr_number');
	$data['employee_from'] = $this->data['userdata']['complete_name'];
	$employee_to = $this->input->post('employee_to');
	if (is_array($employee_to)) {
		$employee_to = implode(' , ', $employee_to);
	}
	$data['employee_to'] = $employee_to;

	$employee_cc = $this->input->post('employee_cc');
	if (is_array($employee_cc)) {
		$employee_ccs = implode(' , ', $employee_cc);
	}
	$data['employee_cc'] = $employee_ccs;
	$data['pesan'] = $this->input->post('pesan');
	$data['date'] = date("d F Y H:i:s");
	$data['status'] = 0;

	if (!empty($_FILES['attach']['name'])) {
		 $upload           = $this->Procpr_m->do_upload('attach');
	     $data['attach']  = $upload;

	}

	$submit = $this->Procpr_m->submit_chat_pr($data);
	if ($submit >= 1) {
		$title = "Chatting $data[pr_number]";
		$msg = "Ada pesan pesan untuk Anda di chatting $data[pr_number]. <br> 
				Silahkan buka <a href='".site_url('procurement/procurement_tools/monitor_pengadaan')."'>Monitor pengadaan</a> dibagian daftar pengadaan atau <a href='".site_url('procurement/daftar_pekerjaan')."'>Daftar pengadaan</a> dibagian Daftar Pekerjaan RFQ-Undangan";
		$this->sendEmail($employee_to,$title,$msg);
		foreach ($employee_cc as $key => $value) {
			$this->sendEmail($value,$title,$msg);
		}
		ob_clean();
		echo "success";
	}else{
		ob_clean();
		echo "error";
	}

?>