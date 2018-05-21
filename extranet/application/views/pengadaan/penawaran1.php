<div class="wrapper wrapper-content animated fadeIn">
	<div class="row">
        <div class="col-lg-12">
			<div class="ibox float-e-margins">
				<div class="ibox-title">
					<h5><?php echo $this->lang->line('Penawaran'); ?></h5>
				</div>
				<div class="ibox-content">
					<form role="form" id="header" method="POST" action="<?php echo site_url('pengadaan/submitquo') ?>" class="form-horizontal">	
						<input type="hidden" id="section" name="section" value="header">
						<input type="hidden" id="pqmid" name="pqmid" value="<?php if(isset($header)){ echo $header["pqm_id"]; } ?>">
						<div class="form-group"><label class="col-sm-2 control-label"><?php echo $this->lang->line('Nomor Pengadaaan'); ?></label>
							<div class="col-lg-6 m-l-n"><input readonly id="tenderid" name="tenderid" type="text" class="form-control" value="<?php echo $tenderid; ?>"></div>
						</div>
						<div class="form-group"><label class="col-sm-2 control-label"><?php echo $this->lang->line('Nomor Penawaran'); ?></label>
							<div class="col-lg-6 m-l-n"><input id="nopenawaran" name="nopenawaran" type="text" class="form-control" value="<?php if(isset($header)){ echo $header["pqm_number"]; } ?>" required></div>
						</div>
						<div class="form-group"><label class="col-sm-2 control-label"><?php echo $this->lang->line('Tipe Penawaran'); ?></label>
							<div class="col-md-2 m-l-n"><select class="form-control m-b" name="tipepenawaran" id="tipepenawaran" required>
								<option value="">--<?php echo $this->lang->line('PILIH'); ?>--</option>
								<option value="A" <?php if(isset($header)) { if(($header["pqm_type"] == "A")){ echo "selected";} } ?>><?php echo $this->lang->line('Tipe'); ?>A</option>
								<option value="B" <?php if(isset($header)) { if(($header["pqm_type"] == "B")){ echo "selected";} } ?>><?php echo $this->lang->line('Tipe'); ?>B</option>
								<option value="C" <?php if(isset($header)) { if(($header["pqm_type"] == "C")){ echo "selected";} } ?>><?php echo $this->lang->line('Tipe'); ?>C</option>
							</select>
							</div>
						</div>
						<div class="form-group"><label class="col-sm-2 control-label"><?php echo $this->lang->line('Nilai Bidbond'); ?></label>
							<div class="col-lg-6 m-l-n"><input onblur="fnChange('','bid_bond')" type="text" id="bid_bond" class="form-control" value="<?php if(isset($header)) { echo $header["pqm_bid_bond_value"]; } ?>"></div>
							<input type="hidden" id="bid_bond_input" name="bid_bond" value="<?php if(isset($header)) { echo $header["pqm_bid_bond_value"]; } ?>">
						</div>
						<div class="form-group"><label class="col-sm-2 control-label"><?php echo $this->lang->line('Lampiran Bidbond'); ?></label>
							<div class="col-lg-6 m-l-n"><input id="lampiran_bidbond" name="lampiran_bidbond" type="file" class="file"><a><?php if(isset($header)){ echo $header["pqm_att"]; } ?></a></div>
						</div>
						<div class="form-group"><label class="col-sm-2 control-label"><?php echo $this->lang->line('Kandungan Lokal'); ?></label>
							<div class="col-md-2 m-l-n"><input id="kandunganlokal" name="kandunganlokal" placeholder="%" type="number" min="0" max="100" class="form-control" required value="<?php if(isset($header)) { echo $header["pqm_local_content"]; } ?>"></div>
						</div>
						<div class="form-group"><label class="col-sm-2 control-label"><?php echo $this->lang->line('Jangka Waktu Pelaksanaan'); ?></label>
							<div class="col-md-2 m-l-n"><input id="jangkawaktu" name="jangkawaktu" type="number" class="form-control" required value="<?php if(isset($header)) { echo $header["pqm_delivery_time"]; } ?>">
							</div>
							<div class="col-md-2 m-l-n">
								<select class="form-control m-b" name="timeunit" id="timeunit" required>
									<option value="D" <?php if(isset($header)) { if(($header["pqm_delivery_unit"] == "D")){ echo "selected";} } ?>><?php echo $this->lang->line('HARI'); ?></option>
									<option value="M" <?php if(isset($header)) { if(($header["pqm_delivery_unit"] == "M")){ echo "selected";} } ?>><?php echo $this->lang->line('BULAN'); ?></option>
									<option value="Y" <?php if(isset($header)) { if(($header["pqm_delivery_unit"] == "Y")){ echo "selected";} } ?>><?php echo $this->lang->line('TAHUN'); ?></option>
								</select>
							</div>
						</div>
						<div class="form-group" id="selesai"><label class="col-sm-2 control-label"><?php echo $this->lang->line('Berlaku Hingga'); ?></label>
							<div class="col-md-4 m-l-n input-group date">
								<span class="input-group-addon"><i class="fa fa-calendar"></i></span><input id="berlakuhingga" name="berlakuhingga" type="text" class="form-control" value="<?php if(isset($header)) { echo date("Y-m-d", strtotime($header["pqm_valid_thru"])); } ?>" required>
							</div>
						</div>
						<div class="form-group"><label class="col-sm-2 control-label"><?php echo $this->lang->line('Catatan'); ?></label>
							<div class="col-lg-6 m-l-n"><input id="catatan" name="catatan" type="text" class="form-control" value="<?php if(isset($header)) { echo $header["pqm_notes"]; } ?>"></div>
						</div>
						<div class="form-group"><label class="col-sm-2 control-label"><?php echo $this->lang->line('Mata Uang'); ?></label>
							<div class="col-md-2 m-l-n"><select class="form-control m-b" name="currency" id="currency">
								<option value="IDR" <?php if(isset($header)) { if(($header["pqm_currency"] == "IDR")){ echo "selected";} } ?>><?php echo $this->lang->line('IDR'); ?></option>
								<option value="USD" <?php if(isset($header)) { if(($header["pqm_currency"] == "USD")){ echo "selected";} } ?>><?php echo $this->lang->line('USD'); ?></option>
							</select>
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
					<h5><?php echo $this->lang->line('Item Administrasi'); ?></h5>
				</div>
				<div class="ibox-content">
					<form role="form" id="adm" method="POST" action="<?php echo site_url('pengadaan/submitquo') ?>" class="form-horizontal">	
						<input type="hidden" id="section" name="section" value="adm">
						<table class="table table-striped">
                            <thead>
								<tr>
									<th style="text-align: center"><?php echo $this->lang->line('Nomor'); ?></th>
									<th style="width: 75%; text-align: center"><?php echo $this->lang->line('Deskripsi'); ?></th>
									<th><?php echo $this->lang->line('Respon Vendor'); ?></th>
								</tr>
							</thead>
                            <tbody>
								<?php if(!isset($header)) { $i = 1; foreach($template as $row) { if($row["etd_mode"] == "0") {?>
									<tr>
										<td style="text-align: center"><?php echo $i; ?></td>
										<td><?php echo $row["etd_item"]; ?></td>
										<input type="hidden" name="desks_<?php echo $i ?>" id="desks_<?php echo $i ?>" value="<?php echo $row["etd_item"]; ?>">
										<td>
											<div class="i-checks">
												<label for="radio_<?php echo $i; ?>"><input type="radio" id="radio_<?php echo $i; ?>" value="1" name="radio_<?php echo $i; ?>" required><?php echo $this->lang->line('Ada'); ?> </label>
											</div>
											<div class="i-checks">
												<label for="radio_<?php echo $i; ?>"><input type="radio" id="radio_<?php echo $i; ?>" value="0" name="radio_<?php echo $i; ?>"> <?php echo $this->lang->line('Tidak'); ?></label>
											</div>
										</td>
									</tr>
								<?php $i++;}} } ?>
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
													<label for="radio_<?php echo $i; ?>"><input type="radio" id="radio_<?php echo $i; ?>" value="1" name="radio_<?php echo $i; ?>" required <?php if(($row["pqt_check_vendor"] == "1")){ echo "checked";} ?>> <?php echo $this->lang->line('Ada'); ?></label>
												</div>
												<div class="i-checks">
													<label for="radio_<?php echo $i; ?>"><input type="radio" id="radio_<?php echo $i; ?>" value="0" name="radio_<?php echo $i; ?>" <?php if(($row["pqt_check_vendor"] == "0")){ echo "checked";} ?>> <?php echo $this->lang->line('Tidak Ada'); ?></label>
												</div>
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
					<h5><?php echo $this->lang->line('Item Teknis'); ?></h5>
				</div>
				<div class="ibox-content">
					<form role="form" id="teknis" method="POST" action="<?php echo site_url('pengadaan/submitquo') ?>" class="form-horizontal">	
						<input type="hidden" id="section" name="section" value="teknis">
						<table class="table table-striped">
                            <thead>
								<tr>
									<th style="text-align: center<?php echo $this->lang->line('Nomor'); ?></th>
									<th style="width: 60%; text-align: center"><?php echo $this->lang->line('Deskripsi'); ?></th>
									<th style="text-align: center"><?php echo $this->lang->line('Respon Vendor'); ?></th>
								</tr>
							</thead>
                            <tbody>
								<?php if(!isset($header)) { $i = 1; foreach($template as $row) { if($row["etd_mode"] == "1") {?>
									<tr>
										<td style="text-align: center"><?php echo $i; ?></td>
										<td><?php echo $row["etd_item"]; ?></td>
										<input type="hidden" name="desk_<?php echo $i ?>" id="desk_<?php echo $i ?>" value="<?php echo $row["etd_item"]; ?>">
										<input type="hidden" name="weight_<?php echo $i ?>" id="weight_<?php echo $i ?>" value="<?php echo $row["etd_weight"]; ?>">
										<td><input type="text" class="form-control" name="respon_<?php echo $i ?>" id="respon_<?php echo $i ?>" required></td>
									</tr>
								<?php $i++;}} }?>
								<?php
									if(isset($header)) { 
										$i = 1; foreach($template as $row) { if($row["pqt_weight"] != "") {
										?>
										<tr>
											<td style="text-align: center"><?php echo $i; ?></td>
											<td><?php echo $row["pqt_item"]; ?></td>
											<input type="hidden" name="desk_<?php echo $i ?>" id="desk_<?php echo $i ?>" value="<?php echo $row["pqt_item"]; ?>">
											<input type="hidden" name="pqtid_<?php echo $i ?>" id="pqtid_<?php echo $i ?>" value="<?php echo $row["pqt_id"]; ?>">
											<td><input type="text" class="form-control" name="respon_<?php echo $i ?>" id="respon_<?php echo $i ?>" required value="<?php echo $row["pqt_vendor_desc"] ?>"></td>
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
					<h5><?php echo $this->lang->line('Item Komersial'); ?></h5>
				</div>
				<div class="ibox-content">
					<form role="form" id="komersial" method="POST" action="<?php echo site_url('pengadaan/submitquo') ?>" class="form-horizontal">	
						<input type="hidden" id="section" name="section" value="komersial">
						<table class="table table-striped">
                            <thead>
								<tr>
									<th style="text-align: center"><?php echo $this->lang->line('No'); ?></th>
									<th style="width: 20%; text-align: center"><?php echo $this->lang->line('Deskripsi'); ?></th>
									<th style="text-align: center"><?php echo $this->lang->line('Jumlah'); ?></th>
									<th style="text-align: center"><?php echo $this->lang->line('[Penawaran Vendor] '); ?> <?php echo $this->lang->line('Deskripsi'); ?></th>
									<th style="text-align: center"><?php echo $this->lang->line('[Penawaran Vendor] '); ?> <?php echo $this->lang->line('Jumlah'); ?> </th>
									<th style="text-align: center"><?php echo $this->lang->line('[Penawaran Vendor] '); ?> <?php echo $this->lang->line('Harga Satuan'); ?></th>
									<th style="text-align: center"><?php echo $this->lang->line('[Penawaran Vendor] '); ?> <?php echo $this->lang->line('Sub Total'); ?></th>
								</tr>
							</thead>
                            <tbody>
								
									<?php if(!isset($header)) { $i = 1; foreach($item as $row) { ?>
										<tr>
										<td style="text-align: center"><?php echo $i ?></td>
										<td><?php echo $row["tit_description"] ?></td>
										<input type="hidden" id="desc_<?php echo $i ?>_temp" name="price_<?php echo $i ?>" value="<?php echo $row["tit_description"] ?>">
										<input type="hidden" id="tit_<?php echo $i ?>" name="tit_<?php echo $i ?>" value="<?php echo $row["tit_id"] ?>">
										<td><?php echo $row["tit_quantity"] ?></td>
										<input type="hidden" id="qty_<?php echo $i ?>_temp" name="price_<?php echo $i ?>" value="<?php echo $row["tit_quantity"] ?>">
										<td><input type="text" class="form-control" id="desc_<?php echo $i ?>" name="desc_<?php echo $i ?>" required></td>
										<td><input onblur="fnChange('<?php echo $i ?>','qty')" type="text" class="form-control" id="qty_<?php echo $i ?>" name="qty_<?php echo $i ?>" required></td>
										<input type="hidden" id="qty_<?php echo $i ?>_input" name="qty_<?php echo $i ?>_input" value="" min="1" required>
										<td><input onblur="fnChange('<?php echo $i ?>','price')" type="text" class="form-control" id="price_<?php echo $i ?>" name="price_<?php echo $i ?>" required></td>
										<input type="hidden" id="price_<?php echo $i ?>_input" name="price_<?php echo $i ?>_input" value="" min="1" required>
										<td><input readonly type="text" class="form-control" id="total_<?php echo $i ?>" name="total_<?php echo $i ?>" value=""></td>
									</tr>
									<?php $i++;} } ?>
									<?php
										if(isset($header)) { 
											$i = 1; foreach($item as $row) {
											?>
											<tr>
											<td style="text-align: center"><?php echo $i ?></td>
											<td><?php echo $row["tit_description"] ?></td>
											<input type="hidden" id="desc_<?php echo $i ?>_temp" name="price_<?php echo $i ?>" value="<?php echo $row["tit_description"] ?>">
											<input type="hidden" id="pqiid_<?php echo $i ?>" name="pqiid_<?php echo $i ?>" value="<?php echo $row["pqi_id"] ?>">
											<td><?php echo $row["tit_quantity"] ?></td>
											<input type="hidden" id="qty_<?php echo $i ?>_temp" name="price_<?php echo $i ?>" value="<?php echo $row["tit_quantity"] ?>">
											<td><input type="text" class="form-control" id="desc_<?php echo $i ?>" name="desc_<?php echo $i ?>" value ="<?php echo $row["pqi_description"] ?>" required></td>
											<td><input onblur="fnChange('<?php echo $i ?>','qty')" type="text" class="form-control" id="qty_<?php echo $i ?>" name="qty_<?php echo $i ?>" value ="<?php echo $row["pqi_quantity"] ?>" required></td>
											<input type="hidden" id="qty_<?php echo $i ?>_input" name="qty_<?php echo $i ?>_input" value="" min="1" value ="<?php echo $row["pqi_quantity"] ?>" required>
											<td><input onblur="fnChange('<?php echo $i ?>','price')" type="text" class="form-control" id="price_<?php echo $i ?>" name="price_<?php echo $i ?>" value ="<?php echo $row["pqi_price"] ?>" required></td>
											<input type="hidden" id="price_<?php echo $i ?>_input" name="price_<?php echo $i ?>_input" value="" min="1" value ="<?php echo $row["pqi_price"] ?>" required>
											<td><input readonly type="text" class="form-control" id="total_<?php echo $i ?>" name="total_<?php echo $i ?>" value=""></td>
										</tr>
										<?php $i++; }} ?>
										<input type="hidden" id="num_item" name="num_item" value="<?php echo $i ?>">
										<input id="tenderids" name="tenderids" type="hidden" value="<?php echo $tenderid; ?>">
										<input type="hidden" id="modo" name="modo" value="<?php if(isset($header)) { echo "edit"; } else { echo "insert"; } ?>" >
								
							</tbody>
						</table>	
						<table class="table invoice-total">
							<tbody>
                                <tr>
                                    <td><strong><?php echo $this->lang->line('Total Sebelum PPN'); ?> : </strong></td>
                                    <td id="totalss"></td>
								</tr>
                                <tr>
                                    <td><strong><?php echo $this->lang->line('Sub Total'); ?> : </strong></td>
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
				<div class="ibox-content text-center">
					<button class="btn btn-primary" type="submit" id="submitBtn"><?php echo $this->lang->line('Submit'); ?></button>
					<button class="btn btn-white" type="submit"><?php echo $this->lang->line('Cancel'); ?></button>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		var cur = "Rp";
		set_field_ontipepenawaran();
		
		$('#bid_bond').focus();
		$('#bid_bond').blur();
		
		$('.i-checks').iCheck({
			checkboxClass: 'icheckbox_square-green',
			radioClass: 'iradio_square-green',
		});
		
		$('#selesai .input-group.date').datepicker({
			keyboardNavigation: false,
			forceParse: false,
			autoclose: true,
			startDate: '+1d',
			format: "yyyy-mm-dd"
		});
		
		//Ubah Blocked Item Komersial Field
		$('#tipepenawaran').change(function(){
			set_field_ontipepenawaran();
		});
		
		//Ubah Mata Uang
		$('#currency').change(function(){
			if($('#currency').val() == 'IDR'){
				if($("#totalss").text() != ""){
					$("#totalss").text($("#totalss").text().replace("$",""));
					$("#totalss").text("Rp"+$("#totalss").text());
				}
				else{
					cur = "Rp";
				}
				if($("#subtotalss").text() != ""){
					$("#subtotalss").text($("#subtotalss").text().replace("$",""));
					$("#subtotalss").text("Rp"+$("#subtotalss").text());
				}
				else{
					cur = "Rp";
				}
			}
			else if($('#currency').val() == 'USD'){
				if($("#totalss").text() != ""){
					$("#totalss").text($("#totalss").text().replace("Rp",""));
					$("#totalss").text("$"+$("#totalss").text());
				}
				else{
					cur = "$";
				}
				if($("#subtotalss").text() != ""){
					$("#subtotalss").text($("#subtotalss").text().replace("Rp",""));
					$("#subtotalss").text("$"+$("#subtotalss").text());
				}
				else{
					cur = "$";
				}
			}
		});
		
		$("#adm").validate({
			// the errorPlacement has to take the table layout into account
			errorPlacement: function(error, element) {
				error.appendTo(element.parent().parent().parent().next());
			}
		});
		
		$("#submitBtn").click(function(){
			//Submit All Form
			if($("#adm").validate().form() && $("#header").validate().form() && $("#teknis").validate().form() && $("#komersial").validate().form()){
				$("#header").ajaxSubmit({
					success: function(msg){
						if(msg == "1"){
							$("#adm").ajaxSubmit({
								success: function(msg){
									$("#teknis").ajaxSubmit({
										success: function(msg){
											$("#komersial").ajaxSubmit({
												success: function(msg){
													if(msg == "2a"){
														swal("Error", "Data Header gagal disimpan. Harap Masukan Data Kembali", "error");
													}
													else if(msg == "3a"){
														swal("Error", "Data Administrasi gagal disimpan. Harap Masukan Data Kembali", "error");
													}
													else if(msg == "4a"){
														swal("Error", "Data Teknis gagal disimpan. Harap Masukan Data Kembali", "error");
													}
													else if(msg == "5a"){
														swal("Error", "Gagal Update Status Vendor. Harap Masukan Data Kembali", "error");
													}
													else if(msg == "6a"){
														swal("Error", "Data Komersial gagal disimpan. Harap Masukan Data Kembali", "error");
													}
													else if($.isNumeric(msg)){
														swal({
															title: "Selamat, Penawaran Anda Berhasil Dikirim",
															text: "Saat ini penawaran anda berada di peringkat #"+msg,
															type: "success"
														},
														function(){
															window.location.assign('<?php echo site_url(); ?>');
														});
													}
												},
												error: function(){
													swal("Error", "Pesan-1 : Data Gagal Disimpan", "error");
												}
											});
										},
										error: function(){
											swal("Error", "Pesan-2 : Data Gagal Disimpan", "error");
										}
									});
								},
								error: function(){
									swal("Error", "Pesan-3 : Data Gagal Disimpan", "error");
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
						swal("Error", "Pesan-4 : Data Hgagal disimpan", "error");
					}
				});
			}
		});
	});
	
	function fnChange(id,param){
		var check = "_"+id;
		if(id == ""){
			check = "";
		}
		if($('#currency').val() == "IDR"){
			var cur = "Rp";
		}
		else{
			var cur = "$";
		}
		
		var current_val = parseFloat(accounting.unformat($("#"+param+check).val()));
		var nonformat = current_val;
		var format = accounting.formatNumber(current_val, 2, ",");
		
		
		$("#"+param+check).val(format);
		$("#"+param+check+"_input").val(nonformat);
		
		if(param == "qty" || param == "price"){
			//Ubah Total Per Item
			var total = $("#qty"+check+"_input").val() * $("#price"+check+"_input").val();
			var format = accounting.formatNumber(total, 2, ",");
			$("#total"+check).val(format);
			
			//Ubah Total Sebelum PPN
			var num = parseInt($('#num_item').val())-1;
			var subtotal = 0;
			
			for (i = 1; i <= num; i++) {
				subtotal = subtotal + parseFloat(accounting.unformat($("#total"+check).val()));
			}
			$("#totalss").text(cur+accounting.formatNumber(subtotal, 2, ","));
			var pajak = "<?php echo $pajak ?>";
			if(pajak == 1){
				$("#subtotalss").text(cur+accounting.formatNumber(subtotal*1.1, 2, ","));
			}
			else{
				$("#subtotalss").text(cur+accounting.formatNumber(subtotal, 2, ","));
			}
		}
	}
	
	function set_field_ontipepenawaran(){
		var tipe = $('#tipepenawaran').val();
		var num = parseInt($('#num_item').val())-1;
		if(tipe == 'A'){
			for (i = 1; i <= num; i++) { 
				$("#desc_"+i).val($("#desc_"+i+"_temp").val());
				$("#qty_"+i).val($("#qty_"+i+"_temp").val());
				$("#qty_"+i+"_input").val($("#qty_"+i+"_temp").val());
				
				$("#price_"+i).focus();
				$("#total_"+i).val("");
				//$("#price_"+i+"_input").val(0);
				
				$("#desc_"+i).attr("readonly", true);
				$("#qty_"+i).attr("readonly", true);
				$("#price_"+i).blur();
			}
		}
		else if(tipe == 'B'){
			for (i = 1; i <= num; i++) { 
				$("#desc_"+i).val("");
				$("#desc_"+i).attr("readonly", false);
				$("#qty_"+i).val($("#qty_"+i+"_temp").val());
				$("#qty_"+i+"_input").val($("#qty_"+i+"_temp").val());
				$("#qty_"+i).attr("readonly", true);
				$("#price_"+i).focus();
				$("#total_"+i).val("");
				//$("#price_"+i+"_input").val(0)
				$("#price_"+i).blur();
			}
		}
		else if(tipe == 'C' || tipe == ''){
			for (i = 1; i <= num; i++) { 
				$("#desc_"+i).val("");
				$("#qty_"+i).val("");
				$("#qty_"+i+"_input").val(0);
				$("#price_"+i).focus();
				$("#total_"+i).val("");
				//$("#price_"+i+"_input").val(0)
				$("#desc_"+i).attr("readonly", false);
				$("#qty_"+i).attr("readonly", false);
				$("#price_"+i).blur();
			}
		}
	}
</script>