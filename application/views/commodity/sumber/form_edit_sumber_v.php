<div class="wrapper wrapper-content animated fadeInRight">
<form method="post" action="<?php echo site_url($controller_name."/submit_edit_sumber");?>"  class="form-horizontal">

<?php //echo buttonsubmit('commodity/data_referensi/sumber') ?>
  
  <?php foreach ($sourcing as $k => $v) {
    $i = $v['sourcing_id'];
   ?>

  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Form #<?php echo $i ?></h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>
          </div>
        </div>
        <div class="ibox-content">

                  <?php $curval = (isset($v['sourcing_id'])) ? $v['sourcing_id'] : set_value("code_inp[$i]") ?>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('code') ?></label>
            <div class="col-sm-10">
              <input type="text" class="form-control" disabled required name="code_inp[<?php echo $i ?>]" value="<?php echo $curval ?>" maxlength="10">
            </div>
          </div>

          <?php $curval = (isset($v['sourcing_name'])) ? $v['sourcing_name'] : set_value("name_inp[$i]") ?>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('sourcing') ?> *</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" required name="name_inp[<?php echo $i ?>]" value="<?php echo $curval ?>">
            </div>
          </div>

          <?php $curval = (isset($v['sourcing_type'])) ? $v['sourcing_type'] : set_value("type_inp[$i]") ?>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('type') ?> *</label>
            <div class="col-sm-10">
              <select name="type_inp[<?php echo $i ?>]" class="form-control">
                  <?php $selected = ($curval == "N") ? "selected" : ""; ?>
                  <option <?php echo $selected ?> value="N">Nasional</option>
                  <?php $selected = ($curval == "I") ? "selected" : ""; ?>
                  <option <?php echo $selected ?> value="I">Internasional</option>
                </select>
            </div>
          </div>

          </div>
        </div>
      </div>
    </div>

    <?php } ?>

 <?php echo buttonsubmit('commodity/data_referensi/sumber',lang('back'),lang('save')) ?>

  </form>

  </div>