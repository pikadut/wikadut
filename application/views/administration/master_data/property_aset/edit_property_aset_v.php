<div class="wrapper wrapper-content animated fadeInRight">
	<form method="post" action="<?php echo site_url($controller_name."/submit_edit_property_aset");?>" class="form-horizontal">

		<input type="hidden" name="id" value="<?php echo $id ?>">

		<div class="row">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Form</h5>
						<div class="ibox-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-up"></i>
							</a>
						</div>
					</div>

					<div class="ibox-content">

						<?php $curval = $data["name_pa"]; ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Nama</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="name_inp" name="name_inp" value="<?php echo $curval ?>">
							</div>
						</div>

						<?php $curval = $data['desc_pa']; ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Deskripsi</label>
							<div class="col-sm-6">
								<textarea class="form-control" id="desc_inp" name="desc_inp"><?php echo $curval ?></textarea>
							</div>
						</div> 

						<?php $curval = $data['commodity_pa']; ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Tipe</label>
							<div class="col-sm-3">
								<select required class="form-control" name="commodity_inp">
									<option value="">Pilih</option>
									<?php 
									foreach($komoditi_type as $key => $val){
										$selected = ($key == $curval) ? "selected" : ""; 
										?>
										<option <?php echo $selected ?> value="<?php echo $val ?>"><?php echo $val ?></option>
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