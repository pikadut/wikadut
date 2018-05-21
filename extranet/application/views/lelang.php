<!DOCTYPE html>
<html>
	
	<head>
		
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		
		<title>eSCM <?php echo COMPANY_NAME ?></title>
		
		<link href="<?php echo base_url('assets/css/bootstrap.min.css') ?>" rel="stylesheet">
		<link href="<?php echo base_url('assets/font-awesome/css/font-awesome.css') ?>" rel="stylesheet">
		<link href="<?php echo base_url('assets/css/animate.css') ?>" rel="stylesheet">
		<link href="<?php echo base_url('assets/css/style.css') ?>" rel="stylesheet">
		
		<!-- Data Tables -->
		<link href="<?php echo base_url('assets/css/plugins/dataTables/dataTables.bootstrap.css') ?>" rel="stylesheet">
		<link href="<?php echo base_url('assets/css/plugins/dataTables/dataTables.responsive.css') ?>" rel="stylesheet">
		<link href="<?php echo base_url('assets/css/plugins/dataTables/dataTables.tableTools.min.css') ?>" rel="stylesheet">
		
		<!-- Sweet Alert -->
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/plugins/sweetalert/sweetalert.css') ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/asdp.css') ?>">
		
	</head>
	
	<body class="top-navigation">
		
		<!-- Mainly scripts -->
		<script src="<?php echo base_url('assets/js/jquery-2.1.1.js') ?>"></script>
		<script src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>
		<script src="<?php echo base_url('assets/js/plugins/metisMenu/jquery.metisMenu.js') ?>"></script>
		<script src="<?php echo base_url('assets/js/plugins/slimscroll/jquery.slimscroll.min.js') ?>"></script>
		<script src="<?php echo base_url('assets/js/jquery.form.min.js') ?>"></script>
		
		<!-- Custom and plugin javascript -->
		<script src="<?php echo base_url('assets/js/inspinia.js') ?>"></script>
		<script src="<?php echo base_url('assets/js/plugins/pace/pace.min.js') ?>"></script>
		
		<!-- Data Tables -->
		<script src="<?php echo base_url('assets/js/plugins/dataTables/jquery.dataTables.js') ?>"></script>
		<script src="<?php echo base_url('assets/js/plugins/dataTables/dataTables.bootstrap.js') ?>"></script>
		<script src="<?php echo base_url('assets/js/plugins/dataTables/dataTables.responsive.js') ?>"></script>
		<script src="<?php echo base_url('assets/js/plugins/dataTables/dataTables.tableTools.min.js') ?>"></script>
		
		<!-- Jquery Validate -->
		<script src="<?php echo base_url('assets/js/plugins/validate/jquery.validate.min.js') ?>"></script>
		
		<!-- Sweet Alert -->
		<script src="<?php echo base_url('assets/js/plugins/sweetalert/sweetalert.min.js') ?>"></script>
		<script src="<?php echo base_url('assets/js/xss.min.js') ?>"></script>
		
		<div id="wrapper">
			<div id="page-wrapper" class="gray-bg">
				<div class="row border-bottom white-bg">
					<nav class="navbar navbar-static-top" role="navigation">
						<div class="navbar-header">
							<button aria-controls="navbar" aria-expanded="false" data-target="#navbar" data-toggle="collapse" class="navbar-toggle collapsed" type="button">
								<i class="fa fa-reorder"></i>
							</button>
							<a href="<?php echo site_url(); ?>" class="navbar-brand"><?php echo COMPANY_LABEL ?></a>
						</div>
						<div class="navbar-collapse collapse" id="navbar">
							<ul class="nav navbar-nav">
								<li class="active">
									<a aria-expanded="false" role="button" href="<?php echo site_url(); ?>"><?php echo $this->lang->line('Beranda'); ?></a>
								</li>
							</ul>
						</div>
					</nav>
				</div>
				<div class="wrapper wrapper-content">
					<div class="container">
						<div class="row">
							<div class="col-lg-12">
								<div class="ibox float-e-margins">
									<div class="ibox-title">
										<h5><?php echo $this->lang->line('Pengumuman Lelang'); ?></h5>
										<div class="ibox-tools">
											<a class="collapse-link">
												<i class="fa fa-chevron-up"></i>
											</a>
										</div>
									</div>
									<div class="ibox-content">
										<div class="table-responsive">
											<table class="table table-striped dataTables-example">
												<thead>
													<tr>
														<th>#</th>
														<th><?php echo $this->lang->line('Nomor Pengadaan'); ?></th>
														<th><?php echo $this->lang->line('Judul Pekerjaan'); ?></th>
														<th><?php echo $this->lang->line('Pembukaan Pendaftaran'); ?></th>
														<th><?php echo $this->lang->line('Penutupan Pendaftaran'); ?></th>
														<th><?php echo $this->lang->line('Aksi'); ?></th>
													</tr>
												</thead>
												<tbody>
													<?php $i = 1; foreach($list as $row) { ?>
														<tr>
															<td><?php echo $i ?></td>
															<td><?php echo $row["ptm_number"] ?></td>
															<td><?php echo $row["ptm_subject_of_work"] ?></td>
															<td><?php echo $this->umum->show_tanggal($row["ptp_reg_opening_date"]) ?></td>
															<td><?php echo $this->umum->show_tanggal($row["ptp_reg_closing_date"]) ?></td>
															<td><button type="button" data-en="<?php echo $this->umum->forbidden($this->encryption->encrypt($row["ptm_number"]), 'enkrip') ?>" data-id="<?php echo $row["ptm_number"] ?>" data-url="<?php echo site_url('welcome/lelang_login'); ?>" class="btn btn-outline btn-primary btn-sm picker">Daftar</button>&nbsp;<button type="button" data-en="none" data-id="none" data-url="<?php echo site_url('welcome/lelang_overview/'.$this->umum->forbidden($this->encryption->encrypt($row["ptm_number"]), 'enkrip').'/'.$this->umum->forbidden($this->encryption->encrypt("0"), 'enkrip')); ?>" class="btn btn-outline btn-success btn-sm picker">Lihat</button></td>
														</tr>
													<?php $i++; } ?>
												</tbody>
											</table>
										</div>
										
									</div>
								</div>
							</div>
						</div>
					<div class="row">
							<div class="col-lg-12">
								<div class="ibox float-e-margins">
									<div class="ibox-title">
										<h5><?php echo $this->lang->line('10 Lelang Terakhir'); ?></h5>
										<div class="ibox-tools">
											<a class="collapse-link">
												<i class="fa fa-chevron-up"></i>
											</a>
										</div>
									</div>
									<div class="ibox-content">
										<div class="table-responsive">
											<table class="table table-striped dataTables-example">
												<thead>
													<tr>
														<th>#</th>
														<th><?php echo $this->lang->line('Nomor Pengadaan'); ?></th>
														<th><?php echo $this->lang->line('Judul Pekerjaan'); ?></th>
														<th><?php echo $this->lang->line('Pembukaan Pendaftaran'); ?></th>
														<th><?php echo $this->lang->line('Penutupan Pendaftaran'); ?></th>
														<th><?php echo $this->lang->line('Aksi'); ?></th>
													</tr>
												</thead>
												<tbody>
													<?php $i = 1; foreach($past_list as $row) { ?>
														<tr>
															<td><?php echo $i ?></td>
															<td><?php echo $row["ptm_number"] ?></td>
															<td><?php echo $row["ptm_subject_of_work"] ?></td>
															<td><?php echo $this->umum->show_tanggal($row["ptp_reg_opening_date"]) ?></td>
															<td><?php echo $this->umum->show_tanggal($row["ptp_reg_closing_date"]) ?></td>
															<td><button type="button" data-en="none" data-id="none" data-url="<?php echo site_url('welcome/lelang_overview/'.$this->umum->forbidden($this->encryption->encrypt($row["ptm_number"]), 'enkrip').'/'.$this->umum->forbidden($this->encryption->encrypt("0"), 'enkrip')); ?>" class="btn btn-outline btn-success btn-sm picker">Lihat</button></td>
														</tr>
													<?php $i++; } ?>
												</tbody>
											</table>
										</div>
										
									</div>
								</div>
							</div>
						</div>
					</div>
					
					<div class="modal fade" id="picker" tabindex="-1" role="dialog" aria-labelledby="pickerLabel">
						<div class="modal-dialog modal-sm" style="width:90%" role="document">
							<div class="modal-content animated fadeIn">
								<div class="modal-header">
									<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
									<h4 class="modal-title" id="pickerLabel"><?php echo $this->lang->line('Pengumuman Lelang'); ?></h4>
								</div>
								<div class="modal-body">
									<div id="picker_content" width="100%" height="480px;"></div>
									<form class="m-t" role="form" id="login_id" method="POST" action="<?php echo site_url("welcome/lelang_in") ?>">
										<input type="hidden" name="picker_id" id="picker_id">
										<input type="hidden" name="en_picker_id" id="en_picker_id">
										</form>
								</div>
								<div class="modal-footer">
									<button style="display: none;" type="button" class="btn btn-primary" id="picker_pick">Login</button>
									<button type="button" class="btn btn-default" id="dismiss" data-dismiss="modal"><?php echo $this->lang->line('Tutup'); ?></button>
								</div>
							</div>
						</div>
					</div>
					
				</div>
				<div class="footer">
					<div class="pull-right">
						<?php echo COMPANY_NAME ?> &copy; 2015
					</div>
				</div>
			</div>
		</div>
		
		<script type="text/javascript">
			$(document).ready(function() {
				
				$(".picker").on("click",function(){
					var url = $(this).attr("data-url");
					$("#picker_content").load(url);
					var id = $(this).attr('data-id');
					var enid = $(this).attr('data-en');
					if($(this).attr('data-id') == "none"){
					$("#picker_pick").hide();
					}
					else{
					$("#picker_pick").show();
					}
					$("#picker_id").val(filterXSS(id));
					$("#en_picker_id").val(filterXSS(enid));
					$("#picker").modal("show");
					return false;
				});
				
				$('.dataTables-example').DataTable({
					"lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]]
				});
				
				$("#picker_pick").click(function(){
					if($("#login_form").validate().form()){
					disables();
						$("#login_form").ajaxSubmit({
							success: function(msg){
							if(msg == 1){
							$("#login_id").ajaxSubmit({
							success: function(msg){
							if(msg == 11){
							swal("Error", "Klasifikasi Perusahaan Anda Tidak Sesuai", "error");
							enables();
							}
							else if(msg == 22){
							swal("Error", "Komoditi Anda Tidak Sesuai", "error");
							enables();
							}
							else if(msg == 33){
							swal("Error", "Anda Telah Mengikuti Pengadaan Ini", "error");
							enables();
							}
							else if(msg == 1){
							window.location.href = '<?php echo site_url('welcome/lelang_overview/')?>'+'/'+$("#en_picker_id").val()+'/<?php echo $this->umum->forbidden($this->encryption->encrypt("1"), 'enkrip') ?>';
							}
							else{
							swal("Error", "Pesan-4: Cek Komoditi Gagal", "error");
							enables();
							}
							},
							error: function(){
							swal("Error", "Pesan-3: Cek Klasifikasi Gagal", "error");
							enables();
							}
							});	
							}
							else if(msg == 2){
							swal("Error", "Captcha Salah", "error");
							enables();
							}
							else{
							swal("Error", "Pesan-1: Username/Password salah ATAU Status Tidak Aktif ATAU Tidak Terdaftar di iProc <?php echo COMPANY_NAME ?>", "error");
							enables();
							}
							},
							error: function(){
								swal("Error", "Pesan-2: Login Gagal", "error");
								enables();
							}
						});
					}
				});
				
			});
			
			function disables(){
			$("#picker_pick").prop("disabled", true);
			$("#dismiss").prop("disabled", true);
			$("#picker_pick").text("Please Wait...");
			}
			
			function enables(){
			$("#picker_pick").prop("disabled", false);
			$("#dismiss").prop("disabled", false);
			$("#picker_pick").text("Login");
			}
		</script>
		
	</body>
	
</html>
