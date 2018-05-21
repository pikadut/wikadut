<div class="wrapper wrapper-content animated fadeInRight">

  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Daftar Tagihan</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="ibox-content">

          <div class="table-responsive">

            <table id="table_monitor_tagihan" class="table table-bordered table-striped"></table>

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

  var $table_monitor_tagihan = $('#table_monitor_tagihan'),
  selections = [];

</script>

<script type="text/javascript">

  $(function () {

    $table_monitor_tagihan.bootstrapTable({

      url: "<?php echo site_url('contract/data_tagihan') ?>",
     
      cookieIdTable:"table_monitor_tagihan",
     
      idField:"invoice_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      
      columns: [
       {
        field: 'invoice_id',
        title: '#',
        align: 'center',
        formatter: operateFormatter,
        width:'8%'
      },

      {
        field: 'contract_number',
        title: 'No. Kontrak',
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
        field: 'invoice_date',
        title: 'Tanggal Penagihan',
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
        align: 'center',
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
  $table_monitor_tagihan.bootstrapTable('resetView');
}, 200);

});

</script>