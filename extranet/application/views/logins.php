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
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/iproc_scm.css') ?>">

<style type="text/css">
  .btnSpesial {
        height: 60px;
        background: rgba(43,145,208, 0.7);
        text-align: center left;
        color:white;
        min-width: 150%;
        max-width: 200%;
        -webkit-transition-duration:0.4s;
        cursor:pointer;
        }

    .btn:hover {
          box-shadow: 0 14px 18px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);
          color:white;
          background: rgba(43,145,208, 0.85);
          }

    .loginLogin {
            position: absolute;
            right: 0;
            min-height: 100% auto; 
            background: rgba(232,232,232,0.7); 
            border-left: 0px;
            padding: 15px 20px 20px 15px;
            border-color: #e7eaec;
            border-image: none;
            border-style: solid solid none;
            border-width: 1px 0px;  
            -webkit-animation-duration: 2s;
            animation-duration: 2s;
    }
    .isiBtnSpesial{
        max-width: 80%; 
        top: 50%;
        height: 100% auto;
        float: left; 
        text-align: left;
    }
    .panahBtnSpesial{
      max-width: 20%; 
      height: 100% auto;
      float: right; 
      text-align: right; 
      padding-right: 5%
    }

</style>
</head>

<body class="gray-bg login-bg" >
<div id="azzaz" style=" position: absolute; top: 40%; left: 0; position: absolute; width: 20%;">

<div class="animated bounceInDown" style="-webkit-animation-duration: 1.5s;
            animation-duration: 2s;animation-delay: 0.5s; margin-bottom: 5%;" >
<a href="http://vendor.pengadaan.com">
<button class="btn btnSpesial btn-sm btn-block" style="height: 100px;padding-left: 25%; padding-top: 5%; font-size: 14px">
<div class="row">
<div class="isiBtnSpesial">
<p class="isiButtonSpesial"><?php echo $this->lang->line('Daftar Rekanan di'); ?> <strong>pengadaan.com</strong></p>
</div>
<div class="panahBtnSpesial">&#9658;</div>
</div>
</button>
</a>
</div>
     
<div class="animated bounceInDown" style="-webkit-animation-duration: 1.5s;
            animation-duration: 2s;" >
<a href="<?php echo site_url("welcome/lelang"); ?>">
<button class="btn btnSpesial btn-sm  btn-block"  style="height: 100px; padding-left: 25%; padding-top: 5%; font-size: 14px">
<div class="row">
<div class="isiBtnSpesial">
<p class="isiButtonSpesial"><?php echo $this->lang->line('Pengumuman Pelelangan'); ?></p>
</div>
<div class="panahBtnSpesial">&#9658;</div>
</div>
</button>
</a>
</div>
        
</div>

