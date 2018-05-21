<div class="row">
  <div class="col-lg-12">

    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>Tagihan</h5>

      </div>

      <div class="ibox-content">

        <table id="tagihan_list" class="table table-bordered table-striped"></table>

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

    function operateFormatter(value, row, index) {
    var link = "<?php echo site_url('contract') ?>";
    return [
    '<a class="btn btn-primary btn-xs dialog" data-url="'+link+'/lihat_tagihan/'+value+'">',
    'Lihat',
    '</a>  ',
  ].join('');
}

</script>

<script type="text/javascript">

  var $tagihan_list = $('#tagihan_list'),
  selections = [];

</script>

<script type="text/javascript">

  $(function () {

    $tagihan_list.bootstrapTable({

      url: "<?php echo site_url('contract/data_tagihan') ?>",
      striped:true,
      sidePagination:"server",
      smartDisplay:false,
      cookie:true,
      cookieExpire:"1h",
      cookieIdTable:"tagihan_list",
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
      idField:"invoice_id",
      
      showColumns:true,
      columns: [
       {
        field: 'invoice_id',
        title: '#',
        align: 'center',
        formatter: operateFormatter,
        width:'8%'
      },
      {
        field: 'invoice_date',
        title: 'Tanggal Penagihan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'invoice_number',
        title: 'No. Penagihan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      {
        field: 'bank_account',
        title: 'Rekening Bank',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      
      {
        field: 'created_date',
        title: 'Dibuat Tanggal',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      
      ]

    });

setTimeout(function () {
  $tagihan_list.bootstrapTable('resetView');
}, 200);

});

</script>