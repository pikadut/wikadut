<div class="row border-bottom">
  <!-- haqim -->
  <nav  class="navbar navbar-static-top navbar-fixed-top" role="navigation" style="margin-bottom: 0; "> 
  <!-- end -->

    <div class="navbar-header hidden-lg">
      <a class="navbar-minimalize minimalize-styl-2 btn btn-primary ">
        <i class="fa fa-bars"></i> 
      </a>

    </div>
    <ul class="nav navbar-top-links navbar-left">
     <li><a href="#" style="font-weight: bold;" id="servertime"></a></li>
   </ul>
   <ul class="nav navbar-top-links navbar-right">

    <span class="m-r-sm text-muted welcome-message">iProc v.1.3</span>
  </li>

        <li class="dropdown">
          <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
            <i class="fa fa-briefcase"></i> Ganti Posisi
          </a>
          <ul class="dropdown-menu dropdown-alerts">
            <?php foreach ($position as $key => $value) { ?>
            <li><a href="<?php echo site_url('log/change_role/'.$value['pos_id']) ?>"><?php echo $value['pos_name'] ?></a></li>
            <?php } ?>
          </ul>
        </li>
  
        <li>

          <li>
            <a href="<?php echo site_url('log/change_password') ?>">
              <i class="fa fa-lock"></i> Ubah Password
            </a>
          </li>
          <li>
            <a href="<?php echo site_url('log/logout') ?>">
              <i class="fa fa-sign-out"></i> Logout
            </a>
          </li>

        </ul>

      </nav>
