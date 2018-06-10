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


        <div class="form-group">
          <label class="col-sm-2 control-label">Kode</label>
          <div class="col-sm-6">
            <div class="input-group">
              <span class="input-group-btn">
               <button type="button" data-id="kode_item" data-url="<?php echo site_url(COMMODITY_KATALOG_BARANG_PATH.'/picker') ?>" class="btn btn-primary picker barang_btn">Pilih Barang</button> 
               <button type="button" data-id="kode_item" data-url="<?php echo site_url(COMMODITY_KATALOG_JASA_PATH.'/picker') ?>" class="btn btn-primary picker jasa_btn">Pilih Jasa</button> 
             </span>
             <?php $curval = set_value("kode_item"); ?>
             <input readonly type="text" class="form-control" id="kode_item" name="kode_item" value="<?php echo $curval ?>">
           </div>
         </div>
       </div>

       <?php $curval = set_value("tipe_item"); ?>
       <div class="form-group">
        <label class="col-sm-2 control-label">Tipe</label>
        <div class="col-sm-2">
         <p class="form-control-static" id="tipe_item"><?php echo $curval ?></p>
       </div>
     </div>

     <?php $curval = set_value("deskripsi_item"); ?>
     <div class="form-group">
      <label class="col-sm-2 control-label">Deskripsi</label>
      <div class="col-sm-10">
        <p class="form-control-static" maxlength="1000" id="deskripsi_item"><?php echo $curval ?></p>
      </div>
    </div>

    <?php $curval = set_value("jumlah_item_inp"); ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Jumlah</label>
      <div class="col-sm-2">
       <input type="text" class="form-control money" maxlength="40" name="jumlah_item_inp" id="jumlah_item_inp" value="<?php echo $curval ?>">
     </div>
   </div>

   <?php $curval = set_value("satuan_item_inp"); ?>
   <div class="form-group">
    <label class="col-sm-2 control-label">Satuan</label>
    <div class="col-sm-2">
     <input type="text" class="form-control" maxlength="12" name="satuan_item_inp" id="satuan_item_inp" value="<?php echo $curval ?>">
   </div>
 </div>

 <?php $curval = set_value("harga_satuan_item_inp"); ?>
 <div class="form-group">
  <label class="col-sm-2 control-label">Harga Satuan <br/>(Sebelum Pajak)</label>
  <div class="col-sm-4">
   <input type="text" class="form-control money" maxlength="40" name="harga_satuan_item_inp" id="harga_satuan_item_inp" value="<?php echo $curval ?>">
 </div>

 <label class="col-sm-1 control-label">PPN</label>
 <div class="col-sm-1">
  <div class="checkbox">
    <?php $curval = set_value("ppn_item_inp"); ?>
    <input type="checkbox" class="" name="ppn_item_inp" id="ppn_item_inp" value="10">
  </div>
</div>

<label class="col-sm-1 control-label">PPH (%)</label>
<div class="col-sm-2">
  <div class="">
    <?php $curval = set_value("pph_item_inp"); ?>
    <input type="text" class="form-control money" name="pph_item_inp" id="pph_item_inp" value="">
  </div>
</div>
</div>

<center>
  <a class="btn btn-primary action_item">Simpan</a>
  <a class="btn btn-default empty_item">Hapus</a>
  <input type="hidden" id="current_item" value=""/>
  <br>
</center>

<hr>

