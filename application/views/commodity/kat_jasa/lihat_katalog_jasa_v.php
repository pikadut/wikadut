<?php $i = 0; ?>
<form method="post" class="form-horizontal">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Detail Jasa</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>
          </div>
        </div>
        <div class="ibox-content">
          <?php $curval = (isset($v['srv_group_code'])) ? $v['srv_group_code'] : set_value("code_inp[$i]") ?>
          <div class="form-group">
            <label class="col-sm-2 control-label">Grup</label>
            <div class="col-sm-10">
             <p class="form-control-static"><?php echo $curval ?></p>
           </div>
         </div>

         <?php $curval = (isset($v['srv_catalog_code'])) ? $v['srv_catalog_code'] : set_value("code_inp[$i]") ?>
         <div class="form-group">
          <label class="col-sm-2 control-label"><?php echo lang('code') ?></label>
          <div class="col-sm-10">
           <p class="form-control-static"><?php echo $curval ?></p> 
         </div>
       </div>
	   
	   <?php $curval = (isset($v['short_description'])) ? $v['short_description'] : set_value("deskripsi_inp[$i]") ?>
       <div class="form-group">
        <label class="col-sm-2 control-label">Deskripsi Jasa</label>
        <div class="col-sm-10">
         <p class="form-control-static"><?php echo $curval ?></p> 
       </div>
     </div>

       <?php $curval = (isset($v['long_description'])) ? $v['long_description'] : set_value("info_inp[$i]") ?>
       <div class="form-group">
        <label class="col-sm-2 control-label">Nama Jasa</label>
        <div class="col-sm-10">
         <p class="form-control-static"><?php echo $curval ?></p> 
       </div>
     </div>
	 
	 <?php $curval = (isset($v['tipe'])) ? $v['tipe'] : set_value("tipe_inp[$i]") ?>
       <div class="form-group">
        <label class="col-sm-2 control-label">Tipe</label>
        <div class="col-sm-10">
         <p class="form-control-static"><?php echo $curval ?></p> 
       </div>
     </div>
	 
	 <?php $curval = (isset($v['lokasi'])) ? $v['lokasi'] : set_value("lokasi_inp[$i]") ?>
       <div class="form-group">
        <label class="col-sm-2 control-label">Lokasi</label>
        <div class="col-sm-10">
         <p class="form-control-static"><?php echo $curval ?></p> 
       </div>
     </div>

     <?php $curval = (isset($v['uraian'])) ? $v['uraian'] : set_value("uraian_inp[$i]") ?>
     <div class="form-group">
      <label class="col-sm-2 control-label">Atribut Lainnya</label>
      <div class="col-sm-10">
        <p class="form-control-static"><?php echo $curval ?></p>  
      </div>
    </div>

  </div>
</div>
<?php 
if(in_array($userdata['job_title'], array("APPROVAL KOMODITI","PENGELOLA KOMODITI"))){
include(VIEWPATH."/comment_view_v.php");
} ?>
<?php echo buttonback('commodity/katalog/katalog_barang',lang('back'),lang('save')) ?>
</div>
</div>

</form>