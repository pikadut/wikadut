<div class="wrapper wrapper-content animated fadeInRight">
<form method="post" action="<?php echo site_url($controller_name."/submit_ubah_tender_pengadaan");?>"  class="form-horizontal ajaxform">

<input type="hidden" name="id" value="<?php echo $id ?>">

<?php 

foreach ($content as $key => $value) {
	include(VIEWPATH."/procurement/proses_pengadaan/".$value['awc_type']."/".$value['awc_file'].".php");
}

?>

<?php 
$i = 0;
include(VIEWPATH."/comment_view_attachment_v.php") ?>

<?php echo buttonback('procurement/daftar_pekerjaan',lang('back'),lang('save')) ?>

</form>

<script type="text/javascript">localStorage.setItem('dialogshow', "");</script>

</div>