<table class="table table-bordered" id="item_table">
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
    if(isset($item) && !empty($item)){
      foreach ($item as $key => $value) {
        $idnya = $key+1;
       ?>

      <tr>
        <td>
          <button data-no="<?php echo $idnya ?>" class="btn btn-primary btn-xs edit_item" type="button">
            <i class="fa fa-edit"></i>
            <?php $curval = (isset($value['ppi_id'])) ? $value['ppi_id'] :  ""; ?>
            <input type="hidden" name="item_id[<?php echo $idnya ?>]" value="<?php echo $curval ?>"/>

          </button>
        </td>
        <td>
          <input type="hidden" value="<?php echo $value['ppi_code'] ?>" name="item_kode[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="kode_item">
          <?php echo $value['ppi_code'] ?>
        </td>
        <td>
          <input type="hidden" value="<?php echo $value['ppi_type'] ?>" name="item_tipe[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="tipe_item">
          <?php echo $value['ppi_type'] ?>
        </td>
        <td>
          <input type="hidden" value="<?php echo $value['ppi_description'] ?>" name="item_deskripsi[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="deskripsi_item">
          <?php echo $value['ppi_description'] ?>
        </td>
        <td class="text-right">
          <input type="hidden" value="<?php echo $value['ppi_quantity'] ?>" name="item_jumlah[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="jumlah_item">
          <?php echo inttomoney($value['ppi_quantity']) ?>
        </td>
        <td>
          <input type="hidden" value="<?php echo $value['ppi_unit'] ?>" name="item_satuan[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="satuan_item">
          <?php echo $value['ppi_unit'] ?>
        </td>
        <td class="text-right">
          <input type="hidden" value="<?php echo $value['ppi_price'] ?>" name="item_harga_satuan[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="harga_satuan_item">
          <?php echo inttomoney($value['ppi_price']) ?>
        </td>
        <td class="text-right">
          <input type="hidden" value="<?php echo $value['ppi_ppn'] ?>" name="item_ppn_satuan[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="ppn_satuan_item">
          <?php echo (!empty($value['ppi_ppn'])) ? " PPN (".$value['ppi_ppn']."%) " : "" ?> 
          <input type="hidden" value="<?php echo $value['ppi_pph'] ?>" name="item_pph_satuan[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="pph_satuan_item">
          <?php echo (!empty($value['ppi_pph'])) ? " PPH (".$value['ppi_pph']."%)" : "" ?> 
        </td>
        <td class="text-right">
          <input type="hidden" value="<?php echo $value['ppi_price']*$value['ppi_quantity'] ?>" name="item_subtotal[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="subtotal_item">
          <?php echo inttomoney($value['ppi_price']*$value['ppi_quantity']) ?>
        </td>
      </tr>

      <?php 
      $subtotal += $value['ppi_price']*$value['ppi_quantity'];
      if(!empty($value['ppi_ppn'])){
        $subtotal_ppn += $value['ppi_price']*$value['ppi_quantity']*($value['ppi_ppn']/100);
      }
      if(!empty($value['ppi_pph'])){
       $subtotal_pph += $value['ppi_price']*$value['ppi_quantity']*($value['ppi_pph']/100);
     }
   } } ?>

 </tbody>
</table>

<hr>

<div class="form-group">
  <div class="col-sm-5">
  </div>
  <label class="col-sm-4 control-label">Nilai HPS</label>
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
  <label class="col-sm-4 control-label">Nilai HPS Setelah PPN &amp; PPH</label>
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
    <p class="form-control-static text-right" id="total_pagu"><?php echo inttomoney($permintaan['pr_pagu_anggaran']) ?></p>
    <input type="hidden" name="total_pagu_inp" id="total_pagu_inp" value="<?php echo $permintaan['pr_pagu_anggaran'] ?>">
  </div>
</div>

<div class="form-group">
  <div class="col-sm-5">
  </div>
  <label class="col-sm-4 control-label">Sisa Nilai Anggaran</label>
  <div class="col-sm-3">
    <p class="form-control-static text-right" id="sisa_pagu">
      <?php echo inttomoney($permintaan['pr_pagu_anggaran']-($subtotal+$subtotal_ppn+$subtotal_pph)) ?></p>
      <input type="hidden" name="sisa_pagu_inp" id="sisa_pagu_inp" 
      value="<?php echo $permintaan['pr_pagu_anggaran']-($subtotal+$subtotal_ppn+$subtotal_pph) ?>">
    </div>
  </div>

</div>

</div>
</div>
</div>

