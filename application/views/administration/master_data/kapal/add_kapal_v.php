<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" action="<?php echo site_url($controller_name."/submit_add_kapal");?>"  class="form-horizontal">

    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
          <div class="ibox-title">
            <h5>Form Tambah</h5>
            <div class="ibox-tools">
              <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
            </a>
        </div>
    </div> 
    <div class="ibox-content">

     <?php $curval = set_value("code_inp"); ?>
     <div class="form-group">
       <label class="col-sm-2 control-label">Kode</label>
       <div class="col-sm-4">
          <input type="text" class="form-control" id="code_inp" maxlength="3" name="code_inp" value="<?php echo $curval ?>">
      </div>
  </div>

  <?php $curval = set_value("name_inp"); ?>
  <div class="form-group">
    <label class="col-sm-2 control-label">Nama</label>
    <div class="col-sm-4">
      <input type="text" class="form-control" id="name_inp" maxlength="50" name="name_inp" value="<?php echo $curval ?>">
  </div>
</div>

<?php $curval = set_value("district_inp"); ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Kantor</label>
  <div class="col-sm-5">
    <select required class="form-control" name="district_inp">
      <option value="">Pilih</option>
      <?php foreach($district as $key => $val){
        $selected = ($val['district_id'] == $curval) ? "selected" : ""; ?>
        <option <?php echo $selected ?> value="<?php echo $val['district_id'] ?>">
          <?php echo $val['district_code'] ?> - <?php echo $val['district_name'] ?>
      </option>
      <?php } ?>
  </select>
</div>
</div>
<!-- ============================================================================================= -->
<?php $curval = set_value("detail_attachment"); ?>
          <div class="form-group" id="tempat_detail">
          <label class="col-md-2 control-label">Attachment</label>
          <div class="col-md-6"> 
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" data-id="detail_attachment" data-folder="<?php echo $dir ?>" data-preview="detail_file" class="btn btn-primary upload">
                  <i class="fa fa-cloud-upload"></i>
                </button> 
                <button type="button" data-id="detail_attachment" data-folder="<?php echo $dir ?>" data-preview="detail_file" class="btn btn-danger removefile">
                  <i class="fa fa-remove"></i>
                </button> 
              </span> 
              <input readonly type="text" class="form-control" id="detail_attachment" ng-model="data.detail_item" name="detail_attachment">
              <span class="input-group-btn">

                <button type="button" data-url="#" class="btn btn-primary preview_upload" id="detail_file">
                  <i class="fa fa-share"></i>
                </button> 
              </span> 
            </div>
          </div>
<!-- ======================================================================================== -->
</div>
</div>
</div>
</div>

<div class="row">
  <div class="col-md-12">
    <div style="margin-bottom: 60px;">
      <?php echo buttonsubmit('administration/master_data/kapal',lang('back'),lang('save')) ?>
  </div>
</div>
</div>

</form>
</div>