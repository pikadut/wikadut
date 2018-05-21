<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>PENATA PERENCANAAN</h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="ibox-content">

        <?php $curval = ""; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Penata Perencanaan *</label>
          <div class="col-sm-6">
           <select class="form-control" name="penata_perencanaan">
             <option value=""><?php echo lang('choose') ?></option>
             <?php foreach($penata_perencana as $key => $val){
              $selected = ($val['employee_id'] == $curval) ? "selected" : ""; 
              ?>
              <option <?php echo $selected ?> value="<?php echo $val['employee_id'] ?>"><?php echo $val['fullname'] ?> - <?php echo $val['pos_name'] ?></option>
              <?php } ?>
            </select>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>