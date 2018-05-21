<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">

      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Daftar Pekerjaan Kontrak</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="ibox-content">

          <div class="table-responsive">

            <table id="table_pekerjaan_kontrak" class="table table-bordered table-striped"></table>

          </div>

        </div>
      </div>

      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Daftar Pekerjaan Adendum</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="ibox-content">

          <div class="table-responsive">

            <table id="table_pekerjaan_adendum" class="table table-bordered table-striped"></table>

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
    var link = "<?php echo site_url('contract/daftar_pekerjaan') ?>";
    return [
    '<a class="btn btn-primary btn-xs action" href="'+link+'/proses_kontrak/'+value+'">',
    'Proses',
    '</a>  ',
  ].join('');
}

 function operateFormatter2(value, row, index) {
    var link = "<?php echo site_url('addendum/daftar_pekerjaan') ?>";
    return [
    '<a class="btn btn-primary btn-xs action" href="'+link+'/proses_adendum/'+value+'">',
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

  var $table_pekerjaan_kontrak = $('#table_pekerjaan_kontrak'),
  $table_pekerjaan_adendum = $('#table_pekerjaan_adendum'),
  selections = [];

</script>

<script type="text/javascript">

  $(function () {

    $table_pekerjaan_kontrak.bootstrapTable({

      url: "<?php echo site_url('contract/data_pekerjaan_kontrak') ?>",
      cookieIdTable:"daftar_pekerjaan_kontrak",
      idField:"ccc_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: "ccc_id",
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'8%',
        valign: 'middle',
        formatter: operateFormatter,
      },
      {
        field: 'ptm_number',
        title: 'Nomor Pengadaan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'14%',
      },
      {
        field: 'contract_number',
        title: 'Nomor Kontrak',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'14%',
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
        field: 'activity',
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
  $table_pekerjaan_kontrak.bootstrapTable('resetView');
}, 200);

$table_pekerjaan_kontrak.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_kontrak"));
});

});

</script>

<script type="text/javascript">

  $(function () {

    $table_pekerjaan_adendum.bootstrapTable({

      url: "<?php echo site_url('contract/data_pekerjaan_adendum') ?>",
      cookieIdTable:"daftar_pekerjaan_adendum",
      idField:"cac_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'cac_id',
        title: '#',
        align: 'center',
        width:'8%',
        valign: 'middle',
        formatter: operateFormatter2,
      },
      {
        field: 'contract_number',
        title: 'Nomor Kontrak',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'14%',
      },
      {
        field: 'subject_work',
        title: 'Deskripsi Pekerjaan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      }, {
        field: 'vendor_name',
        title: 'Vendor',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'30%',
      },
      {
        field: 'activity',
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
  $table_pekerjaan_adendum.bootstrapTable('resetView');
}, 200);

$table_pekerjaan_adendum.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_adendum"));
});

});

</script>