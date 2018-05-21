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

<script type="text/javascript">

  function kontrak_act(value, row, index) {
    var link = "<?php echo site_url('contract/daftar_pekerjaan') ?>";
    return [
    '<a class="btn btn-primary btn-xs action" href="'+link+'/proses_kontrak/'+value+'">',
    'Proses',
    '</a>  ',
    ].join('');
  }

  var $table_pekerjaan_kontrak = $('#table_pekerjaan_kontrak');
  var selections = [];

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
        formatter: kontrak_act,
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
        field: 'contract_type',
        title: 'Tipe',
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
      {
        field: 'waktu',
        title: 'Waktu',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
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