<?php 

$tambah = $this->input->post();

$employee_id = $tambah['employeeid_inp'];
$committee_id = $tambah['committee_id'];
$committee_type = $tambah['abct_inp'];

$employee = $this->Administration_m->employee_view($employee_id)->row_array();
$pos_id = $employee['pos_id'];
$pos_name = $employee['pos_name'];

$this->db->where("committee_type",1);
$ketua = $this->Administration_m->getBidCommittee2("",$committee_id)->row_array();
$sama = $this->db->where(array(
	'committee_id' =>$committee_id,
	'pos_id'=>$pos_id,
	'employee_id'=>$employee_id,
	))->get("adm_bid_committee")->row_array();

if(!empty($ketua) && $committee_type == 1){

	$this->setMessage("Ketua hanya bisa satu dalam tim");

	$this->add_panitia_detail($committee_id);

} else if(!empty($sama)){

	$this->setMessage("Tidak boleh ada anggota yang sama");

	$this->add_panitia_detail($committee_id);

} else {

$data = array(
	'committee_type' =>$committee_type,
	'committee_id' =>$committee_id,
	'pos_id' =>$pos_id,
	'committee_pos' =>$pos_name,
	'employee_id'=>$employee_id
);


$aksi = $this->db->insert('adm_bid_committee', $data);

if($aksi){
	$this->setMessage("Berhasil menambah anggota panitia");
}

redirect(site_url('procurement/procurement_tools/panitia_pengadaan/ubah/'.$committee_id));

}