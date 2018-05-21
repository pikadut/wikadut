<div class="wrapper wrapper-content animated fadeInRight">
<form method="post" action="<?php echo site_url($controller_name."/submit_approval_kat_jasa");?>"  class="form-horizontal">

  <?php foreach ($srv_catalog as $k => $v) {
    $i = $v['srv_catalog_code'];
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

        <?php $curval = (isset($v['srv_catalog_code'])) ? $v['srv_catalog_code'] : set_value("code_inp[$i]") ?>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('code') ?></label>
            <div class="col-sm-10">
              <input type="text" disabled class="form-control" name="code_inp[<?php echo $i ?>]" maxlength="10" value="<?php echo $curval ?>">
            </div>
          </div>

          <?php $curval = (isset($v['srv_group_code'])) ? $v['srv_group_code'] : set_value("code_inp[$i]") ?>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('group') ?></label>
            <div class="col-sm-10">
              <select disabled class="form-control select2" style="width:100%;" name="group_inp[<?php echo $i ?>]">
                <option value=""><?php echo lang('choose') ?></option>
                <?php foreach($list_group as $key => $val){ 
                  $selected = ($curval == $val['srv_group_code']) ? "selected" : "";
                  ?>
                  <option <?php echo $selected ?> value="<?php echo $val['srv_group_code'] ?>"><?php echo $val['srv_group_code'] ?> - <?php echo $val['srv_group_name'] ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <?php $curval = (isset($v['short_description'])) ? $v['short_description'] : set_value("deskripsi_inp[$i]") ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Deskripsi Jasa</label>
              <div class="col-sm-10">
                <textarea disabled name="deskripsi_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
              </div>
            </div>
			
			<?php $curval = (isset($v['long_description'])) ? $v['long_description'] : set_value("info_inp[$i]") ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Nama Jasa</label>
              <div class="col-sm-10">
                <textarea disabled name="info_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
              </div>
            </div>
			
			<?php $curval = (isset($v['tipe'])) ? $v['tipe'] : set_value("tipe_inp[$i]") ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Tipe</label>
              <div class="col-sm-10">
                <textarea disabled name="tipe_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
              </div>
            </div>
			
			<?php $curval = (isset($v['lokasi'])) ? $v['lokasi'] : set_value("lokasi_inp[$i]") ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Lokasi</label>
              <div class="col-sm-10">
                <textarea disabled name="info_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
              </div>
            </div>
			
			<?php $curval = (isset($v['uraian'])) ? $v['uraian'] : set_value("uraian_inp[$i]") ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Uraian Jasa</label>
              <div class="col-sm-10">
                <textarea disabled name="uraian_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <?php include(VIEWPATH."/comment_workflow_v.php") ?>

    <?php } ?>

<?php echo buttonsubmit('commodity/daftar_pekerjaan',lang('back'),lang('save')) ?>

  </form>

  </div>