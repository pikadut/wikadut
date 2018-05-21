<div class="wrapper wrapper-content animated fadeInRight">

  <div class="row">

    <div class="col-lg-12">

      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Daftar Item Progress WO</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>

        </div>

        <div class="ibox-content">

          <div class="table-responsive">

            <table id="daftar_item_prog" class="table table-bordered table-striped"></table>

          </div>

        </div>

      </div>

    </div>

  </div>

</div>

<script type="text/javascript">

  var $daftar_item_prog = $('#daftar_item_prog'),
  selections = [];

  $(function () {

    $daftar_item_prog.bootstrapTable({

      url: "<?php echo site_url('contract/data_progress_wo') ?>",
      cookieIdTable:"daftar_item_prog",
      
      idField:"id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
      {
        field: 'radio',
        radio:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'kode',
        title: 'Kode Barang',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
      },
      {
        field: 'deskripsi',
        title: 'Deskripsi',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
      },
      {
        field: 'satuan',
        title: 'Satuan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
      },
      {
        field: 'harga_satuan',
        title: 'Harga Satuan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'right',
        valign: 'middle',
      },
      {
        field: 'jumlah',
        title: 'Jumlah',
        sortable:true,
        order:true,
        searchable:true,
        align: 'right',
        valign: 'middle',
      },
      ]
    });
    setTimeout(function () {
      $daftar_item_prog.bootstrapTable('resetView');
    }, 200);

    $daftar_item_prog.on('expand-row.bs.table', function (e, index, row, $detail) {
      $detail.html(detailFormatter(index,row,"alias"));
    });

    $daftar_item_prog.on('check.bs.table  check-all.bs.table', function () {

      selections = getIdSelections();

      var param = "";

      $.each(selections,function(i,val){
        param += val+"=1&";
      });
      $.ajax({
        url:"<?php echo site_url('contract/picker') ?>",
        data:param,
        type:"get"
      });

    });
    $daftar_item_prog.on('uncheck.bs.table uncheck-all.bs.table', function () {

      selections = getIdSelections();

      var param = "";

      $.each(selections,function(i,val){
        param += val+"=0&";
      });
      $.ajax({
        url:"<?php echo site_url('contract/picker') ?>",
        data:param,
        type:"get"
      });

    });

    $daftar_item_prog.on('expand-row.bs.table', function (e, index, row, $detail) {
      $detail.html(detailFormatter(index,row));
    });

    $daftar_item_prog.on('all.bs.table', function (e, name, args) {

    });

  });

  function getIdSelections() {
    return $.map($daftar_item_prog.bootstrapTable('getSelections'), function (row) {
      return row.id;
    });
  }

</script>