<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" action="<?php echo site_url($controller_name."/submit_ubah_penjualan_tiket");?>"  class="form-horizontal ajaxform">
    <input type="hidden" name="id" value="<?php echo $id ?>">
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
		  
            <?php 			
			$monthNum  = (isset($penjualan['tsm_month'])) ? $penjualan['tsm_month']  : "";
			$curval = date("F", mktime(0, 0, 0, $monthNum, 10));
			?>
			
              <div class="form-group">
              <label class="col-sm-2 control-label">Bulan</label>
              <div class="col-sm-10">
               <p class="form-control-static"><?php echo $curval ?></p>
             </div>
           </div>
	      
            <?php $curval = (isset($penjualan['tsm_year'])) ? $penjualan['tsm_year'] : ""; ?>
             <div class="form-group">
              <label class="col-sm-2 control-label">Tahun</label>
              <div class="col-sm-10">
               <p class="form-control-static"><?php echo $curval ?></p>
             </div>
           </div>

           <?php $curval = (isset($penjualan['tsm_lane_name'])) ? $penjualan['tsm_lane_name'] : ""; ?>
          <div class="form-group">
            <label class="col-sm-2 control-label">Lintasan</label>
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
               <button type="button" data-id="kode_item" data-url="<?php echo site_url(TIKET_PERMINTAAN_TIKET_FOLDER.'/penjualan_tiket/picktiksold') ?>" class="btn btn-primary picker barang_btn">Pilih Tiket</button> 
               </span>
             <?php $curval = set_value("kode_item"); ?>
             <input readonly type="text" class="form-control" id="kode_item" name="kode_item" value="<?php echo $curval ?>">
           </div>
         </div>
       </div>

	     <?php $curval = set_value("lintasan_item"); ?>
     <div class="form-group">
      <label class="col-sm-2 control-label">Lintasan</label>
      <div class="col-sm-10">
        <p class="form-control-static" maxlength="1000" id="lintasan_item"><?php echo $curval ?></p>
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
 

    <?php $curval = set_value("sisa_item"); ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Stok Bulan Lalu</label>
      <div class="col-sm-2">
		<!--<p class="form-control-static" maxlength="1000" id="sisa_item"><?php echo $curval ?></p>-->
		<input type="text" readonly class="form-control text-right" maxlength="40" name="sisa_item" id="sisa_item" value="<?php echo $curval ?>">
    
     </div>
   </div>
   
   <?php $curval = set_value("pengadaan_item"); ?>
   <div class="form-group">
    <label class="col-sm-2 control-label">Harga Pengadaan / lembar (Rp.)</label>
    <div class="col-sm-2">
       <input type="text" class="form-control text-right money" maxlength="40" name="pengadaan_item_inp" id="pengadaan_item_inp" value="<?php echo $curval ?>">
     </div>	 
 </div>      
   
    <?php $curval = set_value("jumlah_item_inp"); ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Jumlah Terjual</label>
      <div class="col-sm-2">
       <input type="text" class="form-control text-right" maxlength="40" name="jumlah_item_inp" id="jumlah_item_inp" value="<?php echo $curval ?>">
     </div>
   </div>
   
    <?php $curval = set_value("series_item"); ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Nomor Seri Terjual</label>
      <div class="col-sm-4">
     <textarea class="form-control" rows="2" cols="50" name="series_item_inp" id="series_item_inp"><?php echo $curval ?></textarea>
		</div>
   </div>
   
   
    <?php $curval = set_value("jumlah_exp_item_inp"); ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Jumlah Kadaluarsa/Rusak</label>
      <div class="col-sm-2">
       <input type="text" class="form-control text-right" maxlength="40" name="jumlah_exp_item_inp" id="jumlah_exp_item_inp" value="<?php echo $curval ?>">
     </div>
   </div>

   
   <?php $curval = set_value("series_exp_item_inp"); ?>
   <div class="form-group">
    <label class="col-sm-2 control-label">No. Seri Kadaluarsa/Rusak</label>
    <div class="col-sm-4">
     <textarea class="form-control" rows="2" cols="50" name="series_exp_item_inp" id="series_exp_item_inp"><?php echo $curval ?></textarea>
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
      <th class="text-center">#</th>
	  <th class="text-center">Lintasan</th>
      <th class="text-center">Kode</th>
	  <th class="text-center" width="15%">Jenis Tiket</th>
	  <th class="text-center">Satuan</th>
	  <th class="text-center">Stok Bulan Lalu</th>
	  <th class="text-center">Harga Pengadaan per Lembar (Rp)</th>
      <th class="text-center">Jumlah Terjual</th>
	  <th class="text-center">No. Seri Terjual</th>
      <th class="text-center">Jumlah Kadaluarsa / Rusak</th>
	  <th class="text-center">No. Seri Kadaluarsa / Rusak</th>
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
            <?php $curval = (isset($value['tsi_id'])) ? $value['tsi_id'] :  ""; ?>
            <input type="hidden" name="item_id[<?php echo $idnya ?>]" value="<?php echo $curval ?>"/>
          </button>
        </td>
        <td><input type="hidden" value="<?php echo $value['tsi_lane_name'] ?>" name="item_lintasan[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="lintasan_item">
           <?php echo $value['tsi_lane_name'] ?>
        </td>
        <td>
          <input type="hidden" value="<?php echo $value['tsi_code'] ?>" name="item_kode[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="kode_item">
          <?php echo $value['tsi_code'] ?>
        </td>
        <td>
          <input type="hidden" value="<?php echo $value['tsi_description'] ?>" name="item_deskripsi[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="deskripsi_item">
          <?php echo $value['tsi_description'] ?>
        </td>
        <td>
          <input type="hidden" value="<?php echo $value['tsi_unit'] ?>" name="item_satuan[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="satuan_item">
          <?php echo $value['tsi_unit'] ?>
        </td>
        <td class="text-right">
          <input type="hidden" value="<?php echo $value['tsi_remaining'] ?>" name="item_sisa[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="sisa_item form-control text-right">
          <?php echo $value['tsi_remaining'] ?>		
		</td>
        <td class="text-right">
          <input type="hidden" value="<?php echo $value['tsi_pengadaan'] ?>" name="item_pengadaan[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="pengadaan_item form-control text-right money">
		  <?php echo $value['tsi_pengadaan'] ?>		
		</td>
        <td class="text-right">
          <input type="hidden" value="<?php echo $value['tsi_quantity'] ?>" name="item_jumlah[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="jumlah_item form-control text-right">
		  <?php echo $value['tsi_quantity'] ?>			
		 </td>
        <td>
          <input type="hidden" value="<?php echo $value['tsi_series'] ?>" name="item_series[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="series_item form-control">
          <?php echo $value['tsi_series'] ?>	
		</td>
        <td>
          <input type="hidden" value="<?php echo $value['tsi_expired'] ?>" name="item_jumlah_exp[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="jumlah_exp_item form-control text-right">
          <?php echo $value['tsi_expired'] ?>			
		</td>
        <td class="text-right">
          <input type="hidden" value="<?php echo $value['tsi_series_expired'] ?>" name="item_series_exp[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="series_exp_item form-control">
          <?php echo $value['tsi_series_expired'] ?></p>			
		</td>
          <input type="hidden" value="<?php echo $value['tsi_remaining']-($value['tsi_quantity']+$value['tsi_expired']) ?>" name="item_sisa[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="sisa_item form-control text-right">
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
      var url = "<?php echo site_url('tiket/data_tiket_cabang') ?>";

      $.ajax({
        url : url+"?ticket_code="+id,
        dataType:"json",
        success:function(data){
          var mydata = data.rows[0];
		  
          $("#lintasan_item").text(mydata.lane_name);
          $("#deskripsi_item").html(mydata.ticket_description);
          $("#satuan_item").text(mydata.ticket_unit);
          $("#sisa_item").val(mydata.ticket_stock_branch);
          $("#pengadaan_item_inp").val(0);
		  
        }
      });

    });

    $(".action_item").click(function(){		
		
      var current_item = $("#current_item").val();
      var no = current_item;	  
	  var lane = <?php echo json_encode ($penjualan['tsm_lane_name']); ?>;
      if(current_item == ""){
        no = ($("#item_table tr").length) ? parseInt($("#item_table tr").length) : 1;
      }

      var lintasan = $("#lintasan_item").text();
      var kode = $("#kode_item").val();
      var deskripsi = $("#deskripsi_item").text();
      var satuan = $("#satuan_item").text();
      var sisa = $("#sisa_item").val();
      //var tanggal = $("#tanggal_item").val();
      var pengadaan = $("#pengadaan_item_inp").val();
      var pengadaan_int = $("#pengadaan_item_inp").autoNumeric('get');
      var jumlah = $("#jumlah_item_inp").val();
      var series = $("#series_item_inp").val();
	  var jumlah_exp = $("#jumlah_exp_item_inp").val();
      var series_exp = $("#series_exp_item_inp").val();
      
      if(kode == ""){

        alert("Pilih item");

      } else if(lintasan != lane){

        alert("Lintasan tidak sama");	

      } else if(sisa < 1){

        alert("Sisa stok tiket kurang dari <b>1</b>");		
		
	  } else if(pengadaan ==""){	
	  
		alert("Harga Pengadaan belum diisi");		
		
	  } else if(pengadaan < 1){	
	  
		alert("Harga Pengadaan tidak boleh kurang dari 1");	

      } else if(jumlah ==""){

        alert("Jumlah terjual belum diisi");

      } else if(jumlah > sisa){

        alert("Jumlah terjual lebih besar dibanding stok");

      } else if((jumlah+jumlah_exp) > sisa){

        alert("Jumlah Total terjual dan expired/rusak lebih besar dibanding stok");
		
		
	  } else if(series ==""){	
	  
		alert("No Seri Terjual belum diisi");
		
	  } else if(jumlah_exp ==""){	
	  
		alert("Jumlah Kadaluarsa/Rusak belum diisi");
		
	  } else if(series_exp ==""){	
	  
		alert("No Seri Kadaluarsa/Rusak belum diisi");	
		
	  } else {

        var html = "<tr><td><button type='button' class='btn btn-primary btn-xs edit_item' data-no='"+no+"'><i class='fa fa-edit'></i></button></td>";
        html += "<td><input type='hidden' class='lintasan_item' data-no='"+no+"' name='item_lintasan["+no+"]' value='"+lintasan+"'/>"+lintasan+"</td>";
        html += "<td><input type='hidden' class='kode_item' data-no='"+no+"' name='item_kode["+no+"]' value='"+kode+"'/>"+kode+"</td>";
        html += "<td><input type='hidden' class='deskripsi_item' data-no='"+no+"' name='item_deskripsi["+no+"]' value='"+deskripsi+"'/>"+deskripsi+"</td>";
        html += "<td><input type='hidden' class='satuan_item' data-no='"+no+"' name='item_satuan["+no+"]' value='"+satuan+"'/>"+satuan+"</td>";
		html += "<td class='text-right'><input type='hidden' class='sisa_item money' data-no='"+no+"' name='item_sisa["+no+"]' value='"+sisa+"'/>"+sisa+"</td>";
        html += "<td class='text-right'><input type='hidden' class='pengadaan_item' data-no='"+no+"' name='item_pengadaan["+no+"]' value='"+pengadaan+"'/>"+pengadaan+"</td>";
        html += "<td class='text-right'><input type='hidden' class='jumlah_item' data-no='"+no+"' name='item_jumlah["+no+"]' value='"+jumlah+"'/>"+jumlah+"</td>";
        html += "<td><input type='hidden' class='series_item' data-no='"+no+"' name='item_series["+no+"]' value='"+series+"'/>"+series+"</td>";
        html += "<td class='text-right'><input type='hidden' class='jumlah_exp_item' data-no='"+no+"' name='item_jumlah_exp["+no+"]' value='"+jumlah_exp+"'/>"+jumlah_exp+"</td>";
        html += "<td><input type='hidden' class='series_exp_item' data-no='"+no+"' name='item_series_exp["+no+"]' value='"+series_exp+"'/>"+series_exp+"</td>";
        //html += "<td><input type='hidden' class='tanggal_item' data-no='"+no+"' name='item_tanggal["+no+"]' value='"+tanggal+"'/>"+tanggal+"</td>";
        
		$("#item_table").append(html);

        $("#lintasan_item").text("");
        $("#kode_item").val("");
        $("#deskripsi_item").text("");
        $("#satuan_item").text("");
        $("#sisa_item").val("");
        //$("#tanggal_item").text("");
        $("#pengadaan_item_inp").val("");
        $("#jumlah_item_inp").val("");
        $("#series_item_inp").val("");
        $("#jumlah_exp_item_inp").val("");
        $("#series_exp_item_inp").val("");
        $("#current_item").val("");
      }

    });

    $(document.body).on("click",".empty_item",function(){

        $("#lintasan_item").text("");
        $("#kode_item").val("");
        $("#deskripsi_item").text("");
        $("#satuan_item").text("");
        $("#sisa_item").val("");
        $("#pengadaan_item_inp").val("");
        $("#jumlah_item_inp").val("");
        $("#series_item_inp").val("");
        $("#jumlah_exp_item_inp").val("");
        $("#series_exp_item_inp").val("");
        $("#current_item").val("");

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
      var lintasan = $(".lintasan_item[data-no='"+no+"']").val();
      var kode = $(".kode_item[data-no='"+no+"']").val();
      var deskripsi = $(".deskripsi_item[data-no='"+no+"']").val();
      var satuan = $(".satuan_item[data-no='"+no+"']").val();
      var sisa = $(".sisa_item[data-no='"+no+"']").val();
      var pengadaan = $(".pengadaan_item[data-no='"+no+"']").val();
      var jumlah = $(".jumlah_item[data-no='"+no+"']").val();
      var series = $(".series_item[data-no='"+no+"']").val();
      var jumlah_exp = $(".jumlah_exp_item[data-no='"+no+"']").val();
      var series_exp = $(".series_exp_item[data-no='"+no+"']").val();

		$("#current_item").val(no);
        $("#lintasan_item").text(lintasan);
		$("#kode_item").val(kode);
        $("#deskripsi_item").text(deskripsi);
        $("#satuan_item").text(satuan);
        $("#sisa_item").val(sisa);
        $("#pengadaan_item_inp").val(pengadaan);
        $("#jumlah_item_inp").val(jumlah);
        $("#series_item_inp").val(series);
        $("#jumlah_exp_item_inp").val(jumlah_exp);
        $("#series_exp_item_inp").val(series_exp);
		
      cek_group();

      $(this).parent().parent().remove();
      

      return false;

    });
  })

</script>
