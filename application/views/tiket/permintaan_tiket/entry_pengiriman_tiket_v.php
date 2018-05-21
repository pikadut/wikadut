<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" action="<?php echo site_url($controller_name."/submit_entry_pengiriman_tiket");?>"  class="form-horizontal ajaxform">
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
	   
			<div class="form-group">
				
				<?php $curval = (isset($permintaan['tpm_id'])) ? $permintaan['tpm_id'] :  ""; ?>
				<input type="hidden" name="tpm_id" value="<?php echo $curval ?>"/>
			
				<?php $curval = (isset($permintaan['tpm_number'])) ? $permintaan['tpm_number'] : ""; ?>
                <label class="col-sm-2 control-label">No. Permintaan</label>
                <div class="col-sm-10">
                    <p class="form-control-static">
                        <?php echo $curval ?>
                    </p>
                </div>
				<input type="hidden" name="tpm_number" value="<?php echo $curval ?>"/>
            </div>
		   
            <?php $curval = (isset($permintaan['tpm_planner'])) ? $permintaan['tpm_planner'] : ""; ?>
             <div class="form-group">
              <label class="col-sm-2 control-label">User</label>
              <div class="col-sm-10">
               <p class="form-control-static"><?php echo $curval ?></p>
             </div>
				<input type="hidden" name="tpm_planner" value="<?php echo $curval ?>">
           </div>
		   

           <?php $curval = (isset($permintaan['tpm_district_name'])) ? $permintaan['tpm_district_name'] :""; ?>
          <div class="form-group">
            <label class="col-sm-2 control-label">Cabang</label>
            <div class="col-sm-10">
              <p class="form-control-static"><?php echo $curval ?></p>
            </div>
				<input type="hidden" name="trm_district_name" value="<?php echo $curval ?>">
          </div>
		  
	   
 </div>
</div>
</div>
</div>



<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>ITEM PERMINTAAN TIKET</h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="ibox-content">

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
              foreach ($item as $key => $value) { ?>
              <tr>
                <td>
                 <?php echo $key+1 ?>
                </td>
                <td>
                  <?php echo $value['tpi_lane_name'] ?>
                </td>
                <td>
                  <?php echo $value['tpi_code'] ?>
                </td>
                <td>
                  <?php echo $value['tpi_description'] ?>
                </td>
                <td>
                  <?php echo $value['tpi_date'] ?>
                </td>
                <td>
                  <?php echo $value['tpi_series'] ?>
                </td>
                <td>
                  <?php echo $value['tpi_series_end'] ?>
                </td>
                <td class="text-right">
                  <?php echo $value['tpi_quantity'] ?>
                </td>
                <td>
                  <?php echo $value['tpi_unit'] ?>
                </td>
                <td class="text-right">
                  <?php echo $value['tpi_remaining'] ?>
                </td>
                <td class="text-right money">
                  <?php echo $value['tpi_angkut'] ?>
                </td>
                <td class="text-right money">
                  <?php echo $value['tpi_pelabuhan'] ?>
                </td>
                <td class="text-right money">
                  <?php echo $value['tpi_asuransi'] ?>
                </td>
                <td>
                  <?php echo $value['tpi_note'] ?>
                </td>
              </tr>

              <?php         
          
           } } ?>
 </tbody>
</table>



</div>

</div>
</div>
</div>



<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>ITEM PENGIRIMAN TIKET</h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="ibox-content">

<table class="table table-bordered valign" id="item_table">
  <thead>
    <tr>
      <th rowspan="2">#</th>
	  <th rowspan="2">Lintasan</th>
      <th rowspan="2">Kode</th>
	  <th rowspan="2">Nama Item</th>
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
  <tbody><?php 
    if(isset($item) && !empty($item)){
      foreach ($item as $key => $value) {
        $idnya = $key+1;
       ?>

      <tr>
        <td>
            <?php $curval = (isset($value['tpi_id'])) ? $value['tpi_id'] :  ""; ?>
            <input type="hidden" name="item_id[<?php echo $idnya ?>]" value="<?php echo $curval ?>"/>
			<?php echo $key+1 ?>
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
          <input type="text" value="<?php echo $value['tpi_series'] ?>" name="item_series[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="series_item form-control">
        </td>
        <td>
          <input type="text" value="<?php echo $value['tpi_series_end'] ?>" name="item_series_end[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="series_end_item form-control">
        </td>
        <td class="text-right">
          <input type="text" value="<?php echo $value['tpi_quantity'] ?>" name="item_jumlah[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="jumlah_item form-control text-right">
        </td>
        <td>
          <input type="hidden" value="<?php echo $value['tpi_unit'] ?>" name="item_satuan[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="satuan_item">
          <?php echo $value['tpi_unit'] ?>
        </td>
        <td class="text-right">
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
          <input type="hidden" value="<?php echo date('Y-m-d H:i:s'); ?>" name="item_tanggal[<?php echo $idnya ?>]" data-no="<?php echo $idnya ?>" class="tanggal_item">
          
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


<?php  $i = 0; include(VIEWPATH."/comment_workflow_attachment_v.php") ?>

  <?php echo buttonsubmit('tiket/permintaan_tiket/rekapitulasi_pengiriman_tiket',lang('back'),lang('save')) ?>

</form>
</div>
