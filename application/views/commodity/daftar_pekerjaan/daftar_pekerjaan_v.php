<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">

<?php /*
    <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Grup Barang</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="ibox-content">

          <div class="table-responsive">

            <table id="table_grup_brg" class="table table-bordered table-striped"></table>

          </div>

        </div>
      </div>

      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Grup Jasa</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="ibox-content">

          <div class="table-responsive">

            <table id="table_grup_jasa" class="table table-bordered table-striped"></table>

          </div>

        </div>
      </div>
      */ ?>

      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Katalog Barang</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="ibox-content">

          <div class="table-responsive">

            <table id="table_kat_brg" class="table table-bordered table-striped"></table>

          </div>

        </div>
      </div>

      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Katalog Jasa</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="ibox-content">

          <div class="table-responsive">

            <div id="toolbar"></div>
            <table id="table_kat_jasa" class="table table-bordered table-striped"></table>

          </div>

        </div>
      </div>

      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Harga Barang</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="ibox-content">

          <div class="table-responsive">

            <div id="toolbar"></div>
            <table id="table_hrg_brg" class="table table-bordered table-striped"></table>

          </div>

        </div>
      </div>

      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Harga Jasa</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="ibox-content">

          <div class="table-responsive">

            <div id="toolbar"></div>
            <table id="table_hrg_jasa" class="table table-bordered table-striped"></table>

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

    var mydata = $.getCustomJSON("<?php echo site_url('commodity') ?>/"+url);

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
    '<a class="btn btn-primary btn-xs approval" href="'+value+'" title="Approval">',
    'Proses',
    '</a>  ',
  /*
  '<a class="remove" href="javascript:void(0)" title="Remove">',
  '<i class="glyphicon glyphicon-remove"></i>',
  '</a>'
  */
  ].join('');
}
window.operateEvents = {
  'click .approval': function (e, value, row, index) {
    //alert('You click approval action, row: ' + JSON.stringify(row));
  },
  /*
  'click .remove': function (e, value, row, index) {
    $table_kat_brg.bootstrapTable('remove', {
      field: 'id',
      values: [row.mat_catalog_code]
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

  var $table_grup_brg = $('#table_grup_brg'),
  $table_grup_jasa   = $('#table_grup_jasa'),
  $table_kat_brg = $('#table_kat_brg'),
  $table_kat_jasa = $('#table_kat_jasa'),
  $table_hrg_brg = $('#table_hrg_brg'),
  $table_hrg_jasa = $('#table_hrg_jasa'),
  selections = [];

</script>

<script type="text/javascript">

  $(function () {

    $table_grup_brg.bootstrapTable({

      url: "<?php echo site_url('commodity/data_grup_brg/approval') ?>",
      cookieIdTable:"mat_group",
      idField:"mat_group_code",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'operate',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'10%',
        events: operateEvents,
        formatter: operateFormatter,
      },
       {
    field: 'mat_group_code',
    title: 'Kode Group',
    sortable:true,
    order:true,
    searchable:true,
    align: 'center',
    valign: 'middle',
    width:'10%',
  },
{
    field: 'mat_group_parent',
    title: 'Induk',
    sortable:true,
    order:true,
    searchable:true,
    align: 'left',
    valign: 'middle'
  },
   {
    field: 'mat_group_name',
    title: 'Nama',
    sortable:true,
    order:true,
    searchable:true,
    align: 'left',
    valign: 'middle'
  },

      ]

    });
setTimeout(function () {
  $table_grup_brg.bootstrapTable('resetView');
}, 200);

$table_grup_brg.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_grup_brg"));
});

});

</script>

<script type="text/javascript">

  $(function () {

    $table_grup_jasa.bootstrapTable({

      url: "<?php echo site_url('commodity/data_grup_jasa/approval') ?>",
      cookieIdTable:"srv_group",
      idField:"srv_group_code",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'operate',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'10%',
        events: operateEvents,
        formatter: operateFormatter,
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
    field: 'srv_group_parent',
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

      ]

    });
setTimeout(function () {
  $table_grup_jasa.bootstrapTable('resetView');
}, 200);

$table_grup_jasa.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_grup_jasa"));
});

});

</script>

<script type="text/javascript">

  $(function () {

    $table_kat_brg.bootstrapTable({

      url: "<?php echo site_url('commodity/data_mat_catalog/approval') ?>",
      cookieIdTable:"mat_catalog",
      idField:"mat_catalog_code",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'operate',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'10%',
        events: operateEvents,
        formatter: operateFormatter,
      },
      {
        field: 'mat_catalog_code',
        title: 'Kode Barang',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'10%',
      }, {
        field: 'mat_group_code',
        title: 'Group',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'5%',
      },
      {
        field: 'short_description',
        title: 'Deskripsi',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      {
        field: 'uom',
        title: 'Satuan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      }

      ]

    });
setTimeout(function () {
  $table_kat_brg.bootstrapTable('resetView');
}, 200);

$table_kat_brg.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_mat_catalog"));
});

});

</script>


<script type="text/javascript">

  $(function () {

    $table_kat_jasa.bootstrapTable({

      url: "<?php echo site_url('commodity/data_kat_jasa/approval') ?>",
      cookieIdTable:"kat_jasa",
      idField:"kat_jasa_code",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'operate',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'10%',
        events: operateEvents,
        formatter: operateFormatter,
      },
      {
        field: 'srv_catalog_code',
        title: 'Kode Jasa',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'10%',
      }, {
        field: 'srv_group_code',
        title: 'Group',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'5%',
      },

      {
        field: 'short_description',
        title: 'Deskripsi',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      }


      ]

    });
setTimeout(function () {
  $table_kat_jasa.bootstrapTable('resetView');
}, 200);

$table_kat_jasa.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_kat_jasa"));
});

});

</script>

<script type="text/javascript">

  $(function () {

    $table_hrg_brg.bootstrapTable({
      
      url: "<?php echo site_url('commodity/data_hrg_brg/approval') ?>",
      cookieIdTable:"hrg_brg",
      idField:"hrg_brg_code",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'operate',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'10%',
        events: operateEvents,
        formatter: operateFormatter,
      },
{
        field: 'mat_catalog_code',
        title: 'Kode Katalog',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },

      {
        field: 'short_description',
        title: 'Deskripsi',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      {
        field: 'sourcing_name',
        title: 'Referensi',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      {
        field: 'vendor',
        title: 'Vendor',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      {
        field: 'status',
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
  $table_hrg_brg.bootstrapTable('resetView');
}, 200);

$table_hrg_brg.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_hrg_brg"));
});

});

</script>

<script type="text/javascript">

  $(function () {

    $table_hrg_jasa.bootstrapTable({
      
      url: "<?php echo site_url('commodity/data_hrg_jasa/approval') ?>",
      cookieIdTable:"hrg_jasa",
      idField:"hrg_jasa_code",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'operate',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'10%',
        events: operateEvents,
        formatter: operateFormatter,
      },
      {
        field: 'srv_catalog_code',
        title: 'Kode Katalog',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },

      {
        field: 'short_description',
        title: 'Deskripsi',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      {
        field: 'sourcing_name',
        title: 'Referensi',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      {
        field: 'vendor',
        title: 'Vendor',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      {
        field: 'status',
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
  $table_hrg_jasa.bootstrapTable('resetView');
}, 200);

$table_hrg_jasa.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_hrg_jasa"));
});

});

</script>