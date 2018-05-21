<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>Pelaksana Pengadaan</h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="ibox-content">

        <?php $curval = ""; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">User *</label>
          <div class="col-sm-6">
           <select class="form-control select2" required name="pelaksana_pengadaan_inp">
             <option value=""><?php echo lang('choose') ?></option>
             <?php foreach($pelaksana_pengadaan as $key => $val){
              $selected = ($val['employee_id'] == $curval) ? "selected" : ""; 
              ?>
              <option <?php echo $selected ?> value="<?php echo $val['employee_id'] ?>">
              <?php echo $val['complete_name'] ?>
              </option>
              <?php } ?>
            </select>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>