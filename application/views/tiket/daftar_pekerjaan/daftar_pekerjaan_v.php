<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">

      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Daftar Pekerjaan Permintaan Tiket</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="ibox-content">

          <div class="table-responsive">

            <table id="table_pekerjaan_pt" class="table table-bordered table-striped"></table>

          </div>

        </div>
      </div>

      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Daftar Pekerjaan Pengiriman Tiket</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="ibox-content">

          <div class="table-responsive">

            <table id="table_pekerjaan_dt" class="table table-bordered table-striped"></table>

          </div>

        </div>
      </div>

  
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Daftar Pekerjaan Penerimaan Tiket</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="ibox-content">

          <div class="table-responsive">

            <table id="table_pekerjaan_rt" class="table table-bordered table-striped"></table>

          </div>

        </div>
      </div>

      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Daftar Pekerjaan Penjualan Tiket</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="ibox-content">

          <div class="table-responsive">

            <table id="table_pekerjaan_st" class="table table-bordered table-striped"></table>

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

    var mydata = $.getCustomJSON("<?php echo site_url('tiket') ?>/"+url);

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

  function operateFormatter(value, row, index) {var link = "<?php echo site_url('tiket/permintaan_tiket') ?>";
    var approve = "";
    var edit = "";
    <?php if($approve){ ?>
      var approve ='<a class="btn btn-primary btn-xs action" href="'+link+'/rekapitulasi_permintaan_tiket/approval/'+value+'">Proses</a>';
    <?php } ?>
    <?php if($edit){ ?>
      var edit ='<a class="btn btn-primary btn-xs action" href="'+link+'/update_daftar_permintaan_tiket/ubah/'+value+'">Ubah</a>';
    <?php } ?>
    return [approve,edit].join('');
}


  function operateFormatter2(value, row, index) {
    var link = "<?php echo site_url('tiket/permintaan_tiket/daftar_pengiriman_tiket') ?>";
    return [
    '<a class="btn btn-primary btn-xs action" href="'+link+'/entry/'+value+'">',
    'Proses',
    '</a>  ',
  ].join('');
}

 function operateFormatter3(value, row, index) {
    var link = "<?php echo site_url('tiket/permintaan_tiket/daftar_penerimaan_tiket') ?>";
    return [
    '<a class="btn btn-primary btn-xs action" href="'+link+'/entry/'+value+'">',
    'Proses',
    '</a>  ',
  ].join('');
}

 function operateFormatter4(value, row, index) {
    var link = "<?php echo site_url('tiket/daftar_pekerjaan') ?>";
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

  var $table_pekerjaan_pt = $('#table_pekerjaan_pt'),
  $table_pekerjaan_dt = $('#table_pekerjaan_dt'),
  $table_pekerjaan_rt= $('#table_pekerjaan_rt'),
  $table_pekerjaan_st = $('#table_pekerjaan_st'),
  selections = [];

</script>

<script type="text/javascript">

  $(function () {

    $table_pekerjaan_pt.bootstrapTable({

      url: "<?php echo site_url('tiket/data_pekerjaan_pt') ?>",
      cookieIdTable:"daftar_pekerjaan_pt",
      
      idField:"tpm_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'tpm_id',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'10%',
        valign: 'middle',
        formatter: operateFormatter,
      },
      {
        field: 'tpm_number',
        title: 'No. Permintaan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'15%',
      },
      {
        field: 'tpm_planner',
        title: 'User',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'15%',
      },
      {
        field: 'tpm_district_name',
        title: 'Cabang',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'20%',
      },
      {
        field: 'tpm_status_name',
        title: 'Status',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'20%',
      }
      ]

    });
setTimeout(function () {
  $table_pekerjaan_pt.bootstrapTable('resetView');
}, 200);

$table_pekerjaan_pt.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_pt"));
});

});

</script>


<script type="text/javascript">

  $(function () {

    $table_pekerjaan_dt.bootstrapTable({

      url: "<?php echo site_url('tiket/data_pekerjaan_dt') ?>",
      cookieIdTable:"daftar_pekerjaan_dt",
      
      idField:"tpm_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'tpm_id',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'10%',
        valign: 'middle',
        formatter: operateFormatter2,
      },
      {
        field: 'tpm_number',
        title: 'No. Permintaan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'15%',
      },
      {
        field: 'tpm_planner',
        title: 'User',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'15%',
      },
      {
        field: 'tpm_district_name',
        title: 'Cabang',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'20%',
      },
      {
        field: 'tpm_status_name',
        title: 'Status',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'20%',
      }
      ]

    });
setTimeout(function () {
  $table_pekerjaan_dt.bootstrapTable('resetView');
}, 200);

$table_pekerjaan_dt.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_dt"));
});

});

</script>

<script type="text/javascript">

  $(function () {

    $table_pekerjaan_rt.bootstrapTable({

      url: "<?php echo site_url('tiket/data_pekerjaan_rt') ?>",
      cookieIdTable:"daftar_pekerjaan_rt",
      
      idField:"tpm_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'tpm_id',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'10%',
        valign: 'middle',
        formatter: operateFormatter3,
      },
      {
        field: 'tpm_number',
        title: 'No. Permintaan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'15%',
      },
      {
        field: 'tpm_planner',
        title: 'User',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'15%',
      }, 
      {
        field: 'tpm_district_name',
        title: 'Cabang',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'20%',
      },
      {
        field: 'tpm_status_name',
        title: 'Status',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'20%',
      }
      ]

    });
setTimeout(function () {
  $table_pekerjaan_rt.bootstrapTable('resetView');
}, 200);

$table_pekerjaan_rt.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_rt"));
});

});

</script>


<script type="text/javascript">

  $(function () {

    $table_pekerjaan_st.bootstrapTable({

      url: "<?php echo site_url('tiket/data_pekerjaan_st') ?>",
      cookieIdTable:"daftar_pekerjaan_st",
      
      idField:"tsm_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'tsm_id',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'10%',
        valign: 'middle',
        formatter: operateFormatter2,
      },
      {
        field: 'tsm_month',
        title: 'Bulan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'15%',
      },
      {
        field: 'tsm_year',
        title: 'Tahun',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'15%',
      }, 
      {
        field: 'trm_district_name',
        title: 'Cabang',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'20%',
      },
      {
        field: 'tsm_status_name',
        title: 'Status',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'20%',
      }
      ]

    });
setTimeout(function () {
  $table_pekerjaan_st.bootstrapTable('resetView');
}, 200);

$table_pekerjaan_st.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_st"));
});

});

</script>