
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
          <div class="ibox-title">
            <h5>BASTP/B</h5>
            <div class="ibox-tools">
              <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
              </a>
            </div>
          </div>
          <div class="ibox-content">

          <?php $curval =""; ?>
           <div class="form-group">
            <label class="col-sm-2 control-label">Nomor BASTP/B</label>
            <div class="col-sm-10">
             <input class="form-control"><?php echo $curval ?>
           </div>
         </div>

           <?php $curval =""; ?>

           <div class="form-group">
            <label class="col-sm-2 control-label">Tanggal Barang Diterima / Pekerjaan Selesai</label>
            <div class="col-sm-10">
             <input class="form-control"><?php echo $curval ?>
           </div>
         </div>

        <?php $curval =""; ?>

         <div class="form-group">
          <label class="col-sm-2 control-label">Judul</label>
          <div class="col-sm-10">
            <input class="form-control"><?php echo $curval ?>
          </div>
        </div>

        <?php $curval =""; ?>

         <div class="form-group">
          <label class="col-sm-2 control-label">Berita Acara</label>
          <div class="col-sm-10">
            <textarea class="form-control"><?php echo $curval ?></textarea>
          </div>
        </div>

        <?php $curval = ""; ?>
         <div class="form-group">
          <label class="col-sm-2 control-label">Lampiran</label>
          <div class="col-sm-10">
          <input type="file">
          <p>File Saat Ini : <?php echo $curval ?></p>
          </div>
        </div>
       
      </div>
    </div>
  </div>
</div>