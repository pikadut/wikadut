<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
      <h5>Riwayat E-Auction</h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>

        </div>
      </div>
      <div class="ibox-content">
        <div class="table-responsive">

          <table id="riwayat_eauction" class="table table-bordered table-striped"></table>

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

    var mydata = $.getCustomJSON("<?php echo site_url('Procurement') ?>/"+url);

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

  var $riwayat_eauction = $('#riwayat_eauction'),
  selections = [];

</script>

<script type="text/javascript">

  $(function () {

    $riwayat_eauction.bootstrapTable({

      url: "<?php echo site_url('Procurement/data_riwayat_eauction') ?>",
      idField:"vendor_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [

      {
        field: 'vendor_name',
        title: 'Nama Vendor',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      {
        field: 'tgl_bid',
        title: 'Tanggal',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'jumlah_bid',
        title: 'Total',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      ]

    });
    setTimeout(function () {
      $riwayat_eauction.bootstrapTable('resetView');
    }, 200);

    $riwayat_eauction.on('expand-row.bs.table', function (e, index, row, $detail) {
      $detail.html(detailFormatter(index,row,"alias_vendor"));
    });

    setInterval(function(){
      $riwayat_eauction.bootstrapTable('refresh');
    },5000);

  });
</script>