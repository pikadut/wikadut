<div class="wrapper wrapper-content animated fadeInRight">
	<form method="post" action="<?php echo site_url($controller_name."/submit_proses_progress_wo");?>"  class="form-horizontal ajaxform">

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

						<div class="form-group"><label class="col-sm-2 control-label">Nama Pembuat WO</label>
							<div class="col-lg-6 m-l-n"><p class="form-control-static"><?php echo $header["fullname"] ?></p></div>
						</div>

						<div class="form-group"><label class="col-sm-2 control-label">Vendor</label>
							<div class="col-lg-6 m-l-n"><p class="form-control-static"><?php echo $header["vendor_name"] ?></p></div>
						</div>

						<div class="form-group"><label class="col-sm-2 control-label">Tanggal Mulai WO</label>
							<div class="col-lg-6 m-l-n"><p class="form-control-static"><?php echo date("d/m/Y",strtotime($header["start_date"])) ?></p></div>
						</div>

						<div class="form-group"><label class="col-sm-2 control-label">Tanggal Selesai WO</label>
							<div class="col-lg-6 m-l-n"><p class="form-control-static"><?php echo date("d/m/Y",strtotime($header["end_date"])) ?></p></div>
						</div>

						<div class="form-group"><label class="col-sm-2 control-label">Deskripsi WO</label>
							<div class="col-lg-6 m-l-n"><p class="form-control-static"><?php echo $header["po_notes"] ?></p></div>
						</div>

						<div class="form-group"><label class="col-sm-2 control-label">Tanggal Progress</label>
							<div class="col-lg-3 m-l-n">
								<p class="form-control-static"><?php echo date("d/m/Y",strtotime($header["progress_date"])) ?></p>
							</div>
						</div>

						<div class="form-group"><label class="col-sm-2 control-label">Deskripsi Progress</label>
							<div class="col-lg-6 m-l-n">
								<p class="form-control-static"><?php echo $header["progress_description"] ?></p>
							</div>
						</div>

						<div class="form-group"><label class="col-sm-2 control-label">Presentase Progress</label>
							<div class="col-lg-2 m-l-n">
								<p class="form-control-static"><?php echo $header["progress_percentage"] ?>%</p>
								
							</div>
						</div>

						<?php $curval = $header['type_inv']; ?>
						<div class="form-group"><label class="col-sm-2 control-label">Tipe</label>
							<div class="col-lg-4 m-l-n">

								<?php if($header['progress_status'] == 1 && !isset($readonly)){ ?>

								<select class="form-control" required name="jenis_inp">
									<?php foreach($progress_type as $key => $val){
										$selected = ($key == $curval) ? "selected" : ""; 
										?>
										<option <?php echo $selected ?> value="<?php echo $key ?>">
											<?php echo $val ?>
										</option>
										<?php } ?>
									</select>

									<?php } else { ?>
									<p class="form-control-static"><?php echo $progress_type[$curval] ?></p>
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
											<th>Jumlah sudah dikirim sebelumnya</th>
											<th>Jumlah dikirim saat ini</th>
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
												<?php echo (!empty($value['progress_qty'])) ? inttomoney($value['progress_qty']) : 0 ?>
											</td>
											<td class="text-right"><?php echo (!empty($value['approved_qty'])) ? inttomoney($value['approved_qty']) : 0 ?></td>
											

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

		<?php if($lampiran){ ?>
		<div class="row">
			<div class="col-lg-12">
				<center>
					<a class="btn btn-primary tambah_dok">Tambah Lampiran</a>
					<br/>
					<br/>
				</center>
			</div>

		</div>

		<div id="lampiran_container">
			<?php for ($k = 0; $k <= 4; $k++) { 
				$show = ($k == 0) ? "" : "display:none;";
				?>

				<div class="row lampiran" style="<?php echo $show ?>" data-no="<?php echo $k ?>">
					<div class="col-lg-12">
						<div class="ibox float-e-margins">
							<div class="ibox-title">
								<h5>LAMPIRAN FOTO #<?php echo $k ?></h5>
								<div class="ibox-tools">

									<?php if($k > 0){ ?>
									<a class="tutup" data-no="<?php echo $k ?>">
										<i class="fa fa-times"></i>
									</a>
									<?php } ?>

									<a class="collapse-link">
										<i class="fa fa-chevron-up"></i>
									</a>

								</div>
							</div>
							<div class="ibox-content">


								<div class="form-group">
									
									<?php $curval = set_value("doc_attachment_inp[$k]"); ?>
									<label class="col-sm-1 control-label"><?php echo lang('attachment') ?></label>
									<div class="col-sm-3">
										<div class="input-group">
											<span class="input-group-btn">
												<button type="button" data-id="doc_attachment_inp_<?php echo $k ?>" data-folder="<?php echo $dir ?>" data-preview="preview_file_<?php echo $k ?>" class="btn btn-primary upload">
													<i class="fa fa-cloud-upload"></i>
												</button> 
												<button type="button" data-id="doc_attachment_inp_<?php echo $k ?>" data-folder="<?php echo $dir ?>" data-preview="preview_file_<?php echo $k ?>" class="btn btn-danger removefile">
													<i class="fa fa-remove"></i>
												</button> 
											</span> 
											<input readonly type="text" class="form-control" id="doc_attachment_inp_<?php echo $k ?>" name="doc_attachment_inp[<?php echo $k ?>]" value="<?php echo $curval ?>">
											<span class="input-group-btn">
												<button type="button" data-url="<?php echo INTRANET_UPLOAD_FOLDER."/$dir/$curval" ?>" class="btn btn-primary preview_upload" id="preview_file_<?php echo $k ?>">
													<i class="fa fa-share"></i>
												</button> 
											</span> 
										</div>
									</div>
						

								<?php $curval = set_value("doc_desc_inp[$k]"); ?>
							
									<label class="col-sm-1 control-label"><?php echo lang('description') ?></label>
									<div class="col-sm-3">
										<textarea class="form-control" maxlength="1000" name="doc_desc_inp[<?php echo $k ?>]"><?php echo $curval ?></textarea>
									</div>
								</div>

							</div>
						</div>
					</div>
				</div>

				<?php } ?>

			</div>

			<?php } else { ?>
			<div class="row">
				<div class="col-lg-12">
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>LAMPIRAN</h5>
							<div class="ibox-tools">
								<a class="collapse-link">
									<i class="fa fa-chevron-up"></i>
								</a>
							</div>
						</div>
						<div class="ibox-content">

							<table class="table table-bordered default">
								<thead>
									<tr>
										<th>No</th>
										<th>File</th>
										<th>Deskripsi</th>
									</tr>
								</thead>

								<tbody>
									<?php foreach ($lampiranList as $k => $v) {?>
									<tr>
										<td><?php echo $k+1 ?></td>
										<td><a href="<?php echo base_url('/uploads/contract/'.$v['filename']) ?>" >
											<img src="<?php echo base_url('/uploads/contract/'.$v['filename']) ?>" width="100px">
										</a></td>
										<td><?php echo $v['description'] ?></td>
									</tr>
									<?php } ?>
								</tbody>
							</table>

						</div>

					</div>
				</div>
			</div>
			<?php } ?>


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

					<?php $back = buttonsubmit('contract/daftar_pekerjaan',lang('back'),lang('save'));
				} else {
					$back = buttonback('contract/monitor/monitor_progress',lang('back'));
				} 
				echo $back;
				?>

			</form>

		</div>

		<script>
			$(".tambah_dok").click(function(){

				var total = parseInt($("div.lampiran:visible").length);
				var find = parseInt($("div.lampiran:hidden").attr("data-no"));

				if(total == 4){
					$(".tambah_dok").hide();
				}
				$("div.lampiran[data-no='"+find+"']").show();
				return false;

			});

			$(".tutup").click(function(){

				$(".tambah_dok").show();
				var no = parseInt($(this).attr("data-no"));
				$("div.lampiran[data-no='"+no+"']").hide();

				return false;

			});
		</script>