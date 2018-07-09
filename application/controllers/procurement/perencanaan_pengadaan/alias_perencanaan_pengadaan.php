<?php

$alias = array(
    array("field"=>"ppm_id","alias"=>"Kode Perencanaan Pengadaan"),
    array("field"=>"ppm_subject_of_work","alias"=>"Nama Program"),
    array("field"=>"ppm_scope_of_work","alias"=>"Deskripsi Rencana Pekerjaan"),
    array("field"=>"ppm_mata_anggaran","alias"=>"Kode Mata Anggaran"),
    array("field"=>"ppm_nama_mata_anggaran","alias"=>"Nama Mata Anggaran"),
    array("field"=>"ppm_sub_mata_anggaran","alias"=>"Kode Sub Mata Anggaran"),
    array("field"=>"ppm_nama_sub_mata_anggaran","alias"=>"Nama Sub Mata Anggaran"),
    array("field"=>"ppm_pagu_anggaran","alias"=>"Pagu Anggaran"),
    array("field"=>"ppm_sisa_anggaran","alias"=>"Sisa Anggaran"),
    array("field"=>"ppm_renc_kebutuhan","alias"=>"Rencana Kebutuhan"),
    array("field"=>"ppm_renc_pelaksanaan","alias"=>"Rencana Pelaksanaan"),
    /*array("field"=>"ppm_swakelola","alias"=>"Swakelola"),*/
    array("field"=>"ppm_currency","alias"=>"Mata Uang"),
    );

echo json_encode($alias);