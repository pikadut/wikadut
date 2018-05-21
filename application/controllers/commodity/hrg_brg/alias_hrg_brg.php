<?php

$alias = array(
    array("field"=>"mat_price_id","alias"=>"Kode"),
    array("field"=>"mat_catalog_code","alias"=>"Katalog"),
    array("field"=>"short_description","alias"=>"Deskripsi"),
    array("field"=>"long_description","alias"=>"Detail Deskripsi"),
    array("field"=>"del_point_id","alias"=>"Kode Kantor"),
    array("field"=>"del_point_name","alias"=>"Kantor"),
    array("field"=>"sourcing_id","alias"=>"Referensi"),
    array("field"=>"sourcing_date","alias"=>"Tgl Refrensi"),
    array("field"=>"currency","alias"=>"Mata Uang"),
    array("field"=>"unit_price","alias"=>"Harga Unit"),
    array("field"=>"handling_cost","alias"=>"Biaya Penanganan"),
    array("field"=>"insurance_cost","alias"=>"Biaya Asuransi"),
    array("field"=>"freight_cost","alias"=>"Biaya Pengiriman"),
    array("field"=>"tax_duty","alias"=>"Biaya Pajak"),
    array("field"=>"total_cost","alias"=>"Biaya Keseluruhan"),
    array("field"=>"discount","alias"=>"Diskon"),
    array("field"=>"vendor","alias"=>"Vendor"),
    array("field"=>"notes","alias"=>"Catatan"),
    array("field"=>"is_active","alias"=>"Aktif?"),
    array("field"=>"attachment","alias"=>"Lampiran"),
    array("field"=>"status","alias"=>"Status"),
    array("field"=>"update_by","alias"=>"Admin"),
    );

echo json_encode($alias);