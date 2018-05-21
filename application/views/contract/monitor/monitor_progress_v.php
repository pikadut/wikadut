<div class="wrapper wrapper-content animated fadeInRight">

  <div class="row">

    <div class="col-lg-12">

      <div class="ibox float-e-margins">

        <div class="ibox-title">

          <h5>Daftar Progress Milestone</h5>

          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>
          </div>

        </div>

        <div class="ibox-content">

          <div class="table-responsive">

            <table id="table_monitor_progress_milestone" class="table table-bordered table-striped"></table>

          </div>

        </div>

      </div>

      <div class="ibox float-e-margins">

        <div class="ibox-title">

          <h5>Daftar Progress WO</h5>

          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>
          </div>

        </div>

        <div class="ibox-content">

          <div class="table-responsive">

            <table id="table_monitor_progress_wo" class="table table-bordered table-striped"></table>

          </div>

        </div>

      </div>

    </div>
  </div>
</div>


<script type="text/javascript">

  function wo_monitor_progress(value, row, index) {
    var link = "<?php echo site_url('contract') ?>";
    return [
    '<a class="btn btn-primary btn-xs action" href="'+link+'/lihat_progress_wo/'+value+'">',
    'Lihat',
    '</a>  ',
    ].join('');
  }

  var $table_monitor_progress_wo = $('#table_monitor_progress_wo');
  var selections = [];

  $(function () {

    $table_monitor_progress_wo.bootstrapTable({

      url: "<?php echo site_url('contract/data_monitor_progress_wo/'.$act.'/'.$type) ?>",
      cookieIdTable:"monitor_progress_wo",
      idField:"progress_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [

       <?php if(!empty($act)){ ?>
       {
        field: 'radio',
        radio:true,
        align: 'center',
        valign: 'middle'
      },
      <?php } else { ?>
        {
        field: "progress_id",
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'8%',
        valign: 'middle',
        formatter: wo_monitor_progress,
      },
        <?php } ?>
      {
        field: 'po_number',
        title: 'Nomor WO',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'14%',
      },
      
      {
        field: 'progress_description',
        title: 'Deskripsi Pekerjaan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'30%',
      },
      {
        field: 'creator_name',
        title: 'Vendor',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',

      },
      {
        field: 'progress_percentage',
        title: 'Persentase Progress',
        sortable:true,
        order:true,
        searchable:true,
        align: 'right',
        valign: 'middle',

      },
      {
        field: 'bastp_number',
        title: 'BAST',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',

      },
       {
        field: 'pos_name',
        title: 'Approval',
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
      $table_monitor_progress_wo.bootstrapTable('resetView');
    }, 200);


     $table_monitor_progress_wo.on('check.bs.table  check-all.bs.table', function () {

      selections = getIdSelections();
      var param = "";
      $.each(selections,function(i,val){
        param += "wo_"+val+"=1&";
      });
      $.ajax({
        url:"<?php echo site_url('contract/picker') ?>",
        data:param,
        type:"get"
      });

    });
    $table_monitor_progress_wo.on('uncheck.bs.table uncheck-all.bs.table', function () {

      selections = getIdSelections();

      var param = "";
      $.each(selections,function(i,val){
        param += "wo_"+val+"=0&";
      });
      $.ajax({
        url:"<?php echo site_url('contract/picker') ?>",
        data:param,
        type:"get"
      });
    });

    $table_monitor_progress_wo.on('expand-row.bs.table', function (e, index, row, $detail) {
      $detail.html(detailFormatter(index,row));
    });

    function getIdSelections() {
      return $.map($table_monitor_progress_wo.bootstrapTable('getSelections'), function (row) {
        return row.progress_id;
      });
    }

  });

</script>


<script type="text/javascript">

  function milestone_monitor_progress(value, row, index) {
    var link = "<?php echo site_url('contract') ?>";
    return [
    '<a class="btn btn-primary btn-xs action" href="'+link+'/lihat_progress_milestone/'+value+'">',
    'Lihat',
    '</a>  ',
    ].join('');
  }

  var $table_monitor_progress_milestone = $('#table_monitor_progress_milestone');
  var selections = [];

  $(function () {

    $table_monitor_progress_milestone.bootstrapTable({

      url: "<?php echo site_url('contract/data_monitor_progress_milestone/'.$act.'/'.$type) ?>",
      cookieIdTable:"monitor_progress_milestone",
      idField:"progress_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [

      <?php if(!empty($act)){ ?>
       {
        field: 'radio',
        radio:true,
        align: 'center',
        valign: 'middle'
      },
      <?php } else { ?>
         {
        field: "progress_id",
        title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
        align: 'center',
        width:'8%',
        valign: 'middle',
        formatter: milestone_monitor_progress,
      },
        <?php } ?>
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
        align: 'left',
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
        field: 'bastp_number',
        title: 'BAST',
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
      $table_monitor_progress_milestone.bootstrapTable('resetView');
    }, 200);

     $table_monitor_progress_milestone.on('check.bs.table  check-all.bs.table', function () {

      selections = getIdSelections();
      var param = "";
      $.each(selections,function(i,val){
        param += "milestone_"+val+"=1&";
      });
      $.ajax({
        url:"<?php echo site_url('contract/picker') ?>",
        data:param,
        type:"get"
      });

    });
    $table_monitor_progress_milestone.on('uncheck.bs.table uncheck-all.bs.table', function () {

      selections = getIdSelections();

      var param = "";
      $.each(selections,function(i,val){
        param += "milestone_"+val+"=0&";
      });
      $.ajax({
        url:"<?php echo site_url('contract/picker') ?>",
        data:param,
        type:"get"
      });
    });
    $table_monitor_progress_milestone.on('expand-row.bs.table', function (e, index, row, $detail) {
      $detail.html(detailFormatter(index,row));

    });

    function getIdSelections() {
      return $.map($table_monitor_progress_milestone.bootstrapTable('getSelections'), function (row) {
        return row.progress_id;
      });
    }

  });

</script>
