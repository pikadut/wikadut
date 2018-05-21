<?php

  $alias = array(
    array("field"=>"srv_catalog_code","alias"=>"Kode"),
    array("field"=>"srv_group_code","alias"=>"Group"),
    array("field"=>"short_description","alias"=>"Deskripsi"),
    array("field"=>"long_description","alias"=>"Detail Deskripsi"),
    array("field"=>"notes","alias"=>"Catatan"),
    array("field"=>"status","alias"=>"Status"),
    array("field"=>"last_update_by","alias"=>"Admin"),
    );

  echo json_encode($alias);