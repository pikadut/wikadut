<div class="wrapper wrapper-content animated fadeInRight">

  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Daftar Kontrak</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="ibox-content">

          <div class="table-responsive">

            <table id="table_monitor_kontrak" class="table table-bordered table-striped"></table>

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

  function operateFormatter(value, row, index) {
    var link = "<?php echo site_url('contract/monitor/monitor_kontrak') ?>";
    return [
    '<a class="btn btn-primary btn-xs action" href="'+link+'/lihat/'+value+'">',
    'Lihat',
    '</a>  ',
    ].join('');
  }
  window.operateEvents = {
    'click .approval': function (e, value, row, index) {
    //alert('You click approval action, row: ' + JSON.stringify(row));
  },
  /*
  'click .remove': function (e, value, row, index) {
    $table_monitor_kontrak.bootstrapTable('remove', {
      field: 'id',
      values: [row.contract_id]
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

  var $table_monitor_kontrak = $('#table_monitor_kontrak'),
  selections = [];

</script>

<script type="text/javascript">

  $(function () {

    $table_monitor_kontrak.bootstrapTable({

      url: "<?php echo site_url('contract/data_monitor_kontrak/'.$act) ?>",

      cookieIdTable:"monitor_kontrak",
      
      idField:"contract_id",

      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>

      columns: [
      <?php if(!empty($act)){ ?>
       {
        field: 'radio',
        radio:true,
        align: 'center',
        valign: 'middle'
      },
      <?php } else { ?>
        {
          field: "contract_id",
          title: '#',
          align: 'center',
          width:'8%',
          valign: 'middle',
          formatter: operateFormatter,
        },
        <?php } ?>
        {
          field: 'ptm_number',
          title: 'Nomor Pengadaan',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle',
          width:'15%',
        },
        {
          field: 'contract_number',
          title: 'Nomor Kontrak',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle',
          width:'15%',
        },
        {
          field: 'subject_work',
          title: 'Deskripsi Pekerjaan',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle',
          width:'30%',
        },
        {
          field: 'vendor_name',
          title: 'Vendor',
          sortable:true,
          order:true,
          searchable:true,
          align: 'left',
          valign: 'middle',

        },
        {
          field: 'contract_type',
          title: 'Tipe',
          sortable:true,
          order:true,
          searchable:true,
          align: 'left',
          valign: 'middle',

        },
        {
          field: 'status_name',
          title: 'Status',
          sortable:true,
          order:true,
          searchable:true,
          align: 'left',
          valign: 'middle',
          width:'20%',
        },
        ]

      });

    setTimeout(function () {
      $table_monitor_kontrak.bootstrapTable('resetView');
    }, 200);

    $table_monitor_kontrak.on('expand-row.bs.table', function (e, index, row, $detail) {
      $detail.html(detailFormatter(index,row,"alias_permintaan_kontrak"));
    });

    $table_monitor_kontrak.on('check.bs.table  check-all.bs.table', function () {

      selections = getIdSelections();
      var param = "";
      $.each(selections,function(i,val){
        param += val+"=1&";
      });
      $.ajax({
        url:"<?php echo site_url('contract/picker') ?>",
        data:param,
        type:"get"
      });

    });
    $table_monitor_kontrak.on('uncheck.bs.table uncheck-all.bs.table', function () {

      selections = getIdSelections();

      var param = "";
      $.each(selections,function(i,val){
        param += val+"=0&";
      });
      $.ajax({
        url:"<?php echo site_url('contract/picker') ?>",
        data:param,
        type:"get"
      });
    });
    $table_monitor_kontrak.on('expand-row.bs.table', function (e, index, row, $detail) {
      $detail.html(detailFormatter(index,row));

    });
    $table_monitor_kontrak.on('all.bs.table', function (e, name, args) {
  //console.log(name, args);
});

    function getIdSelections() {
      return $.map($table_monitor_kontrak.bootstrapTable('getSelections'), function (row) {
        return row.contract_id;
      });
    }
    function responseHandler(res) {
      $.each(res.rows, function (i, row) {
        row.state = $.inArray(row.contract_id, selections) !== -1;
      });
      return res;
    }

  });


</script>