<?php

  $alias = array(
    array("field"=>"mat_catalog_code","alias"=>"Kode"),
    array("field"=>"mat_group_code","alias"=>"Group"),
    array("field"=>"short_description","alias"=>"Deskripsi"),
    array("field"=>"long_description","alias"=>"Detail Deskripsi"),
    array("field"=>"manufacturer","alias"=>"Manufaktur"),
    array("field"=>"brand","alias"=>"Brand"),
    array("field"=>"part_number","alias"=>"No. Suku Cadang"),
    array("field"=>"model_number","alias"=>"No. Model"),
    array("field"=>"serial_number","alias"=>"No. Serial"),
    array("field"=>"uom","alias"=>"Satuan"),
    array("field"=>"notes","alias"=>"Catatan"),
    array("field"=>"image","alias"=>"Gambar"),
    array("field"=>"attachment","alias"=>"File"),
    array("field"=>"status","alias"=>"Status"),
    array("field"=>"last_update_by","alias"=>"Admin"),
    );

  echo json_encode($alias);
