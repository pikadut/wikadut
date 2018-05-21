
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

        <?php $curval = (isset($po['po_number'])) ? $po['po_number'] : ""; ?>

        <div class="form-group">
          <label class="col-sm-2 control-label">Nomor WO</label>
          <div class="col-sm-10">
           <p class="form-control-static">
             <?php if(!empty($curval)){ ?>
             <?php echo $curval ?>
             <?php } else { ?>
             AUTO NUMBER
             <?php } ?>
           </p>
           <?php $curval = (isset($po['po_id'])) ? $po['po_id'] : ""; ?>
           <input type="hidden" name="po_id" value="<?php echo $curval ?>">
           <?php $curval = (isset($kontrak['contract_id'])) ? $kontrak['contract_id'] : ""; ?>
           <input type="hidden" name="contract_id" value="<?php echo $curval ?>">
         </div>
       </div>

       <?php $curval = (isset($kontrak['contract_number'])) ? $kontrak['contract_number'] : "AUTO NUMBER"; ?>

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

     <?php $curval = (isset($kontrak['ptm_number'])) ? $kontrak['ptm_number'] : "AUTO NUMBER"; ?>

     <div class="form-group">
      <label class="col-sm-2 control-label">Nomor Pengadaan</label>
      <div class="col-sm-10">
       <p class="form-control-static">
         <a href="<?php echo site_url('procurement/procurement_tools/monitor_pengadaan/lihat/'.$curval) ?>" target="_blank">
           <?php echo $curval ?>
         </a>
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

<?php $curval = (isset($po['start_date'])) ?  date("Y-m-d",strtotime($po["start_date"])) : ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Tanggal Mulai WO</label>
  <div class="col-sm-4">
    <div class="input-group date">
      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
      <input type="date" required name="tgl_mulai_inp" class="form-control" value="<?php echo $curval ?>">
    </div>
  </div>
</div>

<?php $curval = (isset($po['end_date'])) ? date("Y-m-d",strtotime($po["end_date"])) : ""; ?>
<div class="form-group">
  <label class="col-sm-2 control-label">Tanggal Berakhir WO</label>
  <div class="col-sm-4">
    <div class="input-group date">
      <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
      <input type="date" required name="tgl_akhir_inp" class="form-control" value="<?php echo $curval ?>">
    </div>
  </div>
</div>

<?php $curval = (isset($po['po_notes'])) ? $po['po_notes'] : $kontrak['scope_work'] ; ?>

<div class="form-group">
  <label class="col-sm-2 control-label">Deskripsi WO</label>
  <div class="col-sm-8">
    <textarea class="form-control" required name="scope_work_inp"><?php echo $curval ?></textarea>
  </div>
</div>

<?php $contract_amount = (isset($kontrak['contract_amount'])) ? $kontrak['contract_amount'] : 0; ?>

<div class="form-group">
  <label class="col-sm-2 control-label">Total Nilai Kontrak</label>
  <div class="col-sm-10">
    <p class="form-control-static"><?php echo inttomoney($contract_amount) ?></p>
  </div>
</div>

<?php $totalwo = (isset($totalwo)) ? $totalwo : 0; ?>

<div class="form-group">
  <label class="col-sm-2 control-label">Total Nilai WO yang sudah dikeluarkan</label>
  <div class="col-sm-10">
    <p class="form-control-static"><?php echo inttomoney($totalwo) ?></p>
  </div>
</div>

<?php $curval = $contract_amount-$totalwo; ?>

<div class="form-group">
  <label class="col-sm-2 control-label">Sisa Nilai Kontrak</label>
  <div class="col-sm-10">
    <p class="form-control-static"><?php echo inttomoney($curval) ?></p>
  </div>
</div>

</div>
</div>
</div>
</div>