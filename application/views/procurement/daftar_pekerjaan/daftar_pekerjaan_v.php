<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">

      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Daftar Pekerjaan PR</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="ibox-content">

          <div class="table-responsive">

            <table id="table_pekerjaan_pr" class="table table-bordered table-striped"></table>

          </div>

        </div>
      </div>

      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Daftar Pekerjaan RFQ-Undangan</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="ibox-content">

          <div class="table-responsive">

            <table id="table_pekerjaan_rfq" class="table table-bordered table-striped"></table>

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

  function operateFormatter(value, row, index) {
    var link = "<?php echo site_url('procurement/daftar_pekerjaan') ?>";
    return [
    '<a class="btn btn-primary btn-xs action" href="'+link+'/proses/'+value+'">',
    'Proses',
    '</a>  ',
  ].join('');
}

 function operateFormatter2(value, row, index) {
    var link = "<?php echo site_url('procurement/daftar_pekerjaan') ?>";
    return [
    '<a class="btn btn-primary btn-xs action" href="'+link+'/proses_tender/'+value+'">',
    'Proses',
    '</a>  ',
  ].join('');
}


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

  var $table_pekerjaan_pr = $('#table_pekerjaan_pr'),
  $table_pekerjaan_rfq = $('#table_pekerjaan_rfq'),
  selections = [];

</script>

<script type="text/javascript">

  $(function () {

    $table_pekerjaan_pr.bootstrapTable({

      url: "<?php echo site_url('Procurement/data_pekerjaan_pr') ?>",
      cookieIdTable:"daftar_pekerjaan_pr",
      
      idField:"ppc_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'ppc_id',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'10%',
        valign: 'middle',
        formatter: operateFormatter,
      },
      {
        field: 'pr_number',
        title: 'No. PR',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'10%',
      },
      {
        field: 'pr_requester_name',
        title: 'User',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'20%',
      },
      {
        field: 'pr_subject_of_work',
        title: 'Nama Pekerjaan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'20%',
      },
      {
        field: 'jenis_pengadaan',
        title: 'Jenis Pengadaan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'5%',
      },
      {
        field: 'activity',
        title: 'Aktifitas',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'20%',
      },
       {
        field: 'waktu',
        title: 'Waktu',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'30%',
      },
      ]

    });
setTimeout(function () {
  $table_pekerjaan_pr.bootstrapTable('resetView');
}, 200);

$table_pekerjaan_pr.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_pr"));
});

});

</script>

<script type="text/javascript">

  $(function () {

    $table_pekerjaan_rfq.bootstrapTable({

      url: "<?php echo site_url('Procurement/data_pekerjaan_rfq') ?>",
      cookieIdTable:"daftar_pekerjaan_rfq",
      
      idField:"ptc_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'ptc_id',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'10%',
        valign: 'middle',
        formatter: operateFormatter2,
      },
      {
        field: 'ptm_number',
        title: 'No. Tender',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'10%',
      },
      {
        field: 'ptm_requester_name',
        title: 'User',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'20%',
      }, {
        field: 'ptm_subject_of_work',
        title: 'Nama Pekerjaan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'20%',
      },
      {
        field: 'jenis_pengadaan',
        title: 'Jenis Pengadaan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'5%',
      },
     {
        field: 'activity',
        title: 'Aktifitas',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'20%',
      },
      {
        field: 'waktu',
        title: 'Waktu',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'30%',
      },
      ]

    });
setTimeout(function () {
  $table_pekerjaan_rfq.bootstrapTable('resetView');
}, 200);

$table_pekerjaan_rfq.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_rfq"));
});

});

</script>