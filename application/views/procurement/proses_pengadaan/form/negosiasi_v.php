<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>PESAN NEGOSIASI</h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>

      <div class="ibox-content">

          <div class="form-group">
            <label class="col-sm-2 control-label">Vendor</label>
            <div class="col-sm-5">
              <select class="form-control select2 vendor" style="width:100%;" name="vendor_nego_inp">
                <option value="">Pilih Vendor</option>
                <?php foreach ($vendor as $kx => $vx) { ?>
                <option value="<?php echo $vx['ptv_vendor_code'] ?>"><?php echo $vx['vendor_name'] ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-sm-2 control-label">Pesan</label>
            <div class="col-sm-8">
              <textarea name="msg_nego_inp" maxlength="1000" class="form-control"></textarea>
            </div>
          </div>

      </div>

    </div>
  </div>
</div>