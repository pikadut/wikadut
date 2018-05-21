<div class="wrapper wrapper-content animated fadeInRight" ng-controller="form_gudang">
	<form method="post" action="<?php echo site_url($controller_name."/submit_edit_gudang");?>" class="form-horizontal" novalidate>

		<input type="hidden" name="id" value="<?php echo $id ?>">

		<div class="row">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Ubah Gudang</h5>
						<div class="ibox-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-up"></i>
							</a>
						</div>
					</div>

					<div class="ibox-content">

						<?php $curval = $data["code_war"]; ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Kode Gudang</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="code_inp" name="code_inp" maxlength="5" value="<?php echo $curval ?>">
							</div>
						</div>

						<?php $curval = $data["name_war"]; ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Nama Gudang</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="name_inp" name="name_inp" value="<?php echo $curval ?>">
							</div>
						</div>

						<?php $curval = $data['location_war']; ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Lokasi Gudang</label>
							<div class="col-sm-6">
								<textarea class="form-control" id="lokasi_inp" name="lokasi_inp"><?php echo $curval ?></textarea>
							</div>
						</div> 

						<?php $curval = $data['type_war']; ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Tipe Gudang</label>
							<div class="col-sm-3">
								<select required class="form-control" ng-init="tipe='<?php echo $curval ?>'" ng-model="tipe" name="tipe_inp">
									<option value="">Pilih</option>
									<?php 
									foreach($gudang_type as $key => $val){
										$selected = ($key == $curval) ? "selected" : ""; 
										?>
										<option <?php echo $selected ?> value="<?php echo $key ?>"><?php echo $val ?></option>
										<?php } ?>
									</select>
								</div>
							</div> 

							<?php $curval = $data['ref_war']; ?>
							<div class="form-group" ng-show="tipe == 0">
								<label class="col-sm-2 control-label">Kantor</label>
								<div class="col-sm-8">
									<select required class="form-control select2" name="district_inp">
										<option value="">Pilih</option>
										<?php foreach($office as $key => $val){
											$selected = ($val['district_id'] == $curval) ? "selected" : ""; ?>
											<option <?php echo $selected ?> value="<?php echo $val['district_id'] ?>">
												<?php echo $val['district_code'] ?> - <?php echo $val['district_name'] ?>
											</option>
											<?php } ?>
										</select>
									</div>
								</div>  

								<?php $curval = $data['ref_war']; ?>
								<div class="form-group" ng-show="tipe == 1">
									<label class="col-sm-2 control-label">Kapal</label>
									<div class="col-sm-8">
										<select required class="form-control select2" name="ship_inp">
											<option value="">Pilih</option>
											<?php foreach($ship as $key => $val){
												$selected = ($val['id_ship'] == $curval) ? "selected" : ""; ?>
												<option <?php echo $selected ?> value="<?php echo $val['id_ship'] ?>">
													<?php echo $val['code_ship'] ?> - <?php echo $val['name_ship'] ?> (<?php echo $val['district_name'] ?>)
												</option>
												<?php } ?>
											</select>
										</div>
									</div>  

								</div>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div style="margin-bottom: 60px;">
								<?php echo buttonsubmit('administration/master_data/gudang',lang('back'),lang('save')) ?>
							</div>
						</div>
					</div>

				</form>
			</div>