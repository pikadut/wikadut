
<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>Daftar Vendor yang Hadir Tahap 2</h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>

        </div>
      </div>
      <div class="ibox-content">
       
       <div class="table-responsive">

        <table id="daftar_vendor_absen" class="table table-bordered table-striped"></table>

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

  function detailFormatter(index, row, url) {

    var mydata = $.getCustomJSON("<?php echo site_url('procurement') ?>/"+url);

    var html = [];
    $.each(row, function (key, value) {
     var data = $.grep(mydata, function(e){ 
       return e.field == key; 
     });

     if(typeof data[0] !== 'undefined'){

       html.push('<p><b>' + data[0].alias + ':</b> ' + value + '</p>');
     }
   });

    return html.join('');

  }

</script>

<script type="text/javascript">

  var $daftar_vendor_absen = $('#daftar_vendor_absen'),
  selections = [];

</script>

<?php 
$list_vnd = $this->session->userdata("selection_vendor_tender");
foreach ($vendor_status as $key => $value) { 
$val = (in_array($value['pvs_vendor_code'], $list_vnd)) ? 1 : 0;
  ?>
  <input type="hidden" class="vendor_hadir_2" name="vendor_hadir_2[<?php echo $value['pvs_vendor_code'] ?>]" data-id="<?php echo $value['pvs_vendor_code'] ?>" value="<?php echo $val ?>">
<?php } ?>

<script type="text/javascript">

  $(function () {

    $daftar_vendor_absen.bootstrapTable({

      url: "<?php echo site_url('procurement/data_vendor_tender/selected_tahap2') ?>",
      
      selectItemName:"vendor_attend_tender[]",
      
      cookieIdTable:"vendor_tender",
      
      idField:"vendor_id",

      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>

           pageSize:100,
      pageList:[100],

      columns: [
      {
        field: 'checkbox',
        title:'Hadir?',
        checkbox:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'vendor_name',
        title: 'Nama Vendor',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      {
        field: 'fin_class',
        title: 'Klasifikasi Vendor',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      
      ]

    });
    setTimeout(function () {
      $daftar_vendor_absen.bootstrapTable('resetView');
    }, 200);

    $daftar_vendor_absen.on('expand-row.bs.table', function (e, index, row, $detail) {
      $detail.html(detailFormatter(index,row,"alias_vendor"));
    });

    $daftar_vendor_absen.on('check.bs.table  check-all.bs.table', function () {

      selections = getIdSelections();
      var param = "";
      $(".vendor_hadir_2").val(0);

      $.each(selections,function(i,val){
        param += val+"=1&";
        $(".vendor_hadir_2[data-id='"+val+"']").val(1);
      });

      $.ajax({
        url:"<?php echo site_url('procurement/selection/selection_vendor_tender_hadir_2') ?>",
        data:param,
        type:"get"
      });

    });
    $daftar_vendor_absen.on('uncheck.bs.table uncheck-all.bs.table', function () {

      selections = getIdSelections();

      var param = "";
      $(".vendor_hadir_2").val(0);

      $.each(selections,function(i,val){
        param += val+"=1&";
        $(".vendor_hadir_2[data-id='"+val+"']").val(1);
      });

      $.ajax({
        url:"<?php echo site_url('procurement/selection/selection_vendor_tender_hadir_2') ?>",
        data:param,
        type:"get"
      });

    });
    $daftar_vendor_absen.on('expand-row.bs.table', function (e, index, row, $detail) {
      $detail.html(detailFormatter(index,row));

    });
    $daftar_vendor_absen.on('all.bs.table', function (e, name, args) {
  //console.log(name, args);
});

    function getIdSelections() {
      return $.map($daftar_vendor_absen.bootstrapTable('getSelections'), function (row) {
        return row.vendor_id
      });
    }
    function responseHandler(res) {
      $.each(res.rows, function (i, row) {
        row.state = $.inArray(row.vendor_id, selections) !== -1;
      });
      return res;
    }

  });

</script>