<div class="wrapper wrapper-content animated fadeInRight">
<form method="post"  class="form-horizontal ajaxform">

<input type="hidden" name="id" value="<?php echo $id ?>">

<?php include("form/item_rfq_v.php"); ?>

<center>
<button type="button" class="btn btn-default" data-dismiss="modal">Kembali</button>
<button type="button" id="update_item_proc" class="btn btn-primary">Simpan</button>
</center>

</form>

</div>

<script type="text/javascript" src="<?php echo base_url() ?>/assets/js/custom.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>/assets/js/bottom.js"></script>


<script type="text/javascript">
	
	$("#update_item_proc").on("click",function(){

  if(confirm("Apakah anda yakin mengubah hps?")){

  var data = $("form.ajaxform").serialize();

  $.ajax({
    url:"<?php echo site_url($controller_name.'/submit_ubah_hps');?>",
    data:data,
    type:"post",
    dataType:"json",
    success:function(x){

      if(x.message === ""){

        toastr.success("Berhasil mengubah item", "Success");

               setTimeout(function() {
        window.location = x.redirect;
      },2000);

      } else {
        toastr.error(x.message, "Error");
      }

    }
  });

}

  return false;

}); 

</script>