<div class="wrapper wrapper-content animated fadeInRight">
<form method="post" action="<?php echo site_url($controller_name."/submit_add_salutation");?>"  class="form-horizontal">

  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Tambah Salutation</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>
          </div>
        </div> 
        <div class="ibox-content">

         <?php $curval = set_value("adm_salutation_name_slttn_inp"); ?>
         <div class="form-group">
          <label class="col-sm-2 control-label">Salutation Name</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="adm_salutation_name_slttn_inp" maxlength="100" name="adm_salutation_name_slttn_inp" value="<?php echo $curval ?>">
          </div>
        </div> 

 </div>
</div>
</div>
</div>

<div class="row">
  <div class="col-md-12">
    <div style="margin-bottom: 60px;">
      <?php echo buttonsubmit('administration/master_data/salutation',lang('back'),lang('save')) ?>
    </div>
  </div>
</div>

</form>
</div>