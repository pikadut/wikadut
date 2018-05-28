<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">

      <?php $hirarki = array("pr"=>0,"rfq"=>1,"pemenang"=>2); 
      foreach ($hirarki as $key => $value) { ?>
      <div class="ibox float-e-margins">
        <div class="ibox-title">
        <h5>Hirarki <?php echo strtoupper($key) ?></h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>        

        <div class="ibox-content">

          <div class="btn-group" role="group" aria-label="...">
            <button type="button" onclick="action_tree('add','<?php echo $key ?>')" class="btn btn-success">Tambah</button>
            <button type="button" onclick="action_tree('edit','<?php echo $key ?>')" class="btn btn-default">Ubah</button>
            <button type="button" onclick="action_tree('delete','<?php echo $key ?>')" class="btn btn-danger">Hapus</button>
          </div>

          <a class="btn btn-primary btn-xs pull-right refresh_hie" data-type="<?php echo $key ?>" href="#" role="button">Refresh</a> 

          <div data-type="<?php echo $key ?>" class="tree_hie"></div>

        </div>
      </div>

      <?php } ?>

    </div>
  </div>
</div>

<script type="text/javascript" src="<?php echo base_url('assets/plugins/jstree/dist/jstree.min.js') ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/plugins/jstree/dist/themes/default/style.min.css') ?>">

<script type="text/javascript">

  $.jstree.defaults.core.themes.icons = false;
  var url = "<?php echo site_url('administration/admin_tools/hierarchy_position') ?>";
     <?php foreach ($hirarki as $key => $value) { ?>
  $(".tree_hie[data-type='<?php echo $key ?>']").jstree({
    'core' : {
      "check_callback" : true,
      'data' : {
        "url" : "<?php echo site_url('administration/data_hierarchy_position/'.$key) ?>",
        "data" : function (node) {
         return { "id" : node.id };
       }
     }
   },
   "plugins" : [ "search","state", "types", "wholerow"],
 });
  <?php } ?>

  function action_tree(path,type) {

    var ref = $(".tree_hie[data-type='"+type+"']").jstree(true),
    sel = ref.get_selected();
    if(!sel.length) { 
      return false; 
    }
    sel = sel[0];
    var conf = true;
    if(path == 'delete'){
      conf = confirm("Apakah anda yakin ingin menghapus data?");
    }
    if(conf){
      if(sel == ""){
        alert("Pilih data");
      } else {
        window.location = url+"/"+path+"/"+sel+"/"+type;
      }
    }
  };

  $('.refresh_hie').on("click", function () {
    var type = $(this).data('type');
    var instance = $('.tree_hie[data-type="'+type+'"]').jstree(true);
    instance.refresh(false);
    return false;
  });

</script>