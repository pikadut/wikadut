<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>TEMPLATE EVALUASI</h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>

      <div class="ibox-content">

      <div class="col-xs-2">
      </div>

      <div class="col-xs-4">

      <?php $curval = ""; ?>
        <div class="form-group">
          <label class="col-sm-5 control-label"></label>
          <div class="col-sm-7">
           <select class="form-control" name="metode_pengadaan" value="<?php echo $curval ?>">
             <option value="">Nama</option>
           </select>
         </div>
       </div>

      </div>

      <div class="col-xs-4">

      <?php $curval = ""; ?>
     <div class="form-group">
      <label class="col-sm-2 control-label"></label>
      <div class="col-sm-8">
        <div class="input-group"> 
          <input readonly type="text" class="form-control" id="" name="panitia_pelelangan" value="<?php echo $curval ?>">
          <span class="input-group-btn">
            <button type="button" data-id="" data-folder="<?php echo $dir ?>" data-preview="" class="btn btn-primary upload">Cari</button> 
          </span>
        </div>
      </div>
    </div>

      </div>

      <div class="col-xs-2">
      </div>

        <table class="table table-bordered">
          <thead>
            <tr>
              <th>No</th>
              <th>ID</th>
              <th>Nama</th>
              <th>Tipe</th>
              <th>Lihat</th>
            </tr>
          </thead>

          <tbody>
            <tr>
              <td>1</td>
              <td>1</td>
              <td>Highest Quality Evaluation Template</td>
              <td>Evaluasi Kualitas Terbaik</td>
              <td align="center"><a class="btn btn-primary" href="#" role="button">Lihat</a></td>
            </tr>
          </tbody>
        </table>

      </div>

    </div>
  </div>
</div>