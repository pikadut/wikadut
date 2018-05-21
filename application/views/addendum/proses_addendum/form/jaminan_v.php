<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>JAMINAN PELAKSANAAN</h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="ibox-content">

        <?php $curval = (isset($kontrak['pf_bank'])) ? $kontrak['pf_bank'] : ""; ?>

        <div class="form-group">
          <label class="col-sm-2 control-label">Nama Bank</label>
          <div class="col-sm-8">
            <input class="form-control" required name="nama_bank_inp" value="<?php echo $curval ?>">
          </div>
        </div>

         <?php $curval = (isset($kontrak['pf_number'])) ? $kontrak['pf_number'] : ""; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Nomor Jaminan</label>
          <div class="col-sm-4">
            <input class="form-control" required name="no_jaminan_inp" value="<?php echo $curval ?>">
          </div>
        </div>

        <?php $curval = (isset($kontrak['pf_start_date'])) ? $kontrak['pf_start_date'] : ""; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Mulai Berlaku</label>
          <div class="col-sm-4">
            <div class="input-group date">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <input  type="text" name="mulai_berlaku_inp" class="form-control datetimepicker" value="<?php echo $curval ?>">
            </div>
          </div>
        </div>

        <?php $curval = (isset($kontrak['pf_end_date'])) ? $kontrak['pf_end_date'] : ""; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Berlaku Hingga</label>
          <div class="col-sm-4">
            <div class="input-group date">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <input  type="text" name="berlaku_hingga_inp" class="form-control datetimepicker" value="<?php echo $curval ?>">
            </div>
          </div>
        </div>

        <?php $curval = (isset($kontrak['pf_amount'])) ? $kontrak['pf_amount'] : ""; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Nilai Jaminan</label>
          <div class="col-sm-5">
            <input class="form-control money" required name="nilai_jaminan_inp" value="<?php echo $curval ?>">
          </div>
        </div>

        <?php $curval = (isset($kontrak['pf_attachment'])) ? $kontrak['pf_attachment'] : ""; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Lampiran Jaminan</label>
          <div class="col-sm-5">
            <div class="input-group">
              <span class="input-group-btn">
              <button type="button" data-id="jaminan_file_inp" data-folder="<?php echo "contract/jaminan" ?>" data-preview="preview_file" class="btn btn-primary upload">...</button> 
              </span> 
              <input readonly type="text" class="form-control" id="jaminan_file_inp" name="jaminan_file_inp" value="<?php echo $curval ?>">
              <span class="input-group-btn">
              <button type="button" data-url="<?php echo INTRANET_UPLOAD_FOLDER."/contract/jaminan/$curval" ?>" class="btn btn-primary preview_upload" id="preview_file">Lihat</button> 
              </span> 
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>