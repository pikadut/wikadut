
<form method="post" action="<?php echo site_url($controller_name."/submit_add_divisi_biro_unit");?>"  class="form-horizontal">

  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Tambah Divisi/Biro/Unit</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>
          </div>
        </div> 
        <div class="ibox-content">

         <?php $curval = set_value("dep_code_divbirnit_inp"); ?>
         <div class="form-group">
          <label class="col-sm-2 control-label">Kode Department</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="dep_code_divbirnit_inp" maxlength="50" name="dep_code_divbirnit_inp" value="<?php echo $curval ?>">
          </div>
        </div>

        <?php $curval = set_value("dept_name_divbirnit_inp"); ?>
         <div class="form-group">
          <label class="col-sm-2 control-label">Nama Department</label>
          <div class="col-sm-4">
            <input type="text" class="form-control" id="dept_name_divbirnit_inp" maxlength="255" name="dept_name_divbirnit_inp" value="<?php echo $curval ?>">
          </div>
        </div>

        <?php $curval = set_value("dist_id_divbirnit_inp"); ?>
          <div class="form-group">
          <label class="col-sm-2 control-label">Kantor</label>
            <div class="col-sm-3">
             <select required class="form-control" name="dist_id_divbirnit_inp">
              <option value="">Pilih</option>
              <?php 
              foreach($dist_name as $key => $val){
                $selected = ($val['district_id'] == $curval) ? "selected" : ""; 
                ?>
                <option <?php echo $selected ?> value="<?php echo $val['district_id'] ?>"><?php echo $val['district_name'] ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

       

 </div>
</div>
</div>
</div>

<div class="row">
  <div class="col-md-12">
    <div style="margin-bottom: 60px;">
      <?php echo buttonsubmit('administration/master_data/divisi_biro_unit',lang('back'),lang('save')) ?>
    </div>
  </div>
</div>

</form>