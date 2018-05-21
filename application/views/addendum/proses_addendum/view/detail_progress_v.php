
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
          <div class="ibox-title">
            <h5>DETAIL PROGRESS YANG DIAJUKAN VENDOR</h5>
            <div class="ibox-tools">
              <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
              </a>
            </div>
          </div>
          <div class="ibox-content">

            <?php $curval = (isset($permintaan['ptm_number'])) ? $permintaan['ptm_number'] : "AUTO"; ?>

           <div class="form-group">
            <label class="col-sm-2 control-label">Nomor Kontrak</label>
            <div class="col-sm-10">
             <p class="form-control-static"><?php echo $curval ?> <span><a href="#">[Klik disini untuk melihat detail kontrak]</a></span></p>
           </div>
         </div>

           <?php $curval = (isset($permintaan['ptm_requester_name'])) ? $permintaan['ptm_requester_name'] : $userdata['complete_name']; ?>

           <div class="form-group">
            <label class="col-sm-2 control-label">Judul Kontrak</label>
            <div class="col-sm-10">
             <p class="form-control-static"><?php echo $curval ?></p>
           </div>
         </div>

        <?php $curval = (isset($permintaan['ptm_requester_pos_name'])) ? $permintaan['ptm_requester_pos_name'] : set_value("lokasi_kebutuhan_inp"); ?>

         <div class="form-group">
          <label class="col-sm-2 control-label">Deskripsi Milestone</label>
          <div class="col-sm-10">
            <p class="form-control-static"><?php echo $curval ?></p>
          </div>
        </div>

        <?php $curval = (isset($permintaan['ptm_requester_pos_name'])) ? $permintaan['ptm_requester_pos_name'] : set_value("lokasi_kebutuhan_inp"); ?>

         <div class="form-group">
          <label class="col-sm-2 control-label">Target Milestone</label>
          <div class="col-sm-10">
            <p class="form-control-static"><?php echo $curval ?></p>
          </div>
        </div>

        <?php $curval = (isset($permintaan['ptm_requester_pos_name'])) ? $permintaan['ptm_requester_pos_name'] : set_value("lokasi_kebutuhan_inp"); ?>

         <div class="form-group">
          <label class="col-sm-2 control-label">Persentase Milestone</label>
          <div class="col-sm-10">
            <p class="form-control-static"><?php echo $curval ?></p>
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