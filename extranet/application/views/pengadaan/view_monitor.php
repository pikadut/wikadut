<div class="wrapper wrapper-content animated fadeIn">
	<div class="row">
        <div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5><?php echo $this->lang->line('Informasi Umum'); ?></h5>
				</div>
				<div class="ibox-content">
					<table class="table">
						
						<tr>
							<th><?php echo $this->lang->line('Nomor Pengadaan'); ?></th>
							<td><?php echo $header["ptm_number"] ?></td>
						</tr>
						<tr>
							<th><?php echo $this->lang->line('Judul Pekerjaan'); ?></th>
							<td><?php echo $header["ptm_subject_of_work"] ?></td>
						</tr>
						<tr>
							<th><?php echo $this->lang->line('Deskripsi Pekerjaan'); ?></th>
							<td><?php echo $header["ptm_scope_of_work"] ?></td>
						</tr>
						<tr>
							<th><?php echo $this->lang->line('Jenis Kontrak'); ?></th>
							<td><?php echo $header["ptm_contract_type"] ?></td>
						</tr>
						<tr>
							<th><?php echo $this->lang->line('Klasifikasi Peserta'); ?></th>
							<td><?php $klas = str_split($header["ptp_klasifikasi_peserta"]);
								$i = 0;
								$count = 1;
								$temp = "";
								foreach($klas as $char) { 
									if($char == 1){
										if($i > 0){
											$temp .= ", ";
										}
										if($count == 1){
											$temp .= $this->lang->line('KECIL');
										}
										else if($count == 2){
											$temp .= $this->lang->line('MENENGAH');
										}
										else if($count == 3){
											$temp .= $this->lang->line('BESAR');
										}
										$i++;
									}
									$count++;
								}
							echo $temp;?></td>
						</tr>
						<tr>
							<th><?php echo $this->lang->line('Mata Uang Registrasi'); ?></th>
							<td><?php echo $header["ptm_currency"] ?></td>
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
					<h5><?php echo $this->lang->line('Item Pengadaan'); ?></h5>
				</div>
				<div class="ibox-content">
					<table class="table table-striped table-bordered dataTables-examples" >
						<thead>
							<tr>
								<th><?php echo $this->lang->line('Kode Barang Jasa'); ?></th>
								<th><?php echo $this->lang->line('Keterangan'); ?></th>
								<th><?php echo $this->lang->line('Jumlah'); ?></th>
								<th><?php echo $this->lang->line('Satuan'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php 
								foreach($item as $row) { ?>
								<tr>
									<td><?php echo $row["tit_code"] ?></td>
									<td><?php echo $row["tit_description"] ?></td>
									<td><?php echo $row["tit_quantity"] ?></td>
									<td><?php echo $row["tit_unit"] ?></td>
								</tr>
								<?php
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
        <div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5><?php echo $this->lang->line('Dokumen Pengadaan'); ?></h5>
				</div>
				<div class="ibox-content">
					<table class="table table-striped table-bordered dataTables-examples" >
						<thead>
							<tr>
								<th><?php echo $this->lang->line('Kategori'); ?></th>
								<th><?php echo $this->lang->line('Keterangan'); ?></th>
								<th><?php echo $this->lang->line('Nama File'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php 
								foreach($dokumen as $row) { ?>
								<tr>
									<td><?php echo $row["ptd_category"] ?></td>
									<td><?php echo $row["ptd_description"] ?></td>
									<td><a target="_blank" href="<?php echo site_url('welcome/download/internal/'.$this->umum->forbidden($this->encryption->encrypt($row["ptd_file_name"]), 'enkrip'))?>"><?php echo $row["ptd_file_name"] ?></a></td>
								</tr>
								<?php
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	
	<div class="row">
        <div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5><?php echo $this->lang->line('Informasi Umum'); ?></h5>
				</div>
				<div class="ibox-content">
					<table class="table">
						
						<tr>
							<th><?php echo $this->lang->line('Metode Pengadaan'); ?></th>
							<td><?php echo $header["metode"] ?></td>
						</tr>
						<tr>
							<th><?php echo $this->lang->line('Tanggal Pembukaan Pendaftaran'); ?></th>
							<?php $curval = (strtotime($header["ptp_reg_opening_date"]) > 0) ? $this->umum->show_tanggal($header["ptp_reg_opening_date"]) : ""; ?>
							<td><?php echo $curval ?></td>
						</tr>
						<tr>
							<th><?php echo $this->lang->line('Tanggal Penutupan Pendaftaran'); ?></th>
							<?php $curval = (strtotime($header["ptp_reg_closing_date"]) > 0) ? $this->umum->show_tanggal($header["ptp_reg_closing_date"]) : ""; ?>
							<td><?php echo $curval ?></td>
							
						</tr>
						<tr>
							<th><?php echo $this->lang->line('Tanggal Aanwijzing'); ?></th>
							<?php $curval = (strtotime($header["ptp_prebid_date"]) > 0) ? $this->umum->show_tanggal($header["ptp_prebid_date"]) : ""; ?>
							<td><?php echo $curval ?></td>
						</tr>
						<tr>
							<th><?php echo $this->lang->line('Lokasi Aanwijzing'); ?></th>
							<td><?php echo $header["ptp_prebid_location"] ?></td>
						</tr>
						<tr>
							<th><?php echo $this->lang->line('Metode Aanwijzing'); ?></th>
							<td><?php if($header["ptp_aanwijzing_online"] == '1') { echo "ONLINE"; } else { echo "OFFLINE"; } ?></td>
						</tr>
						<tr>
							<th><?php echo $this->lang->line('Tanggal Mulai Kirim Penawaran'); ?></th>
							<?php $curval = (strtotime($header["ptp_quot_opening_date"]) > 0) ? $this->umum->show_tanggal($header["ptp_quot_opening_date"]) : ""; ?>
							<td><?php echo $curval ?></td>
						</tr>
						<tr>
							<th><?php echo $this->lang->line('Tanggal Akhir Kirim Penawaran'); ?></th>
							<?php $curval = (strtotime($header["ptp_quot_closing_date"]) > 0) ? $this->umum->show_tanggal($header["ptp_quot_closing_date"]) : ""; ?>
							<td><?php echo $curval ?></td>
						</tr>
						<tr>
							<th><?php echo $this->lang->line('Tanggal Pembukaan Dokumen Penawaran'); ?></th>
							<?php $curval = (strtotime($header["ptp_doc_open_date"]) > 0) ? $this->umum->show_tanggal($header["ptp_doc_open_date"]) : ""; ?>
							<td><?php echo $curval ?></td>
						</tr>

						<tr>
							<th><?php echo $this->lang->line('Pra Kualifikasi'); ?></th>
							<?php $curval = (empty($header["ptp_prequalify"])) ? "Tidak" : "Ya"; ?>
							<td><?php echo $curval ?></td>
						</tr>

						<!-- shantika -->
						<tr>
							<th><?php echo $this->lang->line('Eauction'); ?></th>
							<td><?php if($header["ptp_eauction"] == '1') { echo "Ya"; } else { echo "Tidak"; } ?></td>
						</tr>
						<!-- end -->

						<tr>
							<th><?php echo $this->lang->line('Aanwijzing Online'); ?></th>
							<?php $curval = (empty($header["ptp_aanwijzing_online"])) ? "Tidak" : "Ya"; ?>
							<td><?php echo $curval ?></td>
						</tr>

						<?php if($tahap2) { ?>
						<tr>
							<th><?php echo $this->lang->line('Tanggal Aanwijzing ke-2'); ?></th>
							<?php $curval = (strtotime($header["ptp_tgl_aanwijzing2"]) > 0) ? $this->umum->show_tanggal($header["ptp_tgl_aanwijzing2"]) : ""; ?>
							<td><?php echo $curval ?></td>
						</tr>
						<tr>
							<th><?php echo $this->lang->line('Lokasi Aanwijzing ke-2'); ?></th>
							<td><?php echo $header["ptp_lokasi_aanwijzing2"] ?></td>
						</tr>
						<tr>
							<th><?php echo $this->lang->line('Tanggal Pembukaan Penawaran Harga'); ?></th>
							<?php $curval = (strtotime($header["ptp_bid_opening2"]) > 0) ? $this->umum->show_tanggal($header["ptp_bid_opening2"]) : ""; ?>
							<td><?php echo $curval ?></td>
						</tr>
						<?php } ?>
						<!-- <tr>
							<th><?php //echo $this->lang->line('Nilai PR'); ?></th>
							<td><?php //echo number_format($header["nilai"], 2, '.', ',') ?></td>
						</tr> -->
					</table>
				</div>
			</div>
		</div>
	</div>
	
<!-- 	<?php if($submits) { ?>
	<div class="row">
        <div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-content text-center">
					<form action="<?php echo site_url('pengadaan/daftar') ?>" method="POST" enctype='multipart/form-data'>
						<input hidden id="ptm_number" name="ptm_number" value="<?php echo $header["ptm_number"] ?>">
						<?php if(isset($lelang)) { ?>
						<input hidden id="lelang" name="lelang" value="1">
						<div class="form-group"><label class="col-sm-6 control-label"><?php echo $this->lang->line('Lampiran Prakualifikasi'); ?> <small>(Max 10MB)</small></label>
							<div class="col-lg-6 m-l-n"><input id="lampiran_prakualifikasi" name="lampiran_prakualifikasi" type="file" class="file"></div>
						</div>
						<?php } ?>
						<div class="form-group">
							<div class="i-checks"><label> <input type="checkbox" id="term" name="term"> <i></i> <?php echo $this->lang->line('Dengan ini saya menyatakan telah membaca dan memahami isi Dokumen Pelelangan'); ?> </label></div>
						</div>
						<div class="form-group"><label class="col-sm-2 control-label"><?php echo $this->lang->line('Jawaban'); ?></label>
							<div class="col-sm-2 m-l-n"><select class="form-control m-b" id="response" name="response" required>
								<option value="">--<?php echo $this->lang->line('Pilih'); ?>--</option>
								<option value="1"><?php echo $this->lang->line('Daftar'); ?></option>
								<?php if(!isset($lelang)) { ?>
								<option value="0"><?php echo $this->lang->line('Tidak Ikut'); ?></option>
								<?php } ?>
							</select>
							</div>
						</div>
						<div class="form-group">
							<button class="btn btn-primary" type="submit"><?php echo $this->lang->line('Kirim'); ?></button>
							<button class="btn btn-white" type="submit"><?php echo $this->lang->line('Kembali'); ?></button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<script>
	$(document).ready(function(){
		$('.i-checks').iCheck({
			checkboxClass: 'icheckbox_square-green',
			radioClass: 'iradio_square-green',
		});
	});
</script>
	<?php } ?> -->
</div>

<script>
	$(document).ready(function(){
		$('.dataTables-examples').DataTable({
			"lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
		});
		
		$("#response").change(function() {
			if($("#response").val() == 1){
			$("#term").attr("required", true);
			}
			else{
			$("#term").removeAttr("required");
			}
		});
	});
</script>