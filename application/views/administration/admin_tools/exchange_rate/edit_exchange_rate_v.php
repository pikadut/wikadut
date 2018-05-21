<form method="post" action="<?php echo site_url($controller_name."/submit_edit_exchange_rate");?>"  class="form-horizontal">

  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Ubah Nilai Tukar</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>
          </div>
        </div> 
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <div class="ibox-content">

        <?php $curval = $data["curr_from"]; ?>
          <div class="form-group">
          <label class="col-sm-2 control-label">Currency From</label>
            <div class="col-sm-2">
             <select required class="form-control" name="curr_from_inp">
              <option value="">Pilih</option>
              <?php 
              foreach($currency as $key => $val){
                $selected = ($val['curr_code'] == $curval) ? "selected" : ""; 
                ?>
                <option <?php echo $selected ?> value="<?php echo $val['curr_code'] ?>"><?php echo $val['curr_name'] ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

          <?php $curval = $data["curr_to"]; ?>
          <div class="form-group">
          <label class="col-sm-2 control-label">Currency To</label>
            <div class="col-sm-2">
             <select required class="form-control" name="curr_to_inp">
              <option value="">Pilih</option>
              <?php 
              foreach($currency as $key => $val){
                $selected = ($val['curr_code'] == $curval) ? "selected" : ""; 
                ?>
                <option <?php echo $selected ?> value="<?php echo $val['curr_code'] ?>"><?php echo $val['curr_name'] ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

          <?php $curval = $data["curr_date"]; ?>
         <div class="form-group">
          <label class="col-sm-2 control-label">Currency Date</label>
          <div class="col-sm-4">
            <input type="date" class="form-control" id="curr_date_inp" name="curr_date_inp" value="<?php echo $curval ?>">
          </div>
        </div>

        <?php $curval = $data["curr_value"]; ?>
         <div class="form-group">
          <label class="col-sm-2 control-label">Currency Value</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="curr_value_inp" name="curr_value_inp" value="<?php echo $curval ?>">
          </div>
        </div>

       

 </div>
</div>
</div>
</div>

<div class="row">
  <div class="col-md-12">
    <div style="margin-bottom: 60px;">
      <?php echo buttonsubmit('administration/admin_tools/position',lang('back'),lang('save')) ?>
    </div>
  </div>
</div>

</form>