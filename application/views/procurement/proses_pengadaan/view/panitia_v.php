<?php /* if($hps['hps_total'] > 500*1000000 && !empty($prep['adm_bid_committee'])){ ?>
<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>PANITIA PENGADAAN</h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>

      <div class="ibox-content">

        <?php $curval = $prep['adm_bid_committee']; ?>
        <div class="form-group" id="panitia_pengadaan_cont">
          <label class="col-sm-2 control-label">Tim Panitia</label>
          <div class="col-sm-6">
              <input type="hidden" class="form-control" id="panitia_pengadaan_inp" name="panitia_pengadaan_inp" value="<?php echo $curval ?>">
              <?php $curval = $prep['adm_bid_committee_name']; ?>
              <input type="text" class="form-control" disabled id="panitia_pengadaan_label" value="<?php echo $curval ?>">
          </div>
        </div>

        <?php $curval = (isset($panitia['committee_doc'])) ? $panitia['committee_doc'] : ""; ?>
        <div class="form-group" id="panitia_pengadaan_doc">
          <label class="col-sm-2 control-label">Dokumen Panitia</label>
          <div class="col-sm-6">
          <p class="form-control-static"><a href="<?php echo INTRANET_UPLOAD_FOLDER."/procurement/panitia/$curval" ?>" target="_blank"><?php echo $curval ?></a></p>
          </div>
        </div>

        <div class="table-responsive">

          <table id="panitia_pengadaan_table" class="table table-bordered table-striped"></table>

        </div>

      </div>

    </div>
  </div>
</div>

<script type="text/javascript">

  $(document).ready(function(){

    function check_panitia_pengadaan(){
      var id = $("#panitia_pengadaan_inp").val();
      var url = "<?php echo site_url('Procurement/data_panitia_pengadaan') ?>";
      $.ajax({
        url : url+"?id="+id,
        dataType:"json",
        success:function(data){
          var mydata = data.rows[0];
          $("#panitia_pengadaan_label").val(mydata.committee_name);
          $("#panitia_pengadaan_table").bootstrapTable('refresh',{query:{id:mydata.id}});
        }
      });
    }

    $("#panitia_pengadaan_inp").on("change",function(){

      check_panitia_pengadaan();

    });
  });

</script>

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

    var mydata = $.getCustomJSON("<?php echo site_url('Procurement') ?>/"+url);

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

  var $panitia_pengadaan_table = $('#panitia_pengadaan_table'),
  selections = [];

</script>

<script type="text/javascript">

  $(function () {

    $panitia_pengadaan_table.bootstrapTable({

      url: "<?php echo site_url('Procurement/data_anggota_panitia_pengadaan') ?>",
      selectItemName:"vendor_tender[]",
      cookieIdTable:"vendor_tender",
      idField:"id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [

      {
        field: 'fullname',
        title: 'Nama',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      {
        field: 'committee_pos',
        title: 'Posisi',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      {
        field: 'name_abct',
        title: 'Jabatan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      
      ]

    });
setTimeout(function () {
  $panitia_pengadaan_table.bootstrapTable('resetView');
}, 200);

$panitia_pengadaan_table.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_vendor"));
});

$panitia_pengadaan_table.on('check.bs.table  check-all.bs.table', function () {

  selections = getIdSelections();
  var param = "";
  $.each(selections,function(i,val){
    param += val+"=1&";
  });
  $.ajax({
    url:"<?php echo site_url('Procurement/selection/selection_vendor_tender') ?>",
    data:param,
    type:"get"
  });

});
$panitia_pengadaan_table.on('uncheck.bs.table uncheck-all.bs.table', function () {

  selections = getIdSelections();

  var param = "";
  $.each(selections,function(i,val){
    param += val+"=0&";
  });
  $.ajax({
    url:"<?php echo site_url('Procurement/selection/selection_vendor_tender') ?>",
    data:param,
    type:"get"
  });
});
$panitia_pengadaan_table.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row));

});
$panitia_pengadaan_table.on('all.bs.table', function (e, name, args) {
  //console.log(name, args);
});

function getIdSelections() {
  return $.map($panitia_pengadaan_table.bootstrapTable('getSelections'), function (row) {
    return row.id
  });
}
function responseHandler(res) {
  $.each(res.rows, function (i, row) {
    row.state = $.inArray(row.id, selections) !== -1;
  });
  return res;
}

});

</script>

<?php } */ ?>