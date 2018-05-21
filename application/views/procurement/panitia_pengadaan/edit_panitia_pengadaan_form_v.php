<div class="wrapper wrapper-content">
  <form method="post" action="<?php echo site_url($controller_name."/submit_edit_panitia_pengadaan");?>" class="form-horizontal">

    <input type="hidden" name="id" value="<?php echo $id ?>">

    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
          <div class="ibox-title">
            <h5>Ubah Panitia Pengadaan</h5>
            <div class="ibox-tools">
              <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
              </a>
            </div>
          </div>

          <div class="ibox-content">

              <?php $curval = $data["committee_name"]; ?>
              <div class="form-group">
                <label class="col-sm-2 control-label">Nama Panitia</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" required name="committee_name_inp" value="<?php echo $curval ?>">
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