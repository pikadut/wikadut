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

                        <div class="form-group">
                            <?php $curval=$perencanaan['tpm_number']; ?>
                            <label class="col-sm-2 control-label">No. Permintaan</label>
                            <div class="col-sm-10">
                                <p class="form-control-static">
                                    <?php echo $curval ?>
                                </p>
                            </div>
                        </div>

                        <?php $curval=$perencanaan['trm_district_name']; ?>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Cabang</label>
                            <div class="col-sm-10">
                                <p class="form-control-static">
                                    <?php echo $curval ?>
                                </p>
                            </div>
                        </div>

                        <?php $curval=$perencanaan['trm_entry_name']; ?>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">User </label>
                            <div class="col-sm-10">
                                <p class="form-control-static">
                                    <?php echo $curval ?>
                                </p>
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
      <th rowspan="2">Tanggal Dikirim</th>
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
            if(isset($item2) && !empty($item2)){
              foreach ($item2 as $key => $value) { ?>
              <tr>
                <td>
                 <?php echo $key+1 ?>
                </td>
                <td>
                  <?php echo $value['tdi_lane_name'] ?>
                </td>
                <td>
                  <?php echo $value['tdi_code'] ?>
                </td>
                <td>
                  <?php echo $value['tdi_description'] ?>
                </td>
                <td>
                  <?php echo $value['tdi_date'] ?>
                </td>
                <td>
                  <?php echo $value['tdi_series'] ?>
                </td>
                <td>
                  <?php echo $value['tdi_series_end'] ?>
                </td>
                <td class="text-right">
                  <?php echo $value['tdi_quantity'] ?>
                </td>
                <td>
                  <?php echo $value['tdi_unit'] ?>
                </td>
                <td class="text-right">
                  <?php echo $value['tdi_remaining'] ?>
                </td>
                <td class="text-right money">
                  <?php echo $value['tdi_angkut'] ?>
                </td>
                <td class="text-right money">
                  <?php echo $value['tdi_pelabuhan'] ?>
                </td>
                <td class="text-right money">
                  <?php echo $value['tdi_asuransi'] ?>
                </td>
                <td>
                  <?php echo $value['tdi_note'] ?>
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
        <h5>ITEM PENERIMAAN TIKET</h5>
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
      <th rowspan="2">Tanggal Diterima</th>
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
            if(isset($item3) && !empty($item3)){
              foreach ($item3 as $key => $value) { ?>
              <tr>
                <td>
                 <?php echo $key+1 ?>
                </td>
                <td>
                  <?php echo $value['tri_lane_name'] ?>
                </td>
                <td>
                  <?php echo $value['tri_code'] ?>
                </td>
                <td>
                  <?php echo $value['tri_description'] ?>
                </td>
                <td>
                  <?php echo $value['tri_date'] ?>
                </td>
                <td>
                  <?php echo $value['tri_series'] ?>
                </td>
                <td>
                  <?php echo $value['tri_series_end'] ?>
                </td>
                <td class="text-right">
                  <?php echo $value['tri_quantity'] ?>
                </td>
                <td>
                  <?php echo $value['tri_unit'] ?>
                </td>
                <td class="text-right">
                  <?php echo $value['tri_remaining'] ?>
                </td>
                <td class="text-right money">
                  <?php echo $value['tri_angkut'] ?>
                </td>
                <td class="text-right money">
                  <?php echo $value['tri_pelabuhan'] ?>
                </td>
                <td class="text-right money">
                  <?php echo $value['tri_asuransi'] ?>
                </td>
                <td>
                  <?php echo $value['tri_note'] ?>
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

<?php echo buttonback( 'tiket/permintaan_tiket/rekapitulasi_penerimaan_tiket',lang('back')) ?>


	</form>
</div>