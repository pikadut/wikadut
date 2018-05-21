<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" action="<?php echo site_url($controller_name."/submit_employee");?>"  class="form-horizontal">
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
          <div class="ibox-title">
            <h5>Tambah Employee</h5>
            <div class="ibox-tools">
              <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
              </a>
            </div>
          </div> 
          <div class="ibox-content">

           <?php $curval = set_value("npp_employee_inp"); ?>
           <div class="form-group">
            <label class="col-sm-2 control-label">NPP</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" id="npp_employee_inp" maxlength="10" name="npp_employee_inp" value="<?php echo $curval ?>">
            </div>
          </div>

          <?php $curval = set_value("salutation_employee_inp"); ?>
          <div class="form-group">
            <label class="col-sm-2 control-label">Panggilan</label>
            <div class="col-sm-2">
             <select required class="form-control" name="salutation_employee_inp">
              <option value="">Pilih</option>
              <?php 
              foreach($salutation as $key => $val){
                $selected = ($val['adm_salutation_id'] == $curval) ? "selected" : ""; 
                ?>
                <option <?php echo $selected ?> value="<?php echo $val['adm_salutation_id'] ?>"><?php echo $val['adm_salutation_name'] ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

          <?php $curval = set_value("firstname_employee_inp"); ?>
          <div class="form-group">
            <label class="col-sm-2 control-label">Nama Depan</label>
            <div class="col-sm-8">
             <input type="text" class="form-control" required name="firstname_employee_inp" value="<?php echo $curval ?>">
           </div>
         </div>

         <?php $curval = set_value("lastname_employee_inp"); ?>
         <div class="form-group">
          <label class="col-sm-2 control-label">Nama Belakang</label>
          <div class="col-sm-8">
           <input type="text" class="form-control" name="lastname_employee_inp" value="<?php echo $curval ?>">
         </div>
       </div>

       <?php $curval = set_value("phone_employee_inp"); ?>
       <div class="form-group">
        <label class="col-sm-2 control-label">Telepon</label>
        <div class="col-sm-8">
         <input type="text" class="form-control" name="phone_employee_inp" maxlength="18" value="<?php echo $curval ?>">
       </div>
     </div>

     <?php $curval = set_value("type_employee_inp"); ?>
     <div class="form-group">
      <label class="col-sm-2 control-label">Tipe</label>
      <div class="col-sm-3">
       <select required class="form-control" name="type_employee_inp">
        <option value="">Pilih</option>
        <?php 
        foreach($type as $key => $val){
          $selected = ($val['employee_type_id'] == $curval) ? "selected" : ""; 
          ?>
          <option <?php echo $selected ?> value="<?php echo $val['employee_type_id'] ?>"><?php echo $val['employee_type_name'] ?></option>
          <?php } ?>
        </select>
      </div>
    </div>

    <?php $curval = set_value("status_inp"); ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Status</label>
      <div class="col-sm-3">
       <select required class="form-control" name="status_inp">
         <?php $selected = ($curval == 1) ? "selected" : ""; ?>
         <option <?php echo $selected ?> value="1">Aktif</option>
         <?php $selected = ($curval == 0) ? "selected" : ""; ?>
         <option <?php echo $selected ?> value="0">Nonaktif</option>
       </select>
     </div>
   </div>

 </div>
</div>
</div>
</div>

<br>


<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>Company Information</h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="ibox-content">

       <?php $curval = set_value("email_employee_inp"); ?>
       <div class="form-group">
        <label class="col-sm-2 control-label">Email Address</label>
        <div class="col-sm-7">
          <input type="email" class="form-control" id="email_employee_inp" name="email_employee_inp" value="<?php echo $curval ?>">
        </div>
      </div>

      <?php $curval = set_value("offc_ext_employee_inp"); ?>
      <div class="form-group">
        <label class="col-sm-2 control-label">Office Extention</label>
        <div class="col-sm-7">
          <input type="text" class="form-control" id="offc_ext_employee_inp" name="offc_ext_employee_inp" value="<?php echo $curval ?>">
        </div>
      </div>

    </div>
  </div>
</div>
</div>
<br>
<div class="row">
  <div class="col-md-12">
    <div style="margin-bottom: 60px;">
      <?php echo buttonsubmit('administration/user_management/employee',lang('back'),lang('save')) ?>
    </div>
  </div>
</div>

</form>
</div>