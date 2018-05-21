<div class="wrapper wrapper-content animated fadeInRight">
<form method="post" action="<?php echo site_url($controller_name."/submit_proses_addendum");?>"  class="form-horizontal ajaxform">

<input type="hidden" name="id" value="<?php echo $id ?>">

<?php 

foreach ($content as $key => $value) {
	include($value['awc_type']."/".$value['awc_file'].".php");
}

?>

<?php 
$i = 0;
include(VIEWPATH."/comment_workflow_v.php") ?>

<?php echo buttonsubmit('contract/daftar_pekerjaan',lang('back'),lang('save')) ?>

</form>

</div>