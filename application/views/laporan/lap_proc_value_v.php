<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">

      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Procurement Value</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="ibox-content">

          <form method="post" action="<?php echo site_url($controller_name."/submit_ubah_permintaan_pengadaan");?>"  class="form-horizontal ajaxform">
            <?php $curval = set_value("jumlah_item_inp"); ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Tanggal</label>
              <div class="col-sm-2">
              <input type="date" class="form-control money" name="jumlah_item_inp" id="jumlah_item_inp" value="<?php echo $curval ?>">
             </div>
             <div class="col-sm-1"><p class="form-control-static" align="center">S/D</p></div>
             <div class="col-sm-2">
              <input type="date" class="form-control money" name="jumlah_item_inp" id="jumlah_item_inp" value="<?php echo $curval ?>">
             </div>
           </div>
         </form>

         <div class="table-responsive">

          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <td>No.</td>
                <td>Metode</td>
                <td>Jumlah</td>
                <td>Nilai OE</td>
                <td>Kontrak</td>
                <td>Efisiensi Nilai</td>
                <td>Efisiensi Persentase</td>
              </tr>
            </thead>
            <tbody>
              <?php 
              $i = 1;
              foreach ($total as $key => $value) { ?>
              <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $label[$key] ?></td>
                <td><?php echo inttomoney($value['jumlah']) ?></td>
                <td><?php echo inttomoney($value['oe']) ?></td>
                <td><?php echo inttomoney($value['kontrak']) ?></td>
                <td><?php echo inttomoney($value['oe']-$value['kontrak']) ?></td>
                <td><?php echo inttomoney($value['kontrak']/$value['oe']*100) ?> %</td>
              </tr>
              <?php } ?> 
            </tbody> 
          </table>

        </div>

      </div>
    </div>

  </div>
</div>
</div>