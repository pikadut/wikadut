<div class="row">

 <?php 
 $success = $this->session->userdata("success_msg");
 $error = $this->session->userdata("error_msg");
 $msg = "";
 if(!empty($success)){
  $param = "success";
  $msg = $success;
  $this->session->unset_userdata("success_msg");
} else {
  $param = "danger";
  $msg = $error;
  $this->session->unset_userdata("error_msg");
}
if(!empty($msg)){
  ?>
  <div class="col-xs-12">
    <div class="alert alert-<?php echo $param ?>"><?php echo $msg ?></div>
  </div>
  <?php } ?>

  <div class="col-xs-12">

   <form role="form" action="<?php echo site_url("setting/submit") ?>" method="post" enctype="multipart/form-data">

    <?php foreach ($res as $key => $value) { 
      if($value['disabled_gp'] == 0){
      ?>

    <div class="form-group col-xs-12">

      <label ><?php echo $value['alias_gp'] ?></label>

      <?php if($value['type_gp'] == "text"){ ?>

      <input type="text" name="<?php echo $value['name_gp'] ?>" value="<?php echo $value['value_gp'] ?>" class="form-control">

      <?php } else if($value['type_gp'] == "textarea"){ ?>

      <textarea class="form-control" name="<?php echo $value['name_gp'] ?>"><?php echo $value['value_gp'] ?></textarea>

      <?php } else if($value['type_gp'] == "texteditor"){ ?>

      <textarea class="form-control editor" name="<?php echo $value['name_gp'] ?>"><?php echo $value['value_gp'] ?></textarea>

      <?php }  else if($value['type_gp'] == "image"){  ?>

      <input type="file" name="<?php echo $value['name_gp'] ?>">
      <?php if(!empty($value['value_gp'])){ ?>
      <br/>
      <a href="uploads/<?php echo $value['value_gp'] ?>" target="_blank">
        <img class="thumbnail" width="128px" src="uploads/<?php echo $value['value_gp'] ?>"/>
      </a>
      <a href="<?php echo site_url() ?>/setting/deleteimg/<?php echo $value['id_gp'] ?>" onclick="return confirm('Apakah anda yakin untuk menghapus file?');" class="btn btn-default">Hapus Gambar</a>
      <?php } ?>

      <?php } ?>

      <?php echo form_error('isi'); ?>

    </div> 

    <?php } } ?>

    <div class="form-group col-xs-12">
    <button type="submit" class="btn btn-default">Submit</button>
    </div>
  </form>
</div>

</div>

    <script type="text/javascript"> tinymce.init({
      selector: ".editor",
      plugins: [
      "advlist autolink lists link image charmap print preview anchor",
      "searchreplace visualblocks code fullscreen",
      "insertdatetime media table contextmenu paste"
      ],
      toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image",
      autosave_ask_before_unload: false,
      max_height: 200,
      min_height: 160,
      height : 180
    }); </script>