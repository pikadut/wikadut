<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2><?php echo ($viewer) ? "Lihat" : "Form"; ?> BAST Milestone</h2>
	</div>
	<div class="col-lg-2">
		
	</div>
</div>
<form class="form-horizontal" method="post" action="<?php echo site_url('kontrak/submit_bast_milestone') ?>" enctype="multipart/form-data">
	<div class="wrapper wrapper-content animated fadeIn">
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5><?php echo $this->lang->line('Header'); ?></h5>
					</div>
					<div class="ibox-content">

						<div class="form-group">
							<label class="col-sm-2 control-label">
								Nomor Kontrak
							</label>
							<div class="col-lg-6 m-l-n">
								<p class="form-control-static">
									<?php echo $header["contract_number"]; ?>
								</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">
								Judul Kontrak
							</label>
							<div class="col-lg-6 m-l-n">
								<p class="form-control-static">
									<?php echo $header["subject_work"] ?>

								</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">
								Deskripsi Milestone
							</label>
							<div class="col-lg-6 m-l-n">
								<p class="form-control-static">
									<?php echo $header["description"] ?>
								</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">
								Target Milestone
							</label>
							<div class="col-lg-6 m-l-n">
								<p class="form-control-static">
									<?php echo date("d/m/Y",strtotime($header["target_date"])) ?>
								</p>
							</div>
						</div>  

						<div class="form-group">
							<label class="col-sm-2 control-label">
								Presentase Milestone
							</label>
							<div class="col-lg-6 m-l-n">
								<p class="form-control-static">
									<?php echo $header["percentage"] ?> % 

								</p>
							</div>
						</div>

					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Riwayat Progress</h5>
					</div>
					<div class="ibox-content">

						<table class="table table-striped table-bordered table-hover milestone_table">

							<thead>

								<tr>
									<th>No</th>
									<th>Tanggal</th>
									<th>Deskripsi Progress</th>
									<th>Persentase</th>
								</tr>

							</thead>

							<tbody>

								<?php 
								foreach ($item as $key => $value) { ?>

								<tr>
									<td><?php echo $key+1 ?></td>
									<td><?php echo date('d/m/Y',strtotime($value['progress_date'])) ?></td>
									<td><?php echo $value['description'] ?></td>
									<td><?php echo $value['percentage'] ?> %</td>
								</tr>
								
								<?php } ?>

							</tbody>

						</table>

					</div>
				</div>
			</div>
		</div>
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>BASTP/B</h5>
				</div>
				<div class="ibox-content">

					<div class="form-group">
						<label class="col-sm-2 control-label">
							Nomor BASTP/B
						</label>
						<div class="col-lg-6 m-l-n">
							<p class="form-control-static">
								<?php echo (!empty($header['bastp_number'])) ? $header['bastp_number'] : "AUTO NUMBER"; ?>
							</p>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label">
							Tanggal
						</label>
						<div class="col-lg-3 m-l-n">
							<?php if(!$viewer){ ?>
							<input type="date" class="form-control" required name="tgl_bast">
							<?php } else { ?>
							<p class="form-control-static">
								<?php echo (!empty($header['bastp_date'])) ? date("d/m/Y",strtotime($header['bastp_date'])) : ""; ?>
							</p>
							<?php } ?>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label">
							Judul
						</label>
						<div class="col-lg-6 m-l-n">
							<?php if(!$viewer){ ?>
							<input type="text" class="form-control" required name="judul_bast">
							<?php } else { ?>
							<p class="form-control-static">
								<?php echo (!empty($header['bastp_title'])) ? $header['bastp_title'] : ""; ?>
							</p>
							<?php } ?>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label">
							Berita Acara
						</label>
						<div class="col-lg-6 m-l-n">
						<?php if(!$viewer){ ?>
							<textarea name="berita_bast" class="form-control" required></textarea>
							<?php } else { ?>
							<p class="form-control-static">
								<?php echo (!empty($header['bastp_description'])) ? $header['bastp_description'] : ""; ?>
							</p>
							<?php } ?>
							
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label">
							Lampiran
						</label>
						<div class="col-lg-3 m-l-n">
							<?php if(!$viewer){ ?>
							<input type="file" class="form-control" required name="lampiran_bast">
							<?php } else { ?>
							<p class="form-control-static">
								<?php echo (!empty($header['bastp_attachment'])) ? $header['bastp_attachment'] : ""; ?>
							</p>
							<?php } ?>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>

		<div class="row">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>List Komentar</h5>
						<div class="ibox-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
					<div class="ibox-content">

						<table class="table comment milestone_table">
							<thead>
								<tr>
									<th>Tanggal</th>
									<th>Nama</th>
									<th>Tipe</th>
									<th>Aktifitas</th>
									<th>Komentar</th>
								</tr>
							</thead>
							<tbody>

								<?php if(isset($comment_list) && !empty($comment_list)){ 

									foreach ($comment_list as $kc => $vc) {
										$start_date = date("d/m/Y H:i:s",strtotime($vc['comment_date']));
										?>
										<tr>
											<td><?php echo $start_date ?></td>
											<td><?php echo $vc['comment_name'] ?></td>
											<td><?php echo $vc['comment_type'] ? "Vendor" : "Internal" ?></td>
											<td><?php echo $vc['comment_activity'] ?></td>
											<td><?php echo $vc['comments'] ?></td>
										</tr>
										<?php } } ?>

									</tbody>

								</table>

							</div>
						</div>
					</div>
				</div>

				<?php if(!$viewer){ ?>
				<div class="row">
					<div class="col-lg-12">
						<div class="ibox float-e-margins">
							<div class="ibox-title">
								<h5>Form Komentar</h5>
							</div>
							<div class="ibox-content">

								<div class="form-group">
									<label class="col-sm-2 control-label">Komentar</label>
									<div class="col-lg-10 m-l-n">
										<textarea name="komentar_inp" class="form-control"></textarea>
									</div>
								</div>

								<div class="form-group">
									<div class="col-lg-12 m-l-n text-center">

										<a href="javascript:window.history.go(-1);" class="btn btn-default">Kembali</a>
										<button class="btn btn-primary" type="submit">Simpan</button>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>

				<?php } else { ?>
				<a href="javascript:window.history.go(-1);" class="btn btn-default">Kembali</a>
				<?php } ?> 

			</form>

		</div>

		<script>
			$(document).ready(function() {
				$('.milestone_table').DataTable({
					"order": [[ 0, "desc" ]],
					"lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
				});
			});
		</script>