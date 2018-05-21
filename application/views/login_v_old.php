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
        <br/>
      </div>
      <div class="col-md-6">

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
      <br/>
      <br/>
      <div align="center">
        <img src="assets/img/iproc.png"/>
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
      if(width > 1200){
        $( ".fadeInDown" ).removeClass("loginColumns");
        $(".fadeInDown").addClass("loginColumns-d");
      } else {
        $( ".fadeInDown" ).removeClass("loginColumns-d");
        $(".fadeInDown").addClass("loginColumns");
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
