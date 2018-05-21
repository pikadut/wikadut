<?php if(isset($content)){
	$modes = "disabled";
}
else{
	$modes = "";
}
?>
<div class="wrapper wrapper-content animated fadeIn">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<?php if(!isset($content)) { ?>
					<h5>Form Sanggahan</h5>
					<?php }
					else { ?>
					<h5>Detail Sanggahan</h5>
					<?php } ?>
				</div>
				<div class="ibox-content">
					<form role="form" enctype='multipart/form-data' method="POST" action="<?php echo site_url('pengadaan/inputsanggah') ?>" class="form-horizontal">
						<?php if(!isset($content)) { ?>
						<div class="form-group"><label class="col-sm-2 control-label">Nomor Pengadaan</label>
							<div class="col-lg-6 m-l-n"><select name="nopengadaan" id="nopengadaan" class="form-control m-b" name="account" required>
								<option value="">--PILIH--</option>
								<?php foreach($list as $row) { ?>
								<option value="<?php echo $row["ptm_number"] ?>"><?php echo $row["ptm_number"]." - ".$row["ptm_subject_of_work"] ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<?php }
					else {
						?>
						<div class="form-group"><label class="col-sm-2 control-label">Nomor Pengadaan</label>
							<div class="col-lg-6 m-l-n"><input <?php echo $modes; ?> value="<?php if(isset($content)) { echo $content["ptm_number"]; } ?>" type="text" name="nopengadaan" id="nopengadaan" class="form-control"></div></div>
							<?php } ?>
							<div class="form-group"><label class="col-sm-2 control-label">Judul Sanggahan</label>
								<div class="col-lg-6 m-l-n"><input value="<?php if(isset($content)) { echo $content["pcl_title"]; } ?>" <?php echo $modes; ?> type="text" name="judul" id="judul" class="form-control" maxlength="1024" required></div>
							</div>
							<div class="form-group"><label class="col-sm-2 control-label">Isi Sanggahan</label>
								<div class="col-lg-6 m-l-n"><textarea <?php echo $modes; ?> name="isi" id="isi" class="form-control" required><?php if(isset($content)) { echo $content["pcl_reason"]; } ?></textarea></div>
							</div>
							<div class="form-group"><label class="col-sm-2 control-label">Bukti Pendukung</label>
								<div class="col-lg-6 m-l-n"><input <?php echo $modes; ?> value="<?php if(isset($content)) { echo $content["pcl_supporting_text"]; } ?>" type="text" name="pendukung" id="pendukung" class="form-control" maxlength="4096"></div>
							</div>
							<?php if(!isset($content)) { ?>
							<div class="form-group"><label class="col-sm-2 control-label">Bukti Lampiran</label>
								<div class="col-lg-6 m-l-n"><input <?php echo $modes; ?> id="lampiran_sanggah" name="lampiran_sanggah" type="file" class="file"></div>
							</div>
							<?php }
							else {?>
							<div class="form-group"><label class="col-sm-2 control-label">Bukti Lampiran</label>
								<div class="col-lg-6 m-l-n">
									<p class="form-control-static">
										<a target="_blank" href="<?php echo site_url('log/download_attachment_extranet/sanggah/'.$content['pcl_vendor_id'].'/'.$content['pcl_supporting_att']) ?>">
											<?php echo $content["pcl_supporting_att"] ?>
										</a>
									</p>
								</div>
							</div>
							<?php } ?>
							<div class="hr-line-dashed"></div>
							<div class="form-group"><label class="col-sm-2 control-label">Bank Penjamin</label>
								<div class="col-lg-6 m-l-n"><input <?php echo $modes; ?> value="<?php if(isset($content)) { echo $content["pcl_jam_bank"]; } ?>" type="text" class="form-control" name="bank" id="bank" maxlength="250" required></div>
							</div>
							<div class="form-group"><label class="col-sm-2 control-label">Nomor Jaminan</label>
								<div class="col-lg-6 m-l-n"><input <?php echo $modes; ?> value="<?php if(isset($content)) { echo $content["pcl_jam_number"]; } ?>" type="text" class="form-control" name="nomorjaminan" id="nomorjaminan" maxlength="50" required></div>
							</div>
							<div class="form-group" id="mulai"><label class="col-sm-2 control-label">Mulai Berlaku</label>
								<div class="col-md-4 m-l-n">
									<p class="form-control-static"><?php echo date(DEFAULT_FORMAT_DATE,strtotime($content["pcl_jam_start_date"])) ?></p>
								</div>
							</div>
							<div class="form-group" id="selesai"><label class="col-sm-2 control-label">Berlaku Sampai</label>
								<div class="col-md-4 m-l-n">
									<p class="form-control-static"><?php echo date(DEFAULT_FORMAT_DATE,strtotime($content["pcl_jam_end_date"])) ?></p>
								</div>
							</div>
							<div class="form-group"><label class="col-sm-2 control-label">Nilai Jaminan</label>
								<div class="col-lg-6 m-l-n"><input <?php echo $modes; ?> value="<?php if(isset($content)) { echo number_format($content["pcl_jam_amount"], 2, '.', ','); } ?>" type="text" name="nilaijaminan" id="nilaijaminan" class="form-control" required></div>
							</div>
							<?php if(!isset($content)) { ?>
							<div class="hr-line-dashed"></div>
							<div class="form-group">
								<div class="col-sm-4 col-sm-offset-2">
									<button class="btn btn-primary" type="submit">Submit</button>
									<button class="btn btn-white" type="submit">Cancel</button>
								</div>
							</div>
							<?php }
							else { ?>
							<div class="hr-line-dashed"></div>
							<div class="form-group"><label class="col-sm-2 control-label">Judul Jawaban</label>
								<div class="col-lg-6 m-l-n"><input value="<?php if(isset($content)) { echo $content["pcl_jwb_judul"]; } ?>" <?php echo $modes; ?> type="text" name="judul" id="judul" class="form-control" maxlength="1024" required></div>
							</div>
							<div class="form-group"><label class="col-sm-2 control-label">Nomor Jawaban</label>
								<div class="col-lg-6 m-l-n"><input value="<?php if(isset($content)) { echo $content["pcl_jwb_no"]; } ?>" <?php echo $modes; ?> type="text" name="judul" id="judul" class="form-control" maxlength="1024" required></div>
							</div>
							<div class="form-group"><label class="col-sm-2 control-label">Isi Jawaban</label>
								<div class="col-lg-6 m-l-n"><textarea <?php echo $modes; ?> name="isi" id="isi" class="form-control" required><?php if(isset($content)) { echo $content["pcl_jwb_isi"]; } ?></textarea></div>
							</div>
							<div class="form-group"><label class="col-sm-2 control-label">Lampiran Jawaban</label>
								<div class="col-lg-6 m-l-n">
									<p class="form-control-static">
										<a href="<?php echo site_url('log/download_attachment/procurement/'.$content['pcl_jwb_attachment']) ?>" target="_blank">
											<?php echo $content["pcl_jwb_attachment"] ?>
										</a>
									</p>
								</div>
							</div>
							<div class="form-group"><label class="col-sm-2 control-label">Status Jawaban</label>
								<div class="col-lg-6 m-l-n">
									<p class="form-control-static"><?php echo ($content["pcl_status"]) ?></p>
								</div>
							</div>
							<?php } ?>
						</form>		
					</div>
				</div>
			</div>
		</div>
	</div>

	<script src="<?php echo base_url('assets/js/custom.js') ?>"></script>