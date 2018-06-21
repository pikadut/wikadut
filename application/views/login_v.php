<!DOCTYPE html>
<html>

<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title><?php echo COMPANY_NAME ?> | Login</title>

  <base href="<?php echo base_url() ?>"/>

  <link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet">

  <link href="assets/css/animate.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">
  <script type="text/javascript" src="assets/js/jquery-2.1.1.js"></script>
  <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/iproc_scm.css') ?>">


  <style type="text/css">
    .btn:hover {
            box-shadow: 0 14px 18px 0 rgba(0,0,0,0.24), 0 17px 50px 0 rgba(0,0,0,0.19);
            /*color:white;*/
            /*background-color:#31708f;*/
            }
      .loginLogin {
            position: absolute;
            right: 0; 
            -webkit-animation-duration: 2s;
            animation-duration: 2s;
            min-height: 100%; 
            background: rgba(232,232,232,0.7); 
            border-left: 0px;
            padding: 15px 20px 20px 15px;
            border-color: #e7eaec;
            border-image: none;
            border-style: solid solid none;
            border-width: 1px 0px;
      }
  </style>
</head>

<body class="gray-bg login-bg">
<div class="wrapper">
  <div class="animated slideInRight ibox-content wrapper loginLogin">

   <!-- <div class="" > -->

    <div class="row" style="margin-left: 8%; margin-right: 8%; margin-bottom: 5%">

      <div style="height: 100% absolute">
      <div style="height: 25%">
        <p align="center">
          <img src="<?php echo base_url('assets/img/logo.png') ?>" class="img-responsive" style="height: 35%; width: 35%">
        </p>
       </div> 
        <br/>
        <div style="height: 25%">
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
        </div>
        <br/>
        <div style="height: 25%">
        <h2 class="font-bold">eSCM Intranet</h2>
        <?php 
        $pesan = $this->session->userdata('message');
        $pesan = (empty($pesan)) ? "" : $pesan;
        if(!empty($pesan)){ ?>
        <div class="alert alert-info">
         <?php echo $pesan ?>
       </div>
       <?php } $this->session->unset_userdata('message'); ?>

       <form class="m-t" role="form" id="login_form" method="post" action="<?php echo site_url("log/in") ?>">
        <div class="form-group">
          <input type="text" class="form-control" name="username_login" placeholder="Username" required="">
        </div>
        <div class="form-group">
          <input type="password" class="form-control" name="password_login" placeholder="Password" required="">
        </div>
        <button type="submit" class="btn btn-success block full-width m-b">Masuk</button>

        <a id="forgot-btn">
          <small>Lupa password</small>
        </a>
      </form>
      <form class="m-t" role="form" id="forgot_form" method="post" style="display:none;" action="<?php echo site_url("log/forgot") ?>" >
        <div class="form-group">
          <input type="email" class="form-control" name="email_login" placeholder="Email" required="">
        </div>

        <button type="submit" class="btn btn-success block full-width m-b">Submit</button>

        <a href="#" id="login-btn">
          <small>Back to login</small>
        </a>
      </form>
      </div>
      <br/>
      
      <div style="height: 25%;"> 
        Dikembangkan oleh <strong>ADW Consulting</strong> untuk <strong><?php echo COMPANY_NAME ?></strong>
      </div>
      <br/>
      <div style="display: none" id="crPhone">
        <small>© <?php $made = 2018; echo ($made == DATE('Y')) ? $made : $made .'-'. DATE('Y') ?> All Right Reserved</small>
      </div>
      <!-- <div align="center">
        <img src="assets/img/iproc.png"/>
      </div> -->

    </div>
  </div>


  <div class="row" style="bottom: 0%; position: fixed; width: 100%;">
    
    <div class="col-md-12 text-right" style="background: rgba(255,255,255,1); width: 100%; height: 100%">
    <div align="center">
        <img src="assets/img/iproc.png"/ style="width: 25%; height: 10%">
    </div>
      <!-- 
      -->
   </div>
 </div>
</div>
<!-- </div> -->
<div style="bottom: 0px; position: fixed; text-align: center" id="crPC">
  <small>© <?php $made = 2018; echo ($made == DATE('Y')) ? $made : $made .'-'. DATE('Y') ?> All Right Reserved</small>
</div>
</div>
<script>
  $(function () {
    $("#forgot-btn").click(function(){
      $("#forgot_form").show();
      $("#login_form").hide();
    });
    $("#login-btn").click(function(){
      $("#forgot_form").hide();
      $("#login_form").show();
    });

    function sesuaikan(){
      var width = parseInt($(window).width());
      console.log(width);
      if(width > 480){
        $( ".slideInRight" ).removeClass("loginColumns");
        $(".slideInRight").addClass("loginColumns-d");
        $('#crPhone').hide();
        $('#crPC').show();
      } else {
        $( ".slideInRight" ).removeClass("loginColumns-d");
        $(".slideInRight").addClass("loginColumns");
        $('#crPhone').show();
        $('#crPC').hide();
      }
    }
    sesuaikan();
    $(window).on('resize', function(){

      sesuaikan();
    });
  });
</script>
<script type="text/javascript">
  /* telescoope.org 2015 */
</script>
</body>
</html>
