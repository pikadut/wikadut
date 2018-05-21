<!-- tambah class hidden-print -->
<nav class="navbar-default navbar-static-side hidden-print" role="navigation">
  <div class="sidebar-collapse">
    <ul class="nav metismenu" id="side-menu">
      <li class="nav-header">
        <div class="dropdown profile-element"> 
          <!-- haqim #f3f3f4-->
          <div style="margin-bottom:12px;background-color:white;padding:8px;border-radius: 8px;">
            <img alt="image" style="max-width:100%;" class="img-reponsive" src="<?php echo base_url("assets/img/logo_wika.png") ?>" />
          </div>
          <!-- end -->

          <a data-toggle="dropdown" class="dropdown-toggle" href="#">
            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo $userdata['complete_name'] ?></strong>
            </span> <span class="text-muted text-xs block">
            <?php echo $userdata['district_id'] ?> - <?php echo $userdata['district_name'] ?> 
            <br/>
             <?php echo $userdata['dept_id'] ?> - <?php echo $userdata['dept_name'] ?> 
            <br/>
            <?php echo $userdata['pos_id'] ?> - <?php echo $userdata['pos_name'] ?> </span> </a>
          </div>
          <div class="logo-element" style="background-color: #fff;">
            <img alt="image" style="max-width:90%;" class="img-reponsive" src="<?php echo base_url("assets/img/logo.png") ?>" />
          </div>
        </li>


        <?php include("menu_v.php") ?>
      </ul>
    </div>
  </nav>
