<div class="wrapper wrapper-content animated fadeIn">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5><?php echo $this->lang->line('Informasi Negosiasi'); ?></h5>
				</div>
				<div class="ibox-content">
					<table class="table">
						
						<tr>
							<th><?php echo $this->lang->line('Nomor Pengadaan'); ?></th>
							<td>
							<a href="<?php echo site_url('pengadaan/lihat_pengadaan/'.$this->umum->forbidden($this->encryption->encrypt($tenderid), 'enkrip'))?>" target="_blank">
							<?php echo $tenderid ?>
								
							</a>
							</td>
						</tr>
						<tr>
							<th><?php echo $this->lang->line('Nomor Penawaran'); ?></th>
							<td><?php echo $header["pqm_number"] ?></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5><?php echo $this->lang->line('Riwayat Pesan Negosiasi'); ?></h5>
				</div>
				<div class="ibox-content">
					<table class="table table-striped table-bordered dataTables-example" >
						<thead>
							<tr>
								<th>No</th>
								<th><?php echo $this->lang->line('Dari'); ?></th>
								<th><?php echo $this->lang->line('Kepada'); ?></th>
								<th><?php echo $this->lang->line('Isi Pesan'); ?></th>
								<th><?php echo $this->lang->line('Tanggal'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php
							$ii = 1;
							foreach($pesan as $row) { 
								if($row["pbm_user"] != ""){
									$dari = COMPANY_NAME;
									$ke = $this->session->userdata("nama_vendor");
									$style = "style=\"background: #9af5a1;\"";
								}
								else{
									$ke = COMPANY_NAME;
									$dari = $this->session->userdata("nama_vendor");
									$style = "style=\"background: #b5fabb;\"";
								}
								?>
								<tr <?php echo $style ?>>
									<td><?php echo $ii; ?></td>
									<td><?php echo $dari ?></td>
									<td><?php echo $ke ?></td>
									<td><?php echo $row["pbm_message"] ?></td>
									<td><?php echo $this->umum->show_tanggal($row["pbm_date"]) ?></td>
								</tr>
								<?php
								$ii++;
							}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<?php
	if($prep['ptm_status'] == 1140){ ?>
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title"> 
					<h5><?php echo $this->lang->line('Pesan Negosiasi'); ?></h5>
				</div>
				<div class="ibox-content">
					<p class="text-success" style="font-size:105%;"><?php echo $this->lang->line('Harap ubah rincian penawaran anda, ketika menawarkan harga baru. Klik'); ?> &nbsp;&nbsp;<button type="button" data-url="<?php echo site_url('pengadaan/edit_harga_nego'); ?>" class="btn btn-outline btn-danger btn-xs picker"><?php echo $this->lang->line('Ubah Harga'); ?></button> &nbsp;&nbsp;<?php echo $this->lang->line('untuk mengubah harga'); ?></p>
					<form id="komentar" method="POST" action="<?php echo site_url('pengadaan/submit_nego') ?>" class="form-horizontal">	
						<input type="hidden" name="pta_id" id="pta_id" value="<?php if(isset($pesan[0]["pta_id"])) { echo $pesan[0]["pta_id"]; } else { echo "1140"; } ?>">
						<input type="hidden" name="ptm_number" id="ptm_number" value="<?php echo $tenderid ?>">
						<textarea required class="form-control" rows="5" id="comment" name="comment"></textarea>
					</form>
				</div>
				<div class="ibox-content text-center">
					<button class="btn btn-primary" type="submit" id="submitBtn"><?php echo $this->lang->line('Kirim Negosiasi'); ?></button>
					<button class="btn btn-white" id="backBtn"><?php echo $this->lang->line('Kembali'); ?></button>
				</div>
			</div>
		</div>
	</div>
	<?php } else { ?>

	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-content text-center">
					<button class="btn btn-white" id="backBtn"><?php echo $this->lang->line('Kembali'); ?></button>	
				</div>
			</div>
		</div>
	</div>

	<?php } ?>
</div>

<script type="text/javascript">
	$(document).ready(function(){		
		$('.dataTables-example').DataTable({
			"lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
		});
		
		$(".picker").on("click",function(){
			var id = $(this).attr('data-id');
			$("#picker_id").val(id);
			var url = $(this).attr("data-url");
			$("#picker_content").load(url);
			$("#picker").modal("show");
			return false;
		});
		
		$("#picker_pick").click(function(){
			if($("#header").validate().form() && $("#komersial").validate().form()){
				$("#header").ajaxSubmit({
					success: function(msg){
						if(msg == "1"){
							$("#bidbond").ajaxSubmit({
								success: function(msg){

								},error: function(){
									swal("Error", "<?php echo $this->lang->line('Pesan-0 : Data Gagal Disimpan'); ?>", "error");
									button_enabled();
								}
							});
							$("#komersial").ajaxSubmit({
								success: function(msg){
									if(msg == "1"){
										swal({
											title: "<?php echo $this->lang->line('Data Berhasil Disimpan'); ?>",
											text: "<?php echo $this->lang->line('Silahkan isi pesan negosiasi dibawah ini'); ?>...",
											type: "success"
										},
										function(){
											$("#picker").modal("hide");
											return false;
										});
									}
									else{
										swal("Error", "Pesan-3: Data Komersial Gagal Disimpan", "error");
									}
								},
								error: function(){
									swal("Error", "Pesan-2: Data Komersial Gagal Disimpan", "error");
								}
							});
						}
						else{
							msg = msg.replace("<p>", "");
							msg = msg.replace("</p>", "");
							swal("Error", msg, "error");
						}
					},
					error: function(){
						swal("Error", "Pesan-1: Data Header Gagal Disimpan", "error");
					}
				});
			}
		});
		
		$("#backBtn").click(function(){
			window.history.back();
		});
		
		$("#submitBtn").click(function(){
			if($("#komentar").validate().form()){
				button_disabled();
				$("#komentar").ajaxSubmit({
					success: function(msg){
						if(msg == "1"){
							swal({
								title: "<?php echo $this->lang->line('Selamat, Negosiasi Anda Berhasil Dikirim'); ?>",
								type: "success"
							},
							function(){
								window.location.assign('<?php echo site_url(); ?>');
							});
						}
						else{
							swal("Error", "Pesan-1: Data Gagal Disimpan", "error");
							button_enabled();
						}
					},
					error: function(){
						swal("Error", "Pesan-2: Data Gagal Disimpan", "error");
						button_enabled();
					}
				});
			}
		});
	});
	
	function button_disabled(){
		$("#submitBtn").prop("disabled", true);
		$("#backBtn").prop("disabled", true);
		$("#submitBtn").text("<?php echo $this->lang->line('Sedang Mengirim Negosiasi'); ?>...");	
	}
	
	function button_enabled(){
		$("#submitBtn").prop("disabled", false);
		$("#backBtn").prop("disabled", false);
		$("#submitBtn").text("<?php echo $this->lang->line('Kirim Negosiasi'); ?>");	
	}
</script>