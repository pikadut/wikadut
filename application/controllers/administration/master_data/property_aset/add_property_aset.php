<?php

    $data = array(
    'controller_name'=>"administration",
    );
    $data['komoditi_type'] = array("Tanah","Bangunan","Alat Angkutan","Peralatan Gedung","Inventaris Kantor","Komputer","Perangkat Lunak","Jasa Konstruksi","Jasa Non Konstruksi");

    $this->template('administration/master_data/property_aset/add_property_aset_v',"Tambah Property Aset",$data);
  