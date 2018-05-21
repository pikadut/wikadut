<div class="wrapper wrapper-content">

  <div class="row">
    <div class="col-lg-3">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>SPPBJ</h5>
        </div>
        <div class="ibox-content">
          <h1 class="no-margins"><?php echo inttomoney($total_pr) ?></h1>
          <small></small>
        </div>
      </div>
    </div>
    <div class="col-lg-3">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>RFQ-Undangan</h5>
        </div>
        <div class="ibox-content">
          <h1 class="no-margins"><?php echo inttomoney($total_rfq) ?></h1>
          <small></small>
        </div>
      </div>
    </div>
    <div class="col-lg-3">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Contract</h5>
        </div>
        <div class="ibox-content">
          <h2 class="no-margins"><?php echo inttomoney($total_contract) ?></h2>
          <small></small>
        </div>
      </div>
    </div>
    <div class="col-lg-3">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Vendor Aktif</h5>
        </div>
        <div class="ibox-content">
          <h1 class="no-margins"><?php echo inttomoney($total_vendor) ?></h1>
          <small></small>
        </div>
      </div>
    </div>

  </div>

  <div class="row">
    <div class="col-lg-7">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Procurement Method</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>
          </div>
        </div>
        <div class="ibox-content">

            <canvas id="procurement_method_graph" width="560px" height="200px"></canvas>

        </div>
      </div>
    </div>
    <div class="col-lg-5">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Top 5 Commodities</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>
          </div>
        </div>
        <div class="ibox-content">
          <div class="flot-chart">
            <div class="flot-chart-pie-content" id="top_five_graph"></div>
          </div>
        </div>
      </div>
    </div>
  </div>


<div class="row">

  <div class="col-md-6">

   <div class="ibox float-e-margins border-bottom">
    <div class="ibox-title">
      <h5>Daftar Pekerjaan SPPBJ</h5>
      <div class="ibox-tools">
        <a class="collapse-link">
          <i class="fa fa-chevron-up"></i>
        </a>

      </div>
    </div>
    <div class="ibox-content">

      <div class="table-responsive">

        <table id="table_pekerjaan_pr" class="table table-bordered table-striped"></table>

      </div>

    </div>
  </div>

</div>

<div class="col-md-6">
  <div class="ibox float-e-margins border-bottom">
    <div class="ibox-title">
      <h5>Daftar Pekerjaan RFQ-Undangan</h5>
      <div class="ibox-tools">
        <a class="collapse-link">
          <i class="fa fa-chevron-up"></i>
        </a>

      </div>
    </div>
    <div class="ibox-content">

      <div class="table-responsive">

        <table id="table_pekerjaan_rfq" class="table table-bordered table-striped"></table>

      </div>

    </div>
  </div>
</div>

