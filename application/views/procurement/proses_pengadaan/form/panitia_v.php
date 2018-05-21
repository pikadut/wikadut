<?php /* if($prep['ptp_prequalify'] == 2){ 
  include(VIEWPATH."procurement/proses_pengadaan/view/panitia_v.php");
 } else { 
  if($hps['hps_total'] > 500*1000000){ ?>
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
            <div class="input-group"> 
              <span class="input-group-btn">
                <button type="button" data-id="panitia_pengadaan_inp" data-url="<?php echo site_url(PROCUREMENT_PANITIA_PENGADAAN_PATH.'/picker') ?>" class="btn btn-primary picker"><i class="fa fa-search"></i></button> 
              </span>
              <input type="hidden" class="form-control" id="panitia_pengadaan_inp" name="panitia_pengadaan_inp" value="<?php echo $curval ?>">
              <?php $curval = $prep['adm_bid_committee_name']; ?>
              <input type="text" class="form-control" readonly id="panitia_pengadaan_label" value="<?php echo $curval ?>">
              <span class="input-group-btn">
                <button type="button" id="hapus_panitia_inp" class="btn btn-danger"><i class="fa fa-remove"></i></button> 
              </span>

            </div>
          </div>
        </div>

        <?php $curval = (isset($panitia['committee_doc'])) ? $panitia['committee_doc'] : ""; ?>
        <div class="form-group" id="panitia_pengadaan_doc">
          <label class="col-sm-2 control-label">Dokumen Panitia</label>
          <div class="col-sm-6">
            <p class="form-control-static"><a href="<?php echo INTRANET_UPLOAD_FOLDER."/$dir/$curval" ?>" target="_blank"><?php echo $curval ?></a></p>
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

    $("#hapus_panitia_inp").click(function(){
      $("#panitia_pengadaan_inp").val("");
      $("#panitia_pengadaan_label").val("");
      $.ajax({
        url:"<?php echo site_url('log/set_session/committee_id/') ?>",
        success:function(){
           $panitia_pengadaan_table.bootstrapTable('refresh');
        }
      })
     
    });

    function check_panitia_pengadaan(){
      var id = $("#panitia_pengadaan_inp").val();
      if(id != ""){
        var url = "<?php echo site_url('Procurement/data_panitia_pengadaan') ?>";
        $.ajax({
          url : url+"?id="+id,
          dataType:"json",
          success:function(data){
            var mydata = data.rows[0];
            $("#panitia_pengadaan_label").val(mydata.committee_name);
            $("#panitia_pengadaan_doc a").attr("href","<?php echo INTRANET_UPLOAD_FOLDER.'/procurement/panitia' ?>/"+mydata.committee_doc).text(mydata.committee_doc);
            $("#panitia_pengadaan_table").bootstrapTable('refresh',{query:{id:mydata.id}});
          }
        });
      }
    }

    check_panitia_pengadaan();

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

      url: "<?php echo site_url('Procurement/data_anggota_panitia_pengadaan/view') ?>",
      selectItemName:"panitia_pengadaan[]",
      cookieIdTable:"panitia_pengadaan",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      idField:"id",
      
      showColumns:true,
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
        url:"<?php echo site_url('Procurement/selection/selection_panitia_pengadaan') ?>",
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
        url:"<?php echo site_url('Procurement/selection/selection_panitia_pengadaan') ?>",
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

<?php } ?>
<?php } */ ?>