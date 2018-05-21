<div class="row">
	<div class="col-lg-12">
		<div class="ibox float-e-margins">
			<div class="ibox-title">
				<h5><?php echo $this->lang->line('Item Komersial'); ?></h5>
			</div>
			<div class="ibox-content">
				<style type="text/css">
					.komersial th{
						text-align: center;
						border: 1px solid #DDDDDD !important;
					}
					.komersial td{
						border: 1px solid #DDDDDD !important;
					}
				</style>

				<form role="form" id="komersial" method="POST" action="<?php echo site_url($submit_url) ?>" class="form-horizontal">	
					<input type="hidden" id="section" name="section" value="komersial">
					<input type="hidden" id="pqmid" name="pqmid" value="<?php if(isset($header)){ echo $header["pqm_id"]; } ?>">

					<div class="table-responsivex">

					<table class="table table-striped komersial">
						<thead>
							<tr>
								<th rowspan="2"><?php echo $this->lang->line('No'); ?></th>
								<th colspan="3">Item Tender</th>
								<th colspan="6">Penawaran</th>
							</tr>
							<tr>

								<th><?php echo $this->lang->line('Deskripsi'); ?></th>
								<th>Qty</th>
								<th>Pajak</th>
								<th>Keterangan</th>
								<th><?php echo $this->lang->line('Jumlah'); ?></th>
								<th><?php echo $this->lang->line('Harga Satuan'); ?></th>
								<th><?php echo $this->lang->line('Sub Total'); ?></th>
								<th>Garansi</th>
								<th>Penyerahan / Pelaksanaan</th>
							</tr>
						</thead>
						<tbody>
							<?php 
							$i = 1; 
							foreach($item as $row) { 
								?>
								<tr>
									<td style="text-align: center"><?php echo $i ?></td>
									<td style="width: 320px;">
										<?php echo $row["tit_description"] ?>
										<input type="hidden" id="desc_<?php echo $i ?>_temp" value="<?php echo $row["tit_description"] ?>">
										<input type="hidden" id="tit_<?php echo $i ?>" name="tit_<?php echo $i ?>" value="<?php echo (isset($row["tit_id"])) ? $row["tit_id"] : "" ?>">
										<input type="hidden" id="pqiid_<?php echo $i ?>" name="pqiid_<?php echo $i ?>" value="<?php echo (isset($row["pqi_id"])) ? $row["pqi_id"] : "" ?>">
									</td>
									<td style="width: 48px">
										<?php echo inttomoney($row["tit_quantity"]) ?>
									</td>
									<td style="width: 100px">
										PPN : <?php echo (!empty($row["tit_ppn"])) ? $row["tit_ppn"] : 0 ?> %
										<input type="hidden" id="ppn_<?php echo $i ?>" name="ppn_<?php echo $i ?>" value="<?php echo $row["tit_ppn"]; ?>">
										<br/>
										PPH : <?php echo (!empty($row["tit_pph"])) ? $row["tit_pph"] : 0 ?> %
										<input type="hidden" id="pph_<?php echo $i ?>" name="pph_<?php echo $i ?>" value="<?php echo $row["tit_pph"]; ?>">
									</td>
									<td style="width: 320px">
										<textarea  style="height: 72px;font-size: 13px;" <?php echo $readonly ?> class="form-control" id="desc_<?php echo $i ?>" name="desc_<?php echo $i ?>" required><?php echo (isset($row["pqi_description"])) ? $row["pqi_description"] : $row["tit_description"] ?></textarea>
									</td>

									<td style="width: 180px;">
										<input <?php echo $readonly ?>onblur="fnChange('<?php echo $i ?>','qty')" type="text" class="form-control" id="qty_<?php echo $i ?>" name="qty_<?php echo $i ?>" required 
										value="<?php echo (isset($row["pqi_quantity"])) ? inttomoney($row["pqi_quantity"]) : "" ?>">
										<input type="hidden" id="qty_<?php echo $i ?>_input" name="qty_<?php echo $i ?>_input" value="<?php echo (isset($row["pqi_quantity"])) ? $row["pqi_quantity"] : "" ?>" min="1" required>
										<input type="hidden" id="qty_<?php echo $i ?>_temp" name="qty_<?php echo $i ?>" value="<?php echo $row["tit_quantity"] ?>">
									</td>

									<td style="width: 180px;">
										<input <?php echo $readonly ?> onblur="fnChange('<?php echo $i ?>','price')" type="text" class="form-control" id="price_<?php echo $i ?>" name="price_<?php echo $i ?>" 
										value="<?php echo (isset($row["pqi_price"])) ? $row["pqi_price"] : "" ?>" required>
										<input type="hidden" id="price_<?php echo $i ?>_input" name="price_<?php echo $i ?>_input" value="<?php echo (isset($row["pqi_price"])) ? $row["pqi_price"] : "" ?>" min="1" required>
									</td>
									<td style="width: 180px;">
										<input readonly type="text" class="form-control" id="total_<?php echo $i ?>" name="total_<?php echo $i ?>" value="">
										<input type="hidden" id="tax_<?php echo $i ?>" name="tax_<?php echo $i ?>" value="<?php echo ($row["tit_ppn"]+$row["tit_pph"])/100 ?>">
									</td>

									<td style="width: 180px;">
										<input <?php echo $readonly ?> type="text" class="form-control guarantee_time_item" id="guarantee_<?php echo $i ?>" name="guarantee_<?php echo $i ?>" 
										value="<?php echo (isset($row["pqi_guarantee"])) ? $row["pqi_guarantee"] : 0 ?>" required>
										<select <?php echo $readonly ?> class="form-control guarantee_unit_item" name="guarantee_type_<?php echo $i ?>">
											<?php 
											$curval = (isset($row["pqi_guarantee_type"])) ? $row["pqi_guarantee_type"] : "";
											foreach (array("Hari","Bulan","Tahun") as $key => $value) { ?>
											<option <?php echo ($value == $curval) ? "selected" : "" ?> ><?php echo $value ?></option>
											<?php } ?>
										</select>
									</td>

									<td style="width: 180px;">
										<input <?php echo $readonly ?> type="text" class="form-control deliverable_time_item" id="deliverable_<?php echo $i ?>" name="deliverable_<?php echo $i ?>" 
										value="<?php echo (isset($row["pqi_deliverable"])) ? $row["pqi_deliverable"] : 0 ?>" required>
										<select <?php echo $readonly ?> class="form-control deliverable_unit_item" name="deliverable_type_<?php echo $i ?>">
											<?php 
											$curval = (isset($row["pqi_deliverable_type"])) ? $row["pqi_deliverable_type"] : "";
											foreach (array("Hari","Bulan","Tahun") as $key => $value) { ?>
											<option <?php echo ($value == $curval) ? "selected" : "" ?> ><?php echo $value ?></option>
											<?php } ?>
										</select>
									</td>

								</tr>
								<?php 
								$i++;
							} ?>
						</tbody>
					</table>	
					</div>
					<input type="hidden" id="num_item" name="num_item" value="<?php echo $i ?>">
					<input id="tenderids" name="tenderids" type="hidden" value="<?php echo $tenderid; ?>">
					<input type="hidden" id="modo" name="modo" value="<?php if(isset($header)) { echo "edit"; } else { echo "insert"; } ?>" >
					<table class="table invoice-total">
						<tbody>
							<tr>
								<td><strong><?php echo $this->lang->line('Total Sebelum PPN'); ?> :</strong></td>
								<td id="totalss"></td>
							</tr>
							<tr>
								<td><strong><?php echo $this->lang->line('PPN'); ?> :</strong></td>
								<td id="ppnss"></td>
							</tr>
							<tr>
								<td><strong><?php echo $this->lang->line('Total'); ?> :</strong></td>
								<td id="subtotalss"></td>
							</tr>
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
				<h5>Bid Bond</h5>
			</div>
			<div class="ibox-content">

				<form role="form" id="bidbond" method="POST" action="<?php echo site_url($submit_url) ?>" class="form-horizontal">	
					<input type="hidden" id="section" name="section" value="bidbond">
					<div class="form-group">
						<label class="col-sm-2 control-label">
							<?php echo $this->lang->line('Nilai Bidbond'); ?>
						</label>
						<div class="col-lg-3 m-l-n"><input <?php echo $readonly ?> onblur="fnChange('','bid_bond')" type="text" id="bid_bond" class="form-control" value="<?php if(isset($header)) { echo $header["pqm_bid_bond_value"]; } ?>"></div>
						<input type="hidden" id="bid_bond_input" name="bid_bond_input" value="<?php if(isset($header)) { echo $header["pqm_bid_bond_value"]; } ?>">
						<label class="col-sm-2 control-label">
							<?php echo $this->lang->line('Lampiran Bidbond'); ?> <small>(Max 2MB)</small>
						</label>
						<div class="col-lg-3 m-l-n">
							<?php if(empty($readonly)){ ?>
							<input <?php echo $readonly ?> id="lampiran_bidbond" name="lampiran_bidbond" type="file" class="file">
							<?php } ?>
							<?php if(isset($header)){ ?>
							<p class="form-control-static">
								<a target="_blank" href="<?php echo site_url('pengadaan/download/bidbond/'.$this->umum->forbidden($this->encryption->encrypt($header["pqm_att"]), 'enkrip')); ?>"><?php echo $header["pqm_att"]; ?></a>
							</p>
							<?php } ?></div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>