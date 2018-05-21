<?php

  $alias = array(
    array("field"=>"srv_group_code","alias"=>"Kode"),
    array("field"=>"srv_group_name","alias"=>"Name"),
    array("field"=>"srv_group_parent","alias"=>"Induk"),
    );

  echo json_encode($alias);