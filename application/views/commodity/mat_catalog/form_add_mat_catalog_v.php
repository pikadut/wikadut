<div class="wrapper wrapper-content animated fadeInRight">
<form method="post" action="<?php echo site_url($controller_name."/submit_add_mat_catalog");?>"  class="form-horizontal">

  <?php //echo buttonsubmit('commodity/katalog/katalog_barang') ?>
  
  <input type="hidden" name="jumlah" value="<?php echo $jumlah ?>">

  <?php for ($i=0; $i < $jumlah; $i++) { ?>

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
			
			<div class="form-group">
				<label class="col-sm-2 control-label">Grup Barang Level 1 *</label>
				<div class="col-sm-10">
					<select required class="form-control select2" style="width:100%;" data-no = "<?php echo $i ?>" name="group_level1_inp[<?php echo $i ?>]">
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-2 control-label">Grup Barang Level 2 *</label>
				<div class="col-sm-10">
					<select required class="form-control select2" style="width:100%;" data-no = "<?php echo $i ?>" name="group_level2_inp[<?php echo $i ?>]">
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-2 control-label">Grup Barang Level 3 *</label>
				<div class="col-sm-10">
					<select required class="form-control select2" style="width:100%;" data-no = "<?php echo $i ?>" name="group_level3_inp[<?php echo $i ?>]">
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-2 control-label">Grup Barang Level 4 *</label>
				<div class="col-sm-10">
					<select required class="form-control select2" style="width:100%;" data-no = "<?php echo $i ?>" name="group_level4_inp[<?php echo $i ?>]">
					</select>
				</div>
			</div>

            <?php 

            $curval = set_value("code_inp[$i]");
            $label = lang('code', "code_inp[$i]", array('class' => 'col-sm-2 control-label'));
            ?>
            <div class="form-group">
             <?php echo $label ?>
             <div class="col-sm-10">
             <p class="form-control-static">Otomatis</p>
              
            </div>
          </div>
		  
		  <?php 
          $curval = set_value("info_inp[$i]");
          $label = lang('info', "info_inp[$i]", array('class' => ''));
          ?>
          <div class="form-group">
            <label class="col-sm-2 control-label">Nama Barang *</label>
            <div class="col-sm-10">
              <textarea required name="info_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
            </div>
          </div>
		  
		  <?php 
          $curval = set_value("merek_inp[$i]");
          ?>
		  <div class="form-group">
            <label class="col-sm-2 control-label">Merek</label>
            <div class="col-sm-10">
              <textarea name="merek_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
            </div>
          </div>
		  
		  <?php 
          $curval = set_value("tipe_inp[$i]");
          ?>
		  <div class="form-group">
            <label class="col-sm-2 control-label">Tipe/Jenis</label>
            <div class="col-sm-10">
              <textarea name="tipe_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
            </div>
          </div>
		  
		  <?php 
          $curval = set_value("part_inp[$i]");
          ?>
		  <div class="form-group">
            <label class="col-sm-2 control-label">Nomor Part</label>
            <div class="col-sm-10">
              <textarea name="part_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
            </div>
          </div>
		  
		  <?php 
          $curval = set_value("model_inp[$i]");
          ?>
		  <div class="form-group">
            <label class="col-sm-2 control-label">Nomor Model</label>
            <div class="col-sm-10">
              <textarea name="model_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
            </div>
          </div>
		  
		  <?php 
          $curval = set_value("serial_inp[$i]");
          ?>
		  <div class="form-group">
            <label class="col-sm-2 control-label">Nomor Serial</label>
            <div class="col-sm-10">
              <textarea name="serial_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
            </div>
          </div>
		  
		  <?php 
          $curval = set_value("pabrik_inp[$i]");
          ?>
		  <div class="form-group">
            <label class="col-sm-2 control-label">Pabrik</label>
            <div class="col-sm-10">
              <textarea name="pabrik_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
            </div>
          </div>
		  
		  <?php 
          $curval = set_value("material_inp[$i]");
          ?>
		  <div class="form-group">
            <label class="col-sm-2 control-label">Material</label>
            <div class="col-sm-10">
              <textarea name="material_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
            </div>
          </div>
		  
		  <?php 
          $curval = set_value("ukuran_inp[$i]");
          ?>
		  <div class="form-group">
            <label class="col-sm-2 control-label">Ukuran/Dimensi/Kapasitas</label>
            <div class="col-sm-10">
              <textarea name="ukuran_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
            </div>
          </div>
		  
		  <?php 
          $curval = set_value("warna_inp[$i]");
          ?>
		  <div class="form-group">
            <label class="col-sm-2 control-label">Warna</label>
            <div class="col-sm-10">
              <textarea name="warna_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
            </div>
          </div>
		  
		  <?php 
          $curval = set_value("uom_inp[$i]");
          ?>
		  <div class="form-group">
			<label class="col-sm-2 control-label">Satuan *</label>
			<div class="col-sm-10">
				<input required type="text" class="form-control" name="uom_inp[<?php echo $i ?>]" value="<?php echo $curval ?>">
			</div>
		  </div>
		  
		  <?php 
          $curval = set_value("spesifikasi_inp[$i]");
          ?>
		  <div class="form-group">
            <label class="col-sm-2 control-label">Spesifikasi</label>
            <div class="col-sm-10">
              <textarea name="spesifikasi_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
            </div>
          </div>
		  
		  <?php 
          $curval = set_value("lokasi_inp[$i]");
          ?>
		  <div class="form-group">
            <label class="col-sm-2 control-label">Lokasi</label>
            <div class="col-sm-10">
              <textarea name="lokasi_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
            </div>
          </div>
		  
		  <?php 
          $curval = set_value("kode_inp[$i]");
          ?>
		  <div class="form-group">
            <label class="col-sm-2 control-label">Kode</label>
            <div class="col-sm-10">
              <textarea name="kode_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
            </div>
          </div>
		  
		  <?php $curval = set_value("others_inp[$i]"); ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Atribut Lainnya</label>
              <div class="col-sm-10">
                <textarea name="others_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
              </div>
            </div>

        <?php 
        $curval = set_value("image_inp[$i]");
        $label = lang('image', "image_inp[$i]", array('class' => 'col-sm-2 control-label'));
        ?>
        <div class="form-group">
          <?php echo $label; ?>
          <div class="col-sm-10">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" data-id="image_inp_<?php echo $i ?>" data-folder="<?php echo $dir ?>" data-preview="preview_img_file_<?php echo $i ?>" class="btn btn-primary upload">...</button> 
              </span> 
              <input readonly type="text" class="form-control" id="image_inp_<?php echo $i ?>" name="image_inp[<?php echo $i ?>]" value="<?php echo $curval ?>">
              <span class="input-group-btn">
                <button type="button" data-url="" class="btn btn-primary preview_upload" id="preview_img_file_<?php echo $i ?>">Preview</button> 
              </span> 
            </div>
          </div>
        </div>

        <?php 
        $curval = set_value("attachment_inp[$i]");
        $label = lang('attachment', "attachment_inp[$i]", array('class' => 'col-sm-2 control-label'));
        ?>
        <div class="form-group">
         <?php echo $label; ?>
         <div class="col-sm-10">
          <div class="input-group">
            <span class="input-group-btn">
              <button type="button" data-id="attachment_inp_<?php echo $i ?>" data-folder="<?php echo $dir ?>" data-preview="preview_file_<?php echo $i ?>" class="btn btn-primary upload">...</button> 
            </span> 
            <input readonly type="text" class="form-control" id="attachment_inp_<?php echo $i ?>" name="attachment_inp[<?php echo $i ?>]" value="<?php echo $curval ?>">
            <span class="input-group-btn">
              <button type="button" data-url="" class="btn btn-primary preview_upload" id="preview_file_<?php echo $i ?>">Preview</button> 
            </span> 
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
</div>

<?php include(VIEWPATH."/comment_v.php") ?>

<?php } ?>

