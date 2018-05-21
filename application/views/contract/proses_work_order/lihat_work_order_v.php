<div class="wrapper wrapper-content animated fadeInRight">
	<form class="form-horizontal">

		<input type="hidden" name="id" value="<?php echo $id ?>">

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
		include(VIEWPATH."/comment_view_v.php") ?>

		<?php echo buttonback('contract/monitor/monitor_wo',lang('back')) ?>

	</form>

</div>