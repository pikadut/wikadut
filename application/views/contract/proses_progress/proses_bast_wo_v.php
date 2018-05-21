<div class="wrapper wrapper-content animated fadeInRight">
	<form method="post" action="<?php echo site_url($controller_name."/submit_proses_bast_wo");?>"  class="form-horizontal ajaxform">

		<input type="hidden" name="id" value="<?php echo $id ?>">
		<div class="row">
			<div class="col-lg-12">
				<div class="ibox float-e-margins">
					<div class="ibox-title">
						<h5>Header</h5>
						<div class="ibox-tools">
							<a class="collapse-link">
								<i class="fa fa-chevron-up"></i>
							</a>
						</div>
					</div>
					<div class="ibox-content">

						<?php $curval = (isset($header['contract_number'])) ? $header['contract_number'] : "AUTO NUMBER"; ?>

						<div class="form-group">
							
							<label class="col-sm-2 control-label">Nomor Kontrak</label>
							<div class="col-sm-10 m-l-n">
								<p class="form-control-static">
									<a href="<?php echo site_url('contract/monitor/monitor_kontrak/lihat/'.$header['contract_id']) ?>" target="_blank">
										<?php echo $curval ?>
									</a>
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
									<?php echo date("d/m/Y",strtotime($header["start_date"])) ?>									
								</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Tanggal Selesai WO</label>
							<div class="col-lg-6 m-l-n">
								<p class="form-control-static">
									<?php echo date("d/m/Y",strtotime($header["end_date"])) ?>									
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
							<div class="col-lg-3 m-l-n">
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
							<label class="col-sm-2 control-label">Presentase Progress</label>
							<div class="col-lg-2 m-l-n">
								<p class="form-control-static">
									<?php echo $header["progress_percentage"] ?>%
								</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">
								Inventory / Aset
							</label>
							<div class="col-lg-6 m-l-n">
								<select name="inv_aset" class="form-control">
									<option>Inventory</option>
									<option>Aset</option>
								</select>
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

							<table class="table table-striped table-bordered table-hover">

								<thead>

									<tr>
										<th>No</th>
										<th>Kode <br/>Barang / Jasa</th>
										<th>Deskripsi</th>
										<th>Satuan</th>
										<th>Harga Satuan<br/>(Sebelum Pajak)</th>
										<th>Pajak</th>
										<th>Jumlah WO</th>
										<th>Jumlah yang dikirim</th>
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
											<?php echo (!empty($value['approved_qty'])) ? inttomoney($value['approved_qty']) : 0 ?>
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
								<?php echo $header["bastp_number"] ?>
							</p>
						</div>
					</div>

					<div class="form-group">

						<label class="col-sm-2 control-label">
							Tanggal
						</label>
						<div class="col-lg-3 m-l-n">
							<p class="form-control-static">
								<?php echo date("d/m/Y",strtotime($header["bastp_date"])) ?>
							</p>
						</div>
					</div>

					<div class="form-group">

						<label class="col-sm-2 control-label">
							Judul
						</label>
						<div class="col-lg-6 m-l-n">
							<p class="form-control-static">
								<?php echo $header["bastp_title"] ?>
							</p>
						</div>
					</div>

					<div class="form-group">

						<label class="col-sm-2 control-label">
							Berita Acara
						</label>
						<div class="col-lg-6 m-l-n">
							<p class="form-control-static">
								<?php echo $header["bastp_description"] ?>
							</p>
						</div>
					</div>

					<div class="form-group">

						<label class="col-sm-2 control-label">
							Lampiran
						</label>
						<div class="col-lg-3 m-l-n">
							<p class="form-control-static">
								<a href="<?php echo site_url('log/download_attachment_extranet/bast_wo/'.$header['vendor_id'].'/'.$header['bastp_attachment']) ?>" target="_blank">
									<?php echo $header['bastp_attachment'] ?>
								</a>
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
					<h5><?php echo lang('comment') ?></h5>
					<div class="ibox-tools">
						<a class="collapse-link">
							<i class="fa fa-chevron-up"></i>
						</a>
					</div>
				</div>
				<div class="ibox-content">

					<table class="table comment">
						<thead>
							<tr>
								<th>Tanggal</th>
								<th><?php echo lang('user') ?></th>
								<th>Tipe</th>
								<th>Aktifitas</th>
								<th><?php echo lang('comment') ?></th>
							</tr>
						</thead>
						<tbody>

							<?php if(isset($comment_list) && !empty($comment_list)){ 

								foreach ($comment_list as $kc => $vc) {
									$start_date = date(DEFAULT_FORMAT_DATETIME,strtotime($vc['comment_date']));
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

			<?php if(!isset($readonly)){ ?>

			<div class="row">
				<div class="col-lg-12">
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>Komentar</h5>
						</div>
						<div class="ibox-content">

							<div class="form-group">

								<label class="col-sm-1 control-label">Aksi</label>
								<div class="col-sm-5">
									<select class="form-control select2" style="width:100%;" name="status_inp">
										<option value="1">Setuju</option>
										<option value="0">Revisi</option>
									</select>
								</div>
							</div>

							<?php $curval = set_value("komentar_inp"); ?>
							<div class="form-group">

								<label class="col-sm-1 control-label">Komentar</label>
								<div class="col-sm-11">
									<textarea name="komentar_inp" maxlength="1000" required class="form-control"><?php echo $curval ?></textarea>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<?php 
			$back = buttonsubmit('contract/daftar_pekerjaan',lang('back'),lang('save'));
		} else {
			$back = buttonback('contract/monitor/monitor_bast',lang('back'));
		} 
		echo $back;
		?>

	</form>

</div>