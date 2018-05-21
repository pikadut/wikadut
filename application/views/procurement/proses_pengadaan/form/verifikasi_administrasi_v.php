<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>VERIFIKASI ADMINISTRASI</h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>

      <div class="ibox-content">

        <div class="row">
          <div class="col-xs-2">
            <p>Nomor Pengadaan</p>
          </div>

          <div class="col-xs-3">
            <p><strong><?php echo $ptm_number ?></strong></p>
          </div>

          <div class="col-xs-2">
            <p>Nama Vendor</p>
          </div>

          <div class="col-xs-3">
            <p><strong><?php echo $vendor['vendor_name'] ?></strong></p>
          </div>

        </div>
        
      </div>
    </div>

    <?php if(!empty($administrasi)){ ?>

    <form id="vendor<?php echo $vendor['vendor_id'] ?>">

      <input type="hidden" name="id" value="<?php echo $ptm_number ?>" />
      <input type="hidden" name="vnd" value="<?php echo $vendor['vendor_id'] ?>" />

      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>ITEM</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>
          </div>
        </div>

        <div class="ibox-content">

          <table class="table table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Item</th>
                <th>Lampiran</th>
                <th>Cek Vendor</th>
                <th>Cek Evaluasi</th>
              </tr>
            </thead>

            <tbody>
              <?php foreach ($administrasi as $key => $value) { ?>

              <tr>
                <td><?php echo $key+1 ?></td>
                <td><?php echo $value['pqt_item'] ?></td>
                <td>
                  <!-- <a target="_blank" href="<?php //echo site_url('log/download_attachment_extranet/penawaran/'.$vendor['vendor_id'].'/'.$value['pqt_attachment']); ?>">
                    <?php //echo $value['pqt_attachment'] ?>
                    <a/> -->
                    <!-- haqim -->
                    <a target="_blank" href="<?php echo site_url('log/download_attachment_extranet/administrasi/'.$vendor['vendor_id'].'/'.$value['pqt_attachment']); ?>">
                    <?php echo $value['pqt_attachment'] ?>
                    <a/>
                    <!-- end -->
                  </td>
                  <td align="center">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" disabled name="check_vendor[<?php echo $value['pqt_id'] ?>]" <?php echo ($value['pqt_check_vendor'] == 1) ? "checked" : "" ?>>
                        <?php if($value['pqt_check_vendor'] == 1){ ?>
                        <input type="hidden" name="check_vendor[<?php echo $value['pqt_id'] ?>]" value="on">
                        <?php } ?>
                      </label>
                    </div>
                  </td>
                  <td align="center">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" <?php echo ($act == "view") ? "disabled" : "" ?> name="check_evaluation[<?php echo $value['pqt_id'] ?>]" <?php echo ($value['pqt_check'] == 1) ? "checked" : "" ?>>
                      </label>
                    </div>
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
        </div>

        <hr>

        <div class="ibox float-e-margins">
          <div class="ibox-title">
            <h5>CATATAN</h5>
            <div class="ibox-tools">
              <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
              </a>
            </div>
          </div>

          <div class="ibox-content">
            <?php if($act == "edit"){ ?>
            <textarea class="form-control" name="note"><?php echo $status_vendor['pvs_technical_remark'] ?></textarea>
            <?php } else { ?>
            <p><?php echo $status_vendor['pvs_technical_remark'] ?></p>
            <?php } ?>

          </div>
        </div>

      </form>

      <?php } else { ?>

      <center><h2>Vendor tidak dapat di verifikasi</h2></center>
      <br/>

      <?php } ?>

      <div class="row">
        <div class="col-xs-12">

          <center>

            <button type="button" class="btn btn-success" data-dismiss="modal" aria-label="Close">Tutup</button>
            <?php if(!empty($administrasi) && $act == "edit"){ ?>
            <button class="btn btn-primary save_vadm" data-id="<?php echo $vendor['vendor_id'] ?>" type="button">Simpan</button>
            <?php } ?>
            
          </center>

          
        </div>
      </div>
    </div>