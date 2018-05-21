<ul class="nav navbar-top-links navbar-right">
        
    <li class="dropdown">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
            <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
        </a>
        <ul class="dropdown-menu dropdown-user">
            <li>
                <a href="<?php echo site_url('user/edit/'.$userdata['id_user']) ?>">
                    <i class="fa fa-user fa-fw"></i> User Profile
                </a>
            </li>
            <?php if($userdata['role_user'] == "admin"){ ?>
            <li>
                <a href="<?php echo site_url('setting') ?>">
                    <i class="fa fa-gear fa-fw"></i> Settings
                </a>
            </li>
            <?php } ?>
            <li class="divider"></li>
            <li>
                <a href="<?php echo site_url('log/logout') ?>">
                    <i class="fa fa-sign-out fa-fw"></i> Logout
                </a>
            </li>
        </ul>
        <!-- /.dropdown-user -->
    </li>
    <!-- /.dropdown -->
</ul>
            <!-- /.navbar-top-links -->


            