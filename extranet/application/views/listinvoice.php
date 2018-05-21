        <div class="row">
        <div class="col-lg-12">
        <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5><?php if(!isset($title) || empty($title)) { echo $this->lang->line('Daftar Pekerjaan'); } else { echo $title; } ?></h5>
        </div>
        <div class="ibox-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered datatabless">
                    <thead>
                    <tr>
                        <th><?php echo $this->lang->line('Nomor Kontrak'); ?></th>
                        <th><?php echo $this->lang->line('Nomor Tagihan'); ?></th>
						<th><?php echo $this->lang->line('Tanggal Dibuat'); ?></th>
						<th><?php echo $this->lang->line('Tanggal Tagihan'); ?></th>
						<th><?php echo $this->lang->line('Bank'); ?></th>
						<th><?php echo $this->lang->line('Status'); ?></th>
						<th></th>
                    </tr>
                    </thead>
                    <tbody>
					<?php foreach($list as $row) { ?>
					<tr>
						<form action="<?php echo site_url('kontrak/view_invoice') ?>" method="POST">
						<input type="hidden" id="ids" name="ids" value="<?php echo $row["invoice_id"]; ?>">
						<input type="hidden" id="type" name="type" value="<?php echo $row["type"]; ?>">
						<td><?php echo $row["contract_number"]; ?></td>
						<td><?php echo $row["invoice_number"]; ?></td>
						<td><?php echo $this->umum->show_tanggal($row["created_date"]) ?></td>
						<td><?php echo $this->umum->show_tanggal($row["invoice_date"]) ?></td>
						<td><?php echo $row["bank_account"]; ?></td>
						<td><?php echo $row["status"]; ?></td>
						<td style="text-align: center;"><button type="submit" class="btn btn-primary btn-sm"><?php echo $this->lang->line('Pilih'); ?></button></td>
						</form>
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