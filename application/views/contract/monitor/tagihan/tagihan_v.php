<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>MEMBUAT TAGIHAN</h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>

      <div class="ibox-content">

        <?php $curval = ""; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Vendor</label>
          <div class="col-sm-10">
            <P class="form-control"><?php echo $curval ?></P>
          </div>
        </div>

        <?php $curval = ""; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Tanggal Penagihan</label>
          <div class="col-sm-10">
            <P class="form-control"><?php echo $curval ?></P>
          </div>
        </div>

        <?php $curval = ""; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Target Tanggal</label>
          <div class="col-sm-4">
            <div class="input-group"> 
              <input readonly type="text" class="form-control" id="target_tanggal" name="target_tanggal" value="<?php echo $curval ?>">
              <span class="input-group-btn">
                <button type="button" data-id="" data-folder="<?php echo $dir ?>" data-preview="" class="btn btn-primary upload">...</button> 
              </span>
            </div>
          </div>
        </div>

        <?php $curval = ""; ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Bobot (%)</label>
          <div class="col-sm-4">
            <input class="form-control"><?php echo $curval ?>
          </div>
        </div>

        </div>

        <div class="ibox-content">

        <div class="row">

          <div class="col-xs-5">
          </div>

          <div class="col-xs-2">
            <button class="btn btn-primary" type="submit">Tambah Data</button> <span><button class="btn btn-success" type="submit">Reset</button></span>
          </div>

          <div class="col-xs-5">
          </div>

        </div>
        <br>

       <table class="table table-bordered">
        <thead>
          <tr>
            <th>No</th>
            <th>Deskripsi</th>
            <th>Target Tanggal</th>
            <th>Bobot (%)</th>
            <th>Aksi</th>
          </tr>
        </thead>

        <tbody>
          <tr>
            <td>1</td>
            <td>Termin 1</td>
            <td>08.10.2015</td>
            <td>60%</td>
            <td align="center"><button class="btn btn-default" type="submit">Ubah</button> <span><button class="btn btn-danger" type="submit">Hapus</button></span></td>
          </tr>
        </tbody>
      </table>

    </div>

  </div>
</div>
</div>