</div>

  <script type="text/javascript">

    $(function() {

          var lineOptions = {
        scaleShowGridLines: true,
        scaleGridLineColor: "rgba(0,0,0,.05)",
        scaleGridLineWidth: 1,
        bezierCurve: true,
        bezierCurveTension: 0.4,
        pointDot: true,
        pointDotRadius: 4,
        pointDotStrokeWidth: 1,
        pointHitDetectionRadius: 20,
        datasetStroke: true,
        datasetStrokeWidth: 2,
        datasetFill: true,
        responsive: false,
    };

var lineData = {
        labels: [
        <?php foreach ($top_proc_method as $key => $value) { ?>
          "<?php echo $value['label'] ?>",
        <?php } ?>
        ],
        datasets: [
         
            {
                label: "Top Procurement by Method",
                fillColor: "rgba(220,220,220,0.5)",
                strokeColor: "rgba(220,220,220,1)",
                pointColor: "rgba(220,220,220,1)",
                pointStrokeColor: "#fff",
                pointHighlightFill: "#fff",
                pointHighlightStroke: "rgba(220,220,220,1)",
                data: [
                <?php foreach ($top_proc_method as $key => $value) { ?>
                  <?php echo $value['total'] ?>, 
                  <?php } ?>
                  ]
            },
            
        ]
    };

        var ctx = $("#procurement_method_graph").get(0).getContext("2d");
    var myNewChart = new Chart(ctx).Line(lineData, lineOptions);

var data = [

<?php 
//haqim
// $color = array("d3d3d3","bababa","79d2c0","1ab394","#2f4050");
$color = array("c9cbcc","8fb5c9","529dc4","2284b7","#00a5ff");
foreach ($top_commodity as $key => $value) { ?>
 {
  label: "<?php echo quotes_to_entities($value['code'].' - '.$value['short_description']) ?>",
  data: <?php echo $value['total'] ?>,
  color: "#<?php echo $color[$key] ?>",
},
<?php } ?>

];

var plotObj = $.plot($("#top_five_graph"), data, {
  series: {
    pie: {
      show: true
    }
  },
  grid: {
    hoverable: true
  },
  tooltip: true,
  tooltipOpts: {
            content: "%p.0%, %s", // show percentages, rounding to 2 decimal places
            shifts: {
              x: 20,
              y: 0
            },
            defaultTheme: false
          }
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

  function operateFormatter(value, row, index) {
    var link = "<?php echo site_url('procurement/daftar_pekerjaan') ?>";
    return [
    '<a class="btn btn-primary btn-xs action" href="'+link+'/proses/'+value+'">',
    'Proses',
    '</a>  ',
    ].join('');
  }

  function operateFormatter2(value, row, index) {
    var link = "<?php echo site_url('procurement/daftar_pekerjaan') ?>";
    return [
    '<a class="btn btn-primary btn-xs action" href="'+link+'/proses_tender/'+value+'">',
    'Proses',
    '</a>  ',
    ].join('');
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


<script type="text/javascript">

  var $table_pekerjaan_pr = $('#table_pekerjaan_pr'),
  $table_pekerjaan_rfq = $('#table_pekerjaan_rfq'),
  selections = [];

</script>

<script type="text/javascript">

  $(function () {

    $table_pekerjaan_pr.bootstrapTable({

      url: "<?php echo site_url('Procurement/data_pekerjaan_pr') ?>",
      striped:true,
      selectItemName:"list",
      sidePagination:"server",
      smartDisplay:false,
      cookie:true,
      cookieExpire:"1h",
      cookieIdTable:"daftar_pekerjaan_pr",
      showExport:false,
      exportTypes:['json', 'xml', 'csv', 'txt', 'excel'],
      showFilter:true,
      flat:true,
      keyEvents:false,
      showMultiSort:false,
      
      reorderableColumns:false,
      resizable:false,
      pagination:true,
      cardView:false,
      detailView:false,
      search:true,
      showRefresh:true,
      showToggle:true,
      idField:"ppc_id",
      
      showColumns:true,
      columns: [
      {
        field: 'ppc_id',
        title: '#',
        align: 'center',
        width:'8%',
        valign: 'middle',
        formatter: operateFormatter,
      },
      {
        field: 'pr_number',
        title: 'No. PR',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'20%',
      },

      {
        field: 'pr_subject_of_work',
        title: 'Nama Pekerjaan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'30%',
      },
     
      {
        field: 'activity',
        title: 'Aktifitas',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'20%',
      },
      ]

    });
setTimeout(function () {
  $table_pekerjaan_pr.bootstrapTable('resetView');
}, 200);

$table_pekerjaan_pr.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_pr"));
});

});

</script>

<script type="text/javascript">

  $(function () {

    $table_pekerjaan_rfq.bootstrapTable({

      url: "<?php echo site_url('Procurement/data_pekerjaan_rfq') ?>",
      striped:true,
      selectItemName:"list",
      sidePagination:"server",
      smartDisplay:false,
      cookie:true,
      cookieExpire:"1h",
      cookieIdTable:"daftar_pekerjaan_rfq",
      showExport:false,
      exportTypes:['json', 'xml', 'csv', 'txt', 'excel'],
      showFilter:true,
      flat:true,
      keyEvents:false,
      showMultiSort:false,
      
      reorderableColumns:false,
      resizable:true,
      pagination:true,
      cardView:false,
      detailView:false,
      search:true,
      showRefresh:true,
      showToggle:true,
      idField:"ptc_id",
      
      showColumns:true,
      columns: [
      {
        field: 'ptc_id',
        title: '#',
        align: 'center',
        width:'8%',
        valign: 'middle',
        formatter: operateFormatter2,
      },
      {
        field: 'ptm_number',
        title: 'No. Tender',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'20%',
      },
       {
        field: 'ptm_subject_of_work',
        title: 'Nama Pekerjaan',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'30%',
      },
     
      {
        field: 'activity',
        title: 'Aktifitas',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'20%',
      },
      ]

    });
setTimeout(function () {
  $table_pekerjaan_rfq.bootstrapTable('resetView');
}, 200);

$table_pekerjaan_rfq.on('expand-row.bs.table', function (e, index, row, $detail) {
  $detail.html(detailFormatter(index,row,"alias_rfq"));
});

});

</script>