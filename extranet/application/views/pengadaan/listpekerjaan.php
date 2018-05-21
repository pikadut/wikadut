        <div class="row">
        <div class="col-lg-12">
        <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5><?php if(!isset($title) || empty($title)) { echo "Daftar Pekerjaan"; } else { echo $title; } ?></h5>
        </div>
        <div class="ibox-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered datatabless">
                    <thead>
                    <tr>
                        <th><?php echo $this->lang->line('Nomor'); ?></th>
                        <th><?php echo $this->lang->line('Judul Pekerjaan'); ?></th>
                        <th><?php echo $this->lang->line('Pembukaan Pendaftaran'); ?></th>
                        <th><?php echo $this->lang->line('Penutupan Pendaftaran'); ?></th>
						<th>Aanwijzing</th>
						<th><?php echo $this->lang->line('Status'); ?></th>
						<th style="width: 5%; text-align: center;"><?php echo $this->lang->line('Aksi'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
					<?php foreach($list as $row) { ?>
					<tr>
						<form action="<?php echo site_url('pengadaan/view') ?>" method="POST">
						<input type="hidden" id="ids" name="ids" value="<?php echo $row["ptm_number"]; ?>">
						<input type="hidden" id="current_status" name="current_status" value="<?php echo $row["pvs_status"]; ?>">
						<input type="hidden" id="reg_close" name="reg_close" value="<?php echo $row["ptp_reg_closing_date"]; ?>">
						<input type="hidden" id="aanwijzing" name="aanwijzing" value="<?php echo $row["ptp_prebid_date"]; ?>">
						<input type="hidden" id="bid_open" name="bid_open" value="<?php echo $row["ptp_quot_closing_date"]; ?>">
						<input type="hidden" id="state" name="state" value="<?php echo $this->uri->segment(2, 0); ?>">
						<td><?php echo $row["ptm_number"]; ?></td>
						<td><?php echo $row["ptm_subject_of_work"]; ?></td>
						<td><?php echo $this->umum->show_tanggal($row["ptp_reg_opening_date"]) ?></td>
						<td><?php echo $this->umum->show_tanggal($row["ptp_reg_closing_date"]) ?></td>
						<td><?php echo $this->umum->show_tanggal($row["ptp_prebid_date"]) ?></td>
						<td><?php echo $row["status"] ?></td>
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