<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2>Addendum</h2>
	</div>
	<div class="col-lg-2">
		
	</div>
</div>

<div class="wrapper wrapper-content animated fadeIn">
<form class="form-horizontal" method="post" action="<?php echo site_url('kontrak/submit_addendum') ?>">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5><?php echo $this->lang->line('Header'); ?></h5>
				</div>
				<div class="ibox-content">
					<div class="form-group"><label class="col-sm-3 control-label"><?php echo $this->lang->line('Nomor Pengadaaan'); ?></label>
						<div class="col-lg-6 m-l-n"><p class="form-control-static"><?php echo $header["ptm_number"]; ?></p></div>
					</div>
					
					<div class="form-group"><label class="col-sm-3 control-label"><?php echo $this->lang->line('Nomor Kontrak'); ?></label>
						<div class="col-lg-6 m-l-n"><p class="form-control-static"><?php echo $header["contract_number"] ?></p></div>
					</div>
					
					<div class="form-group"><label class="col-sm-3 control-label"><?php echo $this->lang->line('Nama Pengguna Barang/Jasa'); ?></label>
						<div class="col-lg-6 m-l-n"><p class="form-control-static"><?php echo $header["ctr_spe_complete_name"] ?></p></div>
					</div>
					
					<div class="form-group"><label class="col-sm-3 control-label"><?php echo $this->lang->line('Vendor'); ?></label>
						<div class="col-lg-6 m-l-n"><p class="form-control-static"><?php echo $header["vendor_name"] ?></p></div>
					</div>
					
					<div class="form-group"><label class="col-sm-3 control-label"><?php echo $this->lang->line('Tipe Penawaran'); ?></label>
						<div class="col-lg-6 m-l-n"><p class="form-control-static"><?php echo $header["contract_type"] ?></p></div>
					</div>
					
					<div class="form-group"><label class="col-sm-3 control-label"><?php echo $this->lang->line('Tanggal Penandatanganan'); ?></label>
						<div class="col-lg-6 m-l-n"><p class="form-control-static"><?php echo $this->umum->show_tanggal($header["sign_date"]) ?></p></div>
					</div>
					
					<div class="form-group"><label class="col-sm-3 control-label"><?php echo $this->lang->line('Tanggal Mulai Kontrak'); ?></label>
						<div class="col-lg-6 m-l-n"><p class="form-control-static"><?php echo $this->umum->show_tanggal($header["start_date"]) ?></p></div>
					</div>
					
					<div class="form-group"><label class="col-sm-3 control-label"><?php echo $this->lang->line('Tanggal Berakhir Kontrak'); ?></label>
						<div class="col-lg-6 m-l-n"><p class="form-control-static"><?php echo $this->umum->show_tanggal($header["end_date"]) ?></p></div>
					</div>
					
					<div class="form-group"><label class="col-sm-3 control-label"><?php echo $this->lang->line('Nilai Kontrak'); ?></label>
						<div class="col-lg-6 m-l-n"><p class="form-control-static"><?php echo $this->umum->cetakuang($header["contract_amount"], $header["currency"]) ?></p></div>
					</div>
					
					<div class="form-group"><label class="col-sm-3 control-label"><?php echo $this->lang->line('Judul Pekerjaan'); ?></label>
						<div class="col-lg-6 m-l-n"><p class="form-control-static"><?php echo $header["subject_work"] ?></p></div>
					</div>
					
					<div class="form-group"><label class="col-sm-3 control-label"><?php echo $this->lang->line('Deskripsi Pekerjaan'); ?></label>
						<div class="col-lg-6 m-l-n"><p class="form-control-static"><?php echo $header["scope_work"] ?></p></div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label">Deskripsi Addendum</label>
						<div class="col-lg-6 m-l-n">
							<textarea name="desc_inp" required class="form-control"></textarea>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Alasan Addendum</label>
						<div class="col-lg-6 m-l-n">
							<textarea name="reason_inp" required class="form-control"></textarea>
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
					<h5><?php echo $this->lang->line('Jaminan Pelaksanaan'); ?></h5>
				</div>
				<div class="ibox-content">
					<div class="form-group"><label class="col-sm-3 control-label"><?php echo $this->lang->line('Nama Bank'); ?></label>
						<div class="col-lg-6 m-l-n"><p class="form-control-static"><?php echo $header["pf_bank"]; ?></p></div>
					</div>
					
					<div class="form-group"><label class="col-sm-3 control-label"><?php echo $this->lang->line('Nomor Jaminan'); ?></label>
						<div class="col-lg-6 m-l-n"><p class="form-control-static"><?php echo $header["pf_number"] ?></p></div>
					</div>
					
					<div class="form-group"><label class="col-sm-3 control-label"><?php echo $this->lang->line('Mulai Berlaku'); ?></label>
						<div class="col-lg-6 m-l-n"><p class="form-control-static"><?php echo $this->umum->show_tanggal($header["pf_start_date"]) ?></p></div>
					</div>
					
					<div class="form-group"><label class="col-sm-3 control-label"><?php echo $this->lang->line('Berlaku Hingga'); ?></label>
						<div class="col-lg-6 m-l-n"><p class="form-control-static"><?php echo $this->umum->show_tanggal($header["pf_end_date"]) ?></p></div>
					</div>
					
					<div class="form-group"><label class="col-sm-3 control-label"><?php echo $this->lang->line('Nilai Jaminan'); ?></label>
						<div class="col-lg-6 m-l-n"><p class="form-control-static"><?php echo $this->umum->cetakuang($header["pf_amount"], $header["currency"]) ?></p></div>
					</div>
					
					<div class="form-group"><label class="col-sm-3 control-label"><?php echo $this->lang->line('Lampiran'); ?></label>
						<div class="col-lg-6 m-l-n"><p class="form-control-static"><a target="_blank" href="<?php echo site_url('kontrak/download/jaminan/'.$this->umum->forbidden($this->encryption->encrypt($header["pf_attachment"]), 'enkrip')); ?>"><?php echo $header["pf_attachment"] ?></a></p></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5><?php echo $this->lang->line('Item Kontrak'); ?></h5>
				</div>
				<div class="ibox-content">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover dataTables-example" >
							<thead>
								<tr>
									<th>No</th>
									<th><?php echo $this->lang->line('Kode Barang/Jasa'); ?></th>
									<th><?php echo $this->lang->line('Deskripsi'); ?></th>
									<th><?php echo $this->lang->line('Harga Satuan'); ?></th>
									<th><?php echo $this->lang->line('Satuan'); ?></th>
									<th><?php echo $this->lang->line('Jumlah'); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								foreach($item as $row) { ?>
								<tr>
									<td><?php echo $i ?></td>
									<td><?php echo $row["tit_id"] ?></td>
									<td><?php echo $row["short_description"] ?></td>
									<td><?php echo inttomoney($row["price"]) ?></td>
									<td><?php echo $row["uom"] ?></td>
									<td><?php echo inttomoney($row["qty"]) ?></td>
								</tr>
								<?php
								$i++;
							}
							?>
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
				<h5><?php echo $this->lang->line('Milestone'); ?></h5>
			</div>
			<div class="ibox-content">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover dataTables-example" >
						<thead>
							<tr>
								<th>No</th>
								<th><?php echo $this->lang->line('Deskripsi'); ?></th>
								<th><?php echo $this->lang->line('Target Tanggal'); ?></th>
								<th><?php echo $this->lang->line('Bobot (%)'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$i = 1;
							foreach($milestone as $row) { ?>
							<tr>
								<td><?php echo $i ?></td>
								<td><?php echo $row["description"] ?></td>
								<td><?php echo $this->umum->show_tanggal($row["target_date"]) ?></td>
								<td><?php echo $row["progress_percentage"] ?></td>
							</tr>
							<?php
							$i++;
						}
						?>
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
				<h5><?php echo $this->lang->line('Lampiran'); ?></h5>
			</div>
			<div class="ibox-content">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover dataTables-example" >
						<thead>
							<tr>
								<th>No</th>
								<th><?php echo $this->lang->line('Kategori'); ?></th>
								<th><?php echo $this->lang->line('Deskripsi'); ?></th>
								<th><?php echo $this->lang->line('Nama File'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$i = 1;
							foreach($lampiran as $row) { ?>
							<tr>
								<td><?php echo $i ?></td>
								<td><?php echo $row["category"] ?></td>
								<td><?php echo $row["description"] ?></td>
								<td><?php echo $row["filename"] ?></td>
							</tr>
							<?php
							$i++;
						}
						?>
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
					<h5><?php echo $this->lang->line('Komentar'); ?></h5>
				</div>
				<div class="ibox-content">

					<div class="form-group">
						<label class="col-sm-2 control-label">Komentar</label>
						<div class="col-lg-10 m-l-n">
							<textarea name="komentar_inp" required class="form-control"></textarea>
						</div>
					</div>

					<div class="form-group">
						<div class="col-lg-12 m-l-n text-center">
						<input type="hidden" name="contract_id" value="<?php echo $id ?>">
							<a href="javascript:window.history.go(-1);" class="btn btn-default">Kembali</a>
							<button class="btn btn-primary" type="submit">Simpan</button>
						</div>
					</div>

				</div>
			</div>
		</div>
	</div>
</form>

</div>

<script>
	$(document).ready(function() {
		$('.dataTables-example').DataTable({
			"lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
		});
	});
</script>