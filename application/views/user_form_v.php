<form class="form-horizontal" enctype="multipart/form-data" role="form" method="post" action="<?php echo site_url() ?>/user/submit_data">

  <div class="form-group">
    <label class="col-xs-2 control-label">Username</label>
    <div class="col-xs-4">
      <input type="text" name="username_inp" class="form-control" value="<?php echo (isset($data['username_user'])) ? $data['username_user'] : set_value("username_inp") ?>"/>
    </div>
    <?php echo errormessage(form_error("username_inp")) ?>
  </div>

  <?php if($act != "add"){ ?>
  <div class="form-group">
    <label class="col-xs-2 control-label">Old Password</label>
    <div class="col-xs-6">
      <input type="password" name="oldpass_inp" class="form-control" value=""/>
    </div>
    <?php echo errormessage(form_error("oldpass_inp")) ?>
  </div>
  <?php } ?>
  <div class="form-group">
    <label class="col-xs-2 control-label">Password</label>
    <div class="col-xs-6">
      <input type="password" name="password_inp" class="form-control" value=""/>
    </div>
    <?php echo errormessage(form_error("password_inp")) ?>
  </div>
  <div class="form-group">
    <label class="col-xs-2 control-label">Retype Password</label>
    <div class="col-xs-6">
      <input type="password" name="repassword_inp" class="form-control" value=""/>
    </div>
    <?php echo errormessage(form_error("repassword_inp")) ?>
  </div>

  <div class="form-group">
    <label class="col-xs-2 control-label">Name</label>
    <div class="col-xs-8">
      <input type="text" name="name_inp" class="form-control" value="<?php echo (isset($data['name_user'])) ? $data['name_user'] : set_value("name_inp") ?>"/>
    </div>
    <?php echo errormessage(form_error("name_inp")) ?>
  </div>

  <div class="form-group">
    <label class="col-xs-2 control-label">Email</label>
    <div class="col-xs-4">
    <input type="email" name="email_inp" class="form-control" value="<?php echo (isset($data['email_user'])) ? $data['email_user'] : set_value("email_inp") ?>"/>
    </div>
    <?php echo errormessage(form_error("email_inp")) ?>
  </div>

 <div class="form-group">
    <label class="col-xs-2 control-label">Birthday</label>
    <div class="col-xs-3">
    <input type="text" name="birthday_inp" class="form-control datepicker" value="<?php echo (isset($data['birthday_user'])) ? $data['birthday_user'] : set_value("birthday_inp") ?>"/>
    </div>
    <?php echo errormessage(form_error("birthday_inp")) ?>
  </div>

  <div class="form-group">
    <label class="col-xs-2 control-label">Phone</label>
    <div class="col-xs-4">
    <input type="text" name="phone_inp" class="form-control" value="<?php echo (isset($data['phone_user'])) ? $data['phone_user'] : set_value("phone_inp") ?>"/>
    </div>
    <?php echo errormessage(form_error("phone_inp")) ?>
  </div>
  
<?php if((isset($data['role_user']) && $userdata['role_user'] == "superadmin" && $userdata['id_user'] == 1) || $act == "add"){ ?>

    <div class="form-group">
    <label class="col-xs-2 control-label">Role</label>
    <div class="col-xs-4">

      <select name="role_inp" class="form-control">

      <?php 
      foreach ($role_list as $key => $value) { 
        $selected = (isset($data['role_user'])) ? strtolower($data['role_user']) : set_value("role_inp");
        $selected = (strtolower($value) == $selected) ? "selected" : "";
        ?>
        <option <?php echo $selected ?> value="<?php echo strtolower($value); ?>"><?php echo $value; ?></option>
      <?php } ?>
    
      </select>

    </div>
    <?php echo errormessage(form_error("role_inp")) ?>
  </div>

  <?php } else { ?>

  <div class="form-group">
    <label class="col-xs-2 control-label">Role</label>
    <div class="col-xs-4">
<p class="form-control-static">Superadmin</p>
    </div>

  </div>

  <?php } ?>

 <div class="form-group">
    <label class="col-xs-2 control-label">Photo</label>
    <div class="col-xs-5">
    <input type="file" name="photo_inp" class="form-control" />
    <?php if(isset($data['photo_user']) && !empty($data['photo_user'])){ ?>
    <br/>
      <img src="<?php echo base_url($dir.'/'.$data['photo_user']) ?>" class="img-responsive thumbnail"/>
      <a href="<?php echo site_url('user/delete_img/'.$id) ?>" onclick="return confirm('Are you sure to delete this picture?');" class="btn btn-default btn-sm">Remove</a>
    <?php } ?>
    
    </div>
    <?php echo errormessage(form_error("photo_inp")) ?>
  </div>

  <?php if((isset($data['role_user']) && $data['role_user'] == "superadmin") || $act == "add"){ ?>

        <div class="form-group">
      <label class="col-xs-2 control-label">Status</label>
      <div class="col-xs-2">
        <select name="status_inp" class="form-control">
          <?php $selected = ($data['status_user'] == 0) ? "selected" : "" ?>
          <option <?php echo $selected ?> value="0">Deactive</option>
          <?php $selected = ($data['status_user'] == 1) ? "selected" : "" ?>
          <option <?php echo $selected ?> value="1">Active</option>
        </select>
      </div>
      <?php echo errormessage(form_error("status_inp")) ?>
    </div>

    <?php } ?>

    <div class="form-group">
      <div class="col-xs-offset-2 col-xs-10">
        <input type="hidden" name="act" value="<?php echo $act ?>">
        <input type="hidden" name="id" value="<?php echo $id ?>">
        <button type="submit" class="btn btn-info">Submit</button>
        <button type="reset" class="btn btn-default">Reset</button>
        <a href="<?php echo site_url('user') ?>" class="btn btn-primary">Back</a>
      </div>
    </div>
  </form>

  <script type="text/javascript" src="assets/js/input.js"></script>