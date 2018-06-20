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

        <?php $curval = $permintaan['pr_number']; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">No. Permintaan</label>
          <div class="col-sm-10">
           <p class="form-control-static"><?php echo $curval ?></p>
         </div>
       </div>

       <?php $curval = $permintaan['pr_requester_name']; ?>
       <div class="form-group">
        <label class="col-sm-2 control-label">User *</label>
        <div class="col-sm-10">
         <p class="form-control-static"><?php echo $curval ?></p>
       </div>
     </div>

     <?php $curval = $permintaan['pr_requester_pos_name']; ?>
     <div class="form-group">
      <label class="col-sm-2 control-label">Divisi/Departemen *</label>
      <div class="col-sm-10">
        <p class="form-control-static"><?php echo $curval ?></p>
      </div>
    </div>

    <?php $curval = date(DEFAULT_FORMAT_DATETIME,strtotime($permintaan['pr_created_date'])); ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Tanggal Pembuatan</label>
      <div class="col-sm-10">
       <p class="form-control-static"><?php echo $curval ?></p>
     </div>
   </div>

   <?php $curval = $permintaan["pr_subject_of_work"]; ?>
   <div class="form-group">
    <label class="col-sm-2 control-label">Nama Pekerjaan *</label>
    <div class="col-sm-8">
      <p class="form-control-static" id="nama_pekerjaan"><?php echo $curval ?></p>

    </div>

  </div>

  <?php $curval = $permintaan["pr_scope_of_work"]; ?>
  <div class="form-group">
    <label class="col-sm-2 control-label">Deskripsi Pekerjaan *</label>
    <div class="col-sm-10">
      <p class="form-control-static" id="deskripsi_pekerjaan"><?php echo $curval ?></p>

    </div>
  </div>

  <?php $curval = $permintaan["pr_mata_anggaran"]." - ".$permintaan["pr_nama_mata_anggaran"]; ?>
  <div class="form-group">
    <label class="col-sm-2 control-label">Mata Anggaran *</label>
    <div class="col-sm-10">
      <p class="form-control-static" id="mata_anggaran"><?php echo $curval ?></p>
    </div>
  </div>

  <?php $curval = $permintaan["pr_sub_mata_anggaran"]." - ".$permintaan["pr_nama_sub_mata_anggaran"]; ?>
  <div class="form-group">
    <label class="col-sm-2 control-label">Sub Mata Anggaran *</label>
    <div class="col-sm-10">
      <p class="form-control-static" id="sub_mata_anggaran"><?php echo $curval ?></p>
    </div>
  </div>

  <?php $curval = $permintaan['pr_currency']; ?>
  <div class="form-group">
    <label class="col-sm-2 control-label">Mata Uang</label>
    <div class="col-sm-10">
     <p class="form-control-static"><?php echo $curval ?></p>
   </div>
 </div>

 <?php $curval = inttomoney($permintaan["pr_pagu_anggaran"]); ?>
 <div class="form-group">
  <label class="col-sm-2 control-label">Nilai Anggaran *</label>
  <div class="col-sm-4">
    <p class="form-control-static" id="pagu_anggaran"><?php echo $curval ?></p>
  </div>
</div>

<?php $curval = inttomoney($permintaan["pr_sisa_anggaran"]); ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Sisa Anggaran *</label>
  <div class="col-sm-4">
    <p class="form-control-static" id="sisa_anggaran"><?php echo $curval ?></p>
  </div>
</div>

<?php /*
        <?php $curval = $permintaan["pr_district"]; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Lokasi Kebutuhan *</label>
          <div class="col-sm-10">
            <p class="form-control-static" id="lokasi_kebutuhan"><?php echo $curval ?></p>
          </div>
        </div>
        */ ?>

        <?php $curval = $permintaan["pr_delivery_point"]; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Lokasi Pengiriman *</label>
          <div class="col-sm-10">
            <p class="form-control-static" id="lokasi_pengiriman"><?php echo $curval ?></p>
          </div>
        </div>

         <?php $curval = $permintaan["pr_type"]; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Jenis PR *</label>
          <div class="col-sm-10">
            <p class="form-control-static" id="lokasi_pengiriman"><?php echo $curval ?></p>
          </div>
        </div>
        <!-- hlmifzi -->

        <?php $curval = $permintaan["isSwakelola"]; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Pembelian Langsung/Swakelola
          *</label>
          <div class="col-sm-10">
            <?php if($curval==1){
             echo '<input type="checkbox" class="" name="swakelola_inp" id="swakelola_inp" value="1" checked="" disabled>';
           } else {
            echo '<input type="checkbox" class="" name="swakelola_inp" id="swakelola_inp" value="0" disabled>';
          } ?>
        </div>
      </div>

      <!-- haqim -->
        <div class="form-group">
          <label class="col-sm-2 control-label">Chatting</label>
          <div class="col-sm-10">
            <button type="button" id="chatBtn" class="btn btn-primary" data-toggle="modal" data-target="#chatModal">Chatting</button>
        </div>
      </div>
      <!-- end -->

<?php /*
        <?php $curval = $permintaan["pr_contract_type"]; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Jenis Kontrak *</label>
          <div class="col-sm-10">
            <p class="form-control-static" id="jenis_kontrak"><?php echo $curval ?></p>
          </div>
        </div>
        */ ?>

      </div>
    </div>
  </div>
</div>
