<?php 

  $selection = $this->data['selection_mat_group'];


    if(empty($selection)){

  $this->setMessage("Pilih data yang ingin dihapus");
  redirect(site_url('commodity/katalog/grup_barang'));

}


      $this->db->trans_begin();

  foreach ($selection as $key => $value) {
    $this->Commodity_m->deleteDataMatGroup($value);

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

  redirect(site_url("commodity/katalog/grup_barang"));
