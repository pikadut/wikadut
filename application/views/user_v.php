<?php if($userdata['role_user'] == "admin"){ ?>
<div class="well">

  <div class="row">
    <div class="col-xs-10">
      <form class="form-inline" method="post" action="<?php echo site_url('user/add') ?>" role="form">
        <input type="hidden" name="table" value="<?php echo $table ?>">
        <div class="btn-group">
          <button type="submit" class="btn btn-default btn-sm">Add Data</button>
        </div>
      </form>
    </div>
<?php /*
<div class="col-xs-2">
<form class="form-inline" method="post" action="<?php echo site_url('user/export') ?>" role="form">
<input type="hidden" name="table" value="<?php echo $table ?>">
  <div align="right">
    <button type="submit" class="btn btn-primary">Export Data</button>
  </div>
</form>
</div>
*/ ?>

</div>
</div>
<?php } ?>
<div class="panel panel-default">
  <!-- Default panel contents -->
  <div class="panel-heading">Tabel <strong><?php echo $title ?></strong></div>

  <!-- Table -->
  <div class="table-responsive" style="padding:10px 10px;">

    <table class="table table-bordered">

      <thead>
        <tr>
          <?php foreach ($structure as $key => $value) { ?>
          <th><?php echo (isset($replace[$value])) ? $replace[$value] : ucwords(str_replace("_", " ", str_replace($prefix, "", $value))) ?></th>
          <?php } ?>
        </tr>
      </thead>

      <tfoot>
        <tr>
          <tr>
            <?php foreach ($structure as $key => $value) { ?>
            <th></th>
            <?php } ?>
          </tr>
        </tr>
      </tfoot>

      <tbody>


      </tbody>
    </table>
  </div>
</div>

<script type="text/javascript">

$(document).ready(function(){

  var oTable = $('table').dataTable({
    "processing": true,
    "serverSide": true,
    "ajax": {
      url: $(this).attr("data-href"),
      type: 'POST'
    },
    "aoColumnDefs" : [
    {"bSortable": false, "bSearchable": false,"aTargets": [ <?php echo count($structure)-1 ?> ]}
    ],
    "columns": [
    <?php   
    $n = 1;
    foreach ($structure as $key => $value) { 
      echo "{ 'data': '".$value."' }";
      if(count($structure) != $n){
        echo ",";
        $n++;
      }
    } ?>
    ]
  });



  window.setInterval(function(){
    $(".loading").hide();
    oTable.fnDraw(false); 

  },30000);
});
</script>