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
                        <th><?php echo $this->lang->line('Nomor Pengadaan'); ?></th>
                        <th><?php echo $this->lang->line('Nomor Kontrak'); ?></th>
                        <th><?php echo $this->lang->line('Deskripsi Pekerjaan'); ?></th>
						<th><?php echo $this->lang->line('Jenis Kontrak'); ?></th>
						<!-- <th><?php// echo $this->lang->line('Vendor'); ?></th> -->
						<th><?php echo $this->lang->line('Tanggal Mulai Kontrak'); ?></th>
						<th><?php echo $this->lang->line('Tanggal Berakhir Kontrak'); ?></th>
						<th><?php echo $this->lang->line('Nilai Kontrak'); ?></th>
						<th><?php echo $this->lang->line('Status'); ?></th>
						<th></th>
                    </tr>
                    </thead>
                    <tbody>
					<?php foreach($list as $row) { ?>
					<tr>
						<form action="<?php echo site_url('kontrak/view') ?>" method="POST">
						<input type="hidden" id="ids" name="ids" value="<?php echo $row["contract_id"]; ?>">
						<td><?php echo $row["ptm_number"]; ?></td>
						<td><?php echo $row["contract_number"]; ?></td>
						<td><?php echo $row["subject_work"]; ?></td>
						<td><?php echo $row["contract_type"]; ?></td>
						<!-- <td><?php //echo $row["vendor_name"]; ?></td> -->
						<td><?php echo $this->umum->show_tanggal($row["start_date"]) ?></td>
						<td><?php echo $this->umum->show_tanggal($row["end_date"]) ?></td>
						<td><?php echo $this->umum->cetakuang($row["total_ppn"], $row["currency"])?></td>
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