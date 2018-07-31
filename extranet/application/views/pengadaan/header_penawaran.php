<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5><?php echo $this->lang->line('Penawaran'); ?></h5>
			</div>
			<div class="ibox-content">
				<form role="form" id="header" method="POST" action="<?php echo site_url($submit_url) ?>" class="form-horizontal">	
					<input type="hidden" id="section" name="section" value="header">
					<input type="hidden" id="pqmid" name="pqmid" value="<?php if(isset($header)){ echo $header["pqm_id"]; } ?>">
					<div class="form-group">
						<label class="col-sm-3 control-label">
							<?php echo $this->lang->line('Nomor Pengadaaan'); ?>
						</label>
						<div class="col-lg-6 m-l-n"><input readonly id="tenderid" name="tenderid" type="text" class="form-control" value="<?php echo $tenderid; ?>"></div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">
							<?php echo $this->lang->line('Nomor Penawaran'); ?>
						</label>
						<div class="col-lg-6 m-l-n"><input <?php echo $readonly ?> id="nopenawaran" name="nopenawaran" type="text" class="form-control" value="<?php if(isset($header)){ echo $header["pqm_number"]; } ?>" required></div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">
							<?php echo $this->lang->line('Tipe Penawaran'); ?>	
						</label>
						<div class="col-md-2 m-l-n">
							<select <?php echo $readonly ?> class="form-control" name="tipepenawaran" id="tipepenawaran" required>
								<option value="">--<?php echo $this->lang->line('Pilih'); ?>--</option>
								<?php 
								$ptp_quo_type = array("A");
								if(substr($prep['ptp_quo_type'], 1,1) == 1){
									$ptp_quo_type[] = "B";
								}
								if(substr($prep['ptp_quo_type'], 2,1) == 1){
									$ptp_quo_type[] = "C";
								}
								foreach ($ptp_quo_type as $key => $value) { 
									$v = (isset($header["pqm_type"])) ? $header["pqm_type"] : "";
									?>
									<option value="<?php echo $value ?>" <?php echo ($v == $value) ? "selected" : "" ?> >
										<?php echo $this->lang->line('Tipe'); ?> <?php echo $value ?>
									</option>
									<?php } ?>

								</select>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label">
								<?php echo $this->lang->line('Kandungan Lokal'); ?>
							</label>
							<div class="col-md-2 m-l-n"><input <?php echo $readonly ?> id="kandunganlokal" name="kandunganlokal" placeholder="%" type="number" min="0" max="100" class="form-control" value="<?php if(isset($header)) { echo $header["pqm_local_content"]; } ?>"></div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label">
								Jangka Waktu Garansi/Pemeliharaan
							</label>
							<div class="col-md-2 m-l-n"><input <?php echo $readonly ?> id="garansi_t" name="garansi_t" type="number" class="form-control" required value="<?php echo (isset($header['pqm_guarantee_time'])) ? $header["pqm_guarantee_time"] : "" ?>">
							</div>
							<div class="col-md-2 m-l-n">
								<select <?php echo $readonly ?> class="form-control m-b" name="garansi_u" id="garansi_u" required>
									<?php 
									$curval = (isset($header["pqm_guarantee_unit"])) ? $header["pqm_guarantee_unit"] : "";
									foreach (array("Hari","Bulan","Tahun") as $key => $value) { ?>
									<option <?php echo ($value == $curval) ? "selected" : "" ?> ><?php echo $value ?></option>
									<?php } ?>
								</select>
							</div>
							<?php if(empty($readonly)){ ?>
							<div class="col-md-2 m-l-n">
								<button class="btn btn-primary btn-sm" type="button" id="samakan_garansi">Samakan Semua Item</button>
							</div>
							<?php } ?>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label">
								Jangka Waktu Penyerahan / Pelaksanaan
							</label>
							<div class="col-md-2 m-l-n"><input <?php echo $readonly ?> id="penyerahan_t" name="penyerahan_t" type="number" class="form-control" required value="<?php echo (isset($header['pqm_deliverable_time'])) ? $header["pqm_deliverable_time"] : "" ?>">
							</div>
							<div class="col-md-2 m-l-n">
								<select <?php echo $readonly ?> class="form-control m-b" name="penyerahan_u" id="penyerahan_u" required>
									<?php 
									$curval = (isset($header["pqm_deliverable_unit"])) ? $header["pqm_deliverable_unit"] : "";
									foreach (array("Hari","Bulan","Tahun") as $key => $value) { ?>
									<option <?php echo ($value == $curval) ? "selected" : "" ?> ><?php echo $value ?></option>
									<?php } ?>
								</select>
							</div>
							<?php if(empty($readonly)){ ?>
							<div class="col-md-2 m-l-n">
								<button class="btn btn-primary btn-sm" type="button" id="samakan_penyerahan">Samakan Semua Item</button>
							</div>
							<?php } ?>
						</div>

						<div class="form-group" id="selesai">
							<label class="col-sm-3 control-label">
								<?php echo $this->lang->line('Berlaku Hingga'); ?>
							</label>
							<div class="col-md-4 m-l-n input-group date">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span><input <?php echo $readonly ?> id="berlakuhingga" name="berlakuhingga" type="text" class="form-control" value="<?php if(isset($header)) { echo date("Y-m-d", strtotime($header["pqm_valid_thru"])); } ?>" required>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label">
								<?php echo $this->lang->line('Lampiran Penawaran'); ?> *<small>(Max 10MB)</small>
							</label>
							<div class="col-lg-6 m-l-n">
								<?php if(empty($readonly)){ ?>
								<input <?php echo $readonly ?> id="lampiran_penawaran" name="lampiran_penawaran" type="file" class="file" <?php echo !isset($header) ? 'required' : '' ?> >
								<?php } ?>
								<?php if(isset($header)){ ?>
								<p class="form-control-static">
									<a target="_blank" href="<?php echo site_url('pengadaan/download/penawaran/'.$this->umum->forbidden($this->encryption->encrypt($header["pqm_att_quo"]), 'enkrip')); ?>">
										<?php echo $header["pqm_att_quo"]; ?>
									</a>
								</p>
								<?php } ?>
							</div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">
								<?php echo $this->lang->line('Catatan'); ?>
							</label>
							<div class="col-lg-6 m-l-n"><input <?php echo $readonly ?> id="catatan" name="catatan" type="text" class="form-control" value="<?php if(isset($header)) { echo $header["pqm_notes"]; } ?>"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">
								<?php echo $this->lang->line('Mata Uang'); ?>
							</label>
							<div class="col-md-4 m-l-n">
								<select disabled class="form-control m-b" id="currency">
									<?php foreach($currency as $row) { ?>
									<option value="<?php echo $row["curr_code"] ?>" <?php if(isset($header)) { if(($header["pqm_currency"] == $row["curr_code"])){ echo "selected";} } ?>><?php echo $row["curr_code"]." - ".$row["curr_name"] ?></option>
									<?php } ?>
								</select>
								<input type="hidden" name="currency" value="<?php echo (isset($header)) ? $header["pqm_currency"] : "" ?>">
							</div>
						</div>
					</form>		
				</div>
			</div>
		</div>
	</div>

	<script type="text/javascript">
		
		$(document).ready(function(){

			$("#samakan_garansi").click(function(){

				var unit = $("#garansi_u").val();
				var time = $("#garansi_t").val();

				$(".guarantee_time_item").val(time);
				$(".guarantee_unit_item option:contains('"+unit+"')").prop("selected",true);

			});

			$("#samakan_penyerahan").click(function(){

				var unit = $("#penyerahan_u").val();
				var time = $("#penyerahan_t").val();

				$(".deliverable_time_item").val(time);
				$(".deliverable_unit_item option:contains('"+unit+"')").prop("selected",true);

			});

		});

	</script>