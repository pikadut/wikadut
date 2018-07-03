<div class="wrapper wrapper-content">
  <form method="post" action="<?php echo site_url($controller_name."/submit_add_panitia_pengadaan");?>"  class="form-horizontal">

    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
          <div class="ibox-title">
            <h5>Form Tambah Panitia Pengadaan</h5>
            <div class="ibox-tools">
              <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
              </a>
            </div>
          </div> 
          <div class="ibox-content">

           <?php $curval = set_value("committee_name_inp"); ?>
           <div class="form-group">
            <label class="col-sm-2 control-label">Nama Panitia</label>
            <div class="col-sm-5">
              <input type="text" class="form-control" id="committee_name_inp" maxlength="120" name="committee_name_inp" value="<?php echo $curval ?>">
            </div>
          </div>

          <?php $curval = set_value("panitia_file_inp"); ?>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('attachment') ?></label>
            <div class="col-sm-6">
              <div class="input-group">
                <span class="input-group-btn">
                  <button type="button" data-id="panitia_file_inp_" data-folder="<?php echo $dir ?>" data-preview="preview_file_" class="btn btn-primary upload">
                    <i class="fa fa-cloud-upload"></i>
                  </button> 
                  <button type="button" data-id="panitia_file_inp_" data-folder="<?php echo $dir ?>" data-preview="preview_file_" class="btn btn-danger removefile">
                    <i class="fa fa-remove"></i>
                  </button> 
                </span> 
                <input readonly type="text" class="form-control" id="panitia_file_inp_" name="panitia_file_inp" value="<?php echo $curval ?>">
                <span class="input-group-btn">
                  <button type="button" data-url="<?php echo base_url("uploads/$dir/$curval") ?>" class="btn btn-primary preview_upload" id="preview_file_">
                    <i class="fa fa-share"></i>
                  </button> 
                </span> 
              </div>
               <div class="col-sm-0" style="font-size: 11px">
                <i>Max file 5 MB 
                <br>
                  Tipe file : doc, docx, xls, xlsx, ppt, pptx, pdf, jpg, jpeg, PNG, Zip, rar, tgz, 7zip, tar
                </i>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div style="margin-bottom: 60px;">
        <?php echo buttonsubmit('procurement/procurement_tools/panitia_pengadaan',lang('back'),lang('save')) ?>
      </div>
    </div>
  </div>

</form>
</div>