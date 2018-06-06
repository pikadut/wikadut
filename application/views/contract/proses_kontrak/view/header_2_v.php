
<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>HEADER</h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="ibox-content">

        <?php $curval = (isset($kontrak['ptm_number'])) ? $kontrak['ptm_number'] : "AUTO NUMBER"; ?>

        <div class="form-group">
          <label class="col-sm-2 control-label">Nomor Pengadaan</label>
          <div class="col-sm-10">
           <p class="form-control-static">
             <a href="<?php echo site_url('procurement/procurement_tools/monitor_pengadaan/lihat/'.$curval) ?>" target="_blank">
               <?php echo $curval ?>
             </a></p>
           </div>
         </div>

         <?php $curval = (isset($tender['ptm_requester_name'])) ? $tender['ptm_requester_name'] : ""; ?>
         <div class="form-group">
          <label class="col-sm-2 control-label">Nama Pengguna Barang/Jasa</label>
          <div class="col-sm-10">
           <p class="form-control-static"><?php echo $curval ?> - <?php echo $curval2 ?></p>
         </div>
       </div>

     <?php $curval = (isset($kontrak['vendor_name'])) ? $kontrak['vendor_name'] : ""; ?>

     <div class="form-group">
      <label class="col-sm-2 control-label">Vendor</label>
      <div class="col-sm-10">
       <p class="form-control-static"><?php echo $curval ?></p>
     </div>
   </div>

     <?php $curval = (isset($kontrak[''])) ? $kontrak[''] : set_value(""); ?>

   <div class="form-group">
    <label class="col-sm-2 control-label">Tanggal Penetapan Pelaksana Pekerjaan</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?php echo $curval ?></p>
    </div>
  </div>

  <?php $curval = (isset($kontrak['contract_type_2'])) ? $kontrak["contract_type_2"] : set_value("jenis_kontrak_inp"); ?>
  <div class="form-group">
    <label class="col-sm-2 control-label">Jenis Kontrak</label>
    <div class="col-sm-3">
     <select class="form-control" disabled name="jenis_kontrak_inp" value="<?php echo $curval ?>">
       <option value="">Pilih Jenis Kontrak</option>
       <?php foreach($contract_type as $key => $val){
        $selected = ($val == $curval) ? "selected" : ""; 
        ?>
        <option <?php echo $selected ?> value="<?php echo $val ?>"><?php echo $val ?></option>
        <?php } ?>
      </select>
    </div>
  </div>

  <?php $curval = (isset($kontrak['start_date'])) ?  $kontrak["start_date"] : set_value("tgl_mulai_inp"); ?>
  <div class="form-group">
    <label class="col-sm-2 control-label">Tanggal Mulai Kontrak</label>
    <div class="col-sm-4">
      <p class="form-control-static"><?php echo date("d/m/Y",strtotime($curval)) ?></p>
    </div>
  </div>

  <?php $curval = (isset($kontrak['end_date'])) ?  $kontrak["end_date"] : set_value("tgl_akhir_inp"); ?>
  <div class="form-group">
    <label class="col-sm-2 control-label">Tanggal Berakhir Kontrak</label>
    <div class="col-sm-4">
            <p class="form-control-static"><?php echo date("d/m/Y",strtotime($curval)) ?></p>
    </div>
  </div>

   <?php $curval = (isset($kontrak['contract_type'])) ? $kontrak['contract_type'] : set_value("lokasi_kebutuhan_inp"); ?>

   <div class="form-group">
    <label class="col-sm-2 control-label">Tipe Kontrak</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?php echo $curval ?></p>
    </div>
  </div>

  <?php $curval = (isset($hps['hps_total'])) ? inttomoney($hps['hps_total']) : 0; ?>

  <div class="form-group">
    <label class="col-sm-2 control-label">Nilai HPS</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?php echo $curval ?></p>
    </div>
  </div>


  <?php $curval = (isset($kontrak['contract_amount'])) ? inttomoney($kontrak['contract_amount']) : 0; ?>

  <div class="form-group">
    <label class="col-sm-2 control-label">Nilai Kontrak</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?php echo $curval ?></p>
    </div>
  </div>


  <?php $curval = (isset($kontrak['subject_work'])) ? $kontrak['subject_work'] : set_value("subject_work_inp"); ?>

  <div class="form-group">
    <label class="col-sm-2 control-label">Judul Pekerjaan</label>
    <div class="col-sm-8">
      <p class="form-control-static"><?php echo $curval ?></p>
    </div>
  </div>

  <?php $curval = (isset($kontrak['scope_work'])) ? $kontrak['scope_work'] : set_value("scope_work_inp"); ?>

  <div class="form-group">
    <label class="col-sm-2 control-label">Deskripsi Pekerjaan</label>
    <div class="col-sm-8">
      <p class="form-control-static"><?php echo $curval ?></p>
    </div>
  </div>

</div>
</div>
</div>
</div>
