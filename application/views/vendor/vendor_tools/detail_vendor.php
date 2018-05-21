
<div class="wrapper wrapper-content animated fadeInRight">
  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>Vendor : <?php echo $vendor['vendor_name'] ?></h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>
            </div>
            </div> 
        <div class="ibox-content">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th width="64px">No</th>
                  <th>Nama Buyer</th>
                  <th>Posisi Buyer</th>
                  <th>No. Pengadaan</th>

                </tr>
              </thead>

              <tbody>
                <?php foreach ($item as $key => $value){ ?>

                <tr>
                  <td><?php echo ++$key ?></td>
                  <td><?php echo $value['ptm_buyer']?></td>
                  <td><?php echo $value['ptm_buyer_pos_name']?></td>
                  <td><a target="_blank" href="<?php echo site_url('procurement/procurement_tools/monitor_pengadaan/lihat/'.$value['ptm_number']) ?>"><?php echo $value['ptm_number']?></a></td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
         
      </div>
    </div>
  </div>
</div>