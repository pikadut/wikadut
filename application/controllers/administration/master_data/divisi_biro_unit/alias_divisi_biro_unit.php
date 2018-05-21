<?php

  $alias = array(
    array("field"=>"dep_code","alias"=>"Kode Departemen"),
    array("field"=>"dept_name","alias"=>"Nama Departemen"),
    array("field"=>"district_name","alias"=>"Kantor"),
    );

  echo json_encode($alias);