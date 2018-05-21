
<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>HEADER</h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="ibox-content">

        <?php $curval = (isset($kontrak['ptm_number'])) ? $kontrak['ptm_number'] : ""; ?>

        <div class="form-group">
          <label class="col-sm-2 control-label">Nomor Tender</label>
          <div class="col-sm-10">
           <p class="form-control-static">
             <a href="<?php echo site_url('procurement/procurement_tools/monitor_pengadaan/lihat/'.$curval) ?>" target="_blank">
               <?php echo $curval ?>
             </a></p>
           </div>
         </div>

         <?php $curval = (isset($kontrak['contract_number'])) ? $kontrak['contract_number'] : ""; ?>

         <div class="form-group">
          <label class="col-sm-2 control-label">Nomor Kontrak</label>
          <div class="col-sm-10">
           <p class="form-control-static">
             <a href="<?php echo site_url('contract/monitor/monitor_kontrak/lihat/'.$kontrak['contract_id']) ?>" target="_blank">
               <?php echo $curval ?>
             </a>
           </p>
         </div>
       </div>

       <?php $curval = (isset($po['po_number'])) ? $po['po_number'] : ""; ?>

       <div class="form-group">
        <label class="col-sm-2 control-label">Nomor WO</label>
        <div class="col-sm-10">
         <p class="form-control-static">
           <?php echo $curval ?>
         </p>
       </div>
     </div>

     <?php $curval = (isset($tender['ptm_requester_name'])) ? $tender['ptm_requester_name'] : ""; ?>

     <div class="form-group">
      <label class="col-sm-2 control-label">Nama Pembuat WO</label>
      <div class="col-sm-10">
       <p class="form-control-static"><?php echo $curval ?></p>
     </div>
   </div>

   <?php $curval = (isset($kontrak['vendor_name'])) ? $kontrak['vendor_name'] : ""; ?>

   <div class="form-group">
    <label class="col-sm-2 control-label">Vendor</label>
    <div class="col-sm-10">
     <p class="form-control-static"><?php echo $curval ?></p>
   </div>
 </div>

 <?php $curval = (isset($kontrak['start_date'])) ?  $kontrak["start_date"] : set_value("tgl_mulai_inp"); ?>
 <div class="form-group">
  <label class="col-sm-2 control-label">Tanggal Mulai WO</label>
  <div class="col-sm-4">
    <p class="form-control-static"><?php echo date("d/m/Y",strtotime($curval)) ?></p>
  </div>
</div>

<?php $curval = (isset($kontrak['end_date'])) ?  $kontrak["end_date"] : set_value("tgl_akhir_inp"); ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Tanggal Berakhir WO</label>
  <div class="col-sm-4">
    <p class="form-control-static"><?php echo date("d/m/Y",strtotime($curval)) ?></p>
  </div>
</div>

<?php $curval = (isset($kontrak['scope_work'])) ? $kontrak['scope_work'] : set_value("scope_work_inp"); ?>

<div class="form-group">
  <label class="col-sm-2 control-label">Deskripsi WO</label>
  <div class="col-sm-8">
    <p class="form-control-static">
      <?php echo $curval ?>
      <input type="hidden" name="scope_work_inp" value="<?php echo $curval ?>">
    </p>
  </div>
</div>

<!-- start code hlmifzi -->
<?php foreach ($nilai_kontrak as $k => $v) { ?> 
<?php $curval = (isset($v['total'])) ? inttomoney($v['total']) : 0; ?>
<?php } ?>
<!-- end -->

<div class="form-group">
  <label class="col-sm-2 control-label">Total Nilai Kontrak</label>
  <div class="col-sm-10">
    <p class="form-control-static"><?php echo $curval ?></p>
  </div>
</div>


<?php $curval = (isset($totalwo)) ? inttomoney($totalwo) : 0; ?>

<div class="form-group">
  <label class="col-sm-2 control-label">Total Nilai WO yang sudah dikeluarkan</label>
  <div class="col-sm-10">
    <p class="form-control-static"><?php echo $curval ?></p>
  </div>
</div>

<?php $curval = (isset($kontrak['contract_amount'])) ? inttomoney($kontrak['contract_amount']-$totalwo) : 0; ?>

<div class="form-group">
  <label class="col-sm-2 control-label">Sisa Nilai Kontrak</label>
  <div class="col-sm-10">
    <p class="form-control-static"><?php echo $curval ?></p>
  </div>
</div>

</div>
</div>
</div>
</div>
