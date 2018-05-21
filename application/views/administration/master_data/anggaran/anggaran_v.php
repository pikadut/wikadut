<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Anggaran</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>        

        <div class="ibox-content">

          <div class="table-responsive">
          <a class="btn btn-primary" href="<?php echo site_url('administration/master_data/anggaran/tambah') ?>" role="button">Tambah</a>               

            <table id="anggaran" class="table table-bordered table-striped"></table>

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
    var link = "<?php echo site_url('administration/master_data/anggaran') ?>";
    return [
    '<a class="btn btn-primary btn-xs action" href="'+link+'/ubah/'+value+'">',
    'Ubah',
    '</a>  ',
    '<a class="btn btn-danger btn-xs action" onclick="return confirm(\'Anda yakin ingin menghapus data?\')" href="'+link+'/hapus/'+value+'">',
    'Hapus',
    '</a>  ',
    ].join('');
  }

</script>

<script type="text/javascript">

  var $anggaran = $('#anggaran'),
  selections = [];

</script>

<script type="text/javascript">

  $(function () {

    $anggaran.bootstrapTable({

      url: "<?php echo site_url('administration/data_anggaran') ?>",
      cookieIdTable:"anggaran",
      idField:"id_cc",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'id_cc',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'15%',
        formatter: operateFormatter,
      },
      {
        field: 'name_cc',
        title: 'Nama Anggaran',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      {
        field: 'subcode_cc',
        title: 'Kode Sub Anggaran',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'subname_cc',
        title: 'Nama Sub Anggaran',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      /*
      {
        field: 'year_cc',
        title: 'Tahun Anggaran',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'dept_name',
        title: 'Departemen',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      */
      ]
});
setTimeout(function () {
  $anggaran.bootstrapTable('resetView');
}, 200);


});

</script>