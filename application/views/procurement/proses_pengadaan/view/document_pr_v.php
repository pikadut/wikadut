<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>LAMPIRAN</h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="ibox-content">

       <table class="table table-bordered default">
        <thead>
          <tr>
            <th>No</th>
            <th>Kategori</th>
            <th>Deskripsi</th>
            <th>File</th>
          </tr>
        </thead>

        <tbody>
         <?php 
         $sisa = 5;
         if(isset($document) && !empty($document)){
          foreach ($document as $k => $v) {
            if(!empty($v['ppd_file_name'])){
              ?>
              <tr>
                <td><?php echo $k+1 ?></td>
                <td><?php echo $v["ppd_category"] ?></td>
                <td><?php echo $v['ppd_description'] ?></td>
                <td><a href="<?php echo site_url('log/download_attachment/procurement/permintaan/'.$v['ppd_file_name']) ?>" target="_blank">
                <?php echo $v['ppd_file_name'] ?>
                </a></td>
              </tr>

              <?php } } } ?>
            </tbody>
          </table>

        </div>

      </div>
    </div>
  </div>