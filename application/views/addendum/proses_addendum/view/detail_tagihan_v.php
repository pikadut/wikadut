<div class="row">
  <div class="col-lg-12">

    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>DETAIL TAGIHAN</h5>

      </div>

      <div class="ibox-content">

        <form class="form-horizontal">

          <?php $curval = $invoice['contract_number']; ?>
          <div class="form-group">
            <label class="col-sm-2 control-label">No. Kontrak</label>
            <div class="col-sm-4">
              <p class="form-control-static"><?php echo $curval ?></p>
            </div>
            <?php $curval = $invoice['invoice_number']; ?>
            <label class="col-sm-2 control-label">No. Tagihan</label>
            <div class="col-sm-4">
              <p class="form-control-static"><?php echo $curval ?></p>
            </div>
          </div>

          <?php $curval = $invoice['vendor_name']; ?>
          <div class="form-group">
            <label class="col-sm-2 control-label">Vendor</label>
            <div class="col-sm-4">
              <p class="form-control-static"><?php echo $curval ?></p>
            </div>
            <?php $curval = $invoice['bank_account']; ?>
            <label class="col-sm-2 control-label">Rekening Bank</label>
            <div class="col-sm-4">
              <p class="form-control-static"><?php echo $curval ?></p>
            </div>
          </div>

        </form>

      </div>
    </div>

    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>MILESTONE TAGIHAN</h5>

      </div>

      <div class="ibox-content">

        <table class="table table-bordered" >
          <thead>
            <tr>
              <th>No</th>
              <th>Deskripsi Milestone</th>
              <th>Tanggal Target</th>
              <th>Bobot (%)</th>
              <th>Nominal</th>
            </tr>
          </thead>

          <tbody>

            <?php 
            $total = 0;
            foreach ($item as $key => $value) { ?>
            <tr>
              <td><?php echo $key+1 ?></td>
              <td><?php echo $value['description'] ?></td>
              <td><?php echo date(DEFAULT_FORMAT_DATE,strtotime($value['target_date'])) ?></td>
              <td class="text-right"><?php echo $value['percentage'] ?></td>
              <td class="text-right"><?php echo inttomoney($value['bastp_subtotal']) ?></td>
            </tr>

            <?php $total += $value['bastp_subtotal']; } ?>

          </tbody>

        </table>

        <div class="form-group">
          <div class="col-sm-8">
          </div>
          <label class="col-sm-2 control-label">Total Tagihan</label>
          <div class="col-sm-2">
            <p class="form-control-static text-right" id="total_tagihan"> <?php echo inttomoney($total) ?></p>
          </div>
        </div>

      </div>
    </div>

    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>LAMPIRAN TAGIHAN</h5>
      </div>
      <div class="ibox-content">

       <table class="table table-bordered">
        <thead>
          <tr>
            <th>No</th>
            <th>Deskripsi</th>
            <th>Kirim ke Vendor?</th>
            <th>File</th>
          </tr>
        </thead>

        <tbody>
         <?php 
         $sisa = 5;
         if(isset($document) && !empty($document)){
          foreach ($document as $k => $v) {
            if(!empty($v['filename'])){
              ?>
              <tr>
                <td><?php echo $k+1 ?></td>
                <td><?php echo $v['description'] ?></td>
                <td><?php echo ($v['status']) ? "Ya" : "Tidak" ?></td>
                <td><a href="<?php echo base_url("uploads/$dir/".$v['filename']) ?>" target="_blank"><?php echo $v['filename'] ?></a></td>
              </tr>

              <?php } } } ?>
            </tbody>
          </table>

        </div>

      </div>

  </div>

</div>