 <?php $ctr_type = (isset($kontrak['contract_type'])) ? $kontrak["contract_type"] : ""; ?>
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
         <table class="table table-bordered" id="item_table">
          <thead>
            <tr>
              <th>No</th>
              <th>Kode Barang/Jasa</th>
              <th>Deskripsi</th>
              <th>Satuan</th>
              <th>Harga Satuan<br/>(Sebelum Pajak)</th>
              <?php if($ctr_type != "HARGA SATUAN"){ ?>
              <th>Jumlah</th>
              <?php } else { ?>
              <th>Order Minimum</th>
              <th>Order Maksimum</th>
              <?php } ?>
              <th>Pajak</th>
            </tr>
          </thead>

          <tbody>
            <?php 
            $subtotal = 0;
            $subtotal_ppn = 0;
            $subtotal_pph = 0;
            foreach ($item as $key => $value) { ?>

            <tr>
              <td><?php echo $key+1 ?></td>
              <td><?php echo $value['item_code'] ?></td>
              <td><?php echo $value['short_description'] ?></td>
              <td><?php echo $value['uom'] ?></td>
              <td class="text-right"><?php echo inttomoney($value['price']) ?>
                <input type="hidden" class="form-control price" value="<?php echo $value['price'] ?>">
              </td>
              <?php if($ctr_type != "HARGA SATUAN"){ ?>
              <td class="text-right"><?php echo inttomoney($value['qty']) ?>
               <input type="hidden" class="form-control qty" value="<?php echo $value['qty'] ?>">
             </td>
             <?php } else { ?>
             <td class="text-right">
               <input type="text" style="width: 120px; text-align: right;" name="min_qty[<?php echo $value['contract_item_id'] ?>]" class="form-control min" value="<?php echo $value['min_qty'] ?>">
             </td>
             <td class="text-right">
               <input type="text" style="width: 120px; text-align: right;" name="max_qty[<?php echo $value['contract_item_id'] ?>]" class="form-control max" value="<?php echo $value['max_qty'] ?>">
             </td>
             <?php } ?>
             
             <td>

             <?php /*
              <div class="input-group">
                <span class="input-group-addon">PPN</span>
                <input type="text" class="form-control tax_ppn" style="text-align: right;" name="tax_ppn[<?php echo $value['contract_item_id'] ?>]" value="<?php echo $value['ppn'] ?>">
                <span class="input-group-addon">%</span>
              </div>

              <div class="input-group">
                <span class="input-group-addon">PPH</span>
                <input type="text" class="form-control tax_pph" style="text-align: right;" name="tax_pph[<?php echo $value['contract_item_id'] ?>]" value="<?php echo $value['pph'] ?>">
                <span class="input-group-addon">%</span>
              </div>
              */ ?>

              <?php echo (!empty($value['ppn'])) ? " PPN (".$value['ppn']."%) " : "" ?> 
              <?php echo (!empty($value['pph'])) ? " PPH (".$value['pph']."%)" : "" ?> 

              <input type="hidden" class="tax_ppn" name="tax_ppn[<?php echo $value['contract_item_id'] ?>]" value="<?php echo $value['ppn'] ?>">
              <input type="hidden" class="tax_pph" name="tax_pph[<?php echo $value['contract_item_id'] ?>]" value="<?php echo $value['pph'] ?>">

            </td>

          </tr>
          <?php 
          $subtotal += $value['price']*$value['qty'];
          if(!empty($value['ppn'])){
            $subtotal_ppn += $value['price']*$value['qty']*($value['ppn']/100);
          }
          if(!empty($value['pph'])){
           $subtotal_pph += $value['price']*$value['qty']*($value['pph']/100);
         }
       } ?>
     </tbody>
   </table>
 </div>
</div>
</div>
</div>
</div>