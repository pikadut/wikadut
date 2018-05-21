
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Daftar Vendor Yang Hadir</h5>
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

var $daftar_vendor_absen = $('#daftar_vendor_absen'),
  selections = [];

</script>

<script type="text/javascript">

  $(function () {

    $daftar_vendor_absen.bootstrapTable({

      url: "<?php echo site_url('Procurement/data_vendor_tender_view') ?>",
      selectItemName:"vendor_attend_tender[]",
      cookieIdTable:"vendor_tender",
      idField:"vendor_id",
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      columns: [
   
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
         
      {
        field: 'is_attend',
        title: 'Hadir',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      <?php $jadwal_tahap_2 = ($prep['ptp_submission_method'] == 2 && $activity_id >= 1112);
      if($jadwal_tahap_2){
       ?>
      {
        field: 'is_attend_2',
        title: 'Hadir Tahap 2',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      <?php } ?>
      ]

    });
setTimeout(function () {
  $daftar_vendor_absen.bootstrapTable('resetView');
}, 200);

});

</script>