<div class="wrapper wrapper-content animated fadeInRight">

  <div class="row">

    <div class="col-lg-12">

      <div class="ibox float-e-margins">

        <div class="ibox-title">

        <h5>Daftar BAST Milestone</h5>

          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>
          </div>

        </div>

        <div class="ibox-content">

          <div class="table-responsive">

            <table id="table_monitor_bast_milestone" class="table table-bordered table-striped"></table>

          </div>

        </div>

      </div>

      <div class="ibox float-e-margins">

        <div class="ibox-title">

        <h5>Daftar BAST WO</h5>

          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>
          </div>

        </div>

        <div class="ibox-content">

          <div class="table-responsive">

            <table id="table_monitor_bast_wo" class="table table-bordered table-striped"></table>

          </div>

        </div>

      </div>

    </div>

  </div>

</div>

<script type="text/javascript">

  function wo_monitor_bast(value, row, index) {
    var link = "<?php echo site_url('contract') ?>";
    return [
    '<a class="btn btn-primary btn-xs action" href="'+link+'/lihat_bast_wo/'+value+'">',
    'Lihat',
    '</a>  ',
    ].join('');
  }

  var $table_monitor_bast_wo = $('#table_monitor_bast_wo');
  var selections = [];

  $(function () {

    $table_monitor_bast_wo.bootstrapTable({

      url: "<?php echo site_url('contract/data_monitor_bast_wo') ?>",
      cookieIdTable:"monitor_bast_wo",
      idField:"po_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: "po_id",
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'8%',
        valign: 'middle',
        formatter: wo_monitor_bast,
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
        field: 'po_notes',
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
      $table_monitor_bast_wo.bootstrapTable('resetView');
    }, 200);

  });

</script>

<script type="text/javascript">

  function milestone_monitor_bast(value, row, index) {
    var link = "<?php echo site_url('contract') ?>";
    return [
    '<a class="btn btn-primary btn-xs action" href="'+link+'/lihat_bast_milestone/'+value+'">',
    'Lihat',
    '</a>  ',
    ].join('');
  }

  var $table_monitor_bast_milestone = $('#table_monitor_bast_milestone');
  var selections = [];

  $(function () {

    $table_monitor_bast_milestone.bootstrapTable({

      url: "<?php echo site_url('contract/data_monitor_bast_milestone') ?>",
      cookieIdTable:"monitor_bast_milestone",
      idField:"milestone_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: "milestone_id",
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'8%',
        valign: 'middle',
        formatter: milestone_monitor_bast,
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
        title: 'Persentase',
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
      $table_monitor_bast_milestone.bootstrapTable('resetView');
    }, 200);

  });

</script>