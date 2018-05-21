<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>HISTORI SANGGAHAN</h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>

      <div class="ibox-content">

        <table id="sanggahan_table" class="table table-bordered table-striped"></table>

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

    var mydata = $.getCustomJSON("<?php echo site_url('procurement') ?>/"+url);

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

  function operateFormatterV(value, row, index) {
    return [
    '<a class="btn btn-primary btn-xs dialog" data-url="<?php echo site_url(PROCUREMENT_SANGGAHAN_DETAIL_PATH) ?>/'+value+'" href="#">',
    'Lihat',
    '</a>  ',
  ].join('');
}

</script>

<script type="text/javascript">

  var $sanggahan_table = $('#sanggahan_table'),
  selections = [];

</script>

<script type="text/javascript">

  $(function () {

    $sanggahan_table.bootstrapTable({

      url: "<?php echo site_url('procurement/data_sanggahan/') ?>",
      cookieIdTable:"sanggahan",
      idField:"pcl_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
          {
        field: 'pcl_id',
        title: 'Aksi',
        align: 'center',
        valign: 'middle',
        formatter: operateFormatterV,
      },
      {
        field: 'pcl_created_date',
        title: 'Tanggal & Waktu',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'vendor_name',
        title: 'Vendor',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
       {
        field: 'current_approver_name',
        title: 'Penjawab',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      {
        field: 'pcl_title',
        title: 'Judul Sanggahan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      

      {
        field: 'pcl_jwb_judul',
        title: 'Judul Penjawab',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },

            {
        field: 'pcl_status',
        title: 'Status',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      ]

    });

setTimeout(function () {
  $sanggahan_table.bootstrapTable('resetView');
}, 200);


});

</script>