
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
          <div class="ibox-title">
            <h5>HEADLINE</h5>
            <div class="ibox-tools">
              <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
              </a>
            </div>
          </div>
          <div class="ibox-content">

            <?php $curval = (isset($permintaan['pr_number'])) ? $permintaan['pr_number'] : "AUTO"; ?>

           <div class="form-group">
            <label class="col-sm-2 control-label">No. Permintaan</label>
            <div class="col-sm-10">
             <p class="form-control-static"><?php echo $curval ?></p>
           </div>
         </div>

           <?php $curval = (isset($permintaan['pr_requester_name'])) ? $permintaan['pr_requester_name'] : $userdata['complete_name']; ?>

           <div class="form-group">
            <label class="col-sm-2 control-label">User</label>
            <div class="col-sm-10">
             <p class="form-control-static"><?php echo $curval ?></p>
           </div>
         </div>

         <?php $curval = (isset($permintaan['pr_requester_pos_name'])) ? $permintaan['pr_requester_pos_name'] : $pos['dept_name']; ?>

         <div class="form-group">
          <label class="col-sm-2 control-label">Divisi/Departemen</label>
          <div class="col-sm-10">
            <p class="form-control-static"><?php echo $curval ?></p>
          </div>
        </div>

        <?php $curval = (isset($permintaan['pr_subject_of_work'])) ?  $permintaan["pr_subject_of_work"] : set_value("nama_pekerjaan"); ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Nama Pekerjaan</label>
          <div class="col-sm-8">
             <input type="text" class="form-control" name="nama_pekerjaan" id="nama_pekerjaan" value="<?php echo $curval ?>">
          </div>
          <div class="col-sm-2">
          <?php $curval = (isset($permintaan['ppm_id'])) ?  $permintaan["ppm_id"] : set_value("perencanaan_pengadaan_inp"); ?>
            <button type="button" data-id="perencanaan_pengadaan_inp" data-url="<?php echo site_url(PROCUREMENT_PERENCANAAN_PENGADAAN_PATH.'/picker') ?>" class="btn btn-primary picker"><i class="fa fa-search"></i></button> 
            <input type="hidden" name="perencanaan_pengadaan_inp" value="<?php echo $curval ?>" id="perencanaan_pengadaan_inp"/>
          </div>
        </div>

        <?php $curval = (isset($permintaan['pr_scope_of_work'])) ? $permintaan["pr_scope_of_work"] : set_value("deskripsi_pekerjaan"); ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Deskripsi Pekerjaan</label>
          <div class="col-sm-10">

            <textarea type="text" class="form-control" id="deskripsi_pekerjaan" name="deskripsi_pekerjaan"><?php echo $curval ?></textarea>
          </div>
        </div>

        <?php $curval = (isset($permintaan['pr_mata_anggaran']) && isset($permintaan['pr_nama_mata_anggaran'])) ? $permintaan["pr_mata_anggaran"]." - ".$permintaan["pr_nama_mata_anggaran"] : ""; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Mata Anggaran</label>
          <div class="col-sm-10">
            <p class="form-control-static" id="mata_anggaran"><?php echo $curval ?></p>
          </div>
        </div>

        <?php $curval = (isset($permintaan['pr_sub_mata_anggaran']) && isset($permintaan['pr_nama_sub_mata_anggaran'])) ? $permintaan["pr_sub_mata_anggaran"]." - ".$permintaan["pr_nama_sub_mata_anggaran"] : ""; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Sub Mata Anggaran</label>
          <div class="col-sm-10">
            <p class="form-control-static" id="sub_mata_anggaran"><?php echo $curval ?></p>
          </div>
        </div>

        <?php $curval = (isset($permintaan['pr_pagu_anggaran'])) ? $permintaan["pr_pagu_anggaran"] : 0; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Nilai Anggaran</label>
          <div class="col-sm-4">
            <p class="form-control-static" id="pagu_anggaran" maxlength="22"><?php echo inttomoney($curval) ?></p>
          </div>
        </div>

        <?php $curval = (isset($permintaan['pr_sisa_anggaran'])) ? $permintaan["pr_sisa_anggaran"] : 0 ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Sisa Anggaran</label>
          <div class="col-sm-4">
            <p class="form-control-static" id="sisa_anggaran"><?php echo inttomoney($curval) ?></p>
          </div>
        </div>

        


