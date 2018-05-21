<div class="wrapper wrapper-content animated fadeInRight">

  <div class="row">

    <div class="col-lg-12">

      <?php include("daftar_pekerjaan_kontrak_v.php"); ?>
      <?php include("daftar_pekerjaan_wo_v.php"); ?>
      <?php include("daftar_pekerjaan_wo_progress_v.php"); ?>
      <?php include("daftar_pekerjaan_milestone_progress_v.php"); ?>
      <?php include("daftar_pekerjaan_bast_wo_v.php"); ?>
      <?php include("daftar_pekerjaan_bast_milestone_v.php"); ?>
      <?php include("daftar_pekerjaan_invoice_wo_v.php"); ?>
      <?php include("daftar_pekerjaan_invoice_milestone_v.php"); ?>
      <?php include("daftar_pekerjaan_addendum_v.php"); ?>

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

    var mydata = $.getCustomJSON("<?php echo site_url('contract') ?>/"+url);

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