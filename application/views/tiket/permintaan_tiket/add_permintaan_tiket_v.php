<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" action="<?php echo site_url($controller_name."/submit_pembuatan_permintaan_tiket");?>"  class="form-horizontal ajaxform">
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
          <div class="ibox-title">
            <h5>HEADLINE</h5>
            <div class="ibox-tools">
              <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
              </a>
            </div>
          </div>
          <div class="ibox-content">
	   
			<div class="form-group">
				<?php $curval = "OTOMATIS"; ?>
                <label class="col-sm-2 control-label">No. Permintaan</label>
                <div class="col-sm-10">
                    <p class="form-control-static">
                        <?php echo $curval ?>
                    </p>
                </div>
            </div>
		   
            <?php $curval = $userdata['complete_name']; ?>
             <div class="form-group">
              <label class="col-sm-2 control-label">User</label>
              <div class="col-sm-10">
               <p class="form-control-static"><?php echo $curval ?></p>
             </div>
           </div>

           <?php $curval = $userdata['district_name']; ?>
          <div class="form-group">
            <label class="col-sm-2 control-label">Cabang</label>
            <div class="col-sm-10">
              <p class="form-control-static"><?php echo $curval ?></p>
            </div>
          </div>
	   
 </div>
</div>
</div>
</div>



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
          <div class="col-sm-4">
            <div class="input-group">
              <span class="input-group-btn">
               <button type="button" data-id="kode_item" data-url="<?php echo site_url(COMMODITY_KATALOG_BARANG_PATH.'/picktik') ?>" class="btn btn-primary picker barang_btn">Pilih Tiket</button> 
               </span>
             <?php $curval = set_value("kode_item"); ?>
             <input readonly type="text" class="form-control" id="kode_item" name="kode_item" value="<?php echo $curval ?>">
           </div>
         </div>
       </div>

     <?php $curval = set_value("deskripsi_item"); ?>
     <div class="form-group">
      <label class="col-sm-2 control-label">Deskripsi</label>
      <div class="col-sm-10">
        <p class="form-control-static" maxlength="1000" id="deskripsi_item"><?php echo $curval ?></p>
      </div>
    </div>
	
   <?php $curval = set_value("satuan_item"); ?>
   <div class="form-group">
    <label class="col-sm-2 control-label">Satuan</label>
    <div class="col-sm-2">
	<p class="form-control-static" maxlength="1000" id="satuan_item"><?php echo $curval ?></p>
   </div>
 </div>
 
    <?php $curval = set_value("item_lintasan_inp"); ?>
    <div class="form-group">
     <label class="col-sm-2 control-label">Lintasan *</label>
	 <div class="col-sm-4">
           <select class="form-control" name="lintasan_item_inp" id="lintasan_item_inp">
             <option value="">Pilih Lintasan</option>
             <?php foreach($lane_list as $key => $val){
              $selected = ($val['lintasan'] == $curval) ? "selected" : ""; 
              ?>			  
              <option <?php echo $selected ?> value="<?php echo $val['lintasan'] ?>"><?php echo $val['lintasan'] ?></option>
              <?php } ?>
            </select>
          </div>
   </div>	
   
    <?php $curval = set_value("tanggal_item_inp"); ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Tanggal Dibutuhkan *</label>
	  <div class="col-sm-2">
		<div class="input-group date">
		<span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		<input type="date" class="form-control datepicker" name="tanggal_item_inp" id="tanggal_item_inp" value="<?php echo $curval ?>">
		</div>
	 </div>
   </div>
      
    <?php $curval = set_value("series_item_inp"); ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Nomor Seri Mulai *</label>
      <div class="col-sm-2">
       <input type="text" class="form-control" maxlength="40" name="series_item_inp" id="series_item_inp" value="<?php echo $curval ?>">
     </div>
   </div>
      
    <?php $curval = set_value("series_end_item_inp"); ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Nomor Seri Akhir *</label>
      <div class="col-sm-2">
       <input type="text" class="form-control" maxlength="40" name="series_end_item_inp" id="series_end_item_inp" value="<?php echo $curval ?>">
     </div>
   </div>
   
   
    <?php $curval = set_value("jumlah_item_inp"); ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Jumlah Dibutuhkan *</label>
      <div class="col-sm-2">
       <input type="text" class="form-control text-right" maxlength="40" name="jumlah_item_inp" id="jumlah_item_inp" value="<?php echo $curval ?>">
     </div>
   </div>

    <?php $curval = set_value("sisa_item_inp"); ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Sisa Stok Peminta *</label>
      <div class="col-sm-2">
       <input type="text" class="form-control text-right" maxlength="40" name="sisa_item_inp" id="sisa_item_inp" value="<?php echo $curval ?>">
     </div>
   </div>

    <?php $curval = set_value("angkut_item_inp"); ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Tarif Jasa Angkut (Rp) *</label>
      <div class="col-sm-2">
       <input type="text" class="form-control text-right money" maxlength="40" name="angkut_item_inp" id="angkut_item_inp" value="<?php echo $curval ?>">
     </div>
   </div>

    <?php $curval = set_value("pelabuhan_item_inp"); ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Tarif Jasa Pelabuhan (Rp) *</label>
      <div class="col-sm-2">
       <input type="text" class="form-control text-right money" maxlength="40" name="pelabuhan_item_inp" id="pelabuhan_item_inp" value="<?php echo $curval ?>">
     </div>
   </div>

    <?php $curval = set_value("asuransi_item_inp"); ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Tarif Asuransi (Rp) *</label>
      <div class="col-sm-2">
       <input type="text" class="form-control text-right money" maxlength="40" name="asuransi_item_inp" id="asuransi_item_inp" value="<?php echo $curval ?>">
     </div>
   </div>
   
   <?php $curval = set_value("keterangan_item_inp"); ?>
   <div class="form-group">
    <label class="col-sm-2 control-label">Keterangan</label>
    <div class="col-sm-4">
     <textarea class="form-control" rows="4" cols="50" name="keterangan_item_inp" id="keterangan_item_inp"><?php echo $curval ?></textarea>
   </div>
 </div>


