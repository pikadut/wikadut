<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" action="<?php echo site_url($controller_name."/submit_add_daftar_kantor");?>"  class="form-horizontal">

    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
          <div class="ibox-title">
            <h5>Tambah Daftar Kantor</h5>
            <div class="ibox-tools">
              <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
              </a>
            </div>
          </div> 
          <div class="ibox-content">

           <?php $curval = set_value("district_code_dftrkntr_inp"); ?>
           <div class="form-group">
            <label class="col-sm-2 control-label">Kode Kantor <small>*</small></label>
            <div class="col-sm-4">
              <input type="text" class="form-control" id="district_code_dftrkntr_inp" maxlength="4" name="district_code_dftrkntr_inp" value="<?php echo $curval ?>">
            </div>
          </div>

          <?php $curval = set_value("district_name_dftrkntr_inp"); ?>
          <div class="form-group">
            <label class="col-sm-2 control-label">Nama Kantor <small>*</small></label>
            <div class="col-sm-4">
              <input type="text" class="form-control" id="district_name_dftrkntr_inp" maxlength="255" name="district_name_dftrkntr_inp" value="<?php echo $curval ?>">
            </div>
          </div>  

          <?php $curval = set_value("singkatan_inp"); ?>
          <div class="form-group">
            <label class="col-sm-2 control-label">Singkatan Kantor <small>*</small></label>
            <div class="col-sm-2">
              <input type="text" class="form-control" id="singkatan_inp" maxlength="4" name="singkatan_inp" value="<?php echo $curval ?>">
            </div>
          </div> 
<!-- =============================Tambah============================================================= -->
          <!-- <?php// $curval = set_value("lat_inp"); ?>
          <div class="form-group">
            <label class="col-sm-2 control-label">Latitude </label>
            <div class="col-sm-2">
              <input type="text" class="form-control" id="lat_inp" name="lat_inp" placeholder="e.g., 51.528309" value="<?php// echo $curval ?>">
            </div>
          </div>  

          <?php// $curval = set_value("lng_inp"); ?>
          <div class="form-group">
            <label class="col-sm-2 control-label">Longitude </label>
            <div class="col-sm-2">
              <input type="text" class="form-control" id="lng_inp" name="lng_inp" placeholder="e.g., -0.381779" value="<?php// echo $curval ?>">
            </div>
          </div> -->   
<!-- ================================================================================================= -->
        </div>
      </div>
    </div>
  </div> 

  <div class="row">
    <div class="col-md-12">
      <div style="margin-bottom: 60px;">
        <?php echo buttonsubmit('administration/master_data/daftar_kantor',lang('back'),lang('save')) ?>
      </div>
    </div>
  </div>

</form>
</div>