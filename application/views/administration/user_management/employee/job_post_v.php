<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Job Position</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>
          </div>
        </div>        

        <div class="ibox-content">

          <div class="table-responsive">
            <a class="btn btn-primary" href="<?php echo site_url('administration/user_management/employee/add_job_post/'.$id) ?>" role="button">Tambah</a>               

            <table id="job_post" class="table table-bordered table-striped"></table>

          </div>

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

    var mydata = $.getCustomJSON("<?php echo site_url('administration') ?>/"+url);

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
    var link = "<?php echo site_url('administration/user_management/employee') ?>";
    return [
    '<a class="btn btn-danger btn-xs action" onclick="return confirm(\'Anda yakin ingin menghapus data?\')" href="'+link+'/hapus_job_post/'+value+'">',
    'Hapus',
    '</a>  ',
    ].join('');
  }
  window.operateEvents = {
    'click .approval': function (e, value, row, index) {
    //alert('You click approval action, row: ' + JSON.stringify(row));
  },
  /*
  'click .remove': function (e, value, row, index) {
    $employee.bootstrapTable('remove', {
      field: 'id',
      values: [row.id]
    });
  }
  */
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

<script type="text/javascript">

  var $job_post = $('#job_post'),
  selections = [];

</script>

<script type="text/javascript">

  $(function () {

    $job_post.bootstrapTable({

      url: "<?php echo site_url('administration/data_job_post/'.$id) ?>",
      striped:true,
      selectItemName:"list",
      sidePagination:"server",
      smartDisplay:false,
      cookie:true,
      cookieExpire:"1h",
      cookieIdTable:"adm_employee_pos",
      showExport:false,
      exportTypes:['json', 'xml', 'csv', 'txt', 'excel'],
      showFilter:true,
      flat:true,
      keyEvents:false,
      showMultiSort:true,
      reorderableColumns:false,
      resizable:false,
      pagination:true,
      cardView:false,
      detailView:false,
      search:true,
      showRefresh:true,
      showToggle:true,
      idField:"employee_pos_id",
      
      showColumns:true,
      columns: [
      {
        field: 'employee_pos_id',
        title: '#',
        align: 'center',
        events: operateEvents,
        formatter: operateFormatter,
      },
      {
        field: 'pos_name',
        title: 'Posisi',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'dept_name',
        title: 'Departemen',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'district_name',
        title: 'Kantor',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'is_active',
        title: 'Aktif?',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
       {
        field: 'is_main_job',
        title: 'Posisi Utama?',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      ]

    });
setTimeout(function () {
  $job_post.bootstrapTable('resetView');
}, 200);

$job_post.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,""));
});

});

</script>