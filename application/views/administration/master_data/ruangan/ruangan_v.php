<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Ruangan</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>        

        <div class="ibox-content">

          <div class="table-responsive">
            <a class="btn btn-primary" href="<?php echo site_url('administration/master_data/ruangan/tambah') ?>" role="button">Tambah</a>               

            <table id="ruangan" class="table table-bordered table-striped"></table>

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
    var link = "<?php echo site_url('administration/master_data/ruangan') ?>";
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

  var $ruangan = $('#ruangan'),
  selections = [];

</script>

<script type="text/javascript">

  $(function () {

    $ruangan.bootstrapTable({

      url: "<?php echo site_url('administration/data_ruangan') ?>",
      cookieIdTable:"ruangan",
      idField:"id_room",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'id_room',
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'15%',
        formatter: operateFormatter,
      },
          {
        field: 'name_room',
        title: 'Nama',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'desc_room',
        title: 'Keterangan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      ]
    });
    setTimeout(function () {
      $ruangan.bootstrapTable('resetView');
    }, 200);


  });

</script>