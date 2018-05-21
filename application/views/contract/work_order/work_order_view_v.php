<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" action="<?php echo site_url($controller_name."/work_order_view");?>"  class="form-horizontal">

<?php include("view/header_v.php") ?>

<?php include("view/item_v.php") ?>

<?php include("view/komentar_v.php") ?>

<?php echo buttonsubmit('',lang('back'),lang('save')) ?>

</form>

</div>