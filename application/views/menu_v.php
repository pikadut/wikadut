<?php 
$uri = $this->uri->segment(1);
$uri2 = $this->uri->segment(2);
$uri3 = $this->uri->segment(3);
foreach($main_menu as $key => $value){
	$parent = $value['child'];
	$class = "";

	if(isset($uri)){
		$class = ($uri == $key) ? "active" : "";
	}
	if(empty($parent)){ ?>

	<li class="<?php echo $class ?>">
		<a href="<?php echo site_url() ?>/<?php echo $key ?>">

			<i class="fa <?php echo $value['icon'] ?> fa-fw"></i> 

			<span class="nav-label"><?php echo $value['label'] ?></span>
		</a>
	</li>

	<?php } else { 

		$buka = false;

		if(isset($uri) && !$buka){
			$buka = ($uri == $key) ? true : false;
		}
		?>

		<li class="<?php echo ($buka) ? 'active' : '' ?>">
			<a href="#">

				<i class="fa <?php echo $value['icon'] ?>"></i> 

				<span class="nav-label"><?php echo $value['label'] ?></span>
				<span class="fa arrow"></span>
			</a>

			<ul class="nav nav-second-level collapse <?php echo ($buka) ? 'in' : '' ?>">

				<?php foreach ($parent as $key2 => $value2) { 

					$parent2 = $value2['child'];
					$class2 = "";

					if(isset($uri2)){
						$class2 = ($uri."/".$uri2 == $key2) ? "active" : "";
					}

					if(empty($parent2)){ ?>
					
					<li class="<?php echo $class2 ?>">
						<a  href="<?php echo site_url() ?>/<?php echo $key2 ?>">

							<i class="fa <?php echo $value2['icon'] ?>"></i> 

							<?php echo $value2['label'] ?>
						</a>
					</li>

					<?php } else { 

						$buka2 = false;

						if(isset($uri2) && !$buka2){
							$buka2 = ($uri."/".$uri2 == $key2) ? true : false;
						}

						?>

						<li class="<?php echo ($buka2) ? 'active' : '' ?>">

							<a href="#">
							
								<i class="fa <?php echo $value2['icon'] ?>"></i> 
							
								<?php echo $value2['label'] ?>
								<span class="fa arrow"></span>
							</a>

							<ul class="nav nav-third-level collapse <?php echo ($buka2) ? 'in' : '' ?>">

								<?php foreach ($parent2 as $key3 => $value3) { 
									$class3 = "";
									if(isset($uri3)){
										$class3 = ($uri."/".$uri2."/".$uri3 == $key3) ? "active" : "";
									}
									?>

									<li class="<?php echo $class3 ?>">
										<a  href="<?php echo site_url() ?>/<?php echo $key3 ?>">
										
											<i class="fa <?php echo $value3['icon'] ?>"></i> 
											
											<?php echo $value3['label'] ?>
										</a>
									</li>

									<?php } ?>

								</ul>

							</li>

							<?php } ?>

							<?php } ?>

						</ul>
						
					</li>

					<?php } } ?>