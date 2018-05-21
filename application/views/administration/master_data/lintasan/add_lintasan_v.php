<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" action="<?php echo site_url($controller_name."/submit_add_lintasan");?>"  class="form-horizontal">

    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
          <div class="ibox-title">
            <h5>Tambah Lintasan</h5>
            <div class="ibox-tools">
              <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
              </a>
            </div>
          </div> 
          <div class="ibox-content">

           <?php $curval = set_value("roundtrip_type"); ?>
           <div class="form-group">
             <label class="col-sm-2 control-label">Pulang Pergi</label>
             <div class="col-sm-2">
              <select required class="form-control pp" name="tipe_inp">
               <?php $selected = ($curval == 0) ? "selected" : ""; ?>
               <option <?php echo $selected ?> value="0">Tidak</option>
               <?php $selected = ($curval == 1) ? "selected" : ""; ?>
               <option <?php echo $selected ?> value="1">Ya</option>
             </select>
           </div>
         </div> 

         <?php $curval = set_value("lane_code_divbirnit_inp"); ?>
         <div class="form-group">
          <label class="col-sm-2 control-label">Kode Pergi *</label>
          <div class="col-sm-4">
            <input required type="text" class="form-control" id="lane_code_divbirnit_inp" maxlength="50" name="lane_code_divbirnit_inp[]" value="<?php echo $curval ?>">
          </div>

          <label class="col-sm-2 control-label kode_pulang" style="display: none">Kode Pulang *</label>
          <div class="col-sm-4">
            <input type="text" class="form-control kode_pulang" style="display: none" id="lane_code_divbirnit_inp" maxlength="50" name="lane_code_divbirnit_inp[]" value="<?php echo $curval ?>" disabled="">
          </div>

        </div>


        <?php $curval = set_value("district_inp"); ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Cabang *</label>
          <div class="col-sm-4">			
           <select required class="form-control" name="district_inp" id="district" >
            <option value="">Pilih Cabang</option>
            <?php 
            foreach ($dist_name as $key => $val){
              $selected = ($val['district_id'] == $curval) ? "selected" : ""; 
              ?>
              <option <?php echo $selected ?> value="<?php echo $val['district_id'] ?>"><?php echo $val['district_name'] ?></option>
              <?php } ?>
            </select>
          </div>
        </div>

		  <!--		  
            <?php $curval = $userdata['district_name']; ?>
           <div class="form-group">
            <label class="col-sm-2 control-label">Cabang</label>
            <div class="col-sm-10">
              <p class="form-control-static"><?php echo $curval ?></p>
            </div>
          </div>
        -->

        <?php $curval = set_value("origin_lane_inp"); ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Asal *</label>
          <div class="col-sm-4">			
           <select required class="form-control filter asal1" name="origin_lane_inp[]" id="orig">
            <option value="">Pilih Asal</option>
            <?php 
            foreach($dept_name as $key => $val){
              $selected = ($val['dept_id'] == $curval) ? "selected" : ""; 
              ?>
              <option <?php echo $selected ?> value="<?php echo $val['dept_id'] ?>"><?php echo $val['dep_code'].' - '.$val['dept_name'] ?></option>
              <?php } ?>
            </select>
          </div>

          <label class="col-sm-2 control-label pulang" style="display: none">Asal *</label>
          <div class="col-sm-4">      
           <select class="form-control pulang asal2" style="display: none" name="origin_lane_inp[]" id="orig" readonly="" disabled="">
            <option value="">Pilih Asal</option>
            <?php 
            foreach($dept_name as $key => $val){
              $selected = ($val['dept_id'] == $curval) ? "selected" : ""; 
              ?>
              <option <?php echo $selected ?> value="<?php echo $val['dept_id'] ?>"><?php echo $val['dep_code'].' - '.$val['dept_name'] ?></option>
              <?php } ?>
            </select>
          </div>

        </div>



        <?php $curval = set_value("destination_lane_inp"); ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Tujuan *</label>
          <div class="col-sm-4">
           <select required class="form-control tujuan1" name="destination_lane_inp[]" id="dest">
            <option value="">Pilih Tujuan</option>
            <?php 
            foreach($dept_name as $key => $val){
              $selected = ($val['dept_id'] == $curval) ? "selected" : ""; 
              ?>
              <option <?php echo $selected ?> value="<?php echo $val['dept_id'] ?>"><?php echo $val['dep_code'].' - '.$val['dept_name'] ?></option>
              <?php } ?>
            </select>
          </div>

          <label class="col-sm-2 control-label pulang" style="display: none">Tujuan *</label>
          <div class="col-sm-4">
           <select class="form-control pulang tujuan2" style="display: none" name="destination_lane_inp[]" id="dest" readonly="" disabled>
            <option value="">Pilih Tujuan</option>
            <?php 
            foreach($dept_name as $key => $val){
              $selected = ($val['dept_id'] == $curval) ? "selected" : ""; 
              ?>
              <option <?php echo $selected ?> value="<?php echo $val['dept_id'] ?>"><?php echo $val['dep_code'].' - '.$val['dept_name'] ?></option>
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

<div class="row">
  <div class="col-md-12">
    <div style="margin-bottom: 60px;">
      <?php echo buttonsubmit('administration/master_data/lintasan',lang('back'),lang('save')) ?>
    </div>
  </div>
</div>

</form>
</div>

<script type="text/javascript">
  var $drops = $('.filter'),
  $options = $drops.eq(1).children().clone();

  $drops.change(function(){
    var $other = $drops.not(this),
    otherVal = $other.val(),
    newVal = $(this).val(),
    $opts = $options.clone().filter(function(){
     return this.value !== newVal; 
   })
    $other.html($opts).val(otherVal);
    
  })

  $(document).on('change', '.pp', function() {
    var value = $(this).val()
    if(value == 1){
      $(".kode_pulang").css("display","block");
      $(".kode_pulang").attr("required",true);
      $(".kode_pulang").attr("disabled",false);
      $(".pulang").css("display","block");
      $(".pulang").attr("disabled",false);
    } else if(value == 0){
      $(".kode_pulang").css("display","none");
      $(".pulang").css("display","none");
    }
  });

  $(document).on('change', '.asal1', function() {
    var value = $(this).val()
     $(".tujuan2").val(value);
  });

  $(document).on('change', '.tujuan1', function() {
    var value = $(this).val()
     $(".asal2").val(value);
  });




</script>