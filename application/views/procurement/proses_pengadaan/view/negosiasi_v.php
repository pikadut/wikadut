<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>HISTORI NEGOSIASI</h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>

      <div class="ibox-content">

        <table id="negosiasi_table" class="table table-bordered table-striped"></table>

      </div>

    </div>
  </div>
</div>


<script type="text/javascript">

  var $negosiasi_table = $('#negosiasi_table'),
  selections = [];

</script>

<script type="text/javascript">

  $(function () {

    $negosiasi_table.bootstrapTable({

      url: "<?php echo site_url('Procurement/data_message/1140') ?>",
      cookieIdTable:"sanggahan",
      idField:"pbm_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      sortOrder:"desc",
      sortName:"pbm_date_format",
      columns: [
      {
        field: 'pbm_date_format',
        title: 'Tanggal / Jam',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'pbm_user',
        title: 'Dari',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },

      {
        field: 'vendor_name',
        title: 'Vendor',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
            
      {
        field: 'pbm_message',
        title: 'Komentar',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },

      ]

    });

setTimeout(function () {
  $negosiasi_table.bootstrapTable('resetView');
}, 200);

});

</script>