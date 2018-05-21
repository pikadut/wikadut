<div class="wrapper wrapper-content animated fadeInRight">
	<form method="post" action="<?php echo site_url($controller_name."/submit_edit_aktivasi_commodity_vendor");?>" class="form-horizontal">

		<input type="hidden" name="id" value="<?php echo $id ?>">

		<div class="row">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Aktifkan Vendor</h5>
						<div class="ibox-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-up"></i>
							</a>
						</div>
					</div>

					<div class="ibox-content">

						<?php $curval = $data["vendor_name"]; ?>
						<div class="form-group">
							<label class="col-sm-3 control-label">Nama Vendor</label>
							<div class="col-sm-9">
								<p class="form-control-static" id="vendor_name_inp"><a href="<?php echo site_url('vendor/daftar_vendor/lihat_detail_vendor/'.$data['vendor_id']) ?>" target="_blank"><?php echo $curval ?></a></p>
							</div>
						</div>

						<?php $curval = $data_commodity["group_type"]; ?>
						<div class="form-group">
							<label class="col-sm-3 control-label">Commodity</label>
							<div class="col-sm-9">
								<p class="form-control-static" id="vendor_name_inp"><?php echo $curval ?></p>
							</div>
						</div>

						<?php $curval = $data_commodity["group_name"]; ?>
						<div class="form-group">
							<label class="col-sm-3 control-label">Commodity</label>
							<div class="col-sm-9">
								<p class="form-control-static" id="vendor_name_inp"><?php echo $curval ?></p>
							</div>
						</div>

						<?php $curval = $data["address_street"]; ?>
						<div class="form-group">
							<label class="col-sm-3 control-label">Alamat</label>
							<div class="col-sm-9">
								<p class="form-control-static" id="address_street_inp"><?php echo $curval ?></p>
							</div>
						</div>

						<?php $curval = $data["reg_isactivate"]; ?>
						<div class="form-group">
							<label class="col-md-3 control-label">Status</label>
							<div class="col-md-2">
								<select class="form-control" name="reg_isactivate_inp">
									<option value="" readonly>--Pilih--</option>
									<?php $pilihan=array(
										'0' => 'Non Aktif',
										'1' => 'Aktif',
										);
									foreach($pilihan as $key => $val){
										$selected = ($key == $curval) ? "selected" : ""; 
										?>
										<option <?php echo $selected ?> value="<?php echo $key ?>"><?php echo $val ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-12">
					<div style="margin-bottom: 60px;">
						<?php echo buttonsubmit('vendor/vendor_tools/aktivasi_vendor',lang('back'),lang('save')) ?>
					</div>
				</div>
			</div>

		</form>

	
	</div>