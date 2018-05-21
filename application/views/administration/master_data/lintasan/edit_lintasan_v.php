<div class="wrapper wrapper-content animated fadeInRight">
	<form method="post" action="<?php echo site_url($controller_name."/submit_edit_lintasan");?>" class="form-horizontal">

		<input type="hidden" name="id" value="<?php echo $id ?>">

		<div class="row">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Ubah Lintasan</h5>
						<div class="ibox-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-up"></i>
							</a>
						</div>
					</div>

					<div class="ibox-content">

						<?php $curval = $data["lane_code"]; ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Kode</label>
							<div class="col-sm-4">
								<input type="text" class="form-control" id="lane_code_divbirnit_inp" maxlength="50" name="lane_code_divbirnit_inp" value="<?php echo $curval ?>">
							</div>
						</div>

						<?php $curval = $data["district_id"]; ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Cabang</label>
							<div class="col-sm-4">
								<select required class="form-control" name="district_inp" id="district">
									<option value="">Pilih</option>
									<?php 
									foreach($dist_name as $key => $val){
										$selected = ($val['district_id'] == $curval) ? "selected" : ""; 
										?>
										<option <?php echo $selected ?> value="<?php echo $val['district_id'] ?>"><?php echo $val['district_name'] ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							
						<?php $curval = $data["origin_lane"]; ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Asal</label>
							<div class="col-sm-4">
								<select required class="form-control filter" name="origin_lane_inp">
									<option value="">Pilih</option>
									<?php 
									foreach($dept_name as $key => $val){
										$selected = ($val['dept_id'] == $curval) ? "selected" : ""; 
										?>
										<option <?php echo $selected ?> value="<?php echo $val['dept_id'] ?>"><?php echo $val['dep_code'].' - '.$val['dept_name'] ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
							
							<?php $curval = $data["destination_lane"]; ?>
						<div class="form-group">
							<label class="col-sm-2 control-label">Tujuan</label>
							<div class="col-sm-4">
								<select required class="form-control filter" name="destination_lane_inp">
									<option value="">Pilih</option>
									<?php 
									foreach($dept_name as $key => $val){
										$selected = ($val['dept_id'] == $curval) ? "selected" : ""; 
										?>
										<option <?php echo $selected ?> value="<?php echo $val['dept_id'] ?>"><?php echo $val['dep_code'].' - '.$val['dept_name'] ?></option>
										<?php } ?>
									</select>
								</div>
							</div>
<!-- tambah style="visibility:hidden" -shan -->
							<?php $curval = $data["roundtrip_type"]; ?>
							<div class="form-group">
								<label class="col-sm-2 control-label">Pulang-Pergi</label>
								<div class="col-sm-2">
									<select style="visibility: hidden" required class="form-control" name="tipe_inp">
										<?php 
										foreach($tipe_list as $key => $val){
											$selected = ($key == $curval) ? "selected" : ""; ?>
											<option <?php echo $selected ?> value="<?php echo $key ?>"><?php echo $val ?></option>
											<?php } ?>
										</select>
									</div>
								</div>
								
							
              <?php $curval = $data["lane_active"]; ?>
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

				<div class="row">
					<div class="col-md-12">
						<div style="margin-bottom: 60px;">
							<?php echo buttonsubmit('administration/master_data/lintasan',lang('back'),lang('save')) ?>
						</div>
					</div>
				</div>

			</form>
		</div>
		

<script type="text/javascript">
var $drops = $('.filter'),
    $options = $drops.eq(1).children().clone();

$drops.change(function(){
    var $other = $drops.not(this),
        otherVal = $other.val(),
        newVal = $(this).val(),
        $opts = $options.clone().filter(function(){
           return this.value !== newVal; 
        })
     $other.html($opts).val(otherVal);
})
</script>