<center>
  <a class="btn btn-primary action_item">Simpan</a>
  <a class="btn btn-default empty_item">Hapus</a>
  <input type="hidden" id="current_item" value=""/>
  <br>
</center>

<hr>

<table class="table table-bordered valign" id="item_table">
  <thead>
    <tr>
      <th rowspan="2">#</th>
	  <th rowspan="2">Lintasan</th>
      <th rowspan="2">Kode</th>
	  <th rowspan="2">Nama Item</th>
      <th rowspan="2">Tanggal Dibutuhkan</th>
	  <th colspan="2">No. Seri</th>
      <th rowspan="2">Jumlah</th>
      <th rowspan="2">Satuan</th>
	  <th rowspan="2">Sisa Stok</th>
      <th colspan="3">Tarif (Rp.)</th>
      <th rowspan="2">Keterangan</th>
    </tr>
	<tr>
	  <th>Mulai</th>
	  <th>Selesai</th>
      <th>Jasa Angkut</th>
	  <th>Jasa Pelabuhan</th>
	  <th>Asuransi</th>
	</tr>  
  </thead>
 <tbody>
    <?php 
    if(isset($item) && !empty($item)){
      foreach ($item as $key => $value) {
        $idnya = $key+1;
       ?>

      <tr>
        <td>
          <button data-no="<?php echo $idnya ?>" class="btn btn-primary btn-xs edit_item" type="button">
            <i class="fa fa-edit"></i>
            <?php $curval = (isset($value['tpi_id'])) ? $value['tpi_id'] :  ""; ?>
            <input type="hidden" name="item_id[<?php echo $idnya ?>]" value="<?php echo $curval ?>"/>
          </button>
        </td>
        <td>
          <input type="hidden" value="<?php echo $value['tpi_lane_name'] ?>" name="item_lintasan[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="lintasan_item">
          <?php echo $value['tpi_lane_name'] ?>
        </td>
        <td>
          <input type="hidden" value="<?php echo $value['tpi_code'] ?>" name="item_kode[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="kode_item">
          <?php echo $value['tpi_code'] ?>
        </td>
        <td>
          <input type="hidden" value="<?php echo $value['tpi_description'] ?>" name="item_deskripsi[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="deskripsi_item">
          <?php echo $value['tpi_description'] ?>
        </td>
        <td>
          <input type="hidden" value="<?php echo $value['tpi_date'] ?>" name="item_tanggal[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="tanggal_item">
          <?php echo $value['tpi_date'] ?>
        </td>
        <td>
          <input type="hidden" value="<?php echo $value['tpi_unit'] ?>" name="item_satuan[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="satuan_item">
          <?php echo $value['tpi_unit'] ?>
        </td>
        <td>
          <input type="hidden" value="<?php echo $value['tpi_series'] ?>" name="item_series[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="series_item">
          <?php echo $value['tpi_series'] ?>
        </td>
        <td>
          <input type="hidden" value="<?php echo $value['tpi_series_end'] ?>" name="item_series_end[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="series_end_item">
          <?php echo $value['tpi_series_end'] ?>
        </td>
        <td class="text-right">
          <input type="hidden" value="<?php echo $value['tpi_quantity'] ?>" name="item_jumlah[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="jumlah_item">
          <?php echo ($value['tpi_quantity']) ?>
        </td>
        <td>
          <input type="hidden" value="<?php echo $value['tpi_remaining'] ?>" name="item_sisa[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="sisa_item">
          <?php echo $value['tpi_remaining'] ?>
        </td>
        <td class="text-right">
          <input type="hidden" value="<?php echo $value['tpi_angkut'] ?>" name="item_angkut[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="angkut_item">
          <?php echo inttomoney($value['tpi_angkut']) ?>
        </td>
        <td class="text-right">
          <input type="hidden" value="<?php echo $value['tpi_pelabuhan'] ?>" name="item_pelabuhan[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="pelabuhan_item">
          <?php echo inttomoney($value['tpi_pelabuhan']) ?>
        </td>
        <td class="text-right">
          <input type="hidden" value="<?php echo $value['tpi_asuransi'] ?>" name="item_asuransi[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="asuransi_item">
          <?php echo inttomoney($value['tpi_asuransi']) ?>
        </td>
        <td>
          <input type="hidden" value="<?php echo $value['tpi_note'] ?>" name="item_keterangan[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="keterangan_item">
          <?php echo $value['tpi_note'] ?>
        </td>
      </tr>

		<?php 
			}   
		  }
	    ?>

 </tbody>
 
