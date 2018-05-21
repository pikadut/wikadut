<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Panitia Pengadaan</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>        

        <div class="ibox-content">

          <div class="table-responsive">
          <a class="btn btn-primary" href="<?php echo site_url('procurement/procurement_tools/panitia_pengadaan/add_panitia_pengadaan') ?>" role="button">Tambah</a>               

            <table id="panitia_pengadaan" class="table table-bordered table-striped"></table>

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

    var mydata = $.getCustomJSON("<?php echo site_url('procurement') ?>/"+url);

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
    var link = "<?php echo site_url('procurement/procurement_tools/panitia_pengadaan') ?>";
    return [
    '<a class="btn btn-primary btn-xs action" href="'+link+'/ubah/'+value+'">',
    'Ubah',
    '</a>  ',
    '<a class="btn btn-danger btn-xs action" onclick="return confirm(\'Anda yakin ingin menghapus data?\')" href="'+link+'/hapus/'+value+'">',
    'Hapus',
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

  var $panitia_pengadaan = $('#panitia_pengadaan'),
  selections = [];

</script>

<script type="text/javascript">

  $(function () {

    $panitia_pengadaan.bootstrapTable({

      url: "<?php echo site_url('procurement/data_panitia_pengadaan') ?>",
      cookieIdTable:"adm_committee",
      idField:"id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'id',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'10%',
        formatter: operateFormatter,
      },
      {
        field: 'committee_name',
        title: 'Nama Panitia',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      ]

    });
setTimeout(function () {
  $panitia_pengadaan.bootstrapTable('resetView');
}, 200);

$panitia_pengadaan.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_panitia_pengadaan"));
});

});

</script>