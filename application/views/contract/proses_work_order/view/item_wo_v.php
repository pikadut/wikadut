<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>ITEM WO</h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="ibox-content">
        <div class="table-responsive">
         <table class="table table-bordered" id="item_table">
          <thead>
            <tr>
              <th>No.</th>
              <th>Kode Barang/Jasa</th>
              <th>Deskripsi Detail</th>
              <th>Harga Satuan</th>
              <th>Pajak</th>
              <th>Order Minimum</th>
              <th>Order Maximum</th>
              <th>Jumlah Order</th>
              <th>Satuan</th>
            </tr>
          </thead>

          <tbody>
            <?php 
            $subtotal = 0;
            $subtotal_ppn = 0;
            $subtotal_pph = 0;
            foreach ($item as $key => $value) {
              $qty = (isset($item_wo[$value['contract_item_id']])) ? $item_wo[$value['contract_item_id']] : 0;
              ?>

              <tr>
                <td><?php echo ++$key ?></td>
                <td><?php echo $value['item_code'] ?></td>
                <td><?php echo $value['short_description'] ?></td>
                <td class="text-right"><?php echo inttomoney($value['price']) ?>
                 <input type="hidden" class="form-control price" value="<?php echo $value['price'] ?>">
               </td>
               <td class="text-right">
                <?php echo (!empty($value['ppn'])) ? " PPN (".$value['ppn']."%) " : "" ?> <br/>
                <?php echo (!empty($value['pph'])) ? " PPH (".$value['pph']."%)" : "" ?> 
                <input type="hidden" class="tax_ppn" value="<?php echo $value['ppn'] ?>">
                <input type="hidden" class="tax_pph" value="<?php echo $value['pph'] ?>">
              </td>
              <td class="text-right"><?php echo $value['min_qty'] ?></td>
              <td class="text-right"><?php echo $value['max_qty'] ?></td>
              <td class="text-right"><?php echo $qty ?></td>
              <td><?php echo $value['uom'] ?></td>
            </tr>
            <?php 
            $subtotal += $value['price']*$qty;
            if(!empty($value['ppn'])){
              $subtotal_ppn += $value['price']*$qty*($value['ppn']/100);
            }
            if(!empty($value['pph'])){
             $subtotal_pph += $value['price']*$qty*($value['pph']/100);
           }
         } ?>
       </tbody>
     </table>
   </div>
   <hr>

   <div class="form-group">
    <div class="col-sm-5">
    </div>
    <label class="col-sm-4 control-label">Nilai WO</label>
    <div class="col-sm-3">
      <p class="form-control-static text-right" id="total_alokasi"> <?php echo inttomoney($subtotal) ?></p>
      <input type="hidden" name="total_alokasi_inp" id="total_alokasi_inp" value="<?php echo $subtotal ?>">
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-5">
    </div>
    <label class="col-sm-4 control-label">PPN</label>
    <div class="col-sm-3">
      <p class="form-control-static text-right" id="ppn"><?php echo inttomoney($subtotal_ppn) ?></p>
      <input type="hidden" name="ppn_inp" id="ppn_inp" value="<?php echo $subtotal_ppn ?>">
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-5">
    </div>
    <label class="col-sm-4 control-label">PPH</label>
    <div class="col-sm-3">
      <p class="form-control-static text-right" id="pph"><?php echo inttomoney($subtotal_pph) ?></p>
      <input type="hidden" name="pph_inp" id="pph_inp" value="<?php echo $subtotal_pph ?>">
    </div>
  </div>

  <div class="form-group">
    <div class="col-sm-5">
    </div>
    <label class="col-sm-4 control-label">Nilai WO Setelah PPN &amp; PPH</label>
    <div class="col-sm-3">
      <p class="form-control-static text-right text-red" id="total_alokasi_ppn"><?php echo inttomoney($subtotal+$subtotal_ppn+$subtotal_pph) ?></p>
      <input type="hidden" name="total_alokasi_ppn_inp" id="total_alokasi_ppn_inp" 
      value="<?php echo $subtotal+$subtotal_ppn+$subtotal_pph ?>">
    </div>
  </div>

</div>
</div>
</div>
</div>