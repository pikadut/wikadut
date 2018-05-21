  <?php $i = 0; ?>
  <form method="post" class="form-horizontal">
   <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Form #<?php echo $i ?></h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>
          </div>
        </div>
        <div class="ibox-content">

          <?php 
          $curval = (isset($v['mat_group_code'])) ? $v['mat_group_code'] : set_value("group_inp[$i]");
          $label = lang('group', "group_inp[$i]", array('class' => 'col-sm-2 control-label'));
          ?>

          <div class="form-group">
            <?php echo $label ?>
            <div class="col-sm-10">
              <p class="form-control-static"><?php echo $curval ?></p>
            </div>
          </div>


          <?php 
          $curval = (isset($v['mat_catalog_code'])) ? $v['mat_catalog_code'] : set_value("code_inp[$i]");
          $label = lang('code', "code_inp[$i]", array('class' => 'col-sm-2 control-label'));
          ?>
          <div class="form-group">
            <?php echo $label ?>
            <div class="col-sm-10">
             <p class="form-control-static"><?php echo $curval ?></p>
           </div>
         </div>

         <?php 
         $curval = (isset($v['short_description'])) ? $v['short_description'] : set_value("info_inp[$i]");
         $label = lang('info', "info_inp[$i]", array('class' => 'col-sm-2 control-label'));
         ?>
         <div class="form-group">
          <label class="col-sm-2 control-label">Nama Barang</label>
          <div class="col-sm-10">
            <p class="form-control-static"><?php echo $curval ?></p>
          </div>
        </div>

        <?php 
        $curval = (isset($v['long_description'])) ? $v['long_description'] : set_value("desc_inp[$i]");
        $label = lang('description', "desc_inp[$i]", array('class' => 'col-sm-2 control-label'));
        ?>
        <div class="form-group">
          <?php echo $label ?>
          <div class="col-sm-10">
            <p class="form-control-static"><?php echo $curval ?></p>
          </div>
        </div>

        <?php 
        $curval = (isset($v['manufacturer'])) ? $v['manufacturer'] : set_value("manufacture_inp[$i]");
        $label = lang('manufacture', "manufacture_inp[$i]", array('class' => 'col-sm-2 control-label'));
        ?>
        <div class="form-group">
          <?php echo $label ?>
          <div class="col-sm-10">
           <p class="form-control-static"><?php echo $curval ?></p>
         </div>
       </div>

       <?php 
       $curval = (isset($v['brand'])) ? $v['brand'] : set_value("brand_inp[$i]");
       $label = lang('brand', "brand_inp[$i]", array('class' => 'col-sm-2 control-label'));
       ?>
       <div class="form-group">
        <?php echo $label ?>
        <div class="col-sm-10">
          <p class="form-control-static"><?php echo $curval ?></p>
        </div>
      </div>

      <?php 
      $curval = (isset($v['part_number'])) ? $v['part_number'] : set_value("part_no_inp[$i]");
      $label = lang('part_no', "part_no_inp[$i]", array('class' => 'col-sm-2 control-label'));
      ?>
      <div class="form-group">
        <?php echo $label ?>
        <div class="col-sm-10">
          <p class="form-control-static"><?php echo $curval ?></p>
        </div>
      </div>

      <?php 
      $curval = (isset($v['model_number'])) ? $v['model_number'] : set_value("model_no_inp[$i]");
      $label = lang('model_no', "model_no_inp[$i]", array('class' => 'col-sm-2 control-label'));
      ?>
      <div class="form-group">
        <?php echo $label ?>
        <div class="col-sm-10">
         <p class="form-control-static"><?php echo $curval ?></p>
       </div>
     </div>

     <?php 
     $curval = (isset($v['serial_number'])) ? $v['serial_number'] : set_value("serial_no_inp[$i]");
     $label = lang('serial_no', "serial_no_inp[$i]", array('class' => 'col-sm-2 control-label'));
     ?>
     <div class="form-group">
       <?php echo $label ?>
       <div class="col-sm-10">
        <p class="form-control-static"><?php echo $curval ?></p>
      </div>
    </div>

    <?php 
    $curval = (isset($v['uom'])) ? $v['uom'] : set_value("uom_inp[$i]");
    $label = lang('uom', "uom_inp[$i]", array('class' => 'col-sm-2 control-label'));
    ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Satuan</label>  
      <div class="col-sm-10">
        <p class="form-control-static"><?php echo $curval ?></p>
      </div>
    </div>
	
	<?php 
    $curval = (isset($v['material'])) ? $v['material'] : set_value("material_inp[$i]");
    $label = lang('uom', "uom_inp[$i]", array('class' => 'col-sm-2 control-label'));
    ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Material</label>  
      <div class="col-sm-10">
        <p class="form-control-static"><?php echo $curval ?></p>
      </div>
    </div>
	
	<?php 
    $curval = (isset($v['tipe'])) ? $v['tipe'] : set_value("tipe_inp[$i]");
    $label = lang('uom', "uom_inp[$i]", array('class' => 'col-sm-2 control-label'));
    ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Tipe</label>  
      <div class="col-sm-10">
        <p class="form-control-static"><?php echo $curval ?></p>
      </div>
    </div>
	
	<?php 
    $curval = (isset($v['ukuran'])) ? $v['ukuran'] : set_value("ukuran_inp[$i]");
    $label = lang('uom', "uom_inp[$i]", array('class' => 'col-sm-2 control-label'));
    ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Ukuran</label>  
      <div class="col-sm-10">
        <p class="form-control-static"><?php echo $curval ?></p>
      </div>
    </div>
	
	<?php 
    $curval = (isset($v['spesifikasi'])) ? $v['spesifikasi'] : set_value("spesifikasi_inp[$i]");
    $label = lang('uom', "uom_inp[$i]", array('class' => 'col-sm-2 control-label'));
    ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Spesifikasi</label>  
      <div class="col-sm-10">
        <p class="form-control-static"><?php echo $curval ?></p>
      </div>
    </div>
	
	<?php 
    $curval = (isset($v['lokasi'])) ? $v['lokasi'] : set_value("lokasi_inp[$i]");
    ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Lokasi</label>  
      <div class="col-sm-10">
        <p class="form-control-static"><?php echo $curval ?></p>
      </div>
    </div>
	
	<?php 
    $curval = (isset($v['warna'])) ? $v['warna'] : set_value("warna_inp[$i]");
    $label = lang('uom', "uom_inp[$i]", array('class' => 'col-sm-2 control-label'));
    ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Warna</label>  
      <div class="col-sm-10">
        <p class="form-control-static"><?php echo $curval ?></p>
      </div>
    </div>
	
	<?php 
    $curval = (isset($v['kode'])) ? $v['kode'] : set_value("kode_inp[$i]");
    ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Kode</label>  
      <div class="col-sm-10">
        <p class="form-control-static"><?php echo $curval ?></p>
      </div>
    </div>
	
	<?php 
    $curval = (isset($v['others'])) ? $v['others'] : set_value("others_inp[$i]");
    ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Atribut Lainnya</label>  
      <div class="col-sm-10">
        <p class="form-control-static"><?php echo $curval ?></p>
      </div>
    </div>

    <?php 
    $curval = (isset($v['image'])) ? $v['image'] : set_value("image_inp[$i]");
    $label = lang('image', "image_inp[$i]", array('class' => 'col-sm-2 control-label'));
    ?>
    <div class="form-group">
      <?php echo $label ?>
      <div class="col-sm-10">
       <p class="form-control-static">
        <a href="<?php echo site_url("log/download_attachment/$dir/$curval") ?>" target="_blank"><?php echo $curval ?></a>
      </p>
    </div>
  </div>

  <?php 
  $curval = (isset($v['attachment'])) ? $v['attachment'] : set_value("attachment_inp[$i]");
  $label = lang('attachment', "attachment_inp[$i]", array('class' => 'col-sm-2 control-label'));
  ?>
  <div class="form-group">
    <?php echo $label ?>
    <div class="col-sm-10">
      <p class="form-control-static">
        <a href="<?php echo site_url("log/download_attachment/$dir/$curval") ?>" target="_blank"><?php echo $curval ?></a>
      </p>
    </div>
  </div>

</div>
</div>
<?php 
if(in_array($userdata['job_title'], array("APPROVAL KOMODITI","PENGELOLA KOMODITI"))){
include(VIEWPATH."/comment_view_v.php");
} ?>
<?php echo buttonback('commodity/katalog/katalog_barang',lang('back'),lang('save')) ?>
</div>
</div>

</form>