<?php

  $selection = $this->data['selection_sourcing'];

      $this->db->trans_begin();

  foreach ($selection as $key => $value) {
    $this->Commodity_m->deleteDataSourcing($value);

  }


      if ($this->db->trans_status() === FALSE)
  {
    $this->setMessage("Gagal menghapus data");
    $this->db->trans_rollback();
  }
  else
  {
    $this->setMessage("Sukses menghapus data");
    $this->db->trans_commit();
  }

  redirect(site_url("commodity/data_referensi/sumber"));
