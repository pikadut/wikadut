<div class="wrapper wrapper-content animated fadeInRight">
	<form method="post" action="<?php echo site_url($controller_name."/submit_edit_anggaran");?>" class="form-horizontal">

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

						<?php $curval = $data['code_cc']; ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Kode Anggaran</label>
							<div class="col-sm-3">
								<input type="text" readonly class="form-control" id="code_inp" maxlength="12" name="code_inp" value="<?php echo $curval ?>">
							</div>
						</div>

						<?php $curval = $data['name_cc']; ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Nama Anggaran</label>
							<div class="col-sm-8">
								<input type="text" readonly class="form-control" id="name_inp" maxlength="255" name="name_inp" value="<?php echo $curval ?>">
							</div>
						</div>

						<?php $curval = $data['subcode_cc']; ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Kode Sub Anggaran</label>
							<div class="col-sm-4">
								<input type="text" maxlength="50" class="form-control" id="subcode_inp" maxlength="50" name="subcode_inp" value="<?php echo $curval ?>">
							</div>
						</div>

						<?php $curval = $data['subname_cc']; ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Nama Sub Anggaran</label>
							<div class="col-sm-8">
								<input type="text" class="form-control" id="subname_inp" maxlength="255" name="subname_inp" value="<?php echo $curval ?>">
							</div>
						</div> 

						<?php /* $curval = $data['allocation_cc']; ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Alokasi</label>
							<div class="col-sm-3">
								<input type="text" class="form-control money" id="allocation_inp" name="allocation_inp" value="<?php echo $curval ?>">
							</div>
						</div>
						

						<?php $curval = $data['year_cc']; ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Tahun Anggaran</label>
							<div class="col-sm-2">

								<select name="year_inp" class="form-control">
									<?php for ($i=date("Y"); $i <= date("Y")+5; $i++) { ?>
									<option value="<?php echo $i ?>"><?php echo $i ?></option>
									<?php } ?>
								</select>

							</div>
						</div> 

						<?php /* $curval = $data['dept_cc']; ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Departemen</label>
							<div class="col-sm-5">
								<select required class="form-control select2" name="dept_inp">
									<option value="">Pilih</option>
									<?php 
									foreach($dept as $key => $val){
										$selected = ($val['dept_id'] == $curval) ? "selected" : ""; 
										?>
										<option <?php echo $selected ?> value="<?php echo $val['dept_id'] ?>"><?php echo $val['dept_name'] ?></option>
										<?php } ?>
									</select>
								</div>
							</div>

							*/ ?>

						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div style="margin-bottom: 60px;">
						<?php echo buttonsubmit('administration/master_data/anggaran',lang('back'),lang('save')) ?>
					</div>
				</div>
			</div>

		</form>
	</div>