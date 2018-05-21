<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" action="<?php echo site_url($controller_name."/submit_change_password");?>"  class="form-horizontal">
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
          <div class="ibox-title">
            <h5>Form Ubah Password</h5>
            <div class="ibox-tools">
              <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
              </a>
            </div>
          </div> 
          <div class="ibox-content">

          <?php $curval = $userdata['complete_name']; ?>
           <div class="form-group">
            <label class="col-sm-3 control-label">User</label>
            <div class="col-sm-5">
            <p class="form-control-static"><?php echo $curval ?></p>
            </div>
          </div>

           <?php $curval = set_value("password_lama_inp"); ?>
           <div class="form-group">
            <label class="col-sm-3 control-label">Password Lama</label>
            <div class="col-sm-5">
            <input type="password" class="form-control" required id="password_lama_inp" maxlength="28" name="password_lama_inp">
            </div>
          </div>

          <?php $curval = set_value("password_baru_inp"); ?>
          <div class="form-group">
            <label class="col-sm-3 control-label">Password Baru</label>
            <div class="col-sm-5">
            <input type="password" class="form-control" required id="password_baru_inp" maxlength="28" name="password_baru_inp">
            </div>
          </div>

          <?php $curval = set_value("password_baru_ulang_inp"); ?>
          <div class="form-group">
            <label class="col-sm-3 control-label">Ulangi Password Baru</label>
            <div class="col-sm-5">
            <input type="password" class="form-control" required id="password_baru_ulang_inp" maxlength="28" name="password_baru_ulang_inp">
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <br>

  <div class="row">
    <div class="col-md-12">
      <div style="margin-bottom: 60px;">
        <?php echo buttonsubmit('home',lang('back'),lang('save')) ?>
      </div>
    </div>
  </div>

</form>
</div>