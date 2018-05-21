<?php
if(isset($readonly)){
	if($readonly == "1"){
		$readonly = "disabled";
	}
	else{
		$readonly = "";
	}
}
else{
	$readonly = "";
}
?>
<div class="wrapper wrapper-content animated fadeIn">
	<div class="row">
		<div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5>Penawaran</h5>
				</div>
				<div class="ibox-content">
					<form role="form" id="header" class="form-horizontal">	
						<input type="hidden" id="section" name="section" value="header">
						<input type="hidden" id="pqmid" name="pqmid" value="<?php if(isset($header)){ echo $header["pqm_id"]; } ?>">
						<div class="form-group">
							<label class="col-sm-2 control-label">Nomor Pengadaaan</label>
							<div class="col-lg-6 m-l-n"><input <?php echo $readonly ?> id="tenderid" name="tenderid" type="text" class="form-control" value="<?php echo $tenderid; ?>"></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Nomor Penawaran</label>
							<div class="col-lg-6 m-l-n"><input <?php echo $readonly ?> id="nopenawaran" name="nopenawaran" type="text" class="form-control" value="<?php if(isset($header)){ echo $header["pqm_number"]; } ?>" required></div>
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Tipe Penawaran</label>
							<div class="col-md-2 m-l-n">
								<p class="form-control-static">
									Tipe <?php echo $header["pqm_type"] ?>
								</p>
							</div>
						</div>

						<div class="form-group">
							<label class="col-sm-2 control-label">Nilai Bidbond</label>
							<div class="col-lg-6 m-l-n"><input <?php echo $readonly ?> onblur="fnChange('','bid_bond')" type="text" id="bid_bond" class="form-control" value="<?php if(isset($header)) { echo inttomoney($header["pqm_bid_bond_value"]); } ?>"></div>
							<input type="hidden" id="bid_bond_input" name="bid_bond_input" value="<?php if(isset($header)) { echo $header["pqm_bid_bond_value"]; } ?>">
						</div>
						<div class="form-group">
							<label class="col-sm-2 control-label">Lampiran Bidbond <small>(Max 2MB)</small></label>
							<div class="col-lg-6 m-l-n">
								<p class="form-control-static">
									<?php if(isset($header)){ ?>
									<a  href="<?php echo site_url('log/download_attachment_extranet/bidbond/'.$header['ptv_vendor_code'].'/'.$header["pqm_att"]); ?>" target="_blank"><?php echo $header["pqm_att"]; ?>
									</a>
									<?php } ?>
								</p>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label">Kandungan Lokal</label>
								<div class="col-md-2 m-l-n">
									<p class="form-control-static">
										<?php if(isset($header)) { echo $header["pqm_local_content"]; } ?>
									</p></div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Jangka Waktu Pelaksanaan</label>
									<div class="col-md-2 m-l-n">
										<p class="form-control-static">
											<?php if(isset($header)) { echo $header["pqm_deliverable_time"]; } ?> 
											<?php if(isset($header)) { echo $header["pqm_deliverable_unit"]; } ?>

										</p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Jangka Waktu Garansi</label>
									<div class="col-md-2 m-l-n">
										<p class="form-control-static">
											<?php if(isset($header)) { echo $header["pqm_guarantee_time"]; } ?> 
											<?php if(isset($header)) { echo $header["pqm_guarantee_unit"]; } ?>

										</p>
									</div>
								</div>
								<div class="form-group" id="selesai">
									<label class="col-sm-2 control-label">Jangka Waktu Penawaran</label>
									<div class="col-md-4 m-l-n input-group">
										<p class="form-control-static">

											<?php if(isset($header)) { echo date("d/m/Y", strtotime($header["pqm_valid_thru"])); } ?>

										</p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Lampiran Penawaran <small>(Max 10MB)</small></label>
									<div class="col-lg-6 m-l-n">
										<p class="form-control-static">

											<?php if(isset($header)){ ?><a target="_blank" href="<?php echo site_url('log/download_attachment_extranet/penawaran/'.$header['ptv_vendor_code'].'/'.$header["pqm_att_quo"]); ?>"><?php echo $header["pqm_att_quo"]; ?></a><?php } ?>


										</p>
									</div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Catatan</label>
									<div class="col-lg-6 m-l-n"><input <?php echo $readonly ?> id="catatan" name="catatan" type="text" class="form-control" value="<?php if(isset($header)) { echo $header["pqm_notes"]; } ?>"></div>
								</div>
								<div class="form-group">
									<label class="col-sm-2 control-label">Mata Uang</label>
									<div class="col-md-2 m-l-n">
										<p class="form-control-static">
											<?php echo $header["pqm_currency"] ?>
										</p>
										<input type="hidden" name="currency" id="currency" value="<?php echo $header["pqm_currency"] ?>">
									</div>
								</div>
							</form>		
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="ibox float-e-margins">
						<div class="ibox-title">
							<h5>Item Administrasi</h5>
						</div>
						<div class="ibox-content">
							<form role="form" id="adm" method="POST" action="<?php echo site_url('pengadaan/submitquo') ?>" class="form-horizontal">	
								<input type="hidden" id="section" name="section" value="adm">
								<table class="table table-striped">
									<thead>
										<tr>
											<th style="text-align: center">Nomor</th>
											<th style="width: 75%; text-align: center">Deskripsi</th>
											<th>Respon Vendor</th>
											<th>Lampiran</th>
										</tr>
									</thead>
									<tbody>

										<?php
										if(isset($header)) { 
											$i = 1; foreach($template as $row) { if($row["pqt_weight"] == "") {
												?>
												<tr>
													<td style="text-align: center"><?php echo $i; ?></td>
													<td><?php echo $row["pqt_item"]; ?></td>
													<input type="hidden" name="desks_<?php echo $i ?>" id="desks_<?php echo $i ?>" value="<?php echo $row["pqt_item"]; ?>">
													<input type="hidden" name="pqtids_<?php echo $i ?>" id="pqtids_<?php echo $i ?>" value="<?php echo $row["pqt_id"]; ?>">
													<td>
														<div class="i-checks">

															<label for="radio_<?php echo $i; ?>"><input <?php echo $readonly ?> type="radio" id="radio_<?php echo $i; ?>" value="1" name="radio_<?php echo $i; ?>" required <?php if(($row["pqt_check_vendor"] == "1")){ echo "checked";} ?>> Ada</label>
														</div>
														<div class="i-checks">

															<label for="radio_<?php echo $i; ?>"><input <?php echo $readonly ?> type="radio" id="radio_<?php echo $i; ?>" value="0" name="radio_<?php echo $i; ?>" <?php if(($row["pqt_check_vendor"] == "0")){ echo "checked";} ?>> Tidak Ada</label>
														</div>
													</td>
													<td>
														<a target="_blank" href="<?php echo site_url("log/download_attachment_extranet/administrasi/".$vendor_id."/".$row["pqt_attachment"]) ?>">
															<?php echo $row["pqt_attachment"]; ?>
														</a>
													</td>
												</tr>
												<?php $i++; }}} ?>
												<input type="hidden" name="num_adm" id="num_adm" value="<?php echo $i ?>">
											</tbody>
										</table>	
									</form>		
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-lg-12">
							<div class="ibox float-e-margins">
								<div class="ibox-title">
									<h5>Item Teknis</h5>
								</div>
								<div class="ibox-content">
									<form role="form" id="teknis" method="POST" action="<?php echo site_url('pengadaan/submitquo') ?>" class="form-horizontal">	
										<input type="hidden" id="section" name="section" value="teknis">
										<table class="table table-striped">
											<thead>
												<tr>
													<th style="text-align: center">Nomor</th>
													<th style="width: 55%; text-align: center">Deskripsi</th>
													<th style="text-align: center">Bobot</th>
													<th style="text-align: center">Respon Vendor</th>
													<th style="text-align: center">Lampiran</th>
												</tr>
											</thead>
											<tbody>

												<?php
												if(isset($header)) { 
													$i = 1; foreach($template as $row) { if($row["pqt_weight"] != "") {
														?>
														<tr>
															<td style="text-align: center"><p class="form-control-static"><?php echo $i; ?></p></td>
															<td><p class="form-control-static"><?php echo $row["pqt_item"]; ?></p></td>
															<td style="text-align: center"><p class="form-control-static"><?php echo $row["pqt_weight"]."%"; ?></p></td>
															<input type="hidden" name="desk_<?php echo $i ?>" id="desk_<?php echo $i ?>" value="<?php echo $row["pqt_item"]; ?>">
															<input type="hidden" name="pqtid_<?php echo $i ?>" id="pqtid_<?php echo $i ?>" value="<?php echo $row["pqt_id"]; ?>">
															<td><input <?php echo $readonly ?> type="text" class="form-control" name="respon_<?php echo $i ?>" id="respon_<?php echo $i ?>" required value="<?php echo $row["pqt_vendor_desc"] ?>"></td>
															<td><p class="form-control-static">
																<a target="_blank" href="<?php echo site_url("log/download_attachment_extranet/teknis/".$vendor_id."/".$row["pqt_attachment"]) ?>">
																	<?php echo $row["pqt_attachment"]; ?>

																</a>
																</p>
															</td>
														</tr>
														<?php $i++; }}} ?>
														<input type="hidden" name="num_tek" id="num_tek" value="<?php echo $i ?>">
													</tbody>
												</table>	
											</form>		
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-lg-12">
									<div class="ibox float-e-margins">
										<div class="ibox-title">
											<h5>Item Komersial</h5>
										</div>
										<div class="ibox-content">
											<form role="form" id="komersial" method="POST" action="<?php echo site_url('pengadaan/submitquo') ?>" class="form-horizontal">	
												<input type="hidden" id="section" name="section" value="komersial">
												<table class="table table-striped komersial">
													<thead>
														<tr>
															<th rowspan="2">No.</th>
															<th colspan="3">Item Tender</th>
															<th colspan="6">Penawaran</th>
														</tr>
														<tr>

															<th>Deskripsi</th>
															<th>Qty</th>
															<th>Pajak</th>
															<th>Keterangan</th>
															<th>Garansi</th>
															<th>Penyerahan</th>
															<th>Jumlah</th>
															<th>Harga</th>
															<th>Subtotal</th>
														</tr>
													</thead>
													<tbody>
														<?php 
														$i = 1; 
														$total_sebelum_pajak = 0;
														$total_setelah_pajak = 0;
														$total_pajak = 0;
														foreach($item as $row) { 
															$subtotal = $row["pqi_quantity"]*$row['pqi_price'];
															$total_sebelum_pajak += $subtotal;
															$pajak = $subtotal*(($row["tit_ppn"]+$row["tit_pph"])/100);
															$total_setelah_pajak += $subtotal+$pajak;
															$total_pajak += $pajak;
															?>
															<tr>
																<td class="text-center"><?php echo $i ?></td>
																<td>
																	<?php echo $row["tit_description"] ?>
																</td>
																<td class="text-right">
																	<?php echo $row["tit_quantity"] ?>
																</td>
																<td>
																	PPN : <?php echo (!empty($row["tit_ppn"])) ? $row["tit_ppn"] : 0 ?> %

																	<br/>
																	PPH : <?php echo (!empty($row["tit_pph"])) ? $row["tit_pph"] : 0 ?> %

																</td>

																<td>
																	<?php echo (isset($row["pqi_description"])) ? $row["pqi_description"] : $row["tit_description"] ?>
																</td>

																<td>
																	<?php echo (isset($row["pqi_guarantee"])) ? $row["pqi_guarantee"] : 0 ?> 
																	<?php echo (isset($row["pqi_deliverable_type"])) ? $row["pqi_deliverable_type"] : "" ?>
																</td>

																<td>
																	<?php echo (isset($row["pqi_deliverable"])) ? $row["pqi_deliverable"] : 0 ?> 
																	<?php echo (isset($row["pqi_deliverable_type"])) ? $row["pqi_deliverable_type"] : "" ?>
																</td>

																<td class="text-right">
																	<?php echo (isset($row["pqi_quantity"])) ? inttomoney($row["pqi_quantity"]) : "" ?>
																</td>

																<td class="text-right">
																	<?php echo (isset($row["pqi_price"])) ? inttomoney($row["pqi_price"]) : "" ?>
																</td>
																<td class="text-right">
																	<?php echo inttomoney($subtotal+$pajak) ?>
																</td>

															</tr>
															<?php 
															$i++;
														} ?>
													</tbody>
												</table>	
												<table class="table invoice-total">
													<tbody>
														<tr>
															<td><strong>Total Sebelum Pajak :</strong></td>
															<td id="totalss"><?php echo inttomoney($total_sebelum_pajak) ?></td>
														</tr>
														<tr>
															<td><strong>PPN + PPH (Jika Ada) :</strong></td>
															<td id="ppnss"><?php echo inttomoney($total_pajak) ?></td>
														</tr>
														<tr>
															<td><strong>Total :</strong></td>
															<td id="subtotalss"><?php echo inttomoney($total_setelah_pajak) ?></td>
														</tr>
													</tbody>
												</table>
											</form>		
										</div>
									</div>
								</div>
							</div>
						</div>
