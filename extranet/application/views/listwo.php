<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5><?php echo $judul ?></h5>
			</div>
			<div class="ibox-content">
				<div class="table-responsive">
					<table class="table table-striped table-bordered datatabless">
						<thead>
							<tr>
								<th>No.</th>
								<th>No. WO</th>
								<th>No. Kontrak</th>
								<th>Deskripsi Pekerjaan</th>
								<th>Tipe</th>
								<th>Status</th>
								<th>Aksi</th>
							</tr>
						</thead>
						<tbody>
							<?php foreach($list as $key => $row) { ?>
							<tr>
								<td><?php echo ++$key; ?></td>
								<td><?php echo $row["po_number"]; ?></td>
								<td><?php echo $row["contract_number"]; ?></td>
								<td><?php echo $row["po_notes"]; ?></td>
								<td><?php echo $row["contract_type"]; ?></td>
								<td><?php echo $row["activity"]; ?></td>
								<td style="text-align: center;">
									<form action="<?php echo site_url('kontrak/process_wo') ?>" method="POST">
										<input type="hidden" id="ids" name="ids" value="<?php echo $row["po_id"]; ?>">
										<button type="submit" class="btn btn-primary btn-sm"><?php echo $this->lang->line('Pilih'); ?></button>
									</form>
								</td>

							</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>

			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$('.datatabless').DataTable({
			"lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
		});
	});
</script>