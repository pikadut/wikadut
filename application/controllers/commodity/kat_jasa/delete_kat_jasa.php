<?php 

$selection = $this->data['selection_srv_catalog'];

$position = $this->Administration_m->getPosition("ADMIN");

if(!$position){
  $this->noAccess("Hanya ADMIN yang dapat menonaktifkan katalog komoditi");
}


if(empty($selection)){

  $this->setMessage("Pilih data yang ingin dihapus");
  redirect(site_url('commodity/katalog/katalog_jasa'));

}

$this->db->trans_begin();

foreach ($selection as $key => $value) {
  $this->Commodity_m->deleteDataSrvCatalog($value);

}

if ($this->db->trans_status() === FALSE)
{
  $this->setMessage("Gagal menonaktifkan data");
  $this->db->trans_rollback();
}
else
{
  $this->setMessage("Sukses menonaktifkan data");
  $this->db->trans_commit();
}

redirect(site_url("commodity/katalog/katalog_jasa"));