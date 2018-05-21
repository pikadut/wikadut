<?php
if(isset($readonly)){
	if($readonly == "1"){
		$readonly = "readonly";
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
	<?php 
	$submit_url = "pengadaan/submitnegos";
	include("header_penawaran.php");
	include("item_komersil_penawaran.php");
	?>
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
			var kurs = $('#currency').val();
			var total = $("#totalss").text();
			total = total.split(" ");
			var subtotal = $("#subtotalss").text();
			subtotal = subtotal.split(" ");
			var ppn = $("#ppnss").text();
			ppn = ppn.split(" ");
			$("#totalss").text(kurs+" "+total[1]);
			$("#subtotalss").text(kurs+" "+subtotal[1]);
			$("#ppnss").text(kurs+" "+ppn[1]);
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
							$("#bidbond").ajaxSubmit({
								success: function(msg){

								},error: function(){
									swal("Error", "<?php echo $this->lang->line('Pesan-0 : Data Gagal Disimpan'); ?>", "error");
									button_enabled();
								}
							});
							$("#adm").ajaxSubmit({
								success: function(msg){
									$("#teknis").ajaxSubmit({
										success: function(msg){
											$("#komersial").ajaxSubmit({
												success: function(msg){
													if(msg == "2a"){
														swal("Error", "<?php echo $this->lang->line('Data Header gagal disimpan. Harap Masukan Data Kembali'); ?>", "error");
													}
													else if(msg == "3a"){
														swal("Error", "<?php echo $this->lang->line('Data Administrasi gagal disimpan. Harap Masukan Data Kembali'); ?>", "error");
													}
													else if(msg == "4a"){
														swal("Error", "<?php echo $this->lang->line('Data Teknis gagal disimpan. Harap Masukan Data Kembali'); ?>", "error");
													}
													else if(msg == "5a"){
														swal("Error", "<?php echo $this->lang->line('Gagal Update Status Vendor. Harap Masukan Data Kembali'); ?>", "error");
													}
													else if(msg == "6a"){
														swal("Error", "<?php echo $this->lang->line('Data Komersial gagal disimpan. Harap Masukan Data Kembali'); ?>", "error");
													}
													else if($.isNumeric(msg)){
														swal({
															title: "<?php echo $this->lang->line('Selamat, Penawaran Anda Berhasil Dikirim'); ?>",
															text: "<?php echo $this->lang->line('Saat ini penawaran anda berada di peringkat'); ?> #"+msg,
															type: "success"
														},
														function(){
															window.location.assign('<?php echo site_url(); ?>');
														});
													}
												},
												error: function(){
													swal("Error", "<?php echo $this->lang->line('Pesan-1 : Data Gagal Disimpan'); ?>", "error");
												}
											});
										},
										error: function(){
											swal("Error", "<?php echo $this->lang->line('Pesan-2 : Data Gagal Disimpan'); ?>", "error");
										}
									});
								},
								error: function(){
									swal("Error", "<?php echo $this->lang->line('Pesan-3 : Data Gagal Disimpan'); ?>", "error");
								}
							});
						}
						else{
							if(msg.substring(0, 3) == "<p>"){	
								msg = msg.replace("<p>", "");
								msg = msg.replace("</p>", "");
								swal("Error", msg, "error");
							}
							else{
								swal("Error", "<?php echo $this->lang->line('Pesan-4 : Data Gagal Disimpan'); ?>", "error");
							}
						}
					},
					error: function(){
						swal("Error", "<?php echo $this->lang->line('Pesan-5 : Data Gagal Disimpan'); ?>", "error");
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
	
	var cur = $('#currency').val()+" ";
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
				subtotal = subtotal + parseFloat(accounting.unformat($("#total_"+i).val()));
			}
			$("#totalss").text(cur+accounting.formatNumber(subtotal, 2, ","));
			var pajak = "<?php echo $pajak ?>";
			if(pajak == 1){
				$("#subtotalss").text(cur+accounting.formatNumber(subtotal*1.1, 2, ","));
				$("#ppnss").text(cur+accounting.formatNumber(subtotal*0.1, 2, ","));
			}
			else{
				$("#subtotalss").text(cur+accounting.formatNumber(subtotal, 2, ","));
				$("#ppnss").text(cur+accounting.formatNumber(0, 2, ","));
			}
		}
	}
	
	function set_field_ontipepenawaran(){
		var tipe = $('#tipepenawaran').val();
		var num = parseInt($('#num_item').val())-1;
		if(tipe == 'A'){
			for (i = 1; i <= num; i++) { 
				a = i;
				$("#desc_"+i).val($("#desc_"+i+"_temp").val());
				$("#qty_"+i).val($("#qty_"+i+"_temp").val());
				$("#qty_"+i+"_input").val($("#qty_"+i+"_temp").val());
				$("#total_"+i).val("");
				$("#desc_"+i).attr("readonly", true);
				$("#qty_"+i).attr("readonly", true);
				$("#price_"+i).focus();
				$("#price_"+i).blur();
				i = a;
			}
		}
		else if(tipe == 'B'){
			for (i = 1; i <= num; i++) { 
				a = i;
				if($("#modo").val() != "edit"){
					$("#desc_"+i).val("");
				}
				$("#desc_"+i).attr("readonly", false);
				$("#qty_"+i).val($("#qty_"+i+"_temp").val());
				$("#qty_"+i+"_input").val($("#qty_"+i+"_temp").val());
				$("#qty_"+i).attr("readonly", true);
				$("#total_"+i).val("");
				$("#price_"+i).focus();
				$("#price_"+i).blur();
				i = a;
			}
		}
		else if(tipe == 'C'){
			for (i = 1; i <= num; i++) { 
				a = i;
				if($("#modo").val() != "edit"){
					$("#desc_"+i).val("");
					$("#qty_"+i).val("");
				}
				$("#qty_"+i+"_input").val(0);
				$("#total_"+i).val("");
				$("#desc_"+i).attr("readonly", false);
				$("#qty_"+i).attr("readonly", false);
				$("#price_"+i).focus();
				$("#price_"+i).blur();
				i = a;
			}
		}
	}
</script>