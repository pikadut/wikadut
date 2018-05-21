<?php $jadwal_tahap_2 = ($prep['ptp_submission_method'] == 2 && $activity_id >= 1112); ?>
<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>JADWAL PENGADAAN</h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="ibox-content">

        <div class="form-group">

          <label class="col-sm-2 control-label">Tanggal Pembukaan Pendaftaran</label>
          <div class="col-sm-4">
            <?php $curval = $prep['ptp_reg_opening_date']; ?>
            <div class="input-group date">
              <?php if(!$jadwal_tahap_2){ ?>
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <?php } ?>
              <input <?php echo ($jadwal_tahap_2) ? "disabled" : "" ?> type="text" name="tgl_pembukaan_pendaftaran_inp" class="form-control datetimepicker" value="<?php echo $curval ?>">
            </div>
          </div>

          <?php $curval = $prep['ptp_quot_opening_date']; ?>
          <label class="col-sm-2 control-label">Tanggal Mulai Kirim Penawaran</label>
          <div class="col-sm-4">
            <div class="input-group date">
              <?php if(!$jadwal_tahap_2){ ?>
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <?php } ?>
              <input <?php echo ($jadwal_tahap_2) ? "disabled" : "" ?> type="text" name="tgl_mulai_penawaran_inp" class="form-control datetimepicker" value="<?php echo $curval ?>">
            </div>
          </div>

        </div>

        <div class="form-group">

          <?php $curval = $prep['ptp_reg_closing_date']; ?>
          <label class="col-sm-2 control-label">Tanggal Penutupan Pendaftaran</label>
          <div class="col-sm-4">

            <div class="input-group date">
              <?php if(!$jadwal_tahap_2){ ?>
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <?php } ?>
              <input <?php echo ($jadwal_tahap_2) ? "disabled" : "" ?> type="text" name="tgl_penutupan_pendaftaran_inp" class="form-control datetimepicker" value="<?php echo $curval ?>">
            </div>

          </div>

          <?php $curval = $prep['ptp_quot_closing_date']; ?>
          <label class="col-sm-2 control-label">Tanggal Akhir Kirim Penawaran</label>
          <div class="col-sm-4">

            <div class="input-group date">
              <?php if(!$jadwal_tahap_2){ ?>
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <?php } ?>
              <input <?php echo ($jadwal_tahap_2) ? "disabled" : "" ?> type="text" name="tgl_akhir_penawaran_inp" class="form-control datetimepicker" value="<?php echo $curval ?>">
            </div>

          </div>

        </div>

        <div class="form-group">

          <?php $curval = $prep['ptp_prebid_date']; ?>
          <label class="col-sm-2 control-label">Tanggal Aanwijzing</label>
          <div class="col-sm-4">
            <div class="input-group date">
              <?php if(!$jadwal_tahap_2){ ?>
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <?php } ?>
              <input <?php echo ($jadwal_tahap_2) ? "disabled" : "" ?> type="text" name="tgl_aanwijzing_inp" class="form-control datetimepicker" value="<?php echo $curval ?>">
            </div>
          </div>


          <?php $curval = $prep['ptp_doc_open_date']; ?>
          <label class="col-sm-2 control-label">Tanggal Pembukaan Dokumen Penawaran</label>
          <div class="col-sm-4">

            <div class="input-group date">
              <?php if(!$jadwal_tahap_2){ ?>
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <?php } ?>
              <input <?php echo ($jadwal_tahap_2) ? "disabled" : "" ?> type="text" name="tgl_pembukaan_dok_penawaran_inp" class="form-control datetimepicker" value="<?php echo $curval ?>">
            </div>

          </div>

        </div>

        <div class="form-group">
          <?php $curval = $prep['ptp_prebid_location']; ?>
          <label class="col-sm-2 control-label">Lokasi Aanwijzing</label>
          <div class="col-sm-4">
            <textarea <?php echo ($jadwal_tahap_2) ? "disabled" : "" ?> class="form-control" id="lokasi_aanwijzing_inp" name="lokasi_aanwijzing_inp"><?php echo $curval ?></textarea>
          </div>

          <?php $curval = (!empty($prep['ptp_aanwijzing_online'])) ? "checked" : ""; ?>
          <label class="col-sm-2 control-label">Aanwijzing Online</label>
          <div class="col-sm-4 checkbox">
            <input type="checkbox" name="aanwijzing_online_inp" <?php echo $curval ?> value="1">
          </div>

        </div>

      </div>
    </div>

    <?php if($jadwal_tahap_2){ ?>

    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>JADWAL PENGADAAN TAHAP 2</h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="ibox-content">
        <div class="form-group">

          <?php $curval = $prep['ptp_tgl_aanwijzing2']; ?>
          <label class="col-sm-2 control-label">Tgl Aanwijzing Tahap 2</label>
          <div class="col-sm-4">
            <div class="input-group date">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <input  type="text" name="tgl_aanwijzing_2_inp" class="form-control datetimepicker" value="<?php echo $curval ?>">
            </div>
          </div>
          <?php $curval = $prep['ptp_bid_opening2']; ?>
          <label class="col-sm-2 control-label">Tgl Penutupan Penawaran Tahap 2</label>
          <div class="col-sm-4">

            <div class="input-group date">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <input  type="text" name="tgl_penutupan_penawaran_2_inp" class="form-control datetimepicker" value="<?php echo $curval ?>">
            </div>

          </div>
        </div>


        <div class="form-group">
          <?php $curval = $prep['ptp_lokasi_aanwijzing2']; ?>
          <label class="col-sm-2 control-label">Lokasi Aanwijzing Tahap 2</label>
          <div class="col-sm-4">
            <textarea required class="form-control" id="lokasi_aanwijzing_2_inp" name="lokasi_aanwijzing_2_inp"><?php echo $curval ?></textarea>
          </div>

        </div>

      </div>

    </div>

    <?php } ?>

  </div>
</div>