</table>

</div>

</div>
</div>
</div>



  <?php 
$i = 0;
include(VIEWPATH."/comment_workflow_attachment_v.php") ?>

  <?php echo buttonsubmit('tiket/permintaan_tiket/daftar_permintaan_tiket',lang('back'),lang('save')) ?>

</form>
</div>


<script type="text/javascript">
  
  
  $(document).ready(function(){

    $(document.body).on("change","#kode_item",function(){

      var id = $(this).val();
      var url = "<?php echo site_url('commodity/data_tiket_catalog') ?>";

      $.ajax({
        url : url+"?id="+id,
        dataType:"json",
        success:function(data){
          var mydata = data.rows[0];

          $("#deskripsi_item").html(mydata.short_description);
          $("#jumlah_item_inp").val(1);
          $("#satuan_item").html(mydata.uom);
        }
      });

    });

    $(".action_item").click(function(){

      var current_item = $("#current_item").val();
      var no = current_item;

      if(current_item == ""){
        no = ($("#item_table tr").length) ? parseInt($("#item_table tr").length) : 1;
      }

      var lintasan = $("#lintasan_item_inp").val();
      var kode = $("#kode_item").val();
      var deskripsi = $("#deskripsi_item").text();
      var satuan = $("#satuan_item").text();
      var tanggal = $("#tanggal_item_inp").val();
      var sisa = $("#sisa_item_inp").val();
      var jumlah = $("#jumlah_item_inp").val();
      var series = $("#series_item_inp").val();
      var series_end = $("#series_end_item_inp").val();
      var angkut = $("#angkut_item_inp").val();
      var pelabuhan = $("#pelabuhan_item_inp").val();
      var asuransi = $("#asuransi_item_inp").val();
      var keterangan = $("#keterangan_item_inp").val();
      var angkut_int = $("#angkut_item_inp").autoNumeric('get');
      var pelabuhan_int = $("#pelabuhan_item_inp").autoNumeric('get');
      var asuransi_int = $("#asuransi_item_inp").autoNumeric('get');
      
      if(kode == ""){

        alert("Pilih item");

      } else if(jumlah < 1){

        alert("Jumlah tidak boleh kurang dari 1");
		
	  } else if(lintasan ==""){	
	  
		alert("Pilih Lintasan");
		
	   } else if(series ==""){	
	  
		alert("No Seri Mulai belum diisi");
		
	   } else if(series_end ==""){	
	  
		alert("No Seri Akhir belum diisi");
		
	  } else if(tanggal ==""){	
	  
		alert("Tanggal dibutuhkan belum diisi");
		
	  } else if(sisa ==""){	
	  
		alert("Sisa Stok Peminta belum diisi");
		
	  } else if(angkut_int ==""){	
	  
		alert("Tarif Jasa Angkut belum diisi");	
		
	  } else if(pelabuhan_int ==""){	
	  
		alert("Tarif Jasa Pelabuhan belum diisi");	
		
	  } else if(asuransi_int ==""){	
	  
		alert("Tarif Asuransi belum diisi");		
		
      } else if(angkut_int < 1){	
	  
		alert("Tarif Jasa Angkut kurang dari 1");	
		
	  } else if(pelabuhan_int < 1){	
	  
		alert("Tarif Jasa Pelabuhan kurang dari 1");	
		
	  } else if(asuransi_int < 1){	
	  
		alert("Tarif Asuransi kurang dari 1");		
		
      } else {

        var html = "<tr><td><button type='button' class='btn btn-primary btn-xs edit_item' data-no='"+no+"'><i class='fa fa-edit'></i></button></td>";
        html += "<td><input type='hidden' class='lintasan_item' data-no='"+no+"' name='item_lintasan["+no+"]' value='"+lintasan+"'/>"+lintasan+"</td>";
        html += "<td><input type='hidden' class='kode_item' data-no='"+no+"' name='item_kode["+no+"]' value='"+kode+"'/>"+kode+"</td>";
        html += "<td><input type='hidden' class='deskripsi_item' data-no='"+no+"' name='item_deskripsi["+no+"]' value='"+deskripsi+"'/>"+deskripsi+"</td>";
        html += "<td><input type='hidden' class='tanggal_item' data-no='"+no+"' name='item_tanggal["+no+"]' value='"+tanggal+"'/>"+tanggal+"</td>";
        html += "<td><input type='hidden' class='series_item' data-no='"+no+"' name='item_series["+no+"]' value='"+series+"'/>"+series+"</td>";
        html += "<td><input type='hidden' class='series_end_item' data-no='"+no+"' name='item_series_end["+no+"]' value='"+series_end+"'/>"+series_end+"</td>";
        html += "<td class='text-right'><input type='hidden' class='jumlah_item' data-no='"+no+"' name='item_jumlah["+no+"]' value='"+jumlah+"'/>"+jumlah+"</td>";
        html += "<td><input type='hidden' class='satuan_item' data-no='"+no+"' name='item_satuan["+no+"]' value='"+satuan+"'/>"+satuan+"</td>";
		html += "<td class='text-right'><input type='hidden' class='sisa_item' data-no='"+no+"' name='item_sisa["+no+"]' value='"+sisa+"'/>"+sisa+"</td>";
		html += "<td class='text-right'><input type='hidden' class='angkut_item' data-no='"+no+"' name='item_angkut["+no+"]' value='"+angkut_int+"'/>"+angkut+"</td>";
		html += "<td class='text-right'><input type='hidden' class='pelabuhan_item' data-no='"+no+"' name='item_pelabuhan["+no+"]' value='"+pelabuhan_int+"'/>"+pelabuhan+"</td>";
		html += "<td class='text-right'><input type='hidden' class='asuransi_item' data-no='"+no+"' name='item_asuransi["+no+"]' value='"+asuransi_int+"'/>"+asuransi+"</td>";
		html += "<td><input type='hidden' class='keterangan_item' data-no='"+no+"' name='item_keterangan["+no+"]' value='"+keterangan+"'/>"+keterangan+"</td>";
        
		$("#item_table").append(html);

        $("#lintasan_item_inp").val("");
        $("#kode_item").val("");
        $("#deskripsi_item").text("");
        $("#satuan_item").text("");
        $("#tanggal_item_inp").val("");
        $("#sisa_item_inp").val("");
        $("#jumlah_item_inp").val("");
        $("#series_item_inp").val("");
        $("#series_end_item_inp").val("");
        $("#angkut_item_inp").val("");
        $("#pelabuhan_item_inp").val("");
        $("#asuransi_item_inp").val("");
        $("#keterangan_item_inp").val("");
        $("#current_item").val("");

      }


    });

    $(document.body).on("click",".empty_item",function(){

      $("#current_item").val("");
      $("#kode_item").val("");
      $("#deskripsi_item").text("");
      $("#lintasan_item_inp").text("");
      $("#series_item_inp").val("");
      $("#tanggal_item_inp").val("");
      $("#jumlah_item_inp").val("");
      $("#satuan_item").text("");
      $("#sisa_item_inp").val("");
      $("#series_end_item_inp").val("");
      $("#angkut_item_inp").val("");
      $("#pelabuhan_item_inp").val("");
      $("#asuransi_item_inp").val("");
      $("#keterangan_item_inp").val("");

      cek_group();

    });

    function cek_group(){

      var no = parseInt($("#item_table tr").length);

      if(no == 1){
        $.ajax({
          url:"<?php echo site_url('tiket/set_session/code_group/') ?>",
          success:function(){

          }
        })
      }

    }

    $(document.body).on("click",".edit_item",function(){

      var no = $(this).attr('data-no');
      var kode = $(".kode_item[data-no='"+no+"']").val();
      var deskripsi = $(".deskripsi_item[data-no='"+no+"']").val();
      var tanggal = $(".tanggal_item[data-no='"+no+"']").val();
      var jumlah = $(".jumlah_item[data-no='"+no+"']").val();
      var satuan = $(".satuan_item[data-no='"+no+"']").val();
      var keterangan = $(".keterangan_item[data-no='"+no+"']").val();
      var lintasan = $(".lintasan_item[data-no='"+no+"']").val();
      var sisa = $(".sisa_item[data-no='"+no+"']").val();
      var series = $(".series_item[data-no='"+no+"']").val();
      var series_end = $(".series_end_item[data-no='"+no+"']").val();
      var angkut = $(".angkut_item[data-no='"+no+"']").val();
      var pelabuhan = $(".pelabuhan_item[data-no='"+no+"']").val();
      var asuransi = $(".asuransi_item[data-no='"+no+"']").val();

      $("#current_item").val(no);
      $("#kode_item").val(kode);
      $("#deskripsi_item").text(deskripsi);
      $("#lintasan_item_inp").val(lintasan);
      $("#tanggal_item_inp").val(tanggal);
      $("#jumlah_item_inp").val(jumlah);
      $("#satuan_item").text(satuan);
      $("#sisa_item_inp").val(sisa);
      $("#series_item_inp").val(series);
      $("#series_end_item_inp").val(series_end);
      $("#angkut_item_inp").val(inttomoney(angkut));
      $("#pelabuhan_item_inp").val(inttomoney(pelabuhan));
      $("#asuransi_item_inp").val(inttomoney(asuransi));
      $("#keterangan_item_inp").val(keterangan);

      cek_group();

      $(this).parent().parent().remove();
      

      return false;

    });
  })

//DatePicker

var nowDate = new Date();
var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
$('.datepicker').datepicker({format:'yyyy-mm-dd',startDate:today,todayHighlight: true});

</script>