<?php if($prep['ptp_prequalify'] == 2){ 
  include(VIEWPATH."procurement/proses_pengadaan/view/header_rfq_v.php");
 } else { ?>

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

        <?php $curval = (isset($permintaan['ptm_number'])) ? $permintaan['ptm_number'] : "AUTO"; ?>

        <div class="form-group">
          <label class="col-sm-2 control-label">No. Tender</label>
          <div class="col-sm-10">
           <p class="form-control-static"><?php echo $curval ?></p>
         </div>
       </div>

       <?php $curval = (isset($permintaan['ptm_requester_name'])) ? $permintaan['ptm_requester_name'] : $userdata['complete_name']; ?>

       <div class="form-group">
        <label class="col-sm-2 control-label">User</label>
        <div class="col-sm-10">
         <p class="form-control-static"><?php echo $curval ?></p>
       </div>
     </div>

     <?php $curval = (isset($permintaan['ptm_requester_pos_name'])) ? $permintaan['ptm_requester_pos_name'] : $pos['dept_name']; ?>

     <div class="form-group">
      <label class="col-sm-2 control-label">Divisi/Departemen</label>
      <div class="col-sm-10">
        <p class="form-control-static"><?php echo $curval ?></p>
      </div>
    </div>

   
        <?php $curval = $permintaan["ptm_subject_of_work"]; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Nama Pekerjaan</label>
          <div class="col-sm-8">
            <p class="form-control-static" id="nama_pekerjaan"><?php echo $curval ?></p>
            
          </div>

        </div>

    <?php $curval = (isset($permintaan['ptm_scope_of_work'])) ? $permintaan["ptm_scope_of_work"] : set_value("deskripsi_pekerjaan"); ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Deskripsi Pekerjaan</label>
      <div class="col-sm-10">
        <p class="form-control-static" id="deskripsi_pekerjaan"><?php echo $curval ?></p>

      </div>
    </div>

    <!-- haqim -->
    <?php $curval = (isset($permintaan['ptm_project_name'])) ? $permintaan["ptm_project_name"] : set_value("nama_proyek"); 
    if (isset($permintaan['ptm_project_name'])) { ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Nama Proyek</label>
          <div class="col-sm-10">
            <p class="form-control-static" id="deskripsi_pekerjaan"><?php echo $curval ?></p>

          </div>
        </div>
   <?php  }
      ?>

    <!-- end -->

    <?php $curval = (isset($permintaan['ptm_mata_anggaran']) && isset($permintaan['ptm_nama_mata_anggaran'])) ? $permintaan["ptm_mata_anggaran"]." - ".$permintaan["ptm_nama_mata_anggaran"] : ""; ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Mata Anggaran</label>
      <div class="col-sm-10">
        <p class="form-control-static" id="mata_anggaran"><?php echo $curval ?></p>
      </div>
    </div>

    <?php $curval = (isset($permintaan['ptm_sub_mata_anggaran']) && isset($permintaan['ptm_nama_sub_mata_anggaran'])) ? $permintaan["ptm_sub_mata_anggaran"]." - ".$permintaan["ptm_nama_sub_mata_anggaran"] : ""; ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Sub Mata Anggaran</label>
      <div class="col-sm-10">
        <p class="form-control-static" id="sub_mata_anggaran"><?php echo $curval ?></p>
      </div>
    </div>

    <?php $curval = (isset($permintaan['ptm_pagu_anggaran'])) ? inttomoney($permintaan["ptm_pagu_anggaran"]) : set_value("pagu_anggaran"); ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Nilai Anggaran</label>
      <div class="col-sm-4">
        <p class="form-control-static" id="pagu_anggaran"><?php echo $curval ?></p>
      </div>
    </div>

    <?php $curval = (isset($permintaan['ptm_sisa_anggaran'])) ? inttomoney($permintaan["ptm_sisa_anggaran"]) : set_value("sisa_anggaran") ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Sisa Anggaran</label>
      <div class="col-sm-4">
        <p class="form-control-static" id="sisa_anggaran"><?php echo $curval ?></p>
      </div>
    </div>

<?php /*
    <?php $curval = (isset($permintaan['ptm_district_id'])) ? $permintaan["ptm_district_id"] : set_value("lokasi_kebutuhan_inp"); ?>
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

 <?php $curval = $permintaan["ptm_delivery_point"]; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Lokasi Pengiriman</label>
          <div class="col-sm-10">
            <p class="form-control-static" id="lokasi_pengiriman"><?php echo $curval ?></p>
          </div>
        </div>

        <!-- haqim -->
        <div class="form-group">
            <label class="col-sm-2 control-label">Chatting</label>
            <div class="col-sm-10">
              <button type="button" id="chatBtn" class="btn btn-primary" data-toggle="modal" data-target="#chatModal">Chatting</button>
          </div>
        </div>

  <?php $curval = (isset($permintaan['pr_type'])) ? $permintaan["pr_type"] : set_value("Jenis PR"); ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Jenis PR</label>
      <div class="col-sm-10">
        <p class="form-control-static" id="deskripsi_pekerjaan"><?php echo $curval ?></p>

      </div>
    </div>
      <!-- end -->

    <?php $curval = (isset($permintaan['ptm_contract_type'])) ?  $permintaan["ptm_contract_type"] : set_value("jenis_kontrak_inp"); ?>
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
          $("#nama_pekerjaan").text(mydata.ppm_subject_of_work);
          $("#deskripsi_pekerjaan").text(mydata.ppm_scope_of_work);
          $("#mata_anggaran").text(mydata.ppm_mata_anggaran+" - "+mydata.ppm_nama_mata_anggaran);
          $("#sub_mata_anggaran").text(mydata.ppm_sub_mata_anggaran+" - "+mydata.ppm_nama_sub_mata_anggaran);
          $("#pagu_anggaran").text(mydata.ppm_pagu_anggaran);
          $("#sisa_anggaran").text(mydata.ppm_sisa_anggaran);
        }
      });
    }

    $(document.body).on("change","#perencanaan_pengadaan_inp",function(){

      check_plan_tender();

    });

  });

</script>

<?php } ?>