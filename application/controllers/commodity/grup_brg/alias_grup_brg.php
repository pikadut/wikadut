<?php

  $alias = array(
    array("field"=>"mat_group_code","alias"=>"Kode"),
    array("field"=>"mat_group_name","alias"=>"Name"),
    array("field"=>"mat_group_parent","alias"=>"Induk"),
    );

  echo json_encode($alias);