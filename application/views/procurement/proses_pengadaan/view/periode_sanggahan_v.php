<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>PERIODE SANGGAHAN</h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="ibox-content">

        <?php $curval = $prep['ptp_denial_period']; ?>
        <div class="form-group">
        <label class="col-sm-2 control-label">Lama Sanggahan</label>
          <div class="col-sm-4">
           <p class="form-control-static"><?php echo (!empty($curval)) ? $curval." Hari" : "Tidak Ada" ?></p>
          </div>
        </div>

        <?php $curval = $prep['ptp_denial_period_start']; ?>
        <div class="form-group">
        <label class="col-sm-2 control-label">Mulai Sanggahan</label>
          <div class="col-sm-4">
           <p class="form-control-static"><?php echo (!empty($curval)) ? date(DEFAULT_FORMAT_DATETIME,strtotime($curval)) : "" ?></p>
          </div>
        </div>

                <?php $curval = $prep['ptp_denial_period_end']; ?>
        <div class="form-group">
        <label class="col-sm-2 control-label">Selesai Sanggahan</label>
          <div class="col-sm-4">
           <p class="form-control-static"><?php echo (!empty($curval)) ? date(DEFAULT_FORMAT_DATETIME,strtotime($curval)) : "" ?></p>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>