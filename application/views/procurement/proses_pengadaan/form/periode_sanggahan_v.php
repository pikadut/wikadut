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
          <div class="col-sm-2">

            <div class="input-group">
              <input type="numeric" maxlength="2" name="periode_sanggahan_inp" id="periode_sanggahan_inp" class="form-control" required />
              <span class="input-group-addon" id="basic-addon2">Hari Kerja</span>
            </div>

          <?php /*
          <select name="periode_sanggahan_inp" id="periode_sanggahan_inp" class="form-control">
            <option value="0">Tidak Ada Sanggahan</option>
            <?php for ($i=1; $i <= 5; $i++) { ?>
            <option value="<?php echo $i ?>"><?php echo $i ?> Hari Kerja</option>
            <?php } ?>
          </select>
          */ ?>

        </div>
      </div>

    </div>
  </div>
</div>
</div>