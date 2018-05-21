<div class="ibox float-e-margins">

  <div class="ibox-title">

    <h5>Daftar Pekerjaan Invoice Milestone</h5>

    <div class="ibox-tools">
      <a class="collapse-link">
        <i class="fa fa-chevron-up"></i>
      </a>
    </div>

  </div>

  <div class="ibox-content">

    <div class="table-responsive">

      <table id="table_invoice_milestone" class="table table-bordered table-striped"></table>

    </div>

  </div>
  
</div>

<script type="text/javascript">

  function milestone_act_invoice(value, row, index) {
    var link = "<?php echo site_url('contract') ?>";
    return [
    '<a class="btn btn-primary btn-xs action" href="'+link+'/proses_invoice_milestone/'+value+'">',
    'Proses',
    '</a>  ',
    ].join('');
  }

  var $table_invoice_milestone = $('#table_invoice_milestone');
  var selections = [];

  $(function () {

    $table_invoice_milestone.bootstrapTable({

      url: "<?php echo site_url('contract/data_invoice_milestone') ?>",
      cookieIdTable:"daftar_invoice_wo",
      idField:"po_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: "milestone_id",
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'8%',
        valign: 'middle',
        formatter: milestone_act_invoice,
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
        field: 'invoice_number',
        title: 'No. Invoice',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'14%',
      },

       {
        field: 'created_date',
        title: 'Tanggal Dibuat',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'14%',
      },
       {
        field: 'invoice_date',
        title: 'Tanggal Tagihan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'14%',
      },
      
      {
        field: 'invoice_notes',
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
      $table_invoice_milestone.bootstrapTable('resetView');
    }, 200);

  });

</script>