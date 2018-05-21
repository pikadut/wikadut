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
              <th>Pilih</th>
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
              <td><input type="checkbox" <?php echo (isset($item_wo[$value['contract_item_id']])) ? "checked" : "" ?> class="item_wo" name="item[<?php echo $value['contract_item_id'] ?>]" value="1"></td>
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
              <td><input type="text" class="form-control qty" style="width:120px;text-align: right;" name="qty_wo[<?php echo $value['contract_item_id'] ?>]" value="<?php echo $qty ?>"></td>
              <td><?php echo $value['uom'] ?></td>
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

<script type="text/javascript">

  $(".qty").on("change",function(){
    set_total();
  });

  $(".item_wo").on("change",function(){
    var checked = $(this).prop('checked');
    if(!checked) {
      $(this).parent().parent().find(".qty").val(0);
    }
    set_total();
  });
  
  set_total();

  function set_total(){

    var total_alokasi = 0;
    var ppn = 0;
    var pph = 0;
    var total_alokasi_ppn = 0;
    
    $("#item_table tr").each(function(){

      var item =  $(this).find(".item_wo").prop('checked');

      if(item){
        $(this).find(".qty").prop('readonly',false);
      } else {
        $(this).find(".qty").prop('readonly',true);
      }

      var price = (!isNaN($(this).find(".price").val())) ? parseFloat($(this).find(".price").val()) : 0;
      var qty = (!isNaN($(this).find(".qty").val())) ? parseFloat($(this).find(".qty").val()) : 0;

      var ppn_persen = ($(this).find(".tax_ppn").val()) ? $(this).find(".tax_ppn").val()/100 : 0;
      var pph_persen = ($(this).find(".tax_pph").val()) ? $(this).find(".tax_pph").val()/100 : 0;

      total_alokasi += (price*qty);
      var ppn_nominal = (price*qty) * ppn_persen;

      ppn += ppn_nominal;
      var pph_nominal = (price*qty) * pph_persen;
      pph += pph_nominal;
      total_alokasi_ppn += (price*qty) + ppn_nominal + pph_nominal;

    });

    $("#total_alokasi").text(inttomoney(total_alokasi));
    $("#total_alokasi_inp").val(total_alokasi);
    $("#ppn").text(inttomoney(ppn));
    $("#ppn_inp").val(ppn);
    $("#pph").text(inttomoney(pph));
    $("#pph_inp").val(pph);
    $("#total_alokasi_ppn").text(inttomoney(total_alokasi_ppn));
    $("#total_alokasi_ppn_inp").val(total_alokasi_ppn);

  }

</script>
