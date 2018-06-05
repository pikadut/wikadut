<div class="wrapper wrapper-content animated fadeInRight">
	<form method="post" action="<?php echo site_url($controller_name."/submit_edit_proyek");?>" class="form-horizontal">

		<input type="hidden" name="id" value="<?php echo $id ?>">
		
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Ubah Form</h5>
						<div class="ibox-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-up"></i>
							</a>
						</div>
					</div>

					<div class="ibox-content">

						<?php $curval = $data['project_name']; ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Nama Proyek</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" required name="project_name_inp" value="<?php echo $curval ?>">
							</div>
						</div>

						<?php $curval = $data['description']; ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Deskripsi</label>
							<div class="col-sm-8">
				              <textarea class="form-control" name="desc_inp" required><?=$curval?></textarea>
				            </div>
						</div>

						<?php $curval = $data['date_start']; ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Tanggal Mulai</label>
							<div class="col-sm-4">
								<input type="text" required class="form-control datepicker"  name="date_start_inp" value="<?php echo $curval ?>">
							</div>
						</div>

						<?php $curval = $data['date_end']; ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Tanggal Akhir</label>
							<div class="col-sm-4">
								<input type="text" class="form-control datepicker" name="date_end_inp" value="<?php echo $curval ?>">
							</div>
						</div> 

						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div style="margin-bottom: 60px;">
						<?php echo buttonsubmit('administration/master_data/proyek',lang('back'),lang('save')) ?>
					</div>
				</div>
			</div>

		</form>
	</div>

<script type="text/javascript">
  $(document).ready(function(){
    $( ".datepicker" ).datepicker();
  })
</script>