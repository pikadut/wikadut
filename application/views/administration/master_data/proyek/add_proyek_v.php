<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" action="<?php echo site_url($controller_name."/submit_add_proyek");?>"  class="form-horizontal">

    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
          <div class="ibox-title">
            <h5>Form</h5>
            <div class="ibox-tools">
              <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
              </a>
            </div>
          </div> 
          <div class="ibox-content">

            <?php $curval = set_value("project_name_inp"); ?>
           <div class="form-group">
            <label class="col-sm-2 control-label">Nama Proyek</label>
            <div class="col-sm-8">
              <input type="text" class="form-control" name="project_name_inp" value="<?php echo $curval ?>" required>
            </div>
          </div>

          <?php $curval = set_value("description_inp"); ?>
          <div class="form-group">
            <label class="col-sm-2 control-label">Deskripsi</label>
            <div class="col-sm-8">
              <textarea class="form-control" name="desc_inp" required><?=$curval?></textarea>
            </div>
          </div>

          <?php $curval = set_value("date_start_inp"); ?>
          <div class="form-group">
            <label class="col-sm-2 control-label">Tanggal mulai</label>
            <div class="col-sm-4">
            <input type="text" class="form-control datepicker" name="date_start_inp" required value="<?php echo $curval ?>">
            </div>
          </div>

          <?php $curval = set_value("date_end_inp"); ?>
          <div class="form-group">
            <label class="col-sm-2 control-label">Tanggal akhir</label>
            <div class="col-sm-4">
              <input type="text" class="form-control datepicker" name="date_end_inp" required value="<?php echo $curval ?>">
            </div>
          </div> 

          <?php $curval = set_value("status_inp"); ?>
          <div class="form-group">
            <label class="col-sm-2 control-label">Status</label>
            <div class="col-sm-4">
              <select name="status_inp" class="form-control" required>
                <option value="1">aktif</option>
                <option value="0">non-aktif</option>
              </select>
            </div>
          </div> 

        </div>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <div style="margin-bottom: 60px;">
        <?php echo buttonsubmit('administration/master_data/proyek',lang('back'),lang('save')) ?>
      </div>
    </div>
  </div>

</form>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    $( ".datepicker" ).datepicker();
  })
</script>