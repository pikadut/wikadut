
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

         <div class="form-group">
           <?php $curval = (isset($addendum['contract_number']) && !empty($addendum['contract_number'])) ? $addendum['contract_number'] : "AUTO NUMBER"; ?>
           <label class="col-sm-2 control-label">Nomor Addendum</label>
           <div class="col-sm-3">
             <p class="form-control-static">
               <?php echo $curval ?>
             </p>
           </div>
           <div class="col-sm-2"></div>
           <?php $curval = (isset($kontrak['contract_number'])) ? $kontrak['contract_number'] : "AUTO NUMBER"; ?>
           <label class="col-sm-2 control-label">Nomor Kontrak</label>
           <div class="col-sm-3">
             <p class="form-control-static">
               <?php echo $curval ?>
             </p>
           </div>

         </div>

         <?php $curval = (isset($tender['ptm_requester_name'])) ? $tender['ptm_requester_name'] : ""; ?>
         <?php $curval2 = (isset($tender['ptm_requester_pos_name'])) ? $tender['ptm_requester_pos_name'] : ""; ?>
         <div class="form-group">
          <label class="col-sm-2 control-label">User</label>
          <div class="col-sm-10">
           <p class="form-control-static"><?php echo $curval ?> - <?php echo $curval2 ?></p>
         </div>
       </div>


       <?php $curval = (isset($tender['ptm_buyer'])) ? $tender['ptm_buyer'] : ""; ?>
       <?php $curval2 = (isset($tender['ptm_buyer_pos_name'])) ? $tender['ptm_buyer_pos_name'] : ""; ?>
       <div class="form-group">
        <label class="col-sm-2 control-label">Pelaksana Pengadaan</label>
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

   <?php $curval = (isset($kontrak['contract_type'])) ? $kontrak['contract_type'] : set_value("lokasi_kebutuhan_inp"); ?>

   <div class="form-group">
    <label class="col-sm-2 control-label">Tipe Kontrak</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?php echo $curval ?></p>
    </div>
  </div>

  <?php $curval = (isset($hps['hps_total'])) ? inttomoney($hps['hps_total']) : 0; ?>

  <div class="form-group">
    <label class="col-sm-2 control-label">Nilai PR</label>
    <div class="col-sm-10">
      <p class="form-control-static"><?php echo $curval ?></p>
    </div>
  </div>


  <div class="form-group">
    <?php $curval = (isset($addendum['contract_amount'])) ? $addendum['contract_amount'] : 0; ?>
    <label class="col-sm-2 control-label">Nilai Addendum</label>
    <div class="col-sm-3">
      <input class="form-control money" required name="nilai_kontrak_inp" value="<?php echo $curval ?>">
    </div>
    <div class="col-sm-2"></div>
    <?php $curval = (isset($kontrak['contract_amount'])) ? inttomoney($kontrak['contract_amount']) : 0; ?>
    <label class="col-sm-2 control-label">Nilai Kontrak</label>
    <div class="col-sm-3">
      <p class="form-control-static"><?php echo $curval ?></p>
    </div>
  </div>


  <?php $curval = (isset($addendum['subject_work'])) ? $addendum['subject_work'] : set_value("subject_work_inp"); ?>

  <div class="form-group">
    <label class="col-sm-2 control-label">Judul Pekerjaan Addendum</label>
    <div class="col-sm-5">
      <textarea class="form-control" required name="subject_work_inp"><?php echo $curval ?></textarea>
    </div>

    <?php $curval = (isset($kontrak['subject_work'])) ? $kontrak['subject_work'] : set_value("subject_work_inp"); ?>

    <label class="col-sm-2 control-label">Judul Pekerjaan Kontrak</label>
    <div class="col-sm-3">
      <p class="form-control-static"><?php echo $curval ?></p>
    </div>
  </div>

  

  <?php $curval = (isset($addendum['scope_work'])) ? $addendum['scope_work'] : set_value("scope_work_inp"); ?>

  <div class="form-group">
    <label class="col-sm-2 control-label">Deskripsi Pekerjaan Addendum</label>
    <div class="col-sm-5">
      <textarea class="form-control" required name="scope_work_inp"><?php echo $curval ?></textarea>
    </div>
    <?php $curval = (isset($kontrak['scope_work'])) ? $kontrak['scope_work'] : set_value("scope_work_inp"); ?>
    <label class="col-sm-2 control-label">Deskripsi Pekerjaan Kontrak</label>
    <div class="col-sm-3">
      <p class="form-control-static"><?php echo $curval ?></p>
    </div>
  </div>

  <?php $curval = (isset($addendum['contract_type_2'])) ? $addendum["contract_type_2"] : set_value("jenis_kontrak_inp"); ?>
  <div class="form-group">
    <label class="col-sm-2 control-label">Jenis Addendum</label>
    <div class="col-sm-3">
     <select class="form-control" required name="jenis_kontrak_inp">
       <option value="">Pilih Jenis Kontrak</option>
       <?php foreach($contract_type as $key => $val){
        $selected = ($val == $curval) ? "selected" : ""; 
        ?>
        <option <?php echo $selected ?> value="<?php echo $val ?>"><?php echo $val ?></option>
        <?php } ?>
      </select>
    </div>
    <div class="col-sm-2"></div>
    <?php $curval = (isset($kontrak['contract_type_2'])) ? $kontrak["contract_type_2"] : set_value("jenis_kontrak_inp"); ?>
    <label class="col-sm-2 control-label">Jenis Kontrak</label>
    <div class="col-sm-3">
      <p class="form-control-static"><?php echo $curval ?></p>
    </div>
  </div>

  <?php $curval = (isset($addendum['ammend_description'])) ? $addendum['ammend_description'] : set_value("deskripsi_addendum_inp"); ?>

  <div class="form-group">
    <label class="col-sm-2 control-label">Deskripsi Adendum</label>
    <div class="col-sm-5">
      <textarea class="form-control" required name="deskripsi_addendum_inp"><?php echo $curval ?></textarea>
    </div>
  </div>

  <?php $curval = (isset($addendum['ammend_reason'])) ? $addendum['ammend_reason'] : set_value("justifikasi_addendum_inp"); ?>

  <div class="form-group">
    <label class="col-sm-2 control-label">Justifikasi Adendum</label>
    <div class="col-sm-5">
      <textarea class="form-control" required name="justifikasi_addendum_inp"><?php echo $curval ?></textarea>
    </div>
  </div>

  <?php $curval = (isset($addendum['start_date'])) ?  $addendum["start_date"] : set_value("tgl_mulai_inp"); ?>
  <div class="form-group">
    <label class="col-sm-2 control-label">Tanggal Mulai Addendum</label>
    <div class="col-sm-3">
      <div class="input-group date">
        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
        <input type="text" required name="tgl_mulai_inp" class="form-control datetimepicker" value="<?php echo $curval ?>">
      </div>
    </div>
    <div class="col-sm-2"></div>
    <?php $curval = date(DEFAULT_FORMAT_DATETIME,strtotime($kontrak["start_date"])); ?>

    <label class="col-sm-2 control-label">Tanggal Mulai Kontrak</label>
    <div class="col-sm-3">
      <p class="form-control-static"><?php echo $curval ?></p>
    </div>

  </div>

  <?php $curval = (isset($addendum['end_date'])) ?  $addendum["end_date"] : set_value("tgl_akhir_inp"); ?>
  <div class="form-group">
    <label class="col-sm-2 control-label">Tanggal Berakhir Addendum</label>
    <div class="col-sm-3">
      <div class="input-group date">
        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
        <input type="text" required name="tgl_akhir_inp" class="form-control datetimepicker" value="<?php echo $curval ?>">
      </div>
    </div>
    <div class="col-sm-2"></div>
    <?php $curval = date(DEFAULT_FORMAT_DATETIME,strtotime($kontrak["end_date"])); ?>

    <label class="col-sm-2 control-label">Tanggal Berakhir Kontrak</label>
    <div class="col-sm-3">
      <p class="form-control-static"><?php echo $curval ?></p>
    </div>

  </div>

</div>
</div>
</div>
</div>