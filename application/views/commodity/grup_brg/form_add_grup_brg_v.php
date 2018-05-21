<div class="wrapper wrapper-content animated fadeInRight">
<form method="post" action="<?php echo site_url($controller_name."/submit_add_grup_brg");?>"  class="form-horizontal">

  <?php //echo buttonsubmit('commodity/katalog/grup_barang') ?>

  <input type="hidden" name="jumlah" value="<?php echo $jumlah ?>">
  
  <?php for ($i=0; $i < $jumlah; $i++) { ?>

  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Form Tambah Grup Barang</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>
          </div>
        </div>
        <div class="ibox-content">
		
			<div class="form-group">
				<label class="col-sm-2 control-label">Level 1 *</label>
				<div class="col-sm-10">
					<select class="form-control" id="level_1">
					</select>
				</div>
			</div>

			<div class="form-group">
				<label class="col-sm-2 control-label">Level 2 *</label>
				<div class="col-sm-10">
					<select class="form-control" name="level2_inp[<?php echo $i ?>]" id="level_2">
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<label class="col-sm-2 control-label">Level 3</label>
				<div class="col-sm-10">
					<select class="form-control" name="level3_inp[<?php echo $i ?>]" id="level_3">
					</select>
				</div>
			</div>

          <?php $curval = set_value("name_inp[$i]"); ?>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('name') ?> *</label>
            <div class="col-sm-10">
            <textarea class="form-control" required name="name_inp[<?php echo $i ?>]"><?php echo $curval ?></textarea>
           </div>
         </div>

        </div>
      </div>
    </div>
  </div>

  <?php } ?>

  <?php echo buttonsubmit('commodity/katalog/grup_barang',lang('back'),lang('save')) ?>

</form>

</div>

  <script type="text/javascript">

    $(function () {
		
		$.ajax({
          url:"<?php echo site_url('Commodity/dropdown_grup_brg?level=1') ?>",
          type:"get",
		  dataType:"json",
		  success: function(data) {
            $.each(data, function(index, row) {
				$("#level_1").append("<option value='"+row.mat_group_code+"'>"+row.mat_group_code+" - "+row.mat_group_name+"</option>");
			});
			
			loadLevel2AndBelow();
          }
        });
	  
	  $("#level_1").change(function(){
		$("#level_2").html("");
		$("#level_3").html("");
		loadLevel2AndBelow();  
	  });
	  
	  $("#level_2").change(function(){
		$("#level_3").html("");
		loadLevel3AndBelow();  
	  });
	  
	  $("#level_3").change(function(){
		refreshDatatable();
	  });

    });

	function loadLevel2AndBelow(){
		$.ajax({
				url:"<?php echo site_url('Commodity/dropdown_grup_brg?parent='); ?>"+$("#level_1").val(),
				type:"get",
				dataType:"json",
				success: function(data) {
				$.each(data, function(index, row) {
					$("#level_2").append("<option value='"+row.mat_group_code+"'>"+row.mat_group_code+" - "+row.mat_group_name+"</option>");
				});
				
				loadLevel3AndBelow();
				}
			});		
	}
	function loadLevel3AndBelow(){
		$.ajax({
					url:"<?php echo site_url('Commodity/dropdown_grup_brg?parent=') ?>"+$("#level_2").val(),
					type:"get",
					dataType:"json",
					success: function(data) {
					$("#level_3").append("<option value=''>--PILIH-- (Kosongkan Jika Ingin Menambah Group Level 3)</option>");
					$.each(data, function(index, row) {
					$("#level_3").append("<option value='"+row.mat_group_code+"'>"+row.mat_group_code+" - "+row.mat_group_name+"</option>");
					});
					
					}
				});
	}

  </script>