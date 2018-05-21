<?php

  $alias = array(
    array("field"=>"fullname","alias"=>"Nama Lengkap"),
    array("field"=>"email","alias"=>"Email"),
    array("field"=>"phone","alias"=>"Telepon"),
    );

  echo json_encode($alias);