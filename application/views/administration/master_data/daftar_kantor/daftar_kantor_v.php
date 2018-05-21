<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Daftar Kantor</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>        

        <div class="ibox-content">

          <div class="table-responsive">
          <a class="btn btn-primary" href="<?php echo site_url('administration/master_data/daftar_kantor/add_daftar_kantor') ?>" role="button">Tambah</a>               

            <table id="daftar_kantor" class="table table-bordered table-striped"></table>

          </div>

        </div>
      </div>


    </div>
  </div>
</div>

<script type="text/javascript">

  function operateFormatter(value, row, index) {
    var link = "<?php echo site_url('administration/master_data/daftar_kantor') ?>";
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

  var $daftar_kantor = $('#daftar_kantor'),
  selections = [];

</script>

<script type="text/javascript">

  $(function () {

    $daftar_kantor.bootstrapTable({

      url: "<?php echo site_url('administration/data_daftar_kantor') ?>",
      cookieIdTable:"adm_district",
      idField:"district_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'district_id',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'10%',
        formatter: operateFormatter,
      },
      {
        field: 'district_code',
        title: 'Kode Kantor',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'district_prefix',
        title: 'Singkatan Kantor',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'district_name',
        title: 'Nama Kantor',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      ]

    });
setTimeout(function () {
  $daftar_kantor.bootstrapTable('resetView');
}, 200);

});

</script>