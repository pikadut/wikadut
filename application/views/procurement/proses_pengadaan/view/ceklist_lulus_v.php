<?php if($prep['ptp_prequalify'] != 0){ ?>

<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>PRA KUALIFIKASI</h5>
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
              <th>No</th>
              <th>Nama Vendor</th>
              <th>Lampiran Prakualifikasi</th>
              <th>Lulus/Tidak Lulus</th>
              <th>Alasan</th>
            </tr>
          </thead>

          <tbody>
            <?php 
            if(!empty($vendor_status)){
              foreach ($vendor_status as $key => $value) { ?>
              <tr>
                <td><?php echo $key+1 ?></td>
                <td><a href="<?php echo site_url('vendor/daftar_vendor/lihat_detail_vendor/'.$value['pvs_vendor_code']) ?>" target="_blank"><?php echo $value['vendor_name'] ?></a></td>
                <td><a target="_blank" href="<?php echo site_url('log/download_attachment_extranet/prakualifikasi/'.$value['pvs_vendor_code'].'/'.$value["pvs_pq_attachment"]); ?>"><?php echo $value["pvs_pq_attachment"] ?></a></td>
                <td align="center">
                 <?php echo ($value['pvs_pq_passed']) ? "Ya" : "Tidak" ?>
               </td>
               <td><?php echo $value['pvs_pq_reason'] ?></td>
             </tr>
             <?php } } ?>
           </tbody>
         </table>

       </div>
     </div>
   </div>
 </div>
 
 <?php } ?>