<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Master Data</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="ibox-content">

            <div class="row">
              <div class="col-sm-3">
              <form class="form-horizontal" method="post" action="<?php echo site_url('commodity/data_referensi/sumber/add');?>">
                <div class="input-group margin pull-left">
                  <input type="text" class="form-control" name="jumlah">
                  <span class="input-group-btn">
                  <button type="submit" name="action" class="btn btn-info btn-flat" value="add" >Tambah</button>
                  </span>
                </div>
                </form>
              </div>
              <div class="col-sm-9">
                <div class="btn-group pull-right">

                  <a href="<?php echo site_url('commodity/data_referensi/sumber/edit');?>" class="btn btn-info btn-flat">Ubah</a>

                  <a href="<?php echo site_url('commodity/data_referensi/sumber/delete');?>" onclick="return confirm('Are you sure want to delete this data?')" class="btn btn-info btn-flat">Hapus</a>

                </div>
              </div>
            </div>

          <div class="table-responsive">

            <div id="toolbar"></div>
            <table id="table" class="table table-bordered table-striped"></table>

          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">


  var $table = $('#table'),
  $remove = $('#remove'),
  selections = [];

  $(function () {

$table.bootstrapTable({
  
  url: "<?php echo site_url('Commodity/data_sumber') ?>",
  cookieIdTable:"mat_catalog",
  idField:"sourcing_id",
  <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
  columns: [
  {
    field: 'checkbox',
    checkbox:true,
    align: 'center',
    valign: 'middle'
  },
  <?php /*
  {
    field: 'sourcing_id',
    title: 'Kode Refrensi',
    sortable:true,
    order:true,
    searchable:true,
    align: 'center',
    valign: 'middle'
  }, 
  */ ?>{
    field: 'sourcing_name',
    title: 'Nama',
    sortable:true,
    order:true,
    searchable:true,
    align: 'center',
    valign: 'middle'
  },

  {
    field: 'sourcing_type',
    title: 'Type',
    sortable:true,
    order:true,
    searchable:true,
    align: 'left',
    valign: 'middle'
  },
  
  ]

});
setTimeout(function () {
  $table.bootstrapTable('resetView');
}, 200);
$table.on('check.bs.table  check-all.bs.table', function () {
  $remove.prop('disabled', !$table.bootstrapTable('getSelections').length);

  selections = getIdSelections();
  var param = "";
  $.each(selections,function(i,val){
    param += val+"=1&";
  });
  $.ajax({
    url:"<?php echo site_url('Commodity/selection/selection_sourcing') ?>",
    data:param,
    type:"get"
  });

});
$table.on('uncheck.bs.table uncheck-all.bs.table', function () {
  $remove.prop('disabled', !$table.bootstrapTable('getSelections').length);

  selections = getIdSelections();

  var param = "";
  $.each(selections,function(i,val){
    param += val+"=0&";
  });
  $.ajax({
    url:"<?php echo site_url('Commodity/selection/selection_sourcing') ?>",
    data:param,
    type:"get"
  });
});
$table.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row));

});
$table.on('all.bs.table', function (e, name, args) {
  //console.log(name, args);
});
$remove.click(function () {
  var ids = getIdSelections();
  $table.bootstrapTable('remove', {
    field: 'id',
    values: ids
  });
  $remove.prop('disabled', true);
});

});
function getIdSelections() {
  return $.map($table.bootstrapTable('getSelections'), function (row) {
    return row.sourcing_id
  });
}
function responseHandler(res) {
  $.each(res.rows, function (i, row) {
    row.state = $.inArray(row.sourcing_id, selections) !== -1;
  });
  return res;
}

jQuery.extend({
  getCustomJSON: function(url) {
    var result = null;
    $.ajax({
      url: url,
      type: 'get',
      dataType: 'json',
      async: false,
      success: function(data) {
        result = data;
      }
    });
    return result;
  }
});

function detailFormatter(index, row) {

  var mydata = $.getCustomJSON("<?php echo site_url('Commodity/alias_sumber') ?>");

  var html = [];
  $.each(row, function (key, value) {
   var data = $.grep(mydata, function(e){ 
     return e.field == key; 
   });

   if(typeof data[0] !== 'undefined'){

     html.push('<p><b>' + data[0].alias + ':</b> ' + value + '</p>');
   }
 });

  return html.join('');

}

function operateFormatter(value, row, index) {
  return [
  '<a class="like" href="javascript:void(0)" title="Like">',
  '<i class="glyphicon glyphicon-heart"></i>',
  '</a>  ',
  '<a class="remove" href="javascript:void(0)" title="Remove">',
  '<i class="glyphicon glyphicon-remove"></i>',
  '</a>'
  ].join('');
}
window.operateEvents = {
  'click .like': function (e, value, row, index) {
    alert('You click like action, row: ' + JSON.stringify(row));
  },
  'click .remove': function (e, value, row, index) {
    $table.bootstrapTable('remove', {
      field: 'id',
      values: [row.sourcing_id]
    });
  }
};
function totalTextFormatter(data) {
  return 'Total';
}
function totalNameFormatter(data) {
  return data.length;
}
function totalPriceFormatter(data) {
  var total = 0;
  $.each(data, function (i, row) {
    total += +(row.price.substring(1));
  });
  return '$' + total;
}

</script>