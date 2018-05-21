<div class="row">
  <div class="col-md-12">
    <div class="ibox-content">
      <?php 
      $pesan = $this->session->userdata('message');
      $pesan = (empty($pesan)) ? $this->lang->line('Masuk untuk mengikuti lelang') : $pesan;
      if(!empty($this->session->userdata('message'))){ ?>
      <div class="alert alert-danger">
       <?php echo $pesan ?>
     </div>
     <?php }
     else{
       ?>
       <div class="alert alert-info">
         <?php echo $pesan ?>
       </div>
       <div class="alert alert-success">
         <?php echo $this->lang->line('Gunakan e-mail dan password dari vendor.pengadaan.com'); ?>
       </div>
       <?php }$this->session->unset_userdata('message'); ?>
       <form class="m-t" role="form" id="login_form" method="POST" action="<?php echo site_url("welcome/lelang_in") ?>">
        <div class="form-group">
          <input type="text" name="username_login" class="form-control" placeholder="Email" required>
        </div>
        <div class="form-group">
          <input type="password" name="password_login" class="form-control" placeholder="Password" required>
          <input type="hidden" name="ids" id="ids">
        </div>
        <div class="form-group">
          <img src="<?php echo site_url('welcome/gambar') ?>" width="120" height="30" border="1" alt="CAPTCHA"><br /><br />
          <input type="text" name="captcha" class="form-control" placeholder="Type Text Above" required>
        </div>
      </form>
    </div>
  </div>
</div>
<script src="<?php echo base_url('assets/js/xss.min.js') ?>"></script>
<script type="text/javascript">
 $(document).ready(function() {
  $("#username_login").on("click",function(){
    var id = $("#picker_id").val();
    $("#ids").val(filterXSS(id));
  });	
});
</script>