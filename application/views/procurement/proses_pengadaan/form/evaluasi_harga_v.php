<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>EVALUASI HARGA</h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>

      <div class="ibox-content">

      <div class="table-responsive">

        <table class="table table-bordered" id="evaluasi_harga_table">
          <thead>
            <tr>
              <th rowspan="2">#</th>
              <th rowspan="2">Nilai Total</th>
              <th rowspan="2">Nama Vendor</th>
              <th rowspan="2">Administrasi</th>
              <th colspan="5">Teknis</th>
              <th colspan="4">Harga</th>
            </tr>
            <tr>
              <th>Bobot</th>
              <th>Nilai</th>
              <th>Minimum</th>
              <th>Hasil</th>
              <th>Catatan</th>
              <th>Bobot</th>
              <th>Nilai</th>
              <th>Catatan</th>
              <th>Total</th>
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
    $("#evaluasi_harga_table tbody").load("<?php echo site_url('procurement/load_evaluation') ?>/edit/harga");
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