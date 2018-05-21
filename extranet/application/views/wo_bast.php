<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2><?php echo ($viewer) ? "Lihat" : "Form"; ?> BAST Work Order</h2>
	</div>
	<div class="col-lg-2">
		
	</div>
</div>
<form class="form-horizontal" method="post" action="<?php echo site_url('kontrak/submit_bast_wo') ?>" enctype="multipart/form-data">
	<div class="wrapper wrapper-content animated fadeIn">
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5><?php echo $this->lang->line('Header'); ?></h5>
					</div>
					<div class="ibox-content">

						<div class="form-group">
							<label class="col-sm-2 control-label">Nomor Kontrak</label>
							<div class="col-lg-6 m-l-n">
								<p class="form-control-static">
									<?php echo $header["contract_number"]; ?>
								</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Nama Pembuat WO</label>
							<div class="col-lg-6 m-l-n">
								<p class="form-control-static">
									<?php echo $header["fullname"] ?>
								</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Vendor</label>
							<div class="col-lg-6 m-l-n">
								<p class="form-control-static">
									<?php echo $header["vendor_name"] ?>
								</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Tanggal Mulai WO</label>
							<div class="col-lg-6 m-l-n">
								<p class="form-control-static">
									<?php echo $this->umum->show_tanggal($header["start_date"]) ?>
								</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Tanggal Selesai WO</label>
							<div class="col-lg-6 m-l-n">
								<p class="form-control-static">
									<?php echo $this->umum->show_tanggal($header["end_date"]) ?>
								</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Deskripsi WO</label>
							<div class="col-lg-6 m-l-n">
								<p class="form-control-static">
									<?php echo $header["po_notes"] ?>
								</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Tanggal Progress</label>
							<div class="col-lg-6 m-l-n">
								<p class="form-control-static">
									<?php echo date("d/m/Y",strtotime($header["progress_date"])) ?>
								</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Deskripsi Progress</label>
							<div class="col-lg-6 m-l-n">
								<p class="form-control-static">
									<?php echo $header["progress_description"] ?>
								</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Persentase Progress</label>
							<div class="col-lg-6 m-l-n">
								<p class="form-control-static">
									<?php echo $header["progress_percentage"] ?> %
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
						<h5>Item</h5>
					</div>
					<div class="ibox-content">
						<div class="table-responsive">

							<table class="table table-striped table-bordered table-hover dataTables-example">

								<thead>

									<tr>
										<th>No</th>
										<th>Kode <br/>Barang / Jasa</th>
										<th>Deskripsi</th>
										<th>Satuan</th>
										<th>Harga Satuan<br/>(Sebelum Pajak)</th>
										<th>Pajak</th>
										<th>Jumlah WO</th>
										<th>Jumlah yang kirim</th>
									</tr>

								</thead>

								<tbody>

									<?php 
									$subtotal = 0;
									$subtotal_ppn = 0;
									$subtotal_pph = 0;
									foreach ($item as $key => $value) { ?>

									<tr>
										<td><?php echo $key+1 ?></td>
										<td><?php echo $value['item_code'] ?></td>
										<td><?php echo $value['short_description'] ?></td>
										<td><?php echo $value['uom'] ?></td>
										<td class="text-right"><?php echo inttomoney($value['price']) ?></td>
										<td >
											<?php echo (!empty($value['ppn'])) ? " PPN (".$value['ppn']."%) " : "" ?> 
											<?php echo (!empty($value['pph'])) ? " PPH (".$value['pph']."%)" : "" ?> 
										</td>
										<td class="text-right"><?php echo inttomoney($value['qty']) ?></td>
										<td class="text-right">

											<p class="form-control-static">
												<?php echo inttomoney($value['approved_qty']) ?>
											</p>
										</td>

									</tr>
									<?php 
									$subtotal += $value['price']*$value['qty'];
									if(!empty($value['ppn'])){
										$subtotal_ppn += $value['price']*$value['qty']*($value['ppn']/100);
									}
									if(!empty($value['pph'])){
										$subtotal_pph += $value['price']*$value['qty']*($value['pph']/100);
									}
								} ?>

							</tbody>

						</table>

					</div>
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
							<a href="<?php echo base_url('log/download_attachment_extranet/bast_wo/'.$header['vendor_id'].'/'.$header['bastp_attachment']) ?>" target="_blank">
								<?php echo (!empty($header['bastp_attachment'])) ? $header['bastp_attachment'] : ""; ?>
							</a>
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

				<table class="table comment dataTables-example">
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
		$('.dataTables-example').DataTable({
			"order": [[ 0, "desc" ]],
			"lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
		});
	});
</script>