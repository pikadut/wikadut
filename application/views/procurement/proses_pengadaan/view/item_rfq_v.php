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

        <table class="table table-bordered default" id="item_table">
          <thead>
            <tr>
              <th>#</th>
              <th>Kode</th>
              <th>Tipe</th>
              <th>Item</th>
              <th>Jumlah</th>
              <th>Satuan</th>
              <th>Harga Satuan<br/>(Sebelum Pajak)</th>
              <th>Pajak</th>
              <th>Subtotal<br/>(Sebelum Pajak)</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $subtotal = 0;
            $subtotal_ppn = 0;
            $subtotal_pph = 0;
            foreach ($item as $key => $value) { 
              ?>
              <tr>
                <td><?php echo $key+1 ?></td>
                <td><?php echo $value['tit_code'] ?></td>
                <td><?php echo $value['tit_type'] ?></td>
                <td><?php echo $value['tit_description'] ?></td>
                <td class="text-right"><?php echo inttomoney($value['tit_quantity']) ?></td>
                <td><?php echo $value['tit_unit'] ?></td>
                <td class="text-right"><?php echo inttomoney($value['tit_price']) ?></td>
                <td class="text-right">
                  <?php echo (!empty($value['tit_ppn'])) ? " PPN (".$value['tit_ppn']."%) " : "" ?> 
                  <?php echo (!empty($value['tit_pph'])) ? " PPH (".$value['tit_pph']."%)" : "" ?> 
                </td>
                <td class="text-right">
                <?php echo inttomoney($value['tit_price']*$value['tit_quantity']) ?>
                </td>
              </tr>
              <?php 
              $subtotal += $value['tit_price']*$value['tit_quantity'];
              if(!empty($value['tit_ppn'])){
                $subtotal_ppn += $value['tit_price']*$value['tit_quantity']*($value['tit_ppn']/100);
              }
              if(!empty($value['tit_pph'])){
               $subtotal_pph += $value['tit_price']*$value['tit_quantity']*($value['tit_pph']/100);
             }
            } ?>
         </tbody>
       </table>

       <hr>

       <div class="form-group">
        <div class="col-sm-5">
        </div>
        <label class="col-sm-4 control-label">Nilai PR</label>
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
        <label class="col-sm-4 control-label">Nilai PR Setelah PPN &amp; PPH</label>
        <div class="col-sm-3">
          <p class="form-control-static text-right text-red" id="total_alokasi_ppn"><?php echo inttomoney($subtotal+$subtotal_ppn+$subtotal_pph) ?></p>
          <input type="hidden" name="total_alokasi_ppn_inp" id="total_alokasi_ppn_inp" 
          value="<?php echo $subtotal+$subtotal_ppn+$subtotal_pph ?>">
        </div>
      </div>

      <div class="form-group">
        <div class="col-sm-5">
        </div>
        <label class="col-sm-4 control-label">Total Nilai Anggaran</label>
        <div class="col-sm-3">
          <p class="form-control-static text-right" id="total_pagu"><?php echo inttomoney($permintaan['ptm_pagu_anggaran']) ?></p>
          <input type="hidden" name="total_pagu_inp" id="total_pagu_inp" value="<?php echo $permintaan['ptm_pagu_anggaran'] ?>">
        </div>
      </div>

      <div class="form-group">
        <div class="col-sm-5">
        </div>
        <label class="col-sm-4 control-label">Sisa Nilai Anggaran</label>
        <div class="col-sm-3">
        <p class="form-control-static text-right" id="sisa_pagu"><?php echo inttomoney($permintaan['ptm_pagu_anggaran']-($subtotal+$subtotal_ppn+$subtotal_pph)) ?></p>
        <input type="hidden" name="sisa_pagu_inp" id="sisa_pagu_inp" value="<?php echo $permintaan['ptm_pagu_anggaran']-($subtotal+$subtotal_ppn+$subtotal_pph) ?>">
        </div>
      </div>
    </div>

  </div>
</div>
</div>