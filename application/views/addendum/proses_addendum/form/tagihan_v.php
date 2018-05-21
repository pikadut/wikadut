<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>Form Tagihan</h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>

        </div>
      </div>
      <div class="ibox-content">   

       <?php $curval = $kontrak['vendor_name']; ?>
       <div class="form-group">
        <label class="col-sm-2 control-label">Vendor</label>
        <div class="col-sm-2">
         <p class="form-control-static"><?php echo $curval ?></p>
       </div>
     </div>

     <?php $curval = date(DEFAULT_FORMAT_DATETIME_DB); ?>
     <div class="form-group">
      <label class="col-sm-2 control-label">Tanggal Penagihan</label>
      <div class="col-sm-3">
        <div class="input-group date">
          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
          <input type="text" id="tgl_penagihan_inp" class="form-control datetimepicker" name="tgl_penagihan_inp" value="<?php echo $curval ?>">
        </div>
      </div>
    </div>

    <?php $curval = ""; ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">No. Penagihan</label>
      <div class="col-sm-3">
       <input type="text" class="form-control" maxlength="40" name="no_penagihan_inp" name="no_penagihan_inp" id="no_penagihan_inp" value="<?php echo $curval ?>">
     </div>
   </div>

   <?php $curval = ""; ?>
   <div class="form-group">
    <label class="col-sm-2 control-label">Rekening Bank</label>
    <div class="col-sm-6">
     <input type="text" class="form-control" maxlength="50" name="rek_bank_inp" id="rek_bank_inp" value="<?php echo $curval ?>">
   </div>
 </div>

<hr/>

<div class="table-responsive">

  <table id="milestone_done" class="table table-bordered table-striped"></table>


</div>

</div>
</div>
</div>
</div>


<script type="text/javascript">


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

  function detailFormatter(index, row, url) {

    var mydata = $.getCustomJSON("<?php echo site_url('contract') ?>/"+url);

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

</script>

<script type="text/javascript">

  var $milestone_done = $('#milestone_done'),
  selections = [];

</script>

<script type="text/javascript">

  $(function () {

    $milestone_done.bootstrapTable({

      url: "<?php echo site_url('contract/data_milestone/done') ?>",
      striped:true,
      selectItemName:"milestone_done[]",
      sidePagination:"server",
      smartDisplay:false,
      cookie:true,
      cookieExpire:"1h",
      cookieIdTable:"milestone_done",
      showExport:true,
      exportTypes:['json', 'xml', 'csv', 'txt', 'excel'],
      showFilter:true,
      flat:true,
      keyEvents:false,
      showMultiSort:true,
      reorderableColumns:false,
      resizable:true,
      pagination:true,
      cardView:false,
      detailView:false,
      search:true,
      showRefresh:true,
      showToggle:true,
      idField:"milestone_id",
      
      showColumns:true,
      columns: [
      {
        field: 'checkbox',
        title:'#',
        checkbox:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'description',
        title: 'Deskripsi Milestone',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      {
        field: 'target_date',
        title: 'Tanggal Target',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'percentage',
        title: 'Bobot (%)',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'total',
        title: 'Nominal',
        sortable:true,
        order:true,
        searchable:true,
        align: 'right',
        valign: 'middle'
      },
      ]

    });
setTimeout(function () {
  $milestone_done.bootstrapTable('resetView');
}, 200);

$milestone_done.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_vendor"));
});

$milestone_done.on('check.bs.table  check-all.bs.table', function () {

  selections = getIdSelections();
  var param = "";
  $.each(selections,function(i,val){
    param += val+"=1&";
  });
  $.ajax({
    url:"<?php echo site_url('contract/selection/selection_milestone') ?>",
    data:param,
    type:"get"
  });

});
$milestone_done.on('uncheck.bs.table uncheck-all.bs.table', function () {

  selections = getIdSelections();

  var param = "";
  $.each(selections,function(i,val){
    param += val+"=0&";
  });
  $.ajax({
    url:"<?php echo site_url('contract/selection/selection_milestone') ?>",
    data:param,
    type:"get"
  });
});
$milestone_done.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row));

});
$milestone_done.on('all.bs.table', function (e, name, args) {
  //console.log(name, args);
});

function getIdSelections() {
  return $.map($milestone_done.bootstrapTable('getSelections'), function (row) {
    return row.milestone_id
  });
}
function responseHandler(res) {
  $.each(res.rows, function (i, row) {
    row.state = $.inArray(row.milestone_id, selections) !== -1;
  });
  return res;
}


$("#add_invoice_btn").on("click",function(){

  if(confirm("Apakah anda yakin membuat tagihan? Tagihan yang sudah dibuat tidak dapat diubah")){

  var data = $("form.ajaxform").serialize();

  $.ajax({
    url:"<?php echo site_url('contract/save_invoice') ?>",
    data:data,
    type:"post",
    dataType:"json",
    success:function(x){

      if(x.message === ""){

        $(".ajaxform input:text,.ajaxform textarea").each(function(){
          $(this).val("");
        });

        toastr.success("Berhasil membuat tagihan", "Success");
        $("#milestone_done").bootstrapTable('refresh');
        $("#tagihan_list").bootstrapTable('refresh');
      } else {
        toastr.error(x.message, "Error");
      }

    }
  });

}

  return false;

}); 

});

</script>