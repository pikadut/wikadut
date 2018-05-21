<div class="row wrapper border-bottom white-bg page-heading img-header">

  <div class="col-lg-10">
    <h2><?php echo $mytitle ?></h2>
    <?php /*
    <ol class="breadcrumb">
      <li>
        <a href="index.html">Home</a>
      </li>
      <li>
        <a>Forms</a>
      </li>
      <li class="active">
        <strong>Basic Form</strong>
      </li>
    </ol>
    */ ?> 
  </div>

  <div class="col-lg-2">

  </div>

</div>

<?php 
$message = $this->session->userdata("message");
$validate = validation_errors(); 

if(!empty($message)){ ?>

<br/>

<div class="alert alert-info" role="alert"><?php echo $message ?></div>

<?php } $this->session->unset_userdata("message");

if(!empty($validate)){ ?>

<br/>

<div class="alert alert-danger" role="alert"><?php echo $validate ?></div>

<?php } ?>

<?php include($body.".php"); ?>