<div class="row wrapper border-bottom white-bg page-heading">
	<div class="col-lg-10">
		<h2><?php echo $this->lang->line('Profil Anda'); ?></h2>
	</div>
	<div class="col-lg-2">
		
	</div>
</div>

<div class="wrapper wrapper-content animated fadeIn">
	<div class="row m-t-lg">
		<div class="col-lg-12">
			<div class="tabs-container">
				
				<div class="tabs-left">
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#tab-1"><?php echo $this->lang->line('Data Utama'); ?></a></li>
						<li class=""><a data-toggle="tab" href="#tab-2"><?php echo $this->lang->line('Data Legal'); ?></a></li>
						<li class=""><a data-toggle="tab" href="#tab-3"><?php echo $this->lang->line('Pengurus Perusahaan'); ?></a></li>
						<li class=""><a data-toggle="tab" href="#tab-4"><?php echo $this->lang->line('Data Keuangan'); ?></a></li>
						<li class=""><a data-toggle="tab" href="#tab-5"><?php echo $this->lang->line('Barang/Jasa'); ?></a></li>
						<li class=""><a data-toggle="tab" href="#tab-6"><?php echo $this->lang->line('SDM'); ?></a></li>
						<li class=""><a data-toggle="tab" href="#tab-7"><?php echo $this->lang->line('Sertifikasi'); ?></a></li>
						<li class=""><a data-toggle="tab" href="#tab-8"><?php echo $this->lang->line('Fasilitas/Peralatan'); ?></a></li>
						<li class=""><a data-toggle="tab" href="#tab-9"><?php echo $this->lang->line('Pengalaman Proyek'); ?></a></li>
						<li class=""><a data-toggle="tab" href="#tab-10"><?php echo $this->lang->line('Data Tambahan'); ?></a></li>
						<li class=""><a data-toggle="tab" href="#tab-11">Data Dokumen</a></li>
					</ul>
					
					<div class="tab-content ">
						<div id="tab-1" class="tab-pane active">
							<div class="panel-body">
								<div class="panel panel-primary">
									<div class="panel-heading">
										<?php echo $this->lang->line('Nama Perusahaan'); ?>
									</div>
									<div style="padding: 15px;">
										<table class="table">
											
											<tr>
												<th><?php echo $this->lang->line('Prefiks'); ?></th>
												<td><?php echo $header[0]['prefix']; ?></td>
											</tr>
											<tr>
												<th><?php echo $this->lang->line('Prefiks Lainnya'); ?></th>
												<td><?php echo $header[0]['prefixOther']; ?></td>
											</tr>
											<tr>
												<th><?php echo $this->lang->line('Nama Perusahaan'); ?></th>
												<td><?php echo $header[0]['vendorName']; ?></td>
											</tr>
											<tr>
												<th><?php echo $this->lang->line('Sufiks'); ?></th>
												<td><?php echo $header[0]['suffix']; ?></td>
											</tr>
											<tr>
												<th><?php echo $this->lang->line('Sufiks Lainnya'); ?></th>
												<td><?php echo $header[0]['suffixOther']; ?></td>
											</tr>
											<tr>
												<th><?php echo $this->lang->line('Tipe Perusahaan'); ?></th>
												<td>
													<ol>
														<?php foreach($tipe as $row) { echo "<li>".$row['id']['companyType']."</li>"?>

														<?php } ?>
													</ol>
												</td>
											</tr>
											<tr>
												<th><?php echo $this->lang->line('Email Registrasi'); ?></th>
												<td><?php echo $header[0]['emailAddress']; ?></td>
											</tr>
										</table>
									</div>
								</div>
								
								<div class="panel panel-primary">
									<div class="panel-heading">
										<?php echo $this->lang->line('Kontak Perusahaan'); ?>
									</div>
									<div style="padding: 15px;">
										<div class="table-responsive">
											<table class="table table-striped table-bordered table-hover dataTables-example" >
												<thead>
													<tr>
														<th>No</th>
														<th><?php echo $this->lang->line('Jenis'); ?></th>
														<th><?php echo $this->lang->line('Alamat'); ?></th>
														<th><?php echo $this->lang->line('Kota'); ?></th>
														<th><?php echo $this->lang->line('Negara'); ?></th>
														<th><?php echo $this->lang->line('Telp Kantor-1'); ?></th>
														<th><?php echo $this->lang->line('Telp Kantor-2'); ?></th>
														<th><?php echo $this->lang->line('Fax'); ?></th>
														<th><?php echo $this->lang->line('Website'); ?></th>
													</tr>
												</thead>
												<tbody>
													<?php 
													$i = 1;
													foreach($alamat as $row) { ?>
													<tr>
														<td><?php echo $i ?></td>
														<td><?php echo $row["type"] ?></td>
														<td><?php echo $row["address"] ?></td>
														<td><?php echo $row["city"] ?></td>
														<td><?php echo $row["country"] ?></td>
														<td><?php echo $row["telephone1No"] ?></td>
														<td><?php echo $row["telephone2No"] ?></td>
														<td><?php echo $row["fax"] ?></td>
														<td><?php echo $row["website"] ?></td>
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

							<div class="panel panel-primary">
								<div class="panel-heading">
									<?php echo $this->lang->line('Kontak Person'); ?>
								</div>
								<div style="padding: 15px;">
									<table class="table">

										<tr>
											<th><?php echo $this->lang->line('Nama'); ?></th>
											<td><?php echo $header[0]['contactName']; ?></td>
										</tr>
										<tr>
											<th><?php echo $this->lang->line('Jabatan'); ?></th>
											<td><?php echo $header[0]['contactPos']; ?></td>
										</tr>
										<tr>
											<th><?php echo $this->lang->line('Nomor Telepon'); ?></th>
											<td><?php echo $header[0]['contactPhoneNo']; ?></td>
										</tr>
										<tr>
											<th><?php echo $this->lang->line('Alamat Email'); ?></th>
											<td><?php echo $header[0]['contactEmail']; ?></td>
										</tr>
									</table>
								</div>
							</div>

						</div>

					</div>
					<div id="tab-2" class="tab-pane">
						<div class="panel-body">
							<div class="panel panel-primary">
								<div class="panel-heading">
									<?php echo $this->lang->line('Akta Pendirian'); ?>
								</div>
								<div style="padding: 15px;">
									<div class="table-responsive">
										<table class="table table-striped table-bordered table-hover dataTables-example" >
											<thead>
												<tr>
													<th><?php echo $this->lang->line('No Akta'); ?></th>
													<th><?php echo $this->lang->line('Jenis Akta'); ?></th>
													<th><?php echo $this->lang->line('Tanggal Pembuatan'); ?></th>
													<th><?php echo $this->lang->line('Notaris'); ?></th>
													<th><?php echo $this->lang->line('Alamat'); ?></th>
													<th><?php echo $this->lang->line('Pengesahan Kehakiman'); ?></th>
													<th><?php echo $this->lang->line('Berita Negara'); ?></th>
												</tr>
											</thead>
											<tbody>
												<?php 
												$i = 1;
												foreach($akta as $row) { ?>
												<tr>
													<td><?php echo $row["aktaNo"] ?></td>
													<td><?php echo $row["aktaType"] ?></td>
													<td><?php echo $this->umum->show_tanggal($this->umum->unixtotime($row["dateCreation"]['time'])); ?></td>
													<td><?php echo $row["notarisName"] ?></td>
													<td><?php echo $row["notarisAddress"] ?></td>
													<td><?php echo $this->umum->show_tanggal($this->umum->unixtotime($row["pengesahanHakim"]['time'])); ?></td>
													<td><?php echo $this->umum->show_tanggal($this->umum->unixtotime($row["beritaAcaraNgr"]['time'])); ?></td>
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

						<div class="panel panel-primary">
							<div class="panel-heading">
								<?php echo $this->lang->line('Domisili Perusahaan'); ?>
							</div>
							<div style="padding: 15px;">
								<table class="table">

									<tr>
										<th><?php echo $this->lang->line('Nomor Domisili'); ?></th>
										<td><?php echo $header[0]['addressDomisiliNo']; ?></td>
									</tr>
									<tr>
										<th><?php echo $this->lang->line('Tanggal Domisili'); ?></th>
										<td><?php echo $this->umum->show_tanggal($this->umum->unixtotime($header[0]['addressDomisiliDate']['time'])); ?></td>
									</tr>
									<tr>
										<th><?php echo $this->lang->line('Kadaluarsa'); ?></th>
										<td><?php echo $this->umum->show_tanggal($this->umum->unixtotime($header[0]['addressDomisiliExpDate']['time'])) ?></td>
									</tr>
									<tr>
										<th><?php echo $this->lang->line('Alamat Perusahaan'); ?></th>
										<td><?php echo $header[0]['addressStreet']; ?></td>
									</tr>
									<tr>
										<th><?php echo $this->lang->line('Kota'); ?></th>
										<td><?php echo $header[0]['addressCity']; ?></td>
									</tr>
									<tr>
										<th><?php echo $this->lang->line('Provinsi'); ?></th>
										<td><?php echo $header[0]['addresProp']; ?></td>
									</tr>
									<tr>
										<th><?php echo $this->lang->line('Kode Pos'); ?></th>
										<td><?php echo $header[0]['addressPostcode']; ?></td>
									</tr>
									<tr>
										<th><?php echo $this->lang->line('Negara'); ?></th>
										<td><?php echo $header[0]['addressCountry']; ?></td>
									</tr>
									<tr>
										<th><?php echo $this->lang->line('Nomor Telepon'); ?></th>
										<td><?php echo $header[0]['addressPhoneNo']; ?></td>
									</tr>
								</table>
							</div>
						</div>

						<div class="panel panel-primary">
							<div class="panel-heading">
								<?php echo $this->lang->line('Nilai Pokok Wajib Pajak (NPWP)'); ?>
							</div>
							<div style="padding: 15px;">
								<table class="table">

									<tr>
										<th><?php echo $this->lang->line('Nomor'); ?></th>
										<td><?php echo $header[0]['npwpNo']; ?></td>
									</tr>
									<tr>
										<th><?php echo $this->lang->line('Alamat (Sesuai NPWP)'); ?></th>
										<td><?php echo $header[0]['npwpAddress']; ?></td>
									</tr>
									<tr>
										<th><?php echo $this->lang->line('Kota'); ?></th>
										<td><?php echo $header[0]['npwpCity']; ?></td>
									</tr>
									<tr>
										<th><?php echo $this->lang->line('Provinsi'); ?></th>
										<td><?php echo $header[0]['npwpProp']; ?></td>
									</tr>
									<tr>
										<th><?php echo $this->lang->line('Kode Pos'); ?></th>
										<td><?php echo $header[0]['npwpPostcode']; ?></td>
									</tr>
									<tr>
										<th><?php echo $this->lang->line('PKP'); ?></th>
										<td><?php echo $header[0]['npwpPkp']; ?></td>
									</tr>
									<tr>
										<th><?php echo $this->lang->line('Nomor PKP'); ?></th>
										<td><?php echo $header[0]['npwpPkpNo']; ?></td>
									</tr>
								</table>
							</div>
						</div>

						<div class="panel panel-primary">
							<div class="panel-heading">
								<?php echo $this->lang->line('Jenis Mitra Kerja'); ?>
							</div>
							<div style="padding: 15px;">
								<table class="table">

									<tr>
										<th><?php echo $this->lang->line('Mitra Kerja'); ?></th>
										<td><?php echo $header[0]['vendorType']; ?></td>
									</tr>
								</table>
							</div>
						</div>

						<div class="panel panel-primary">
							<div class="panel-heading">
								<?php echo $this->lang->line('Surat Izin Usaha Perusahaan (SIUP)'); ?>
							</div>
							<div style="padding: 15px;">
								<table class="table">

									<tr>
										<th><?php echo $this->lang->line('Dikeluarkan Oleh'); ?></th>
										<td><?php echo $header[0]['siupIssuedBy']; ?></td>
									</tr>
									<tr>
										<th><?php echo $this->lang->line('Nomor'); ?></th>
										<td><?php echo $header[0]['siupNo']; ?></td>
									</tr>
									<tr>
										<th><?php echo $this->lang->line('Jenis SIUP'); ?></th>
										<td><?php echo $header[0]['siupType']; ?></td>
									</tr>
									<tr>
										<th><?php echo $this->lang->line('Berlaku Mulai'); ?></th>
										<td><?php echo $this->umum->show_tanggal($this->umum->unixtotime($header[0]['siupFrom']['time']))?></td>
									</tr>
									<tr>
										<th><?php echo $this->lang->line('Berlaku Sampai'); ?></th>
										<td><?php echo $this->umum->show_tanggal($this->umum->unixtotime($header[0]['siupTo']['time']))?></td>
									</tr>
								</table>
							</div>
						</div>

						<div class="panel panel-primary">
							<div class="panel-heading">
								<?php echo $this->lang->line('Izin Lain Lain'); ?>
							</div>
							<div style="padding: 15px;">
								<div class="table-responsive">
									<table class="table table-striped table-bordered table-hover dataTables-example" >
										<thead>
											<tr>
												<th><?php echo $this->lang->line('No'); ?></th>
												<th><?php echo $this->lang->line('Jenis Izin'); ?></th>
												<th><?php echo $this->lang->line('Dikeluarkan Oleh'); ?></th>
												<th><?php echo $this->lang->line('Nomor'); ?></th>
												<th><?php echo $this->lang->line('Berlaku Mulai'); ?></th>
												<th><?php echo $this->lang->line('Berlaku Sampai'); ?></th>
											</tr>
										</thead>
										<tbody>
											<?php 
											$i = 1;
											foreach($izin_lain as $row) { ?>
											<tr>
												<td><?php echo $i; ?></td>
												<td><?php echo $row["type"] ?></td>
												<td><?php echo $row["issuedBy"] ?></td>
												<td><?php echo $row["no"] ?></td>
												<td><?php echo $this->umum->show_tanggal($this->umum->unixtotime($row["startDate"]["time"]))?></td>
												<td><?php echo $this->umum->show_tanggal($this->umum->unixtotime($row["endDate"]["time"]))?></td>
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

					<div class="panel panel-primary">
						<div class="panel-heading">
							<?php echo $this->lang->line('Tanda Daftar Perusahaan (TDP)'); ?>
						</div>
						<div style="padding: 15px;">
							<table class="table">

								<tr>
									<th><?php echo $this->lang->line('Dikeluarkan Oleh'); ?></th>
									<td><?php echo $header[0]['tdpIssuedBy']; ?></td>
								</tr>
								<tr>
									<th><?php echo $this->lang->line('Nomor'); ?></th>
									<td><?php echo $header[0]['tdpNo']; ?></td>
								</tr>
								<tr>
									<th><?php echo $this->lang->line('Berlaku Mulai'); ?></th>
									<td><?php echo $this->umum->show_tanggal($this->umum->unixtotime($header[0]['tdpFrom']['time']))?></td>
								</tr>
								<tr>
									<th><?php echo $this->lang->line('Berlaku Sampai'); ?></th>
									<td><?php echo $this->umum->show_tanggal($this->umum->unixtotime($header[0]['tdpTo']['time']))?></td>
								</tr>
							</table>
						</div>
					</div>

					<div class="panel panel-primary">
						<div class="panel-heading">
							<?php echo $this->lang->line('Surat Keagenan/Distributorship'); ?>
						</div>
						<div style="padding: 15px;">
							<div class="table-responsive">
								<table class="table table-striped table-bordered table-hover dataTables-example" >
									<thead>
										<tr>
											<th><?php echo $this->lang->line('No'); ?></th>
											<th><?php echo $this->lang->line('Dikeluarkan Oleh'); ?></th>
											<th><?php echo $this->lang->line('Nomor'); ?></th>
											<th><?php echo $this->lang->line('Berlaku Mulai'); ?></th>
											<th><?php echo $this->lang->line('Berlaku Sampai'); ?></th>
										</tr>
									</thead>
									<tbody>
										<?php 
										$i = 1;
										foreach($agent_importir as $row) { if($row["type"] == "AGENT") {?>
										<tr>
											<td><?php echo $i; ?></td>
											<td><?php echo $row["issuedBy"] ?></td>
											<td><?php echo $row["no"] ?></td>
											<td><?php echo $this->umum->show_tanggal($this->umum->unixtotime($row["createdDate"]))?></td>
											<td><?php echo $this->umum->show_tanggal($this->umum->unixtotime($row["expiredDate"]))?></td>
										</tr>
										<?php
										$i++;
									}
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>


			<div class="panel panel-primary">
				<div class="panel-heading">
					<?php echo $this->lang->line('Angka Pengenal Importir'); ?>
				</div>
				<div style="padding: 15px;">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover dataTables-example" >
							<thead>
								<tr>
									<th><?php echo $this->lang->line('No'); ?></th>
									<th><?php echo $this->lang->line('Dikeluarkan Oleh'); ?></th>
									<th><?php echo $this->lang->line('Nomor'); ?></th>
									<th><?php echo $this->lang->line('Berlaku Mulai'); ?></th>
									<th><?php echo $this->lang->line('Berlaku Sampai'); ?></th>
								</tr>
							</thead>
							<tbody>
								<?php 
								$i = 1;
								foreach($agent_importir as $row) { if($row["type"] == "IMPORTIR") {?>
								<tr>
									<td><?php echo $i; ?></td>
									<td><?php echo $row["issuedBy"] ?></td>
									<td><?php echo $row["no"] ?></td>
									<td><?php echo $this->umum->show_tanggal($this->umum->unixtotime($row["createdDate"]))?></td>
									<td><?php echo $this->umum->show_tanggal($this->umum->unixtotime($row["expiredDate"]))?></td>
								</tr>
								<?php
								$i++;
							}
						}
						?>
					</tbody>
				</table>
			</div>
		</div>
	</div>

</div>
</div>
<div id="tab-3" class="tab-pane">
	<div class="panel-body">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<?php echo $this->lang->line('Dewan Komisaris'); ?>
			</div>
			<div style="padding: 15px;">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover dataTables-example" >
						<thead>
							<tr>
								<th><?php echo $this->lang->line('No'); ?></th>
								<th><?php echo $this->lang->line('Nama'); ?></th>
								<th><?php echo $this->lang->line('Jabatan'); ?></th>
								<th><?php echo $this->lang->line('Telepon'); ?></th>
								<th><?php echo $this->lang->line('Email'); ?></th>
								<th><?php echo $this->lang->line('KTP'); ?></th>
								<th><?php echo $this->lang->line('NPWP'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$i = 1;
							foreach($board as $row) {  if($row["type"] == "BOC") {?>
							<tr>
								<td><?php echo $i ?></td>
								<td><?php echo $row["name"] ?></td>
								<td><?php echo $row["pos"]; ?></td>
								<td><?php echo $row["telephoneNo"] ?></td>
								<td><?php echo $row["emailAddress"] ?></td>
								<td><?php echo $row["ktpNo"] ?></td>
								<td><?php echo $row["npwpNo"] ?></td>
							</tr>
							<?php
							$i++;
						}
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="panel panel-primary">
	<div class="panel-heading">
		<?php echo $this->lang->line('Dewan Direksi'); ?>
	</div>
	<div style="padding: 15px;">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover dataTables-example" >
				<thead>
					<tr>
						<th><?php echo $this->lang->line('No'); ?></th>
						<th><?php echo $this->lang->line('Nama'); ?></th>
						<th><?php echo $this->lang->line('Jabatan'); ?></th>
						<th><?php echo $this->lang->line('Telepon'); ?></th>
						<th><?php echo $this->lang->line('Email'); ?></th>
						<th><?php echo $this->lang->line('KTP'); ?></th>
						<th><?php echo $this->lang->line('NPWP'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
					foreach($board as $row) {  if($row["type"] == "BOD") {?>
					<tr>
						<td><?php echo $i ?></td>
						<td><?php echo $row["name"] ?></td>
						<td><?php echo $row["pos"]; ?></td>
						<td><?php echo $row["telephoneNo"] ?></td>
						<td><?php echo $row["emailAddress"] ?></td>
						<td><?php echo $row["ktpNo"] ?></td>
						<td><?php echo $row["npwpNo"] ?></td>
					</tr>
					<?php
					$i++;
				}
			}
			?>
		</tbody>
	</table>
</div>
</div>
</div>
</div>
</div>
<div id="tab-4" class="tab-pane">
	<div class="panel-body">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<?php echo $this->lang->line('Rekening Bank'); ?>
			</div>
			<div style="padding: 15px;">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover dataTables-example" >
						<thead>
							<tr>
								<th><?php echo $this->lang->line('No'); ?></th>
								<th><?php echo $this->lang->line('No.Rekening'); ?></th>
								<th><?php echo $this->lang->line('Pemegang Rekening'); ?></th>
								<th><?php echo $this->lang->line('Nama Bank'); ?></th>
								<th><?php echo $this->lang->line('Cabang Bank'); ?></th>
								<th><?php echo $this->lang->line('Alamat'); ?></th>
								<th><?php echo $this->lang->line('Valuta'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$i = 1;
							foreach($bank as $row) { ?>
							<tr>
								<td><?php echo $i ?></td>
								<td><?php echo $row["accountNo"] ?></td>
								<td><?php echo $row["accountName"]; ?></td>
								<td><?php echo $row["bankName"] ?></td>
								<td><?php echo $row["bankBranch"] ?></td>
								<td><?php echo $row["address"] ?></td>
								<td><?php echo $row["currency"] ?></td>
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
	<div class="panel panel-primary">
		<div class="panel-heading">
			<?php echo $this->lang->line('Modal Sesuai Data Terakhir'); ?>
		</div>
		<div style="padding: 15px;">
			<table class="table">

				<tr>
					<th><?php echo $this->lang->line('Modal Dasar'); ?></th>
					<td><?php echo $this->umum->cetakuang($header[0]['finAktaMdlDsr'], $header[0]['finAktaMdlDsrCurr']); ?></td>
				</tr>
				<tr>
					<th><?php echo $this->lang->line('Modal Setor'); ?></th>
					<td><?php echo $this->umum->cetakuang($header[0]['finAktaMdlStr'], $header[0]['finAktaMdlStrCurr']); ?></td>
				</tr>
			</table>
		</div>
	</div>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<?php echo $this->lang->line('Informasi Laporan Keuangan'); ?>
		</div>
		<div style="padding: 15px;">
			<div class="table-responsive">
				<table class="table table-striped table-bordered table-hover dataTables-example" >
					<thead>
						<tr>
							<th><?php echo $this->lang->line('No'); ?></th>
							<th><?php echo $this->lang->line('Tahun Laporan'); ?></th>
							<th><?php echo $this->lang->line('Jenis Laporan'); ?></th>
							<th><?php echo $this->lang->line('Total Nilai Aset'); ?></th>
							<th><?php echo $this->lang->line('Hutang Perusahaan'); ?></th>
							<th><?php echo $this->lang->line('Pendapatan Kotor'); ?></th>
							<th><?php echo $this->lang->line('Laba Bersih'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php 
						$i = 1;
						foreach($financial as $row) { ?>
						<tr>
							<td><?php echo $i; ?></td>
							<td><?php echo $row["finRptYear"]; ?></td>
							<td><?php echo $row["finRptType"]; ?></td>
							<td><?php echo $this->umum->cetakuang($row["finRptAssetValue"], $row["finRptCurrency"]) ?></td>
							<td><?php echo $this->umum->cetakuang($row["finRptHutang"], $row["finRptCurrency"]) ?></td>
							<td><?php echo $this->umum->cetakuang($row["finRptRevenue"], $row["finRptCurrency"]) ?></td>
							<td><?php echo $this->umum->cetakuang($row["finRptNetincome"], $row["finRptCurrency"]) ?></td>
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
<div class="panel panel-primary">
	<div class="panel-heading">
		<?php echo $this->lang->line('Klasifikasi Perusahaan'); ?>
	</div>
	<div style="padding: 15px;">
		<table class="table">

			<tr>
				<th><?php echo $this->lang->line('Klasifikasi Perusahaan'); ?></th>
				<td><?php if($header[0]['finClass'] == "3") { echo "BESAR"; } else if($header[0]['finClass'] == "2"){ echo "MENENGAH"; } else if($header[0]['finClass'] == "1"){ echo "KECIL"; } ?></td>
			</tr>
		</table>
	</div>
</div>
</div>
</div>
<div id="tab-5" class="tab-pane">
	<div class="panel-body">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<?php echo $this->lang->line('Barang yang Bisa Dipasok'); ?>
			</div>
			<div style="padding: 15px;">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover dataTables-example" >
						<thead>
							<tr>
								<th><?php echo $this->lang->line('No'); ?></th>
								<th><?php echo $this->lang->line('Jenis Komoditas'); ?></th>
								<th><?php echo $this->lang->line('Nama Barang'); ?></th>
								<th><?php echo $this->lang->line('Merk'); ?></th>
								<th><?php echo $this->lang->line('Sumber'); ?></th>
								<th><?php echo $this->lang->line('Tipe'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$i = 1;
							foreach($barang as $row) { if($row["catalog_type"] == "M") { ?>
							<tr>
								<td><?php echo $i ?></td>
								<td><?php echo $row["product_description"]; ?></td>
								<td><?php echo $row["product_name"] ?></td>
								<td><?php echo $row["brand"] ?></td>
								<td><?php echo $row["source"] ?></td>
								<td><?php echo $row["type"] ?></td>
							</tr>
							<?php
							$i++;
						}
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="panel panel-primary">
	<div class="panel-heading">
		<?php echo $this->lang->line('Jasa yang Bisa Dipasok'); ?>
	</div>
	<div style="padding: 15px;">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover dataTables-example" >
				<thead>
					<tr>
						<th><?php echo $this->lang->line('No'); ?></th>
						<th><?php echo $this->lang->line('Jenis Komoditas'); ?></th>
						<th><?php echo $this->lang->line('Nama Barang'); ?></th>
						<th><?php echo $this->lang->line('Merk'); ?></th>
						<th><?php echo $this->lang->line('Sumber'); ?></th>
						<th><?php echo $this->lang->line('Tipe'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
					foreach($barang as $row) { if($row["catalog_type"] == "S") { ?>
					<tr>
						<td><?php echo $i ?></td>
						<td><?php echo $row["product_description"]; ?></td>
						<td><?php echo $row["product_name"] ?></td>
						<td><?php echo $row["brand"] ?></td>
						<td><?php echo $row["source"] ?></td>
						<td><?php echo $row["type"] ?></td>
					</tr>
					<?php
					$i++;
				}
			}
			?>
		</tbody>
	</table>
</div>
</div>
</div>
</div>
</div>
<div id="tab-6" class="tab-pane">
	<div class="panel-body">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<?php echo $this->lang->line('Tenaga Ahli Utama'); ?>
			</div>
			<div style="padding: 15px;">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover dataTables-example" >
						<thead>
							<tr>
								<th><?php echo $this->lang->line('No'); ?></th>
								<th><?php echo $this->lang->line('Nama'); ?></th>
								<th><?php echo $this->lang->line('Pendidikan Terakhir'); ?></th>
								<th><?php echo $this->lang->line('Pengalaman'); ?></th>
								<th><?php echo $this->lang->line('Status'); ?></th>
								<th><?php echo $this->lang->line('Kewarganegaraan'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$i = 1;
							foreach($sdm as $row) { if($row["type"] == "PRIMER") { ?>
							<tr>
								<td><?php echo $i ?></td>
								<td><?php echo $row["name"]; ?></td>
								<td><?php echo $row["lastEducation"] ?></td>
								<td><?php echo $row["yearExp"] ?></td>
								<td><?php echo $row["empStatus"] ?></td>
								<td><?php echo $row["empType"] ?></td>
							</tr>
							<?php
							$i++;
						}
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="panel panel-primary">
	<div class="panel-heading">
		<?php echo $this->lang->line('Tenaga Ahli Pendukung'); ?>
	</div>
	<div style="padding: 15px;">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover dataTables-example" >
				<thead>
					<tr>
						<th><?php echo $this->lang->line('No'); ?></th>
						<th><?php echo $this->lang->line('Nama'); ?></th>
						<th><?php echo $this->lang->line('Pendidikan Terakhir'); ?></th>
						<th><?php echo $this->lang->line('Pengalaman'); ?></th>
						<th><?php echo $this->lang->line('Status'); ?></th>
						<th><?php echo $this->lang->line('Kewarganegaraan'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
					foreach($sdm as $row) { if($row["type"] == "SUPPORT") { ?>
					<tr>
						<td><?php echo $i ?></td>
						<td><?php echo $row["name"]; ?></td>
						<td><?php echo $row["lastEducation"] ?></td>
						<td><?php echo $row["yearExp"] ?></td>
						<td><?php echo $row["empStatus"] ?></td>
						<td><?php echo $row["empType"] ?></td>
					</tr>
					<?php
					$i++;
				}
			}
			?>
		</tbody>
	</table>
</div>
</div>
</div>
</div>
</div>
<div id="tab-7" class="tab-pane">
	<div class="panel-body">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<?php echo $this->lang->line('Keterangan Sertifikasi'); ?>
			</div>
			<div style="padding: 15px;">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover dataTables-example" >
						<thead>
							<tr>
								<th><?php echo $this->lang->line('No'); ?></th>
								<th><?php echo $this->lang->line('Jenis'); ?></th>
								<th><?php echo $this->lang->line('Nama Sertifikat'); ?></th>
								<th><?php echo $this->lang->line('Nomor Sertifikat'); ?></th>
								<th><?php echo $this->lang->line('Dikeluarkan Oleh'); ?></th>
								<th><?php echo $this->lang->line('Berlaku Mulai'); ?></th>
								<th><?php echo $this->lang->line('Berlaku Sampai'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$i = 1;
							foreach($sertifikasi as $row) { ?>
							<tr>
								<td><?php echo $i ?></td>
								<td><?php echo $row["type"]; ?></td>
								<td><?php echo $row["certName"] ?></td>
								<td><?php echo $row["certNo"] ?></td>
								<td><?php echo $row["issuedBy"] ?></td>
								<td><?php echo $this->umum->show_tanggal($this->umum->unixtotime($row["validFrom"]["time"])) ?></td>
								<td><?php echo $this->umum->show_tanggal($this->umum->unixtotime($row["validTo"]["time"])) ?></td>
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
<div id="tab-8" class="tab-pane">
	<div class="panel-body">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<?php echo $this->lang->line('Keterangan Fasilitas/Peralatan'); ?>
			</div>
			<div style="padding: 15px;">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover dataTables-example" >
						<thead>
							<tr>
								<th><?php echo $this->lang->line('No'); ?></th>
								<th><?php echo $this->lang->line('Kategori'); ?></th>
								<th><?php echo $this->lang->line('Nama Peralatan'); ?></th>
								<th><?php echo $this->lang->line('Spesifikasi'); ?></th>
								<th><?php echo $this->lang->line('Kuantitas'); ?></th>
								<th><?php echo $this->lang->line('Tahun Pembuatan'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$i = 1;
							foreach($fasilitas as $row) { ?>
							<tr>
								<td><?php echo $i ?></td>
								<td><?php echo $row["category"]; ?></td>
								<td><?php echo $row["equipName"] ?></td>
								<td><?php echo $row["spec"] ?></td>
								<td><?php echo $row["yearMade"] ?></td>
								<td><?php echo $row["quantity"] ?></td>
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
<div id="tab-9" class="tab-pane">
	<div class="panel-body">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<?php echo $this->lang->line('Pengalaman Pekerjaan'); ?>
			</div>
			<div style="padding: 15px;">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover dataTables-example" >
						<thead>
							<tr>
								<th><?php echo $this->lang->line('No'); ?></th>
								<th><?php echo $this->lang->line('Nama Pelanggan'); ?></th>
								<th><?php echo $this->lang->line('Nama Proyek'); ?></th>
								<th><?php echo $this->lang->line('Keterangan Proyek'); ?></th>
								<th><?php echo $this->lang->line('Nilai'); ?></th>
								<th><?php echo $this->lang->line('Nomor Kontrak'); ?></th>
								<th><?php echo $this->lang->line('Tanggal Dimulai'); ?></th>
								<th><?php echo $this->lang->line('Tanggal Selesai'); ?></th>
								<th>Contact Person</th>
								<th><?php echo $this->lang->line('No Kontak'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$i = 1;
							foreach($pengalaman as $row) { ?>
							<tr>
								<td><?php echo $i ?></td>
								<td><?php echo $row["clientName"]; ?></td>
								<td><?php echo $row["projectName"] ?></td>
								<td><?php echo $row["description"] ?></td>
								<td><?php echo $this->umum->cetakuang($row["amount"], $row["currency"]) ?></td>
								<td><?php echo $row["contractNo"] ?></td>
								<td><?php echo $this->umum->show_tanggal($this->umum->unixtotime($row["startDate"]["time"])) ?></td>
								<td><?php echo $this->umum->show_tanggal($this->umum->unixtotime($row["endDate"]["time"])) ?></td>
								<td><?php echo $row["contactPerson"] ?></td>
								<td><?php echo $row["contactNo"] ?></td>
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
<div id="tab-10" class="tab-pane">
	<div class="panel-body">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<?php echo $this->lang->line('Prinsipal'); ?>
			</div>
			<div style="padding: 15px;">
				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover dataTables-example" >
						<thead>
							<tr>
								<th><?php echo $this->lang->line('No'); ?></th>
								<th><?php echo $this->lang->line('Nama'); ?></th>
								<th><?php echo $this->lang->line('Alamat'); ?></th>
								<th><?php echo $this->lang->line('Kota'); ?></th>
								<th><?php echo $this->lang->line('Negara'); ?></th>
								<th><?php echo $this->lang->line('Kode Pos'); ?></th>
								<th><?php echo $this->lang->line('Kualifikasi'); ?></th>
								<th><?php echo $this->lang->line('Hubungan'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$i = 1;
							foreach($tambahan as $row) { if($row["type"] == "PRINCIPAL") { ?>
							<tr>
								<td><?php echo $i ?></td>
								<td><?php echo $row["name"]; ?></td>
								<td><?php echo $row["address"] ?></td>
								<td><?php echo $row["city"] ?></td>
								<td><?php echo $row["country"] ?></td>
								<td><?php echo $row["postCode"] ?></td>
								<td><?php echo $row["qualification"] ?></td>
								<td><?php echo $row["relationship"] ?></td>
							</tr>
							<?php
							$i++;
						}
					}
					?>
				</tbody>
			</table>
		</div>
	</div>
</div>
<div class="panel panel-primary">
	<div class="panel-heading">
		<?php echo $this->lang->line('Afiliasi'); ?>
	</div>
	<div style="padding: 15px;">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover dataTables-example" >
				<thead>
					<tr>
						<th><?php echo $this->lang->line('No'); ?></th>
						<th><?php echo $this->lang->line('Nama'); ?></th>
						<th><?php echo $this->lang->line('Alamat'); ?></th>
						<th><?php echo $this->lang->line('Kota'); ?></th>
						<th><?php echo $this->lang->line('Negara'); ?></th>
						<th><?php echo $this->lang->line('Kode Pos'); ?></th>
						<th><?php echo $this->lang->line('Kualifikasi'); ?></th>
						<th><?php echo $this->lang->line('Hubungan'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
					foreach($tambahan as $row) { if($row["type"] == "AFFILIATE") { ?>
					<tr>
						<td><?php echo $i ?></td>
						<td><?php echo $row["name"]; ?></td>
						<td><?php echo $row["address"] ?></td>
						<td><?php echo $row["city"] ?></td>
						<td><?php echo $row["country"] ?></td>
						<td><?php echo $row["postCode"] ?></td>
						<td><?php echo $row["qualification"] ?></td>
						<td><?php echo $row["relationship"] ?></td>
					</tr>
					<?php
					$i++;
				}
			}
			?>
		</tbody>
	</table>
</div>
</div>
</div>
<div class="panel panel-primary">
	<div class="panel-heading">
		<?php echo $this->lang->line('Subkontraktor'); ?>
	</div>
	<div style="padding: 15px;">
		<div class="table-responsive">
			<table class="table table-striped table-bordered table-hover dataTables-example" >
				<thead>
					<tr>
						<th><?php echo $this->lang->line('No'); ?></th>
						<th><?php echo $this->lang->line('Nama'); ?></th>
						<th><?php echo $this->lang->line('Alamat'); ?></th>
						<th><?php echo $this->lang->line('Kota'); ?></th>
						<th><?php echo $this->lang->line('Negara'); ?></th>
						<th><?php echo $this->lang->line('Kode Pos'); ?></th>
						<th><?php echo $this->lang->line('Kualifikasi'); ?></th>
						<th><?php echo $this->lang->line('Hubungan'); ?></th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$i = 1;
					foreach($tambahan as $row) { if($row["type"] == "SUBCONTRACTOR") { ?>
					<tr>
						<td><?php echo $i ?></td>
						<td><?php echo $row["name"]; ?></td>
						<td><?php echo $row["address"] ?></td>
						<td><?php echo $row["city"] ?></td>
						<td><?php echo $row["country"] ?></td>
						<td><?php echo $row["postCode"] ?></td>
						<td><?php echo $row["qualification"] ?></td>
						<td><?php echo $row["relationship"] ?></td>
					</tr>
					<?php
					$i++;
				}
			}
			?>
		</tbody>
	</table>
</div>
</div>
</div>
</div>
</div>

<div id="tab-11" class="tab-pane">
	<div class="panel-body">
		<div class="panel panel-primary">
			<div class="panel-heading">
				Dokumen
			</div>
			<div style="padding: 15px;">

				<div class="table-responsive">
					<table class="table table-striped table-bordered table-hover dataTables-example" >
						<thead>
							<tr>
								<th>No</th>
								<th>Nama</th>
								<th>File</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$i = 1;
							foreach($dokumen as $row) { ?>
							<tr>
								<td><?php echo $i ?></td>
								<td><?php echo $row["vndSuppdocDesc"]; ?></td>
								<td><a href="<?php echo $url_doc."/".$row["vndSuppdocFilename"] ?>" target="_blank"><?php echo $row["vndSuppdocFilename"] ?></a></td>
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