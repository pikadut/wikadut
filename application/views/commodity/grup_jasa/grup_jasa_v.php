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
              <form class="form-horizontal" method="post" action="<?php echo site_url('commodity/katalog/grup_jasa/add');?>">
                <div class="input-group margin pull-left">
                  <span class="input-group-btn">
                  <button type="submit" name="action" class="btn btn-info btn-flat" value="add" >Tambah</button>
                  </span>
                </div>
                </form>
              </div>
            </div>
		<br />
		<div class="row">
			<div class="form-group">
				<label class="col-sm-1 control-label">Level 1</label>
				<div class="col-sm-8">
					<select class="form-control" id="level_1">
					</select>
				</div>
			</div>
			</div>
			<br />
			<div class="row">
			<div class="form-group">
				<label class="col-sm-1 control-label">Level 2</label>
				<div class="col-sm-8">
					<select class="form-control" id="level_2">
					</select>
				</div>
			</div>
			</div>
			<br />
			<div class="row">
			<div class="form-group">
				<label class="col-sm-1 control-label">Level 3</label>
				<div class="col-sm-8">
					<select class="form-control" id="level_3">
					</select>
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
	  
	  initDatatable();
	  
	  $.ajax({
          url:"<?php echo site_url('Commodity/dropdown_grup_jasa?level=1') ?>",
          type:"get",
		  dataType:"json",
		  success: function(data) {
            $.each(data, function(index, row) {
				$("#level_1").append("<option value='"+row.srv_group_code+"'>"+row.srv_group_code+" - "+row.srv_group_name+"</option>");
			});
			
			loadLevel2AndBelow();
          }
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
    url:"<?php echo site_url('Commodity/selection/selection_srv_group') ?>",
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
    url:"<?php echo site_url('Commodity/selection/selection_srv_group') ?>",
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
$("#level_1").change(function(){
		$("#level_2").html("");
		$("#level_3").html("");
		loadLevel2AndBelow();  
	  });
	  
	  $("#level_2").change(function(){
		$("#level_3").html("");
		loadLevel3AndBelow();  
	  });
	  
	  $("#level_3").change(function(){
		refreshDatatable();
	  });

});
function getIdSelections() {
  return $.map($table.bootstrapTable('getSelections'), function (row) {
    return row.srv_group_code
  });
}
function responseHandler(res) {
  $.each(res.rows, function (i, row) {
    row.state = $.inArray(row.srv_group_code, selections) !== -1;
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

  var mydata = $.getCustomJSON("<?php echo site_url('Commodity/alias_grup_jasa') ?>");

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
      values: [row.srv_group_code]
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
function initDatatable(){
	$table.bootstrapTable({
  cookieIdTable:"grup_jasa",
  idField:"srv_group_code",
  <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
  columns: [
  {
    field: 'checkbox',
    checkbox:true,
    align: 'center',
    valign: 'middle'
  },
  {
    field: 'srv_group_code',
    title: 'Kode Group',
    sortable:true,
    order:true,
    searchable:true,
    align: 'center',
    valign: 'middle',
    width:'10%',
  }, 
 {
    field: 'name_group',
    title: 'Induk',
    sortable:true,
    order:true,
    searchable:true,
    align: 'left',
    valign: 'middle'
  },
  {
    field: 'srv_group_name',
    title: 'Nama',
    sortable:true,
    order:true,
    searchable:true,
    align: 'left',
    valign: 'middle'
  },
  /*
   {
    field: 'srv_group_status',
    title: 'Status',
    sortable:true,
    order:true,
    searchable:true,
    align: 'center',
    valign: 'middle'
  },
  */
  ]

});
}
function loadLevel2AndBelow(){
		$.ajax({
				url:"<?php echo site_url('Commodity/dropdown_grup_jasa?parent='); ?>"+$("#level_1").val(),
				type:"get",
				dataType:"json",
				success: function(data) {
				$.each(data, function(index, row) {
					$("#level_2").append("<option value='"+row.srv_group_code+"'>"+row.srv_group_code+" - "+row.srv_group_name+"</option>");
				});
				
				loadLevel3AndBelow();
				}
			});		
	}
function loadLevel3AndBelow(){
	$.ajax({
				url:"<?php echo site_url('Commodity/dropdown_grup_jasa?parent=') ?>"+$("#level_2").val(),
				type:"get",
				dataType:"json",
				success: function(data) {
				$.each(data, function(index, row) {
				$("#level_3").append("<option value='"+row.srv_group_code+"'>"+row.srv_group_code+" - "+row.srv_group_name+"</option>");
				});
				
				refreshDatatable();
				}
			});
}
function refreshDatatable(){
		$table.bootstrapTable('refresh', {url: "<?php echo site_url('Commodity/data_grup_jasa?parent=') ?>"+$("#level_3").val()});
	}

</script>