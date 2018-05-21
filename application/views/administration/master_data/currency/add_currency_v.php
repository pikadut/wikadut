<div class="wrapper wrapper-content animated fadeInRight">
<form method="post" action="<?php echo site_url($controller_name."/submit_add_currency");?>"  class="form-horizontal">

  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Tambah Mata Uang</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>
          </div>
        </div> 
        <div class="ibox-content">

         <?php $curval = set_value("curr_code_currency_inp"); ?>
         <div class="form-group">
          <label class="col-sm-2 control-label">Currency Code</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="curr_code_currency_inp" maxlength="3" name="curr_code_currency_inp" value="<?php echo $curval ?>">
          </div>
        </div>

        <?php $curval = set_value("curr_name_currency_inp"); ?>
         <div class="form-group">
          <label class="col-sm-2 control-label">Currency Name</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="curr_name_currency_inp" maxlength="50" name="curr_name_currency_inp" value="<?php echo $curval ?>">
          </div>
        </div>  

 </div>
</div>
</div>
</div>

<div class="row">
  <div class="col-md-12">
    <div style="margin-bottom: 60px;">
      <?php echo buttonsubmit('administration/master_data/currency',lang('back'),lang('save')) ?>
    </div>
  </div>
</div>

</form>
</div>