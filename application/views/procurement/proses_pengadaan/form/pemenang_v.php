<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>Penetapan Pelaksana Pekerjaan</h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>

      <div class="ibox-content">

        <div class="row">
        <div class="col-xs-4">
        </div>
        <div class="col-xs-4">
        <h2 align="center"><strong>Pilih Pelaksana Pekerjaan</strong></h2>

        <select class="form-control" name="winner_inp" required>
          <option value="">--Pilih--</option>
          <?php foreach ($evaluation as $key => $value) {
            if($value['adm'] == "Lulus" && $value['pass'] == "Lulus"){
           ?>
            <option style="font-size:12pt;font-weight:bold;" value="<?php echo $value['ptv_vendor_code'] ?>"><?php echo $value['vendor_name'] ?> (<?php echo inttomoney($value['total']) ?>)</option>
          <?php } } ?>
        </select>
        </div>
         <div class="col-xs-4">
        </div>
      </div>

    </div>
  </div>
</div>
</div>