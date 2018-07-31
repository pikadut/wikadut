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

          <?php $curval = $permintaan['ptm_number']; ?>
           <div class="form-group">
            <label class="col-sm-2 control-label">No. Tender</label>
            <div class="col-sm-10">
             <p class="form-control-static"><?php echo $curval ?></p>
           </div>
         </div>

           <?php $curval = $permintaan['ptm_requester_name']; ?>
           <div class="form-group">
            <label class="col-sm-2 control-label">User</label>
            <div class="col-sm-10">
             <p class="form-control-static"><?php echo $curval ?></p>
           </div>
         </div>

         <?php $curval = $permintaan['ptm_requester_pos_name']; ?>
         <div class="form-group">
          <label class="col-sm-2 control-label">Divisi/Departemen</label>
          <div class="col-sm-10">
            <p class="form-control-static"><?php echo $curval ?></p>
          </div>
        </div>

        <?php $curval = date(DEFAULT_FORMAT_DATETIME,strtotime($permintaan['ptm_created_date'])); ?>
           <div class="form-group">
            <label class="col-sm-2 control-label">Tanggal Pembuatan</label>
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

        <?php $curval = $permintaan["ptm_scope_of_work"]; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Deskripsi Pekerjaan</label>
          <div class="col-sm-10">
            <p class="form-control-static" id="deskripsi_pekerjaan"><?php echo $curval ?></p>

          </div>
        </div>

        <!-- haqim -->
        <?php $curval = $permintaan['ptm_project_name']; 
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

        <?php $curval = $permintaan["ptm_mata_anggaran"]." - ".$permintaan["ptm_nama_mata_anggaran"]; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Mata Anggaran</label>
          <div class="col-sm-10">
            <p class="form-control-static" id="mata_anggaran"><?php echo $curval ?></p>
          </div>
        </div>

        <?php $curval = $permintaan["ptm_sub_mata_anggaran"]." - ".$permintaan["ptm_nama_sub_mata_anggaran"]; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Sub Mata Anggaran</label>
          <div class="col-sm-10">
            <p class="form-control-static" id="sub_mata_anggaran"><?php echo $curval ?></p>
          </div>
        </div>

        <?php $curval = $permintaan['ptm_currency']; ?>
           <div class="form-group">
            <label class="col-sm-2 control-label">Mata Uang</label>
            <div class="col-sm-10">
             <p class="form-control-static"><?php echo $curval ?></p>
           </div>
         </div>

        <?php $curval = inttomoney($permintaan["ptm_pagu_anggaran"]); ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Nilai Anggaran</label>
          <div class="col-sm-4">
            <p class="form-control-static" id="pagu_anggaran"><?php echo $curval ?></p>
          </div>
        </div>

        <?php $curval = inttomoney($permintaan["ptm_sisa_anggaran"]); ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Sisa Anggaran</label>
          <div class="col-sm-4">
            <p class="form-control-static" id="sisa_anggaran"><?php echo $curval ?></p>
          </div>
        </div>

<?php /*
        <?php $curval = $permintaan["ptm_district_name"]; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Lokasi Kebutuhan</label>
          <div class="col-sm-10">
            <p class="form-control-static" id="lokasi_kebutuhan"><?php echo $curval ?></p>
          </div>
        </div>
       */ ?>

       <?php /*
        <?php $curval = $permintaan["ptm_delivery_point"]; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Lokasi Pengiriman</label>
          <div class="col-sm-10">
            <p class="form-control-static" id="lokasi_pengiriman"><?php echo $curval ?></p>
          </div>
        </div>
        */ ?>

        <!-- haqim -->
        <div class="form-group">
            <label class="col-sm-2 control-label">Pesan</label>
            <div class="col-sm-10">
              <button type="button" id="chatBtn" class="btn btn-primary" data-toggle="modal" data-target="#chatModal">Pesan</button>
          </div>
        </div>

        <?php $curval = $permintaan['pr_type']?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Jenis PR</label>
          <div class="col-sm-10">
            <p class="form-control-static" id="deskripsi_pekerjaan"><?php echo $curval ?></p>

          </div>
        </div>
      <!-- end -->

        <?php 
        if($activity_id > 1030){ 
        $curval = $permintaan["ptm_contract_type"]; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Jenis Kontrak</label>
          <div class="col-sm-10">
            <p class="form-control-static" id="jenis_kontrak"><?php echo $curval ?></p>
          </div>
        </div>

        <?php } ?>

      </div>
    </div>
  </div>
</div>