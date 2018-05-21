<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Template Evaluasi</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>
        <div class="ibox-content">

          <div class="table-responsive">

            <table id="table_template_evaluasi" class="table table-bordered table-striped"></table>

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
    var link = "<?php echo site_url('procurement/procurement_tools/') ?>";
    return [
    '<a class="btn btn-default btn-xs action" href="'+link+'/lihat_template_evaluasi/'+value+'">',
    'Lihat',
    '</a>  ',
    '<a class="btn btn-primary btn-xs action" href="'+link+'/ubah_template_evaluasi/'+value+'">',
    'Ubah',
    '</a>  ',
    '<a onclick="return confirm(\'Yakin Menghapus Data Ini?\')" class="btn btn-danger btn-xs action" href="'+link+'/hapus_template_evaluasi/'+value+'">',
    'Hapus',
    '</a>  ',
  ].join('');
}
window.operateEvents = {
  'click .approval': function (e, value, row, index) {
    //alert('You click approval action, row: ' + JSON.stringify(row));
  },
  /*
  'click .remove': function (e, value, row, index) {
    $table_template_evaluasi.bootstrapTable('remove', {
      field: 'id',
      values: [row.ptm_number]
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

  var $table_template_evaluasi = $('#table_template_evaluasi'),
  selections = [];

</script>

<script type="text/javascript">

  $(function () {

    $table_template_evaluasi.bootstrapTable({

      url: "<?php echo site_url('Procurement/data_template_evaluasi') ?>",
      cookieIdTable:"template_evaluasi",
      idField:"ptm_number",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'evt_id',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'20%',
        events: operateEvents,
        formatter: operateFormatter,
      },
      {
        field: 'evt_type',
        title: 'Tipe',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'20%',
      },
      {
        field: 'evt_name',
        title: 'Nama',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'25%',
      }, {
        field: 'evt_passing_grade',
        title: 'Passing Grade',
        sortable:true,
        order:true,
        searchable:true,
        align: 'right',
        valign: 'middle'
      },
      {
        field: 'evt_tech_weight',
        title: 'Bobot Teknis',
        sortable:true,
        order:true,
        searchable:true,
        align: 'right',
        valign: 'middle'
      },
     {
        field: 'evt_price_weight',
        title: 'Bobot Harga',
        sortable:true,
        order:true,
        searchable:true,
        align: 'right',
        valign: 'middle'
      },
      ]

    });
setTimeout(function () {
  $table_template_evaluasi.bootstrapTable('resetView');
}, 200);

$table_template_evaluasi.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_template_evaluasi"));
});

});

</script>