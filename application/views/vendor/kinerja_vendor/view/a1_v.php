
<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>A.1 DATA PERUSAHAAN</h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="ibox-content">

        <?php $curval = (isset($vendor['vendor_name'])) ? $vendor['vendor_name'] : ""; ?>

        <div class="form-group">
          <label class="col-sm-2 control-label">Nama Vendor</label>
          <div class="col-sm-10">
           <p class="form-control-static">
             <a href="<?php echo site_url('vendor/lihat_detail_vendor/'.$vendor['vendor_id']) ?>" target="_blank">
               <?php echo $curval ?>
             </a></p>
           </div>
         </div>

         <?php $curval = (isset($vendor['email'])) ? $vendor['email'] : ""; ?>

         <div class="form-group">
          <label class="col-sm-2 control-label">Email</label>
          <div class="col-sm-10">
           <p class="form-control-static">
             <?php echo $curval ?>
           </p>
         </div>
       </div>

       <?php $curval = (isset($vendor['address_website'])) ? $vendor['address_website'] : ""; ?>
       <div class="form-group">
        <label class="col-sm-2 control-label">Website</label>
        <div class="col-sm-10">
         <p class="form-control-static"><?php echo $curval ?></p>
       </div>
     </div>
   </div>
 </div>
</div>
</div>
