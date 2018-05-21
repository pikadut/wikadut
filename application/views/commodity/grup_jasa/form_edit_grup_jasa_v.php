<div class="wrapper wrapper-content animated fadeInRight">
<form method="post" action="<?php echo site_url($controller_name."/submit_edit_grup_jasa");?>"  class="form-horizontal">
 
 <?php //echo buttonsubmit('commodity/katalog/grup_jasa') ?>
  
  <?php foreach ($srv_group as $k => $v) {
    $i = $v['srv_group_code'];
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

        <?php $curval = (isset($v['srv_group_code'])) ? $v['srv_group_code'] : set_value("code_inp[$i]") ?>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('code') ?> *</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" required maxlength="4" name="code_inp[<?php echo $i ?>]" maxlength="10" value="<?php echo $curval ?>">
            </div>
          </div>

          <?php $curval = (isset($v['srv_group_name'])) ? $v['srv_group_name'] : set_value("name_inp[$i]") ?>
            <div class="form-group">
              <label class="col-sm-2 control-label"><?php echo lang('name') ?> *</label>
              <div class="col-sm-10">
                <textarea class="form-control" required name="name_inp[<?php echo $i ?>]"><?php echo $curval ?></textarea>
              </div>
            </div>

            <?php 

            for ($lvl=1; $lvl <= COMMODITY_GROUP_MAX_LEVEL; $lvl++) { ?>

            <?php $curval = (isset($v['level'][$lvl-1]['srv_group_code'])) ? $v['level'][$lvl-1]['srv_group_code'] : set_value("parent_".$lvl."_inp[$i]") ?>
            <div class="form-group">
             <label class="col-sm-2 control-label"><?php echo lang('level') ?> <?php echo $lvl ?></label>
             <div class="col-sm-10">
              <select class="form-control level" data-group="grup_jasa_<?php echo $i ?>" data-level="<?php echo $lvl ?>" style="width:100%;" name="parent_<?php echo $lvl ?>_inp[<?php echo $i ?>]">
                <option value=""><?php echo ($lvl == 1 && empty($val['srv_group_parent'])) ? "Grup Baru" : "Pilih Grup" ?></option>
                <?php foreach($list_group as $key => $val){
                  $selected = ($val['srv_group_code'] == $curval) ? "selected" : "";
                  $cond = (($lvl == 1 && empty($val['srv_group_parent'])) || ($lvl > 1 && !empty($val['srv_group_parent'])));
                  $cond2 = ($v['srv_group_code'] != $val['srv_group_code']);
                  if($cond){ ?>
                  <option <?php echo $selected ?> data-parent="<?php echo $val['srv_group_parent'] ?>" value="<?php echo $val['srv_group_code'] ?>"><?php echo $val['srv_group_code'] ?> - <?php echo $val['srv_group_name'] ?></option>
                  <?php } } ?>
                </select>
              </div>
            </div>

            <?php } ?>

            <?php $curval = (isset($v['srv_group_parent'])) ? $v['srv_group_parent'] : set_value("parent_inp[$i]") ?>
            <input type="hidden" class="form-control level" data-group="grup_jasa_<?php echo $i ?>" name="parent_inp[<?php echo $i ?>]" value="<?php echo $curval ?>">

          </div>
        </div>
      </div>
    </div>

    <?php include(VIEWPATH."/comment_v.php") ?>

    <?php } ?>

<?php echo buttonsubmit('commodity/katalog/grup_jasa',lang('back'),lang('save')) ?>

  </form>

  </div>