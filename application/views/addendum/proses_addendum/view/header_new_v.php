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

      <?php $curval = (isset($kontrak['ptm_number'])) ? $kontrak['ptm_number'] : "AUTO"; ?>

        <div class="form-group">
          <label class="col-sm-2 control-label">Nomor Kontrak</label>
          <div class="col-sm-10">
           <p class="form-control-static">AUTO NUMBER</p>
         </div>
       </div>

       <?php $curval = (isset($kontrak['ptm_number'])) ? $kontrak['ptm_number'] : ""; ?>

       <div class="form-group">
        <label class="col-sm-2 control-label">Nomor Pengadaan</label>
        <div class="col-sm-10">
         <p class="form-control-static">
           <a href="<?php echo site_url('procurement/procurement_tools/monitor_pengadaan/lihat/'.$curval) ?>" target="_blank">
             <?php echo $curval ?>
           </a>
         </p>
       </div>
     </div>


     <?php $curval = (isset($kontrak['ptm_subject_of_work'])) ? $kontrak['ptm_subject_of_work'] : ""; ?>

     <div class="form-group">
      <label class="col-sm-2 control-label">Judul Pekerjaan</label>
      <div class="col-sm-10">
        <p class="form-control-static"><?php echo $curval ?></p>
      </div>
    </div>

    <?php $curval = (isset($kontrak['ptm_scope_of_work'])) ? $kontrak['ptm_scope_of_work'] : "" ?>

    <div class="form-group">
      <label class="col-sm-2 control-label">Deskripsi Pekerjaan</label>
      <div class="col-sm-10">
        <p class="form-control-static"><?php echo $curval ?></p>
      </div>
    </div>

    <?php $curval = (isset($kontrak['ptm_requester_name'])) ? $kontrak['ptm_requester_name'] : ""; ?>
    <?php $curval2 = (isset($kontrak['ptm_requester_pos_name'])) ? $kontrak['ptm_requester_pos_name'] : ""; ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">User</label>
      <div class="col-sm-10">
       <p class="form-control-static"><?php echo $curval ?> - <?php echo $curval2 ?></p>
     </div>
   </div>


   <?php $curval = (isset($kontrak['ptm_buyer'])) ? $kontrak['ptm_buyer'] : ""; ?>
   <?php $curval2 = (isset($kontrak['ptm_buyer_pos_name'])) ? $kontrak['ptm_buyer_pos_name'] : ""; ?>
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

</div>
</div>
</div>
</div>
