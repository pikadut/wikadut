<div class="wrapper wrapper-content animated fadeInRight">

  <form class="form-horizontal">

		<?php 

		$loaded = array();

		foreach ($content as $key => $value) {
			$str = "view/".$value['awc_file'].".php";
			if(!in_array($str, $loaded)){
				include($str);
				$loaded[] = $str;
			}
		}

		?>

    <?php 
    $i = 0;
    include(VIEWPATH."/comment_view_attachment_v.php"); 
    ?>

    <?php echo buttonback($redirect_back,lang('back'),lang('save')) ?>

  </form>

  <?php
  	//haqim
	include VIEWPATH.'procurement/proses_pengadaan/chat_pr_v.php';
	//end
  ?>

  

</div>
