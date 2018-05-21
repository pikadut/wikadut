<div class="wrapper wrapper-content animated fadeInRight">
<form method="post" action="<?php echo site_url($controller_name."/submit_approval_grup_brg");?>"  class="form-horizontal">

  
  <?php foreach ($mat_group as $k => $v) {
    $i = $v['mat_group_code'];
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

            <?php $curval = (isset($v['mat_group_code'])) ? $v['mat_group_code'] : set_value("code_inp[$i]") ?>
            <div class="form-group">
              <label class="col-sm-2 control-label"><?php echo lang('code') ?></label>
              <div class="col-sm-10">
                <input type="text" disabled class="form-control" name="code_inp[<?php echo $i ?>]" maxlength="10" value="<?php echo $curval ?>">
              </div>
            </div>

            <?php $curval = (isset($v['mat_group_name'])) ? $v['mat_group_name'] : set_value("name_inp[$i]") ?>
            <div class="form-group">
              <label class="col-sm-2 control-label"><?php echo lang('name') ?></label>
              <div class="col-sm-10">
               <textarea disabled class="form-control" required name="name_inp[<?php echo $i ?>]"><?php echo $curval ?></textarea>
              </div>
            </div>

            <?php 

            for ($lvl=1; $lvl <= COMMODITY_GROUP_MAX_LEVEL; $lvl++) { ?>

            <?php $curval = (isset($v['level'][$lvl-1]['mat_group_code'])) ? $v['level'][$lvl-1]['mat_group_code'] : set_value("parent_".$lvl."_inp[$i]") ?>
            <div class="form-group">
             <label class="col-sm-2 control-label"><?php echo lang('level') ?> <?php echo $lvl ?></label>
             <div class="col-sm-10">
              <select disabled class="form-control level" data-group="grup_brg_<?php echo $i ?>" data-level="<?php echo $lvl ?>" style="width:100%;" name="parent_<?php echo $lvl ?>_inp[<?php echo $i ?>]">
                <option value=""><?php echo ($lvl == 1 && empty($val['mat_group_parent'])) ? "Grup Baru" : "Pilih Grup" ?></option>
                <?php foreach($list_group as $key => $val){
                  $selected = ($val['mat_group_code'] == $curval) ? "selected" : "";
                  $cond = (($lvl == 1 && empty($val['mat_group_parent'])) || ($lvl > 1 && !empty($val['mat_group_parent'])));
                  if($v['mat_group_code'] != $val['mat_group_code'] && $cond){ ?>
                  <option <?php echo $selected ?> data-parent="<?php echo $val['mat_group_parent'] ?>" value="<?php echo $val['mat_group_code'] ?>"><?php echo $val['mat_group_code'] ?> - <?php echo $val['mat_group_name'] ?></option>
                  <?php } } ?>
                </select>
              </div>
            </div>

            <?php } ?>

            <?php $curval = (isset($v['mat_group_parent'])) ? $v['mat_group_parent'] : set_value("parent_inp[$i]") ?>
            <input type="hidden" class="form-control level" data-group="grup_brg_<?php echo $i ?>" name="parent_inp[<?php echo $i ?>]" value="<?php echo $curval ?>">

          </div>
        </div>
      </div>
    </div>

    <?php include(VIEWPATH."/comment_workflow_v.php") ?>

    <?php } ?>

<?php echo buttonsubmit('commodity/daftar_pekerjaan',lang('back'),lang('save')) ?>

  </form>

  </div>