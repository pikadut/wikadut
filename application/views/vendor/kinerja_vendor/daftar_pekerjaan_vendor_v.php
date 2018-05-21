<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Suspend Vendor</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>        

        <div class="ibox-content">

          <div class="table-responsive">             

            <table id="daftar_pekerjaan_vendor" class="table table-bordered table-striped"></table>

          </div>

        </div>
      </div>

       <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Suspend Commodity Vendor</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>        

        <div class="ibox-content">

          <div class="table-responsive">             

            <table id="suspend_commodity_vendor" class="table table-bordered table-striped"></table>

          </div>

        </div>
      </div>


      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Blacklist Vendor</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>        

        <div class="ibox-content">

          <div class="table-responsive">             

            <table id="blacklist_vendor" class="table table-bordered table-striped"></table>

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

    var mydata = $.getCustomJSON("<?php echo site_url('Vendor') ?>/"+url);

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

  function operateFormatterSuspend(value, row, index) {
    var link = "<?php echo site_url('vendor') ?>";
    return [
    '<a class="btn btn-primary btn-xs action" href="'+link+'/daftar_pekerjaan_vendor_form/'+value+'">',
    'Proses Suspend',
    '</a>  '
    ].join('');
  }

  function operateFormatterSuspendCommodity(value, row, index) {
    var link = "<?php echo site_url('vendor') ?>";
    return [
    '<a class="btn btn-primary btn-xs action" href="'+link+'/daftar_pekerjaan_vendor_commodity_form/'+value+'">',
    'Proses Suspend Commodity',
    '</a>  '
    ].join('');
  }

  function operateFormatterBlacklist(value, row, index) {
    var link = "<?php echo site_url('vendor') ?>";
    return [
    '<a class="btn btn-primary btn-xs action" href="'+link+'/daftar_pekerjaan_blacklist_vendor_form/'+value+'">',
    'Proses Blacklist',
    '</a>  '
    ].join('');
  }
  window.operateEvents = {
    'click .approval': function (e, value, row, index) {
    //alert('You click approval action, row: ' + JSON.stringify(row));
  },
  /*
  'click .remove': function (e, value, row, index) {
    $daftar_pekerjaan_vendor.bootstrapTable('remove', {
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

  var $daftar_pekerjaan_vendor = $('#daftar_pekerjaan_vendor'),
      $suspend_commodity_vendor = $('#suspend_commodity_vendor'),
      $blacklist_vendor = $('#blacklist_vendor'),
  selections = [];

</script>

<script type="text/javascript">

  $(function () {

    $daftar_pekerjaan_vendor.bootstrapTable({

      url: "<?php echo site_url('Vendor/data_daftar_pekerjaan_vendor') ?>",
     
      cookieIdTable:"vw_daftar_pekerjaan_vendor",
      
      idField:"vendor_id",
      
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      
      columns: [
      {
        field: 'vendor_id',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        events: operateEvents,
        formatter: operateFormatterSuspend,
      },
      {
        field: 'vendor_name',
        title: 'Nama Vendor',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'activity',
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
  $daftar_pekerjaan_vendor.bootstrapTable('resetView');
}, 200);

$daftar_pekerjaan_vendor.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_daftar_pekerjaan_vendor"));
});

});

</script>


<script type="text/javascript">

  $(function () {

    $suspend_commodity_vendor.bootstrapTable({

      url: "<?php echo site_url('Vendor/data_daftar_pekerjaan_commodity_vendor') ?>",
     
      cookieIdTable:"vnd_suspend_commodity_vendor",
      
      idField:"vendor_id",
      
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      
      columns: [
      {
        field: 'id_suspend_commodity_vendor',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        events: operateEvents,
        formatter: operateFormatterSuspendCommodity,
      },
      {
        field: 'vendor_name',
        title: 'Nama Vendor',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'group_type',
        title: 'Type',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'group_name',
        title: 'Commodity',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'vc_activity',
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
  $suspend_commodity_vendor.bootstrapTable('resetView');
}, 200);

$suspend_commodity_vendor.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_daftar_pekerjaan_vendor"));
});

});

</script>



<script type="text/javascript">

  $(function () {

    $blacklist_vendor.bootstrapTable({

      url: "<?php echo site_url('Vendor/data_daftar_pekerjaan_blacklist_vendor') ?>",

      cookieIdTable:"vw_daftar_pekerjaan_blacklist_vendor",

      idField:"vendor_id",

      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>

      columns: [
      {
        field: 'vendor_id',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        events: operateEvents,
        formatter: operateFormatterBlacklist,
      },
      {
        field: 'vendor_name',
        title: 'Nama Vendor',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'activity',
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
  $blacklist_vendor.bootstrapTable('resetView');
}, 200);

$blacklist_vendor.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_blacklist_vendor"));
});

});

</script>