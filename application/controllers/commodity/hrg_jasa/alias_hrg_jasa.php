<?php

$alias = array(
    array("field"=>"srv_price_id","alias"=>"Kode"),
    array("field"=>"srv_catalog_code","alias"=>"Katalog"),
    array("field"=>"short_description","alias"=>"Deskripsi"),
    array("field"=>"long_description","alias"=>"Detail Deskripsi"),
    array("field"=>"del_point_id","alias"=>"Kode Kantor"),
    array("field"=>"del_point_name","alias"=>"Kantor"),
    array("field"=>"sourcing_id","alias"=>"Referensi"),
    array("field"=>"sourcing_date","alias"=>"Tgl Refrensi"),
    array("field"=>"currency","alias"=>"Mata Uang"),
    array("field"=>"total_price","alias"=>"Harga"),
    array("field"=>"vendor","alias"=>"Vendor"),
    array("field"=>"notes","alias"=>"Catatan"),
    array("field"=>"is_active","alias"=>"Aktif"),
    array("field"=>"attachment","alias"=>"Lampiran"),
    array("field"=>"status","alias"=>"Status"),
    array("field"=>"update_by","alias"=>"Admin"),
    );

echo json_encode($alias);