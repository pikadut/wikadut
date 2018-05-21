        <div class="row">
        	<div class="col-lg-12">
        		<div class="ibox float-e-margins">
        			<div class="ibox-title">
        				<h5>Revisi Progress Milestone</h5>
        			</div>
        			<div class="ibox-content">
        				<div class="table-responsive">
        					<table class="table table-striped table-bordered datatabless">
        						<thead>
        							<tr>
        								<th>No.</th>
        								<th>No. Kontrak</th>
        								<th>Deskripsi</th>
        								<th>Presentase (%)</th>
        								<th>Target Tanggal</th>
        								<th>Progress (%)</th>
        								<th>Status</th>
        								<th>Aksi</th>
        							</tr>
        						</thead>
        						<tbody>
        							<?php foreach($list_milestone as $key => $row) { ?>
        							<tr>
        								<td><?php echo ++$key; ?></td>
        								<td><?php echo $row["contract_number"]; ?></td>
        								<td><?php echo $row["description"]; ?></td>
        								<td><?php echo $row["percentage"]; ?></td>
        								<td><?php echo date("d/m/Y",strtotime($row["target_date"])); ?></td>
        								<td><?php echo $row["progress_percentage"]; ?></td>
        								<td><?php echo $row["activity"]; ?></td>
        								<td style="text-align: center;">
        									<form action="<?php echo site_url('kontrak/process_milestone') ?>" method="POST">
        										<input type="hidden" id="ids" name="ids" value="<?php echo $row["milestone_id"]; ?>">
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

        		<div class="ibox float-e-margins">
        			<div class="ibox-title">
        				<h5>Revisi Progress WO</h5>
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
               <?php foreach($list_wo as $key => $row) { ?>
               <tr>
                <td><?php echo ++$key; ?></td>
                <td><?php echo $row["po_number"]; ?></td>
                <td><?php echo $row["contract_number"]; ?></td>
                <td><?php echo $row["subject_work"]; ?></td>
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

          <div class="ibox float-e-margins">
           <div class="ibox-title">
            <h5>Pembuatan BAST</h5>
           </div>
           <div class="ibox-content">
            <div class="table-responsive">
             <table class="table table-striped table-bordered datatabless">
              <thead>
               <tr>
                <th>No.</th>
                <th>No. Kontrak</th>
                <th>Deskripsi</th>
                <th>Presentase Progress</th>
                <th>Aksi</th>
               </tr>
              </thead>
              <tbody>
               <?php foreach($list_bast as $key => $row) { ?>
               <tr>
                <td><?php echo ++$key; ?></td>
                <td><?php echo $row["contract_number"]; ?></td>
                <td><?php echo $row["description"]; ?></td>
                <td><?php echo $row["progress_percentage"]; ?></td>
                <td style="text-align: center;">
                 <form action="<?php echo site_url('kontrak/process_bast') ?>" method="POST">
                  <input type="hidden" id="ids" name="ids" value="<?php echo $row["id"]; ?>">
                  <input type="hidden" id="type" name="type" value="<?php echo $row["type"]; ?>">
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

          <div class="ibox float-e-margins">
           <div class="ibox-title">
            <h5>Pembuatan Tagihan</h5>
           </div>
           <div class="ibox-content">
            <div class="table-responsive">
             <table class="table table-striped table-bordered datatabless">
              <thead>
               <tr>
                <th>No.</th>
                <th>No. Kontrak</th>
                <th>Deskripsi</th>
                <th>Aksi</th>
               </tr>
              </thead>
              <tbody>
               <?php foreach($list_invoice as $key => $row) { ?>
               <tr>
                <td><?php echo ++$key; ?></td>
                <td><?php echo $row["contract_number"]; ?></td>
                <td><?php echo $row["description"]; ?></td>
                <td style="text-align: center;">
                 <form action="<?php echo site_url('kontrak/process_tagihan') ?>" method="POST">
                  <input type="hidden" id="ids" name="ids" value="<?php echo $row["id"]; ?>">
                  <input type="hidden" id="type" name="type" value="<?php echo $row["type"]; ?>">
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