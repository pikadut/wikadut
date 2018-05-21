<?php if($prep['ptp_prequalify'] != 0){ ?>
<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>PRA KUALIFIKASI</h5>
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
              <th>Nama Vendor</th>
              <th>Lampiran Prakualifikasi</th>
              <th>Lulus/Tidak Lulus</th>
              <th>Alasan</th>
            </tr>
          </thead>

          <tbody>
            <?php 
            if(!empty($vendor_status)){
              foreach ($vendor_status as $key => $value) {
               ?>

              <tr>
                <td><?php echo $key+1 ?></td>
                <td><a target="_blank" href="<?php echo site_url('vendor/daftar_vendor/lihat_detail_vendor/'.$value['pvs_vendor_code']) ?>">
                <?php echo $value['vendor_name'] ?>
                  
                </a></td>
                <td>
                <a target="_blank" href="<?php echo site_url('log/download_attachment_extranet/prakualifikasi/'.$value['pvs_vendor_code'].'/'.$value["pvs_pq_attachment"]); ?>">
                <?php echo $value["pvs_pq_attachment"] ?>
                  
                </a>
                <input type="hidden" name="attachment_pq_inp[<?php echo $value['pvs_vendor_code'] ?>]" 
                value="<?php echo $value["pvs_pq_attachment"] ?>"/>
                </td>
                <td align="center">
                  <div class="checkbox">
                    <label>
                      <input type="checkbox" <?php echo (!empty($value['pvs_pq_passed'])) ? "checked" : "" ?> name="lulus_pq_inp[<?php echo $value['pvs_vendor_code'] ?>]">
                    </label>
                  </div>
                </td>
                <td><textarea class="form-control" name="alasan_pq_inp[<?php echo $value['pvs_vendor_code'] ?>]"><?php echo $value['pvs_pq_reason'] ?></textarea></td>
                
              </tr>

              <?php } } ?>
            </tbody>
          </table>

        </div>
      </div>
    </div>
  </div>
  
   <?php } ?>