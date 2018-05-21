        <div class="row">
        <div class="col-lg-12">
        <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5><?php echo $this->lang->line('Monitor Sanggah'); ?></h5>
        </div>
        <div class="ibox-content">
            <div class="table-responsive">
                <table class="table table-striped table-bordered datatabless">
                    <thead>
                    <tr>
                        <th><?php echo $this->lang->line('Nomor Pengadaan'); ?></th>
                        <th><?php echo $this->lang->line('Judul Pekerjaan'); ?></th>
						<th><?php echo $this->lang->line('Judul Sanggahan'); ?></th>
                        <th><?php echo $this->lang->line('Status'); ?></th>
						<th style="width: 5%; text-align: center;"><?php echo $this->lang->line('Aksi'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
					<?php foreach($list as $row) { ?>
					<tr>
					<form action="<?php echo site_url('pengadaan/view_sanggah') ?>" method="POST">
					<input type="hidden" id="ids" name="ids" value="<?php echo $row["pcl_id"]; ?>">
						<td><?php echo $row["ptm_number"] ?></td>
						<td><?php echo $row["ptm_subject_of_work"] ?></td>
						<td><?php echo $row["pcl_title"] ?></td>
						<td><?php if(empty($row["pcl_jwb_isi"])) { echo $this->lang->line('Belum Dijawab'); } else { echo $this->lang->line('Sudah Dijawab'); } ?></td>
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