<script type="text/javascript">


  function set_total(){

    var total_alokasi = 0;
    var ppn = 0;
    var pph = 0;
    var total_alokasi_ppn = 0;
    
    $("#item_table tr").each(function(){

      var item = (!isNaN($(this).find(".harga_satuan_item").val())) ? parseFloat($(this).find(".harga_satuan_item").val()) : 0;
      var qty = (!isNaN($(this).find(".jumlah_item").val())) ? parseFloat($(this).find(".jumlah_item").val()) : 0;
      var subtotal = (!isNaN($(this).find(".subtotal_item").val())) ? parseFloat($(this).find(".subtotal_item").val()) : 0;
      var ppn_persen = ($(this).find(".ppn_satuan_item").val()) ? $(this).find(".ppn_satuan_item").val()/100 : 0;
      var pph_persen = ($(this).find(".pph_satuan_item").val()) ? $(this).find(".pph_satuan_item").val()/100 : 0;

      total_alokasi += (item*qty);
      var ppn_nominal = (item*qty) * ppn_persen;

      ppn += ppn_nominal;
      var pph_nominal = (item*qty) * pph_persen;
      pph += pph_nominal;
      total_alokasi_ppn += (item*qty) + ppn_nominal + pph_nominal;

    });

    var total_pagu = parseInt($("#total_pagu_inp").val());

    var sisa_pagu = parseInt(total_pagu)-parseInt(total_alokasi_ppn);

    $("#total_alokasi").text(inttomoney(total_alokasi));
    $("#total_alokasi_inp").val(total_alokasi);
    $("#ppn").text(inttomoney(ppn));
    $("#ppn_inp").val(ppn);
    $("#pph").text(inttomoney(pph));
    $("#pph_inp").val(pph);
    $("#total_alokasi_ppn").text(inttomoney(total_alokasi_ppn));
    $("#total_alokasi_ppn_inp").val(total_alokasi_ppn);
    $("#sisa_pagu").text(inttomoney(sisa_pagu));
    $("#sisa_pagu_inp").val(sisa_pagu);

  }
  
  $(document).ready(function(){

    $(".barang_btn").click(function(){
      $("#tipe_item").text("BARANG");
    });
    $(".jasa_btn").click(function(){
      $("#tipe_item").text("JASA");
    });

    $(document.body).on("change","#kode_item",function(){

      var tipe = $("#tipe_item").text();
      var id = $(this).val();
      var url = "<?php echo site_url('Commodity/data_mat_catalog') ?>";

      if(tipe == "JASA"){
        var url = "<?php echo site_url('Commodity/data_kat_jasa') ?>";
      }

      $.ajax({
        url : url+"?id="+id,
        dataType:"json",
        success:function(data){
          var mydata = data.rows[0];

          $("#deskripsi_item").html(mydata.short_description);
          $("#deskripsi_pekerjaan").html(mydata.ppm_scope_of_work);
          $("#jumlah_item_inp").val(1);
          $("#satuan_item_inp").val(mydata.uom);
          $("#harga_satuan_item_inp").val(mydata.total_price);
        }
      });

    });

    $(".action_item").click(function(){

      
     

      var current_item = $("#current_item").val();
      var no = current_item;

      if(current_item == ""){
        no = ($("#item_table tr").length) ? parseInt($("#item_table tr").length) : 1;
      }

      var kode = $("#kode_item").val();
      var tipe = $("#tipe_item").text();
      var deskripsi = $("#deskripsi_item").text();
      var jumlah = $("#jumlah_item_inp").val();
      var satuan = $("#satuan_item_inp").val();
      var harga_satuan = $("#harga_satuan_item_inp").val();
      var jumlah_int = $("#jumlah_item_inp").autoNumeric('get');
      var harga_satuan_int = $("#harga_satuan_item_inp").autoNumeric('get');
      var ppn = ($("#ppn_item_inp").prop('checked')) ? 10 : 0;
      var pph = $("#pph_item_inp").autoNumeric('get');
      var label_ppn = (ppn == 0) ? "" : " PPN ("+ppn+"%) ";
      var label_pph = (pph == 0) ? "" : " PPH ("+pph+"%) ";
      
      if(kode == ""){

        alert("Pilih item");
      //haqim
      } else  if (satuan=='') {

        alert("Satuan harus diisi");

      } 
      // end
      else if(harga_satuan_int < 1){

        alert("Harga tidak boleh kurang dari 1");
        
      } else if(jumlah_int < 1){

        alert("Jumlah tidak boleh kurang dari 1");

      } else {

        var x = parseFloat(jumlah_int)*parseFloat(harga_satuan_int);
        var subtotal_int = x+(x*parseFloat(ppn)/100)+(x*(pph)/100);
        var subtotal = inttomoney(subtotal_int);
        harga_satuan = inttomoney(harga_satuan_int);

        var html = "<tr><td><button type='button' class='btn btn-primary btn-xs edit_item' data-no='"+no+"'><i class='fa fa-edit'></i></button></td>";
        html += "<td><input type='hidden' class='kode_item' data-no='"+no+"' name='item_kode["+no+"]' value='"+kode+"'/>"+kode+"</td>";
        html += "<td><input type='hidden' class='tipe_item' data-no='"+no+"' name='item_tipe["+no+"]' value='"+tipe+"'/>"+tipe+"</td>";
        html += "<td><input type='hidden' class='deskripsi_item' data-no='"+no+"' name='item_deskripsi["+no+"]' value='"+deskripsi+"'/>"+deskripsi+"</td>";
        html += "<td class='text-right'><input type='hidden' class='jumlah_item' data-no='"+no+"' name='item_jumlah["+no+"]' value='"+jumlah_int+"'/>"+jumlah+"</td>";
        html += "<td><input type='hidden' class='satuan_item' data-no='"+no+"' name='item_satuan["+no+"]' value='"+satuan+"'/>"+satuan+"</td>";

        html += "<td class='text-right'><input type='hidden' class='harga_satuan_item' data-no='"+no+"' name='item_harga_satuan["+no+"]' value='"+harga_satuan_int+"'/>"+harga_satuan+"</td>";
        html += "<td class='text-right'><input type='hidden' class='ppn_satuan_item' data-no='"+no+"' name='item_ppn_satuan["+no+"]' value='"+ppn+"'/> "+label_ppn;
        html += " <input type='hidden' class='pph_satuan_item' data-no='"+no+"' name='item_pph_satuan["+no+"]' value='"+pph+"'/> "+label_pph;
        html += "</td>";
        html += "<td class='text-right'><input type='hidden' class='subtotal_item' data-no='"+no+"' name='item_subtotal["+no+"]' value='"+subtotal_int+"'/>"+subtotal+"</td></tr>";
        $("#item_table").append(html);

        $("#kode_item").val("");
        $("#tipe_item").text("");
        $("#deskripsi_item").text("");
        $("#jumlah_item_inp").val("");
        $("#satuan_item_inp").val("");
        $("#harga_satuan_item_inp").val("");
        $("#pph_item_inp").val("");
        $("#ppn_item_inp").prop("checked",false);
        $("#current_item").val("");

      }

      set_total();

    });

    $(document.body).on("click",".empty_item",function(){

      $("#current_item").val("");
      $("#kode_item").val("");
      $("#tipe_item").text("");
      $("#deskripsi_item").text("");
      $("#jumlah_item_inp").val("");
      $("#satuan_item_inp").val("");
      $("#harga_satuan_item_inp").val("");

      cek_group();

    });

    function cek_group(){

      var no = parseInt($("#item_table tr").length);

      if(no == 1){
        $.ajax({
          url:"<?php echo site_url('procurement/set_session/code_group/') ?>",
          success:function(){

          }
        })
      }

    }

    $(document.body).on("click",".edit_item",function(){

      var no = $(this).attr('data-no');
      var kode = $(".kode_item[data-no='"+no+"']").val();
      var tipe = $(".tipe_item[data-no='"+no+"']").val();
      var deskripsi = $(".deskripsi_item[data-no='"+no+"']").val();
      var jumlah = $(".jumlah_item[data-no='"+no+"']").val();
      var satuan = $(".satuan_item[data-no='"+no+"']").val();
      var harga_satuan = $(".harga_satuan_item[data-no='"+no+"']").val();
      var ppn = $(".ppn_satuan_item[data-no='"+no+"']").val();
      var pph = $(".pph_satuan_item[data-no='"+no+"']").val();

      $("#current_item").val(no);
      $("#kode_item").val(kode);
      $("#tipe_item").text(tipe);
      $("#deskripsi_item").text(deskripsi);
      $("#jumlah_item_inp").val(inttomoney(jumlah));
      $("#satuan_item_inp").val(satuan);
      var is_ppn = (parseInt(ppn) != 0);
      $("#ppn_item_inp").prop('checked',is_ppn);
      $("#pph_item_inp").val(pph);
      $("#harga_satuan_item_inp").val(inttomoney(harga_satuan));

      cek_group();

      $(this).parent().parent().remove();
      
      set_total();

      return false;

    });
  })

</script>