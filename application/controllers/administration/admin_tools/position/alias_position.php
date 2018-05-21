<?php

  $alias = array(
    array("field"=>"pos_name","alias"=>"Nama Job Position"),
    array("field"=>"job_title","alias"=>"Nama Department"),
    array("field"=>"district_id","alias"=>"Distrik")
    );

  echo json_encode($alias);