<?php /*
        <?php $curval = (isset($permintaan['pr_district_id'])) ? $permintaan["pr_district_id"] : set_value("lokasi_kebutuhan_inp"); ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Lokasi Kebutuhan *</label>
          <div class="col-sm-5">
           <select class="form-control" required name="lokasi_kebutuhan_inp" value="<?php echo $curval ?>">
             <option value=""><?php echo lang('choose') ?></option>
             <?php foreach($district_list as $key => $val){
              $selected = ($val['district_id'] == $curval) ? "selected" : ""; 
              ?>
              <option <?php echo $selected ?> value="<?php echo $val['district_id'] ?>"><?php echo $val['district_code'] ?> - <?php echo $val['district_name'] ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        */ ?>

        <?php $curval = (isset($permintaan['pr_delivery_point_id'])) ? $permintaan["pr_delivery_point_id"] : set_value("lokasi_pengiriman_inp"); ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Lokasi Pengiriman *</label>
          <div class="col-sm-5">
           <select class="form-control" required name="lokasi_pengiriman_inp">
             <option value=""><?php echo lang('choose') ?></option>
             <?php foreach($del_point_list as $key => $val){
              $selected = ($val['dept_id'] == $curval) ? "selected" : ""; 
              $type = (!empty($val['dept_type'])) ? "Pelabuhan" : "Divisi";
              ?>
              <option <?php echo $selected ?> value="<?php echo $val['dept_id'] ?>">
              <?php echo $type ?> - <?php echo $val['dept_name'] ?></option>
              <?php } ?>
            </select>
          </div>
        </div>

        <!-- //y tambah jenis pr -->        
        <?php $curval = (isset($permintaan['pr_type'])) ?  $permintaan["pr_type"] : set_value("tipe_pr"); ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Jenis PR *</label>
          <div class="col-sm-5">
           <select class="form-control" required name="tipe_pr" value="<?php echo $curval ?>">
            <option value=""><?php echo lang('choose') ?></option>
            <?php foreach($pr_type as $key => $val){
              $selected = ($key == $curval) ? "selected" : ""; 
              ?>
              <option <?php echo $selected ?> value="<?php echo $key ?>"><?php echo $val ?></option>
              <?php } ?>
            </select>
          </div>
        </div>

<!-- HLMIFZI -->
        <div class="form-group">
          <label class="col-sm-2 control-label">Pembelian Langsung/Swakelola
</label>
          <div class="col-sm-4">
            <div class="checkbox">
              <?php $curval = set_value("swakelola_inp"); ?>
              <input type="checkbox" onclick="swakelola_confirm()" class="" name="swakelola_inp" id="swakelola_inp" value="1">
            </div>
          </div>
        </div>

<?php /*
        <?php $curval = (isset($permintaan['pr_contract_type'])) ?  $permintaan["pr_contract_type"] : set_value("jenis_kontrak_inp"); ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Jenis Kontrak *</label>
          <div class="col-sm-5">
           <select class="form-control" required name="jenis_kontrak_inp" value="<?php echo $curval ?>">
            <option value=""><?php echo lang('choose') ?></option>
            <?php foreach($contract_type as $key => $val){
              $selected = ($key == $curval) ? "selected" : ""; 
              ?>
              <option <?php echo $selected ?> value="<?php echo $key ?>"><?php echo $val ?></option>
              <?php } ?>
            </select>
          </div>
        </div>
        */ ?>

      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

  $(document).ready(function(){

    function check_plan_tender(){
      var id = $("#perencanaan_pengadaan_inp").val();
      var url = "<?php echo site_url('Procurement/data_perencanaan_pengadaan') ?>";
      $.ajax({
        url : url+"?id="+id,
        dataType:"json",
        success:function(data){
          var mydata = data.rows[0];
          $("#nama_pekerjaan").val(mydata.ppm_subject_of_work);
          $("#deskripsi_pekerjaan").val(mydata.ppm_scope_of_work);
          $("#mata_anggaran").text(mydata.ppm_mata_anggaran+" - "+mydata.ppm_nama_mata_anggaran);
          $("#sub_mata_anggaran").text(mydata.ppm_sub_mata_anggaran+" - "+mydata.ppm_nama_sub_mata_anggaran);
          $("#pagu_anggaran,#total_pagu").text(mydata.ppm_pagu_anggaran);
          $("#sisa_anggaran,#sisa_pagu").text(mydata.ppm_sisa_anggaran);
          $("#total_pagu_inp").val(moneytoint(mydata.ppm_pagu_anggaran));
          $("#total_sisa_inp").val(moneytoint(mydata.ppm_sisa_anggaran));
        }
      });
    }

    $(document.body).on("change","#perencanaan_pengadaan_inp",function(){

      check_plan_tender();

    });

});

  function swakelola_confirm(){
     
     if ($('[name=swakelola_inp]')[0].checked == true) {

        if (confirm('Anda yakin untuk melakukan pembelian langsung bukan melalui pelelangan/RFQ?')) {
          $('[name=swakelola_inp]').prop('checked', true);
        } else {
          $('[name=swakelola_inp]').prop('checked', false);

        }

     }
      
     }

</script>