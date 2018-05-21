<div class="wrapper wrapper-content animated fadeInRight">
	<form method="post" action="<?php echo site_url($controller_name."/submit_edit_employee_type");?>" class="form-horizontal">

		<input type="hidden" name="id" value="<?php echo $id ?>">

		<div class="row">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Ubah Tipe Pegawai</h5>
						<div class="ibox-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-up"></i>
							</a>
						</div>
					</div>

					<div class="ibox-content">

						<?php $curval = $data["employee_type_name"]; ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Employee Type Name</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="employee_type_name_emptype_inp" maxlength="100" name="employee_type_name_emptype_inp" value="<?php echo $curval ?>">
							</div>
						</div>
						
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12">
				<div style="margin-bottom: 60px;">
					<?php echo buttonsubmit('administration/master_data/employee_type',lang('back'),lang('save')) ?>
				</div>
			</div>
		</div>

	</form>
</div>