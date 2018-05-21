<div class="row">
  <div class="col-lg-12">

    <form class="form-horizontal" id="eval_price_form">

      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>PERBANDINGAN PENAWARAN</h5>
        </div>

        <div class="ibox-content">

          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th rowspan="2">No</th>
                  <th rowspan="2">Item</th>
                  <th colspan="2">Nilai SPPBJ</th>
                  <?php foreach ($vendor as $key => $value) { ?>
                  <th colspan="2">
                    <a target="_blank" href="<?php echo site_url('procurement/lihat_penawaran/'.$value['id']) ?>">
                      <?php echo $value['vendor_name'] ?> (<?php echo $value['type_quo'] ?>)
                    </th>
                    <?php } ?>
                  </tr>
                  <tr>
                    <th>Qty</th>
                    <th>Price</th>
                    <?php foreach ($vendor as $key => $value) { ?>
                    <th>Qty</th>
                    <th>Price</th>
                    <?php } ?>
                  </tr>
                </thead>

                <tbody>

                  <?php 
                  $hps_total = 0;
                  $tax_total = 0;
                  foreach ($item as $key => $value) { ?>

                  <tr>

                    <td><?php echo $key+1 ?></td>
                    <td><?php echo $value['tit_code'] ?> - <?php echo $value['tit_description'] ?></td>
                    <td class="text-right"><?php echo inttomoney($value['tit_quantity']) ?></td>
                    <td class="text-right"><?php echo inttomoney($value['tit_price']) ?></td>

                    <?php if(isset($harga[$value['tit_id']])){ 
                      foreach ($harga[$value['tit_id']] as $k => $v) { ?>
                      <td class="text-right">
                        <?php echo inttomoney($v['qty']) ?>
                      </td>
                      <td class="text-right">
                        <a title="<?php echo $v['desc'] ?>">
                          <?php echo inttomoney($v['price']) ?>
                        </a>
                      </td>
                      <?php } } else { ?>
                      <?php foreach ($head as $k => $v) { ?>
                    <td class="text-right">
                        <?php echo inttomoney(0) ?>
                      </td>
                      <td class="text-right">
                        <a title="<?php echo '' ?>">
                          <?php echo inttomoney(0) ?>
                        </a>
                      </td>
                    <?php } ?>
                        <?php } ?>

                    </tr>

                    <?php 
                    $hps_total += $value['tit_price']*$value['tit_quantity'];
                    $tax_total += ($value['tit_price']*$value['tit_quantity']) * (($value['tit_ppn']+$value['tit_pph'])/100);
                  } ?>

                  <tr>
                    <td colspan="2" class="text-right"><strong>TOTAL HARGA</strong></td>
                    <td class="text-right" colspan="2"><strong><?php echo inttomoney($hps_total) ?></strong></td>

                    <?php foreach ($head as $k => $v) { ?>
                    <td class="text-right" colspan="2"><strong><?php echo inttomoney($v['subtotal']) ?></strong></td>
                    <?php } ?>

                  </tr>
                  <tr>
                    <td colspan="2" class="text-right"><strong>PPN</strong></td>
                    <td class="text-right" colspan="2"><strong><?php echo inttomoney($tax_total) ?></strong></td>

                    <?php foreach ($head as $k => $v) { ?>
                    <td class="text-right" colspan="2"><strong><?php echo inttomoney($v['subtotal_tax']) ?></strong></td>
                    <?php } ?>

                  </tr>
                  <tr>
                    <td colspan="2" class="text-right"><strong>TOTAL HARGA SETELAH PPN</strong></td>
                    <td class="text-right" colspan="2"><strong><?php echo inttomoney($hps_total+$tax_total) ?></strong></td>

                    <?php foreach ($head as $k => $v) { ?>
                    <td class="text-right" colspan="2"><strong><?php echo inttomoney($v['total']) ?></strong></td>
                    <?php } ?>

                  </tr>
                  <tr>
                    <td colspan="2" class="text-right"><strong>BID BOND</strong></td>
                    <td class="text-right" colspan="2"><strong>0.00</strong></td>
                    <?php foreach ($head as $k => $v) { ?>
                    <td class="text-right" colspan="2"><strong><?php echo inttomoney($v['bid_bond']) ?></strong></td>
                    <?php } ?>
                  </tr>
                  <tr> 
                    <td colspan="2" class="text-right"><strong>VALID SAMPAI</strong></td>
                    <td colspan="2"></td>
                    <?php foreach ($head as $k => $v) { ?>
                    <td class="text-center" colspan="2"><strong><?php echo date("d M Y",strtotime($v['valid_time'])) ?></strong></td>
                    <?php } ?>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>


        <div class="ibox float-e-margins">
          <div class="ibox-title">
            <h5>NILAI</h5>
          </div>

          <div class="ibox-content">

            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>No</th>
                  <th>Nama Vendor</th>
                  <th>Nilai Harga</th>
                  <th>Catatan</th>
                  <th>Validitas Penawaran</th>
                  <th>Validitas Bid Bond</th>
                </tr>
              </thead>

              <tbody>
                <?php foreach ($nilai as $key => $value) { ?>
                <tr>
                  <td><?php echo $key+1 ?></td>
                  <td><?php echo $value['vendor_name'] ?></td>
                  <td class="vendor_price_value text-right" data-id="<?php echo $value['ptv_vendor_code'] ?>"><?php echo inttomoney($value['pte_price_value']) ?></td>
                  <td>
                    <?php if($act == "edit"){ ?>
                    <textarea class="form-control" name="eval_note[<?php echo $value['pte_id'] ?>]"><?php echo $value['pte_price_remark'] ?></textarea>
                    <?php } else { ?>
                    <?php echo $value['pte_price_remark'] ?>
                    <?php } ?>
                    <?php if($tender['ptm_status'] == 1140){ ?>
                    <input type="hidden" class="form-control" name="eval_note[<?php echo $value['pte_id'] ?>]" value="<?php echo $value['pte_price_remark'] ?>">
                    <?php } ?>
                  </td>
                  <td align="center">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" <?php echo ($act == "view") ? "disabled" : "" ?> name="validity_offer[<?php echo $value['pte_id'] ?>]" <?php echo ($value['pte_validity_offer'] == 1) ? "checked" : "" ?>>
                        <?php if($tender['ptm_status'] == 1140 && !empty($value['pte_validity_offer'])){ ?>
                        <input type="hidden" name="validity_offer[<?php echo $value['pte_id'] ?>]" value="<?php echo $value['pte_validity_offer'] ?>">
                        <?php } ?>
                      </label>
                    </div>
                  </td>
                  <td align="center">
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" <?php echo ($act == "view") ? "disabled" : "" ?> name="validity_bid_bond[<?php echo $value['pte_id'] ?>]" <?php echo ($value['pte_validity_bid_bond'] == 1) ? "checked" : "" ?>>
                        <?php if($tender['ptm_status'] == 1140 && !empty($value['pte_validity_bid_bond'])){ ?>
                        <input type="hidden" name="validity_bid_bond[<?php echo $value['pte_id'] ?>]" value="<?php echo $value['pte_validity_bid_bond'] ?>">
                        <?php } ?>
                      </label>
                    </div>
                  </td>
                </tr>
                <?php } ?>

              </tbody>
            </table>

            <?php if($act == "edit" || $tender['ptm_status'] == 1140){ ?>
            <center>
              <a href="#" class="btn btn-primary" id="calculate_price">Hitung Nilai Harga</a>
            </center>
            <?php } ?>

          </div>
        </div>

      </form>

      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>KOMENTAR EVALUASI HARGA</h5>

        </div>

        <div class="ibox-content">

          <?php if($act == "edit"){ ?>

          <form class="form-horizontal" id="eval_com_form">

            <div class="form-group">
              <label class="col-sm-2 control-label">Vendor</label>
              <div class="col-sm-5">
                <select class="form-control select2 vendor" style="width:100%;" name="vendor_eval_inp">
                  <?php foreach ($nilai as $kx => $vx) { ?>
                  <option value="<?php echo $vx['ptv_vendor_code'] ?>"><?php echo $vx['vendor_name'] ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label"><?php echo lang('comment') ?></label>
              <div class="col-sm-8">
                <textarea name="comment_eval_inp" id="comment_eval_inp" maxlength="1000" required class="form-control"></textarea>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label"> </label>
              <div class="col-sm-10">
                <input type="hidden" name="type_eval_inp" value="C">
                <a href="#" class="btn btn-primary" id="eval_com_btn">Simpan</a>
              </div>
            </div>

          </form>

          <br/>

          <?php } ?>

          <table id="eval_com_table" class="table table-bordered table-striped"></table>

        </div>
      </div>

      <hr/>
      <center>
        <button type="button" class="btn btn-primary" data-dismiss="modal">Kembali</button>
      </center>

    </div>
  </div>


  <script type="text/javascript">

    jQuery.extend({
      getCustomJSON: function(url) {
        var result = null;
        $.ajax({
          url: url,
          type: 'get',
          dataType: 'json',
          async: false,
          success: function(data) {
            result = data;
          }
        });
        return result;
      }
    });

  </script>

  <script type="text/javascript">

    var $eval_com_table = $('#eval_com_table'),
    selections = [];

  </script>

  <script type="text/javascript">

    $(function () {

      $eval_com_table.bootstrapTable({

        url: "<?php echo site_url('Procurement/data_eval_com') ?>/C",

        cookieIdTable:"eval_com",

        idField:"pec_id",

        <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>

        columns: [
        {
          field: 'pec_datetime',
          title: 'Tanggal & Waktu',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'pec_name',
          title: 'Nama',
          sortable:true,
          order:true,
          searchable:true,
          align: 'left',
          valign: 'middle'
        },
        {
          field: 'pec_vendor_name',
          title: 'Nama Vendor',
          sortable:true,
          order:true,
          searchable:true,
          align: 'left',
          valign: 'middle'
        },

        {
          field: 'pec_comment',
          title: 'Komentar',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle'
        },

        ]

      });

      setTimeout(function () {
        $eval_com_table.bootstrapTable('resetView');
      }, 200);

      $("#eval_com_btn").on("click",function(){
        var comment = $("#comment_eval_inp").val();
        if(comment == ""){
          alert("Isi komentar");
        } else {
          var data = $("#eval_com_form").serialize();
          $.ajax({
            url:"index.php/procurement/save_eval_com",
            data:data,
            type:"post",
            success:function(x){
              $("#comment_eval_inp").val("");
              $("#eval_com_table").bootstrapTable('refresh');
            }
          });
        }
        return false;
      }); 

      $("#calculate_price").on("click",function(){
        var data = $("#eval_price_form").serialize();
        $.ajax({
          url:"index.php/procurement/calculate_eval_price",
          data:data,
          type:"post",
          dataType:"json",
          success:function(x){
            alert("Berhasil kalkulasi evaluasi harga");
            $(".vendor_price_value").each(function(i,val){
              var id = $(this).attr("data-id");

              $(this).html(inttomoney(x[id]));

            });

          }
        });
        return false;
      }); 

    });

  </script>