<?php echo buttonsubmit('commodity/katalog/katalog_barang',lang('back'),lang('save')) ?>

</form>

</div>

<script type="text/javascript">

  $(function () {
	  
	  $.ajax({
          url:"<?php echo site_url('Commodity/dropdown_grup_brg?level=1') ?>",
          type:"get",
		  dataType:"json",
		  success: function(data) {
				$("select[name*='group_level1_inp']").append("<option value=''><?php echo lang('choose') ?></option>");
            $.each(data, function(index, row) {
				$("select[name*='group_level1_inp']").append("<option value='"+row.mat_group_code+"'>"+row.mat_group_code+" - "+row.mat_group_name+"</option>");
			});
          }
        });

	$("select[name*='group_level1_inp']").change(function(){
		$("select[name='group_level2_inp["+$(this).data("no")+"]']").select2("val","");
		$("select[name='group_level3_inp["+$(this).data("no")+"]']").select2("val","");
		$("select[name='group_level4_inp["+$(this).data("no")+"]']").select2("val","");
		$("select[name='group_level2_inp["+$(this).data("no")+"]']").html("");
		$("select[name='group_level3_inp["+$(this).data("no")+"]']").html("");
		$("select[name='group_level4_inp["+$(this).data("no")+"]']").html("");
		if($(this).val() != ""){
			loadLevel2AndBelow($(this).data("no"));
		}
	});
	  
	$("select[name*='group_level2_inp']").change(function(){
		$("select[name='group_level3_inp["+$(this).data("no")+"]']").select2("val","");
		$("select[name='group_level4_inp["+$(this).data("no")+"]']").select2("val","");
		$("select[name='group_level3_inp["+$(this).data("no")+"]']").html("");
		$("select[name='group_level4_inp["+$(this).data("no")+"]']").html("");
		if($(this).val() != ""){
			loadLevel3AndBelow($(this).data("no"));
		}
	});
	  
	$("select[name*='group_level3_inp']").change(function(){
		$("select[name='group_level4_inp["+$(this).data("no")+"]']").select2("val","");
		$("select[name='group_level4_inp["+$(this).data("no")+"]']").html("");
		if($(this).val() != ""){
			loadLevel4($(this).data("no"));
		}
	});

});

