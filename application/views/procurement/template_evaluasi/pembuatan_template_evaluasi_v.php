<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" action="<?php echo site_url($controller_name."/submit_pembuatan_template_evaluasi");?>"  class="form-horizontal ajaxform">

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

            <?php $curval = set_value("nama_inp"); ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Nama *</label>
              <div class="col-sm-10">
               <input type="text" class="form-control" maxlength="120" required id="nama_inp" name="nama_inp" value="<?php echo $curval ?>">
             </div>
           </div>

           <?php $curval = set_value("jenis_inp"); ?>
           <div class="form-group">
            <label class="col-sm-2 control-label">Jenis *</label>
            <div class="col-sm-4">
             <select class="form-control" required id="jenis_inp" name="jenis_inp">
               <option value="0">Evaluasi Kualitas Terbaik</option>
               <option value="1">Evaluasi Kualitas Teknik Dan Harga</option>
               <option value="2">Evaluasi Harga Rendah</option>
             </select>
           </div>
         </div>

         <?php $curval = set_value("passing_grade_inp"); ?>
         <div class="form-group">
          <label class="col-sm-2 control-label">Passing Grade *</label>
          <div class="col-sm-5">
           <input type="text" class="form-control money" required id="passing_grade_inp" name="passing_grade_inp" value="<?php echo $curval ?>">
         </div>
       </div>

       <?php $curval = set_value("bobot_teknis_inp"); ?>
       <div class="form-group">
        <label class="col-sm-2 control-label">Bobot Teknis *</label>
        <div class="col-sm-2">
         <input type="text" class="form-control money" required id="bobot_teknis_inp" name="bobot_teknis_inp" value="<?php echo $curval ?>">
       </div>
     </div>

     <?php $curval = set_value("bobot_harga_inp"); ?>
     <div class="form-group">
      <label class="col-sm-2 control-label">Bobot Harga *</label>
      <div class="col-sm-2">
       <input type="text" class="form-control money" required id="bobot_harga_inp" name="bobot_harga_inp" value="<?php echo $curval ?>">
     </div>
   </div>

 </div>
</div>
</div>
</div>

<br>

<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>ITEM ADMINISTRASI/TEKNIS</h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="ibox-content">

        <?php $curval = set_value("item"); ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Item</label>
          <div class="col-sm-10">
           <input type="text" class="form-control" maxlength="120" id="item" name="item" value="<?php echo $curval ?>">
         </div>
       </div>

       <?php $curval = set_value("jenis_item"); ?>
       <div class="form-group">
         <label class="col-sm-2 control-label">Jenis Item</label>
         <div class="col-sm-10">
          <div class="radio">
           <label>
             <?php $selected = (0 == $curval) ? "checked" : "";  ?>
             <input type="radio" <?php echo $selected ?> class="jenis_item" name="jenis_item" value="0"> Administrasi
           </label>
           <label>
             <?php $selected = (1 == $curval) ? "checked" : "";  ?>
             <input type="radio" <?php echo $selected ?> class="jenis_item" name="jenis_item" value="1"> Teknis
           </label>
         </div>
       </div>
     </div>

     <?php $curval = set_value("bobot"); ?>
     <div class="form-group">
      <label class="col-sm-2 control-label">Bobot (%)</label>
      <div class="col-sm-3">
       <input type="text" maxlength="3" class="form-control money" id="bobot" name="bobot" value="<?php echo $curval ?>">
     </div>
   </div>

   <center>
    <a class="btn btn-primary action_item">Simpan</a>
    <input type="hidden" id="current_item" value=""/>
    <br>
  </center>

  <hr>

  <table class="table table-bordered" id="item_table">
    <thead>
      <tr>
        <th>#</th>
        <th>Item</th>
        <th>Jenis</th>
        <th>Bobot (%)</th>
      </tr>
    </thead>
    <tbody>
    </tbody>
  </table>

</div>

</div>
</div>
</div>

<?php echo buttonsubmit('procurement/perencanaan_pengadaan/daftar_perencanaan_pengadaan',lang('back'),lang('save')) ?>

</form>

</div>

<?php include("form_template_evaluasi_js.php") ?>