<div class="wrapper wrapper-content animated fadeInRight">
<form method="post" action="<?php echo site_url($controller_name."/submit_job_post");?>" class="form-horizontal">
		<div class="row">
		<input type="hidden" name="employee_id" value="<?php echo $employee_id ?>">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Position Details</h5>
						<div class="ibox-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
					<div class="ibox-content">

						<?php $curval = set_value("pos_id_inp"); ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Job Position</label>
							<div class="col-sm-6">
								<select class="form-control select2" name="pos_id_inp">
									<?php foreach ($job_pos as $key => $value) { 
										$selected = ($val['pos_id'] == $curval) ? "selected" : ""; 
										?>
									<option <?php echo $selected ?> value="<?php echo $value['pos_id'] ?>"><?php echo $value['pos_name'] ?></option>
									<?php } ?>
								</select>
							</div>
						</div>

						<?php $curval = set_value("is_active_inp"); ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Is Active ?</label>
							<div class="col-sm-10">
								<div class="checkbox">
									<label>
										<?php $selected = (1 == $curval) ? "checked" : "";  ?>
										<input type="checkbox" <?php echo $selected ?> name="is_active_inp" value="1"> Yes
									</label>
								</div>
							</div>
						</div>

						<?php $curval = set_value("is_main_job_inp"); ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Is Main Job ?</label>
							<div class="col-sm-10">
								<div class="checkbox">
									<label>
										<?php $selected = (1 == $curval) ? "checked" : "";  ?>
										<input type="checkbox" <?php echo $selected ?> name="is_main_job_inp" value="1"> Yes
									</label>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
  <div class="col-md-12">
    <?php echo buttonsubmit('administration/user_management/employee/ubah/'.$employee_id,lang('back'),lang('save')) ?>
    </div>
  </div>
</div>
</form>