<div class="wrapper wrapper-content animated fadeInRight">
    <form class="form-horizontal">

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
			$monthNum  = $penjualan['tsm_month'];
			$curval = date("F", mktime(0, 0, 0, $monthNum, 10));
			?>
             <div class="form-group">
              <label class="col-sm-2 control-label">Bulan</label>
              <div class="col-sm-10">
               <p class="form-control-static"><?php echo $curval ?></p>
             </div>
           </div>
	      
            <?php $curval = $penjualan['tsm_year']; ?>
             <div class="form-group">
              <label class="col-sm-2 control-label">Tahun</label>
              <div class="col-sm-10">
               <p class="form-control-static"><?php echo $curval ?></p>
             </div>
           </div>

           <?php $curval = $penjualan['tsm_lane_name']; ?>
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
              foreach ($item as $key => $value) { ?>
              <tr>
                <td>
                 <?php echo $key+1 ?>
                </td>
                <td>
                  <?php echo $value['tsi_lane_name'] ?>
                </td>
                <td>
                  <?php echo $value['tsi_code'] ?>
                </td>
                <td>
                  <?php echo $value['tsi_description'] ?>
                </td>
                <td>
                  <?php echo $value['tsi_unit'] ?>
                </td>
                <td class="text-right">
                  <?php echo $value['tsi_remaining'] ?>
                </td>  
                <td class="text-right money">
                  <?php echo $value['tsi_pengadaan'] ?>
                </td>               
                <td class="text-right">
                  <?php echo $value['tsi_quantity'] ?>
                </td>
                <td>
                  <?php echo $value['tsi_series'] ?>
                </td> 
                <td class="text-right">
                  <?php echo $value['tsi_expired'] ?>
                </td>
                <td>
                  <?php echo $value['tsi_series_expired'] ?>
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


<?php $i=0 ; include(VIEWPATH. "/comment_view_attachment_v.php") ?>

<?php echo buttonback( 'tiket/penjualan_tiket/daftar_penjualan_tiket',lang('back')) ?>


	</form>
</div>