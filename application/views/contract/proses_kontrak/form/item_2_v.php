<div class="row">
  <div class="col-lg-12">
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
        <div class="table-responsive">
         <table class="table table-bordered">
          <thead>
            <tr>
              <th>No</th>
              <th>Kode Barang/Jasa</th>
              <th>Deskripsi</th>
              <th>Harga Satuan</th>
              <th>Satuan</th>
              <th>Jumlah Order Minimum</th>
              <th>Jumlah Order Maximum</th>
            </tr>
          </thead>

          <tbody>
            <?php 
            $total = 0;
            foreach ($item as $key => $value) {
              $subtotal = $value['price']*$value['qty']; 
              $total += $subtotal;
              ?>
              
              <tr>
                <td><?php echo $key+1 ?></td>
                <td><?php echo $value['item_code'] ?></td>
                <td><?php echo $value['short_description'] ?></td>
                <td class="text-right"><?php echo inttomoney($value['price']) ?></td>
                <td><?php echo $value['uom'] ?></td>
                <td class="text-right"><?php echo inttomoney($value['qty']) ?></td>
                <td class="text-right"><?php echo inttomoney($value['qty']) ?></td>
              </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
        <hr>
        <div class="form-group">
          <div class="col-sm-5">
          </div>
          <label class="col-sm-4 control-label">Total PR</label>
          <div class="col-sm-3">
            <p class="form-control-static text-right" id="total_alokasi"> <?php echo inttomoney($total) ?></p>
            <input type="hidden" name="total_alokasi_inp" id="total_alokasi_inp" value="<?php echo $total ?>">
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-5">
          </div>
          <label class="col-sm-4 control-label">PPN</label>
          <div class="col-sm-3">
            <p class="form-control-static text-right" id="ppn"><?php echo inttomoney($total*0.1) ?></p>
            <input type="hidden" name="ppn_inp" id="ppn_inp" value="<?php echo $total*0.1 ?>">
          </div>
        </div>

        <div class="form-group">
          <div class="col-sm-5">
          </div>
          <label class="col-sm-4 control-label">Total PR Setelah PPN</label>
          <div class="col-sm-3">
            <p class="form-control-static text-right text-red" id="total_alokasi_ppn"><?php echo inttomoney($total+($total*0.1)) ?></p>
            <input type="hidden" name="total_alokasi_ppn_inp" id="total_alokasi_ppn_inp" value="<?php echo $total+($total*0.1) ?>">
          </div>
        </div>

      </div>
    </div>
  </div>
</div>