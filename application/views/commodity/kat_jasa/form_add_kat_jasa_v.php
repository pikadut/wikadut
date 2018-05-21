<div class="wrapper wrapper-content animated fadeInRight">
<form method="post" action="<?php echo site_url($controller_name."/submit_add_kat_jasa");?>"  class="form-horizontal">

  <?php //echo buttonsubmit('commodity/katalog/katalog_jasa') ?>

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
				<label class="col-sm-2 control-label">Grup Level 1 *</label>
				<div class="col-sm-10">
					<select required class="form-control select2" style="width:100%;" data-no = "<?php echo $i ?>" name="group_level1_inp[<?php echo $i ?>]">
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-2 control-label">Grup Level 2 *</label>
				<div class="col-sm-10">
					<select required class="form-control select2" style="width:100%;" data-no = "<?php echo $i ?>" name="group_level2_inp[<?php echo $i ?>]">
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-2 control-label">Grup Level 3 *</label>
				<div class="col-sm-10">
					<select required class="form-control select2" style="width:100%;" data-no = "<?php echo $i ?>" name="group_level3_inp[<?php echo $i ?>]">
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-2 control-label">Grup Level 4 *</label>
				<div class="col-sm-10">
					<select required class="form-control select2" style="width:100%;" data-no = "<?php echo $i ?>" name="group_level4_inp[<?php echo $i ?>]">
					</select>
				</div>
			</div>

             <?php $curval = set_value("code_inp[$i]"); ?>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('code') ?></label>
            <div class="col-sm-10">
              <p class="form-control-static">Otomatis</p>
            </div>
          </div>

            <?php $curval = set_value("info_inp[$i]"); ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Nama Jasa *</label>
              <div class="col-sm-10">
                <textarea required name="info_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
              </div>
            </div>
			
			<?php $curval = set_value("tipe_inp[$i]"); ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Tipe</label>
              <div class="col-sm-10">
                <textarea name="tipe_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
              </div>
            </div>
			
			<?php $curval = set_value("lokasi_inp[$i]"); ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Lokasi</label>
              <div class="col-sm-10">
                <textarea name="lokasi_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
              </div>
            </div>
			
			<?php $curval = set_value("uraian_inp[$i]"); ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Atribut Lainnya</label>
              <div class="col-sm-10">
                <textarea name="uraian_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

    <?php include(VIEWPATH."/comment_v.php") ?>

    <?php } ?>

<?php echo buttonsubmit('commodity/katalog/katalog_jasa',lang('back'),lang('save')) ?>

  </form>

  </div>
  
  <script type="text/javascript">

  $(function () {
	  
	  $.ajax({
          url:"<?php echo site_url('Commodity/dropdown_grup_jasa?level=1') ?>",
          type:"get",
		  dataType:"json",
		  success: function(data) {
				$("select[name*='group_level1_inp']").append("<option value=''><?php echo lang('choose') ?></option>");
            $.each(data, function(index, row) {
				$("select[name*='group_level1_inp']").append("<option value='"+row.srv_group_code+"'>"+row.srv_group_code+" - "+row.srv_group_name+"</option>");
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
				url:"<?php echo site_url('Commodity/dropdown_grup_jasa?parent='); ?>"+$("select[name='group_level1_inp["+no+"]']").val(),
				type:"get",
				dataType:"json",
				success: function(data) {
					$("select[name='group_level2_inp["+no+"]']").append("<option value=''><?php echo lang('choose') ?></option>");
				$.each(data, function(index, row) {
					$("select[name='group_level2_inp["+no+"]']").append("<option value='"+row.srv_group_code+"'>"+row.srv_group_code+" - "+row.srv_group_name+"</option>");
				});
				
				loadLevel3AndBelow(no);
				}
			});		
	}
function loadLevel3AndBelow(no){
	$.ajax({
				url:"<?php echo site_url('Commodity/dropdown_grup_jasa?parent=') ?>"+$("select[name='group_level2_inp["+no+"]']").val(),
				type:"get",
				dataType:"json",
				success: function(data) {
					$("select[name='group_level3_inp["+no+"]']").append("<option value=''><?php echo lang('choose') ?></option>");
				$.each(data, function(index, row) {
					$("select[name='group_level3_inp["+no+"]']").append("<option value='"+row.srv_group_code+"'>"+row.srv_group_code+" - "+row.srv_group_name+"</option>");
				});
				
				loadLevel4(no);
				}
			});
}
function loadLevel4(no){
	$.ajax({
				url:"<?php echo site_url('Commodity/dropdown_grup_jasa?parent=') ?>"+$("select[name='group_level3_inp["+no+"]']").val(),
				type:"get",
				dataType:"json",
				success: function(data) {
					$("select[name='group_level4_inp["+no+"]']").append("<option value=''><?php echo lang('choose') ?></option>");
				$.each(data, function(index, row) {
					$("select[name='group_level4_inp["+no+"]']").append("<option value='"+row.srv_group_code+"'>"+row.srv_group_code+" - "+row.srv_group_name+"</option>");
				});
				
				}
			});
}

</script>