function loadLevel2AndBelow(no){
		$.ajax({
				url:"<?php echo site_url('Commodity/dropdown_grup_brg?parent='); ?>"+$("select[name='group_level1_inp["+no+"]']").val(),
				type:"get",
				dataType:"json",
				success: function(data) {
					$("select[name='group_level2_inp["+no+"]']").append("<option value=''><?php echo lang('choose') ?></option>");
				$.each(data, function(index, row) {
					$("select[name='group_level2_inp["+no+"]']").append("<option value='"+row.mat_group_code+"'>"+row.mat_group_code+" - "+row.mat_group_name+"</option>");
				});
				
				loadLevel3AndBelow(no);
				}
			});		
	}
function loadLevel3AndBelow(no){
	$.ajax({
				url:"<?php echo site_url('Commodity/dropdown_grup_brg?parent=') ?>"+$("select[name='group_level2_inp["+no+"]']").val(),
				type:"get",
				dataType:"json",
				success: function(data) {
					$("select[name='group_level3_inp["+no+"]']").append("<option value=''><?php echo lang('choose') ?></option>");
				$.each(data, function(index, row) {
					$("select[name='group_level3_inp["+no+"]']").append("<option value='"+row.mat_group_code+"'>"+row.mat_group_code+" - "+row.mat_group_name+"</option>");
				});
				
				loadLevel4(no);
				}
			});
}
function loadLevel4(no){
	$.ajax({
				url:"<?php echo site_url('Commodity/dropdown_grup_brg?parent=') ?>"+$("select[name='group_level3_inp["+no+"]']").val(),
				type:"get",
				dataType:"json",
				success: function(data) {
					$("select[name='group_level4_inp["+no+"]']").append("<option value=''><?php echo lang('choose') ?></option>");
				$.each(data, function(index, row) {
					$("select[name='group_level4_inp["+no+"]']").append("<option value='"+row.mat_group_code+"'>"+row.mat_group_code+" - "+row.mat_group_name+"</option>");
				});
				
				}
			});
}

</script>