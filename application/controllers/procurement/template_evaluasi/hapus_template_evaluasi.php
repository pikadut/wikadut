<?php 

$id = (isset($post['id'])) ? $post['id'] : $this->uri->segment(4, 0);

$selection = $id;

if(empty($selection)){

  $this->setMessage("Pilih data yang ingin dihapus");
  redirect(site_url('procurement/procurement_tools/daftar_template_evaluasi_pengadaan'));

}


$this->db->trans_begin();

$this->Procevaltemp_m->deleteTemplateEvaluasiDetailByParent($id);

$this->Procevaltemp_m->deleteTemplateEvaluasi($id);

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

redirect(site_url("procurement/procurement_tools/daftar_template_evaluasi_pengadaan"));
