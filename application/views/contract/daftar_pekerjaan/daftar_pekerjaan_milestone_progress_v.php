<div class="ibox float-e-margins">

  <div class="ibox-title">

    <h5>Daftar Pekerjaan Progress Milestone</h5>

    <div class="ibox-tools">
      <a class="collapse-link">
        <i class="fa fa-chevron-up"></i>
      </a>
    </div>

  </div>

  <div class="ibox-content">

    <div class="table-responsive">

      <table id="table_progress_milestone" class="table table-bordered table-striped"></table>

    </div>

  </div>
  
</div>

<script type="text/javascript">

  function milestone_act_progress(value, row, index) {
    var link = "<?php echo site_url('contract') ?>";
    return [
    '<a class="btn btn-primary btn-xs action" href="'+link+'/proses_progress_milestone/'+value+'">',
    'Proses',
    '</a>  ',
    ].join('');
  }

  var $table_progress_milestone = $('#table_progress_milestone');
  var selections = [];

  $(function () {

    $table_progress_milestone.bootstrapTable({

      url: "<?php echo site_url('contract/data_progress_milestone') ?>",
      cookieIdTable:"daftar_progress_milestone",
      idField:"progress_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: "progress_id",
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'8%',
        valign: 'middle',
        formatter: milestone_act_progress,
      },
      {
        field: 'contract_number',
        title: 'No. Kontrak',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'14%',
      },
      
      {
        field: 'description',
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
        field: 'percentage',
        title: 'Persentase Progress',
        sortable:true,
        order:true,
        searchable:true,
        align: 'right',
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
      $table_progress_milestone.bootstrapTable('resetView');
    }, 200);

    $table_progress_milestone.on('expand-row.bs.table', function (e, index, row, $detail) {
      $detail.html(detailFormatter(index,row,"alias_progress"));
    });

  });

</script>