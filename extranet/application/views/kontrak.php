<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2><?php echo $this->lang->line('Monitor Kontrak'); ?></h2>
	</div>
	<div class="col-lg-2">
		
	</div>
</div>

<div class="wrapper wrapper-content animated fadeIn">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5><?php echo $this->lang->line('Header'); ?></h5>
				</div>
				<div class="ibox-content">
					<div class="form-group"><label class="col-sm-4 control-label"><?php echo $this->lang->line('Nomor Pengadaaan'); ?></label>
						<div class="col-lg-6 m-l-n"><?php echo $header["ptm_number"]; ?></div>
					</div>
					<br>
					<div class="form-group"><label class="col-sm-4 control-label"><?php echo $this->lang->line('Nomor Kontrak'); ?></label>
						<div class="col-lg-6 m-l-n"><?php echo $header["contract_number"] ?></div>
					</div>
					<br>
					<div class="form-group"><label class="col-sm-4 control-label"><?php echo $this->lang->line('Nama Pengguna Barang/Jasa'); ?></label>
						<div class="col-lg-6 m-l-n"><?php echo $header["ctr_spe_complete_name"] ?></div>
					</div>
					<br>
					<div class="form-group"><label class="col-sm-4 control-label"><?php echo $this->lang->line('Vendor'); ?></label>
						<div class="col-lg-6 m-l-n"><?php echo $header["vendor_name"] ?></div>
					</div>
					<br>
					<div class="form-group"><label class="col-sm-4 control-label"><?php echo $this->lang->line('Tipe Penawaran'); ?></label>
						<div class="col-lg-6 m-l-n"><?php echo $header["contract_type"] ?></div>
					</div>
					<br>
					<div class="form-group"><label class="col-sm-4 control-label"><?php echo $this->lang->line('Tanggal Penandatanganan'); ?></label>
						<div class="col-lg-6 m-l-n"><?php echo $this->umum->show_tanggal($header["sign_date"]) ?></div>
					</div>
					<br>
					<div class="form-group"><label class="col-sm-4 control-label"><?php echo $this->lang->line('Tanggal Mulai Kontrak'); ?></label>
						<div class="col-lg-6 m-l-n"><?php echo $this->umum->show_tanggal($header["start_date"]) ?></div>
					</div>
					<br>
					<div class="form-group"><label class="col-sm-4 control-label"><?php echo $this->lang->line('Tanggal Berakhir Kontrak'); ?></label>
						<div class="col-lg-6 m-l-n"><?php echo $this->umum->show_tanggal($header["end_date"]) ?></div>
					</div>
					<br>
					<div class="form-group"><label class="col-sm-4 control-label"><?php echo $this->lang->line('Nilai Kontrak'); ?></label>
						<div class="col-lg-6 m-l-n"><?php echo $this->umum->cetakuang($header["contract_amount"], $header["currency"]) ?></div>
					</div>
					<br>
					<div class="form-group"><label class="col-sm-4 control-label"><?php echo $this->lang->line('Judul Pekerjaan'); ?></label>
						<div class="col-lg-6 m-l-n"><?php echo $header["subject_work"] ?></div>
					</div>
					<br>
					<div class="form-group"><label class="col-sm-4 control-label"><?php echo $this->lang->line('Deskripsi Pekerjaan'); ?></label>
						<div class="col-lg-6 m-l-n"><?php echo $header["scope_work"] ?></div>
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
					<div class="form-group"><label class="col-sm-4 control-label"><?php echo $this->lang->line('Nama Bank'); ?></label>
						<div class="col-lg-6 m-l-n"><?php echo $header["pf_bank"]; ?></div>
					</div>
					<br>
					<div class="form-group"><label class="col-sm-4 control-label"><?php echo $this->lang->line('Nomor Jaminan'); ?></label>
						<div class="col-lg-6 m-l-n"><?php echo $header["pf_number"] ?></div>
					</div>
					<br>
					<div class="form-group"><label class="col-sm-4 control-label"><?php echo $this->lang->line('Mulai Berlaku'); ?></label>
						<div class="col-lg-6 m-l-n"><?php echo $this->umum->show_tanggal($header["pf_start_date"]) ?></div>
					</div>
					<br>
					<div class="form-group"><label class="col-sm-4 control-label"><?php echo $this->lang->line('Berlaku Hingga'); ?></label>
						<div class="col-lg-6 m-l-n"><?php echo $this->umum->show_tanggal($header["pf_end_date"]) ?></div>
					</div>
					<br>
					<div class="form-group"><label class="col-sm-4 control-label"><?php echo $this->lang->line('Nilai Jaminan'); ?></label>
						<div class="col-lg-6 m-l-n"><?php echo $this->umum->cetakuang($header["pf_amount"], $header["currency"]) ?></div>
					</div>
					<br>
					<div class="form-group"><label class="col-sm-4 control-label"><?php echo $this->lang->line('Lampiran'); ?></label>
						<!-- <div class="col-lg-6 m-l-n"><a target="_blank" href="<?php //echo site_url('kontrak/download/jaminan/'.$this->umum->forbidden($this->encryption->encrypt($header["pf_attachment"]), 'enkrip')); ?>"><?php //echo $header["pf_attachment"] ?></a></div> -->
						<div class="col-lg-6 m-l-n"><a target="_blank" href="<?php echo INTRANET_DOWNLOAD_URL."contract/jaminan/".$header["pf_attachment"] ?>"><?php echo $header["pf_attachment"] ?></a></div>
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
								<!-- <td><?php //echo $row["filename"] ?></td> -->
								<td><a href="<?php echo INTRANET_DOWNLOAD_URL."contract/document/".$row["filename"] ?>"><?php echo $row["filename"] ?></a></td>
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
</div>

<script>
	$(document).ready(function() {
		$('.dataTables-example').DataTable({
			"lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
		});
	});
</script>