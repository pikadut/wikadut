<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Hirarki Menu</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>        

        <div class="ibox-content">

          <div class="row">
            <div class="col-xs-12">
              <form id="search_pos">
                <select name="jobtitle" id="pos" class="form-control select2">
                  <option value="">Pilih Jabatan</option>
                  <?php foreach ($jobtitle as $k => $v) { ?>
                  <option <?php echo ($current_jobtitle == $v['job_title']) ? "selected" : "" ?> value="<?php echo $v['job_title'] ?>"><?php echo $v['job_title'] ?></option>
                  <?php } ?>
                </select>
              </form>
            </div>
          </div>
          <br/>

          <?php if(!empty($current_jobtitle)) { ?>

          <button type="button" data-loading-text="Loading..." class="save_menu btn btn-success btn-block">Simpan</button>

          <div id="treex">

            <?php echo $html ?>

          </div>

          <br/>

          <button type="button" data-loading-text="Loading..." class="save_menu btn btn-success btn-block">Simpan</button>

          <?php } ?>

        </div>
      </div>

    </div>
  </div>
</div>
<style type="text/css">
  ul
  {
    list-style-type: none;
  }
</style>

<script type="text/javascript">

  $(document).ready(function(){

    $("#pos").change(function(){
      var val = $(this).find("option:selected").val();
      $("#search_pos").submit();
    });

    $("#treex ul li input:checkbox").click(function(){
      var id = $(this).parent().attr("id");
      var parent = $(this).parent().attr("data-parent");
      var total_child = parseInt($("#treex ul li[data-parent='"+id+"']").length);
      var checked = $(this).prop("checked");

      if(total_child == 0){

        var p = $("#treex ul li#"+parent+" input:checkbox").prop("checked");

        if(checked && !p){
          $("#treex ul li#"+parent+" > input:checkbox").prop("checked",true);
          var parent2 = $("#treex ul li#"+parent).attr("data-parent");
          var p2 = $("#treex ul li#"+parent2+" > input:checkbox").prop("checked");

          if(!p2){
           $("#treex ul li#"+parent2+" > input:checkbox").prop("checked",true);
         }

       }

     } else {
       $("#treex ul li[data-parent='"+id+"'] input:checkbox").prop("checked",checked);
     }

   });

    $(".save_menu").click(function(){ 

      var mydata = []; 

      $(".save_menu").prop("disabled",true).button('loading');

      //var $btn = $(this).button('loading');

      $("input[type='checkbox']:checked").each(function (i,val) { 
        var isi = $(this).val();
        mydata.push(isi);
      }); 

      $.ajax({
        url:"<?php echo site_url('administration/submit_menu_management') ?>",
        data:{
          jobtitle:"<?php echo html_escape($current_jobtitle) ?>",
          menu:mydata
        },
        type:"post",
        success:function(data){
          alert("Berhasil menyimpan menu");
          $(".save_menu").prop("disabled",false).button('reset');
          window.location.refresh();
        }
      });

      //$btn.button('reset');

    });

  });

</script>