
  <form method="post" action="<?php echo site_url($controller_name."/update_tanggal_pembukaan_penawaran");?>"  class="form-horizontal">

    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
          <div class="ibox-title">
            <h5>Cari Pengadaan</h5>
            <div class="ibox-tools">
              <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
              </a>
            </div>
          </div>
          <div class="ibox-content">

           
          </div>

 </div>
</div>
</div>

<br>

<div class="row">
   <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>Jadwal Pengadaan Tahap ...</h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>

      <div class="ibox-content">

      <?php $curval = ""; ?>
     <div class="form-group">
      <label class="col-sm-2 control-label">Tgl Aanwijzing Tahap ...</label>
      <div class="col-sm-4">
        <div class="input-group"> 
          <input readonly type="text" class="form-control" id="" name="panitia_pelelangan" value="<?php echo $curval ?>">
          <span class="input-group-btn">
            <button type="button" data-id="" data-folder="<?php echo $dir ?>" data-preview="" class="btn btn-primary upload">Date</button>
            <a class="btn btn-primary action_item">Reset</a>          
          </span>
        </div>
      </div>
    </div>

    <?php $curval = ""; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Lokasi Aanwijzing Tahap ...</label>
          <div class="col-sm-4">
            <input class="form-control" id="" maxlength="120" ><?php echo $curval ?>
          </div>
        </div>

        <?php $curval = ""; ?>
     <div class="form-group">
      <label class="col-sm-2 control-label">Tgl Pembukaan Penawaran Tahap ...</label>
      <div class="col-sm-4">
        <div class="input-group"> 
          <input readonly type="text" class="form-control" id="" name="panitia_pelelangan" value="<?php echo $curval ?>">
          <span class="input-group-btn">
            <button type="button" data-id="" data-folder="<?php echo $dir ?>" data-preview="" class="btn btn-primary upload">Date</button> 
          </span>
        </div>
      </div>
    </div>

      </div>

    </div>
  </div>
</div>

</form>