<div id="crPC" style="bottom: 0; position: fixed;">
   <small>© <?php $made = 2018; echo ($made == DATE('Y')) ? $made : $made .'-'. DATE('Y') ?> All Right Reserved</small>
 </div>

  <div class="animated slideInRight loginLogin wrapper">
    <!-- <div class="ibox-content"> -->
     <div class="row" style="margin: 0% 5% 8% 5%; height: 100%">
      <div style="height: 100%;">
        <p align="center">
          <img src="<?php echo base_url('assets/img/logo.png') ?>" class="img-responsive" style="height: 35%; width: 35%">
        </p>
        <p>
          Eletronic Supply Chain Management <br/><strong><?php echo COMPANY_NAME ?></strong>
        </p>
        <p>
          Tujuan eSCM adalah untuk menciptakan transparansi, efisiensi dan efektifitas serta akuntabilitas dalam pengadaan barang dan jasa melalui media elektronik antara pengguna jasa dan penyedia jasa.
        </p>
        <p>
          <strong>Informasi eSCM</strong>
          <br/>
          Telp : 021-7202630
          <br/>
          Email : helpdesk@adw.co.id
        </p>
       
      <?php 
      $pesan = $this->session->userdata('message');
      $pesan = (empty(trim($pesan))) ? "" : $pesan;
      if(!empty($pesan)){ ?>
      <div class="alert alert-danger">
       <?php echo $pesan ?>
     </div>
     <?php } else { ?>
     <div class="alert alert-success" id="alert-alert">
       <?php echo $this->lang->line('Gunakan e-mail dan password dari vendor.pengadaan.com'); ?>
     </div>
     <?php }$this->session->unset_userdata('message'); ?>
     <form class="m-t" role="form" id="login_form" method="post" action="<?php echo site_url("welcome/in") ?>">
     
       
       <div class="form-group" style="display: none">
        <btn class="btn btn-success" id="helpleh">?</btn>
        <select class="form-control m-b" name="bahasa" style="width: 85%;float: right; padding-left: 0%">
          <option value="indonesia">Bahasa Indonesia</option>
          <option value="english">English</option>
        </select>

      </div>
      
      <div class="form-group">
        <input type="text" name="username_login" class="form-control" placeholder="Email" id="username_login" required>
      </div>
      <div class="form-group">
        <input type="password" name="password_login" class="form-control" placeholder="Password" id="password_login" required>
      </div>
      <div class="form-group" id="form_captcha" style="display: none">
        <img src="<?php echo site_url('welcome/gambar') ?>" style="width: 50%;" border="1" alt="CAPTCHA"><br /><br />
        <input type="text" name="captcha" class="form-control" placeholder="Type Text Above" required>
      </div>
      
      <button id="logins" type="submit" class="btn btn-success block m-b" style="float: left;"><?php echo $this->lang->line('Login'); ?></button>
      <btn class="btn btn-success tombolButtons" id="arrowDown" style="float: right; width: 15%;"> &#x2193; </btn>
      <btn class="btn btn-success tombolButtons" id="arrowUp" style="display: none;float: right; width: 15%;"> &#x2191; </btn>
      
    </form>
    <br/>
    <!-- <div align="center">
     -->
    <div align="center">
   Dikembangkan oleh <strong>ADW Consulting</strong> untuk <strong><?php echo COMPANY_NAME ?></strong>
  </div>
  <br/>
  <div id="crPhone" style="display: none; text-align: center;">
   <small>© <?php $made = 2018; echo ($made == DATE('Y')) ? $made : $made .'-'. DATE('Y') ?> All Right Reserved</small>
 </div>
 <br/>
    <div class="row" id="btnButtons" style="display: none;">
      
           <a href="http://vendor.pengadaan.com">
           <button class="btn btn-sm btn-block" style="height: 4em; background: rgba(43,145,208, 0.7); color: white; padding-top: 10px;font-size: 14px; margin-bottom: 10px">
           <p><?php echo $this->lang->line('Daftar Rekanan di'); ?> <strong>pengadaan.com</strong></p></button>
           </a>
         
         
          <a  href="<?php echo site_url("welcome/lelang"); ?>">
          <button class="btn btn-sm btn-block" style="height: 4em; background: rgba(43,145,208, 0.7);font-size: 14px; color: white"><?php echo $this->lang->line('Pengumuman Pelelangan'); ?></button></a>
        
    </div>
  </div>
</div>
<!-- <div class="row"> -->
  
 <div class="row" style="position: absolute; bottom: 0px; width: 100%; background-color: black">
    
    <div class="col-md-12 text-right" style="background: rgba(255,255,255,1); width: 100%; height: 100%">
    <div align="center">
        <a href="http://pengadaan.com" target="_blank"><img src="<?php echo base_url('assets/img/iproc.png') ?>"style="width: 25%; height: 10%" /></a>
    </div>
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
        $(".slideInRight").addClass("loginColumns-d");
        $("#azzaz").addClass("loginPengadaan-d");
        $('#logins').css('width', '100%');
        $('.tombolButtons').hide();
        $('#crPC').show();
        $('#crPhone').hide();
      } else {
        $(".slideInRight").addClass("loginColumns");
        $("#azzaz").hide();
        $('#arrowDown').show();
        $('#logins').css('width', '80%');
        $(".isiButtonSpesial").addClass("wordWrap")
        $('#crPC').hide();
        $('#crPhone').show();
      }

    });
    // $('#helpleh').click(function(){
    //   $('#alert-alert').toggle();
    // });
		$("#logins").click(function(){
      if($("#login_form").validate().form()){
        $("#logins").prop("disabled", true);
        $("#logins").text("Please Wait...");
      }
    });

    $('.tombolButtons').click(function(){
      if ($('#arrowDown').is(':visible')) {
        $('#arrowUp').show();
        $('#arrowDown').hide();
         }else {
        $('#arrowDown').show();
        $('#arrowUp').hide();
      }
      $('#btnButtons').toggle("slow");
    })
	});
 
$('#password_login').bind("change keyup input", function(){
  if($('#username_login').val()) {
    
      $('#form_captcha').show("slow");
    }})
$('#username_login').bind("change keyup input", function(){
  if($('#password_login').val()) {
    
      $('#form_captcha').show("slow");
    }})
</script>
</html>
