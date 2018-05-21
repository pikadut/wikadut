<?php

$alias = array(
    array("field"=>"pr_number","alias"=>"Kode Permintaan Pengadaan"),
    array("field"=>"pr_requester_name","alias"=>"User"),
    array("field"=>"pr_requester_pos_name","alias"=>"Biro/Unit"),
    array("field"=>"pr_subject_of_work","alias"=>"Nama Pekerjaan"),
    array("field"=>"pr_scope_of_work","alias"=>"Deskripsi Pekerjaan"),
    array("field"=>"mata_anggaran","alias"=>"Mata Anggaran"),
    array("field"=>"sub_mata_anggaran","alias"=>"Sub Mata Anggaran"),
    array("field"=>"pr_pagu_anggaran","alias"=>"Pagu Anggaran"),
    array("field"=>"pr_sisa_anggaran","alias"=>"Sisa Anggaran"),
    array("field"=>"pr_district","alias"=>"Lokasi Pengadaan"),
    array("field"=>"pr_delivery_point","alias"=>"Lokasi Pengiriman"),
    array("field"=>"pr_contract_type","alias"=>"Jenis Kontrak"),
    );

echo json_encode($alias);