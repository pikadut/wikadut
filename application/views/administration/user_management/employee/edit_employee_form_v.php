<div class="wrapper wrapper-content">
	<form method="post" action="<?php echo site_url($controller_name."/submit_edit_employee");?>" class="form-horizontal">

		<input type="hidden" name="id" value="<?php echo $id ?>">

		<div class="row">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Ubah Employee</h5>
						<div class="ibox-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-up"></i>
							</a>
						</div>
					</div>

					<div class="ibox-content">


						<?php $curval = $data['npp'];?>
						<div class="form-group">
							<label class="col-sm-2 control-label">NPP</label>
							<div class="col-sm-10">
								<input type="text" class="form-control" id="npp_employee_inp" name="npp_employee_inp" value="<?php echo $curval ?>">
							</div>
						</div>

						<?php $curval = $data["adm_salutation_id"]; ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Salutation</label>
							<div class="col-sm-2">
								<select required class="form-control" name="salutation_employee_inp">
									<option value="">Pilih</option>
									<?php 
									foreach($salutation as $key => $val){
										$selected = ($val['adm_salutation_id'] == $curval) ? "selected" : ""; 
										?>
										<option <?php echo $selected ?> value="<?php echo $val['adm_salutation_id'] ?>"><?php echo $val['adm_salutation_name'] ?></option>
										<?php } ?>
									</select>
								</div>
							</div>

							<?php $curval = $data["firstname"]; ?>
							<div class="form-group">
								<label class="col-sm-2 control-label">Nama Depan</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" required name="firstname_employee_inp" value="<?php echo $curval ?>">
								</div>
							</div>

							<?php $curval = $data["lastname"]; ?>
							<div class="form-group">
								<label class="col-sm-2 control-label">Nama Belakang</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="lastname_employee_inp" value="<?php echo $curval ?>">
								</div>
							</div>

							<?php $curval = $data["phone"]; ?>
							<div class="form-group">
								<label class="col-sm-2 control-label">Telepon</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" name="phone_employee_inp" value="<?php echo $curval ?>">
								</div>
							</div>

							<?php $curval = $data["status"]; ?>
							<div class="form-group">
								<label class="col-sm-2 control-label">Status</label>
								<div class="col-sm-3">
									<select required class="form-control" name="status_inp">
										<?php $selected = ($curval == 1) ? "selected" : ""; ?>
										<option <?php echo $selected ?> value="1">Aktif</option>
										<?php $selected = ($curval == 0) ? "selected" : ""; ?>
										<option <?php echo $selected ?> value="0">Nonaktif</option>
									</select>
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
							<h5>Company Information</h5>
							<div class="ibox-tools">
								<a class="collapse-link">
									<i class="fa fa-chevron-up"></i>
								</a>
							</div>
						</div>
						<div class="ibox-content">

							<?php $curval = $data["email"]; ?>
							<div class="form-group">
								<label class="col-sm-2 control-label">Email Address</label>
								<div class="col-sm-10">
									<input type="email" class="form-control" id="email_employee_inp" name="email_employee_inp" value="<?php echo $curval ?>">
								</div>
							</div>

							<?php $curval = $data["officeextension"]; ?>
							<div class="form-group">
								<label class="col-sm-2 control-label">Office Extention</label>
								<div class="col-sm-10">
									<input type="text" class="form-control" id="offc_ext_employee_inp" name="offc_ext_employee_inp" value="<?php echo $curval ?>">
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div style="margin-bottom: 60px;">
						<?php echo buttonsubmit('administration/user_management/employee',lang('back'),lang('save')) ?>
					</div>
				</div>
			</div>
		</form>
	</div>