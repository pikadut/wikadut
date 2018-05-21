<!-- Modal -->
<div class="modal fade" id="myLoader" tabindex="-1" role="dialog" aria-labelledby="myLoaderLabel">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-body">
			<center><h3 class="modal-title" id="myLoaderLabel">Loading...</h3></center>
			<br/>
				<div class="progress">
					<div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
						<span class="sr-only">100% Complete</span>
					</div>
				</div>
			</div>

		</div>
	</div>
</div>

<div class="footer">
	<div>
		<strong>Copyright</strong> 
		<?php echo COMPANY_NAME;  
		echo " &copy "; 
			$created = 2018;
	    $now = date('Y');
	    if($now == $created){ 
	      echo $created;
	    }else{
	      echo $created." - ".$now;
	    }
	    ?>
	</div>
</div>

<script type="text/javascript">
/* telescoope.org 2015-2017 */
</script>