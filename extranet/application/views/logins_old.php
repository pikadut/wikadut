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
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/asdp.css') ?>">
</head>

<body class="gray-bg login-bg">

  <div class="animated fadeInDown">
    <div class="ibox-content">
     <div class="row">
      <div class="col-md-6">
        <p>
          <img src="<?php echo base_url('assets/img/logo.png') ?>" class="img-responsive">
        </p>
        <br/>
        <p>
          Eletronic Supply Chain Management <br/><strong><?php echo COMPANY_NAME ?></strong>
        </p>
        <p>
          Tujuan eSCM adalah untuk menciptakan transparansi, efisiensi dan efektifitas serta akuntabilitas dalam pengadaan barang dan jasa melalui media elektronik antara pengguna jasa dan penyedia jasa.
        </p>
        <p>
          <strong>Informasi eSCM</strong>
          <br/>
          Telp : +6221 8067 9200
          <br/>
          Email : humas@wika.co.id
        </p>
        <p>
         <a class="btn btn-sm btn-warning btn-block" href="http://vendor.pengadaan.com"><?php echo $this->lang->line('Daftar Rekanan di'); ?> <strong>pengadaan.com</strong></a>
       </p>
       <p>
        <a class="btn btn-sm btn-success btn-block" href="<?php echo site_url("welcome/lelang"); ?>"><?php echo $this->lang->line('Pengumuman Pelelangan'); ?></a>
      </p>

    </div>
    <div class="col-md-6">
      <?php 
      $pesan = $this->session->userdata('message');
      $pesan = (empty(trim($pesan))) ? "" : $pesan;
      if(!empty($pesan)){ ?>
      <div class="alert alert-danger">
       <?php echo $pesan ?>
     </div>
     <?php } else { ?>
     <div class="alert alert-success">
       <?php echo $this->lang->line('Gunakan e-mail dan password dari vendor.pengadaan.com'); ?>
     </div>
     <?php }$this->session->unset_userdata('message'); ?>
     <form class="m-t" role="form" id="login_form" method="post" action="<?php echo site_url("welcome/in") ?>">
       <div class="form-group">
        <select class="form-control m-b" name="bahasa">
          <option value="indonesia">Bahasa Indonesia</option>
          <option value="english">English</option>
        </select>
      </div>
      <br />
      <div class="form-group">
        <input type="text" name="username_login" class="form-control" placeholder="Email" required>
      </div>
      <div class="form-group">
        <input type="password" name="password_login" class="form-control" placeholder="Password" required>
      </div>
      <div class="form-group">
        <img src="<?php echo site_url('welcome/gambar') ?>" width="120" height="30" border="1" alt="CAPTCHA"><br /><br />
        <input type="text" name="captcha" class="form-control" placeholder="Type Text Above" required>
      </div>
      <button id="logins" type="submit" class="btn btn-success block full-width m-b"><?php echo $this->lang->line('Login'); ?></button>
    </form>
    <div align="center">
    <a href="http://pengadaan.com" target="_blank"><img src="<?php echo base_url('assets/img/iproc.png') ?>"/></a>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-6" align="center">
   Dikembangkan oleh <strong>ADW Consulting</strong> untuk <strong><?php echo COMPANY_NAME ?></strong>
 </div>
 <div class="col-md-6 text-right">
   <small>© 
    <?php 
    $created = 2018;
    $now = date('Y');
    if($now == $created){ 
      echo $created;
    }else{
      echo $created." - ".$now;
    }
    ?>
    All Right Reserved</small>
 </div>
</div>
</div>
</div>

</body>
<script src="<?php echo base_url('assets/js/jquery-2.1.1.js') ?>"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$(function () {
      var width = parseInt($(window).width());
      if(width > 480){
        $(".fadeInDown").addClass("loginColumns-d");
      } else {
        $(".fadeInDown").addClass("loginColumns");
      }

    });

		$("#logins").click(function(){
      if($("#login_form").validate().form()){
        $("#logins").prop("disabled", true);
        $("#logins").text("Please Wait...");
      }
    });
	});
</script>
</html>
