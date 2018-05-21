<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Performa Vendor</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>

          </div>
        </div>

        <div class="ibox-content">

          <form method="get" class="form-horizontal">

           <div class="form-group">
            <label class="col-sm-2 control-label">Item</label>
            <div class="col-sm-6">
              <div class="input-group">
                <span class="input-group-btn">
                 <button type="button" data-id="kode_item" data-url="<?php echo site_url(COMMODITY_KATALOG_BARANG_PATH.'/picker') ?>" class="btn btn-primary picker barang_btn">Barang</button> 
                 <button type="button" data-id="kode_item" data-url="<?php echo site_url(COMMODITY_KATALOG_JASA_PATH.'/picker') ?>" class="btn btn-primary picker jasa_btn">Jasa</button> 
               </span>
               <?php $curval = $this->session->userdata("item_gbl"); ?>
               <input type="text" class="form-control" id="kode_item" name="kode_item" value="<?php echo $curval ?>">

             </div>

           </div>

         </div>

         <div class="form-group">
           <?php $curval = $this->session->userdata("kantor_gbl"); ?>
           <label class="col-md-2 control-label">Kantor</label>
           <div class="col-md-4">
             <select name="kantor" id="kantor" class="form-control">
              <option value="">--Pilih--</option>
              <?php $pilihan=$kantor;
              foreach($pilihan as $key => $val){
                $selected = ($val['district_code'] == $curval) ? "selected" : ""; 
                ?>
                 <option <?php echo $selected ?> value="<?php echo $val['district_code'] ?>"><?php echo $val['district_name'] ?></option>
                <?php } ?>
              </select>
            </div>
          </div>

        </form>

        <div class="table-responsive">            

          <table id="kpi_vendor" class="table table-bordered table-striped"></table>

        </div>

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

    var mydata = $.getCustomJSON("<?php echo site_url('Vendor') ?>/"+url);

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

  function operateFormatter(value, row, index) {
    var link = "<?php echo site_url('vendor/view_kpi_vendor') ?>";
    var link1 = "<?php echo site_url('vendor/info_kpi_vendor') ?>";
    return [
    '<a class="btn btn-primary btn-xs action" target="_blank" href="'+link+'/'+value+'">',
    'Lihat',
    '</a>  ',
    '<a class="btn btn-primary btn-xs action" target="_blank" href="'+link1+'/'+value+'">',
    'Info',
    '</a>  ',
    ].join('');
  }
  window.operateEvents = {
    'click .approval': function (e, value, row, index) {
    //alert('You click approval action, row: ' + JSON.stringify(row));
  },
  /*
  'click .remove': function (e, value, row, index) {
    $kpi_vendor.bootstrapTable('remove', {
      field: 'id',
      values: [row.id]
    });
  }
  */
};
function totalTextFormatter(data) {
  return 'Total';
}
function totalNameFormatter(data) {
  return data.length;
}
function totalPriceFormatter(data) {
  var total = 0;
  $.each(data, function (i, row) {
    total += +(row.price.substring(1));
  });
  return '$' + total;
}

</script>

<script type="text/javascript">

  var $kpi_vendor = $('#kpi_vendor'),
  selections = [];

</script>

<script type="text/javascript">

  $(function () {

   $("#klir").click(function(){
    window.location.assign('<?php echo site_url('vendor/daftar_vendor/kpi_vendor/1'); ?>');
  });

   $("#kode_item").change(function(){

    var myfilter = $(this).val();
    var url = "<?php echo site_url('procurement/set_session/item_gbl') ?>";
    $.ajax({
      url : url+"/"+myfilter,
      success:function(data){
        $("#kpi_vendor").bootstrapTable('refresh');
      }
    });

  });


   $("#kantor").change(function(){

    var myfilter = $(this).val();
    var url = "<?php echo site_url('procurement/set_session/kantor_gbl') ?>";
    $.ajax({
      url : url+"/"+myfilter,
      success:function(data){
        $("#kpi_vendor").bootstrapTable('refresh');
      }
    });

  });

   $kpi_vendor.bootstrapTable({

    url: "<?php echo site_url('Vendor/data_kpi_vendor') ?>",

    cookieIdTable:"vw_prc_bidder_list",

    idField:"vendor_id",

    <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>

    columns: [
    {
      field: 'vendor_id',
      title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
      align: 'center',
      width: '10%',
      events: operateEvents,
      formatter: operateFormatter,
    },
    {
      field: 'vendor_name',
      title: 'Nama Vendor',
      sortable:true,
      order:true,
      searchable:true,
      align: 'center',
      valign: 'middle'
    },
    {
      field: 'fin_class_name',
      title: 'Status Flag',
      sortable:true,
      order:true,
      searchable:true,
      align: 'center',
      valign: 'middle'
    },
    ]

  });
   setTimeout(function () {
    $kpi_vendor.bootstrapTable('resetView');
  }, 200);

   $kpi_vendor.on('expand-row.bs.table', function (e, index, row, $detail) {
    $detail.html(detailFormatter(index,row,"alias_kpi_vendor"));
  });

 });

</script>