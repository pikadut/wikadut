<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>EVALUASI TEKNIS</h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>

      <div class="ibox-content">
        <div class="table-responsive">
        <table class="table table-bordered" id="evaluasi_teknis_table">
            <thead>
              <tr>
                <th rowspan="2">#</th>
                <th rowspan="2">Nilai Total</th>
                <th rowspan="2">Nama Vendor</th>
                <th rowspan="2">Administrasi</th>
                <th colspan="5">Teknis</th>

              </tr>
              <tr>
                <th>Bobot</th>
                <th>Nilai</th>
                <th>Minimum</th>
                <th>Hasil</th>
                <th>Catatan</th>
              </tr>
            </thead>

            <tbody></tbody>

          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">

  reloadeval();
  
  function reloadeval(){
    $("#vendor_verifikasi_view").bootstrapTable("refresh");
    $("#evaluasi_teknis_table tbody").load("<?php echo site_url('procurement/load_evaluation') ?>/edit/teknis");
  }

  $(document).ready(function(){

    $(document.body).on("click",".reloadeval",function(){
      $("#dialog").modal("hide");
    });

    $('#dialog').on('hidden.bs.modal', function (e) {
      reloadeval();
    });

  });

</script>