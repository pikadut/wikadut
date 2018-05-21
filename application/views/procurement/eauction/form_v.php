<div class="wrapper wrapper-content animated fadeInRight">
<form method="post" action="<?php echo site_url($controller_name."/submit_eauction");?>"  class="form-horizontal ajaxform">

<input type="hidden" name="id" value="<?php echo $id ?>">

<?php 

foreach ($content as $key => $value) {
  include(VIEWPATH."procurement/proses_pengadaan/".$value['awc_type']."/".$value['awc_file'].".php");
}

?>

<?php echo buttonsubmit('procurement/procurement_tools/e_auction',lang('back'),lang('save')) ?>

</form>

<script type="text/javascript">localStorage.setItem('dialogshow', "");</script>

</div>