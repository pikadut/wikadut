<?php foreach ($evaluation as $key => $value) {
 ?>
 <tr>
  <td><?php echo $key+1 ?>
  <input type="hidden" name="rank_inp[<?php echo $value['ptv_vendor_code'] ?>]" value="<?php echo $key+1 ?>" />
  </td>
  <td class="text-center"><strong><?php echo inttomoney($value['total']) ?></strong></td>
  <td>
    <?php if(isset($value['pqm_id'])) { ?>
    <a target="_blank" href="<?php echo site_url('procurement/lihat_penawaran/'.$value['pqm_id']) ?>">
      <?php } ?>
      <?php echo $value['vendor_name'] ?>
      <?php if(isset($value['pqm_id'])) { ?>
    </a>
    <?php } ?>
    <?php echo (!empty($value['pqm_type'])) ? "(<strong>Tipe ".$value['pqm_type']."</strong>)" : "" ?>
  </td>
  <td class="text-center">
   
    <?php if($value['adm'] == "Lulus"){ ?>
    <span class="text-success">
      <?php } else { ?>
      <span class="text-danger">
        <?php } ?>
        <?php echo $value['adm'] ?>
      </span>
    
  </td>
  <td class="text-right"><?php echo inttomoney($value['pte_technical_weight']) ?></td>
  <td class="text-right">
    <a href="#" class="dialog" data-url="<?php echo site_url(PROCUREMENT_EVALUASI_TEKNIS_VENDOR_PATH) ?>/<?php echo ($viewer == "harga" || ($prep['ptp_submission_method'] == 2 && $activity_id !=1112)) ? "view" : $act ?>/<?php echo $value['ptv_vendor_code'] ?>">
      <span class="vendor_tech_value" data-id="<?php echo $value['ptv_vendor_code'] ?>"><u><?php echo inttomoney($value['pte_technical_value']) ?></u></span>
    </a>
  </td>
  <td class="text-right"><?php echo inttomoney($value['pte_passing_grade']) ?></td>
  <td class="text-center">
    
      <?php if($value['pass'] == "Lulus"){ ?>
      <span class="text-success">
        <?php } else { ?>
        <span class="text-danger">
          <?php } ?>
          <?php echo $value['pass'] ?>
        </span>
      
    </td>
    <td class="text-right"><?php echo $value['pte_technical_remark'] ?></td>
    <?php 

    if($viewer != "teknis"){ ?>
    <td class="text-right">

     <?php echo inttomoney($value['pte_price_weight']) ?>

   </td>
   <td class="text-right">
     <a href="#" class="dialog" data-url="<?php echo site_url(PROCUREMENT_EVALUASI_HARGA_VENDOR_PATH) ?>/<?php echo $act ?>/<?php echo $value['ptv_vendor_code'] ?>">
       <strong><u><?php echo inttomoney($value['pte_price_value']) ?></u></strong>
     </a>
   </td>
   <td>
     <?php if($value['pass_price'] == "Lulus"){ ?>
      <span class="text-success">
        <?php } else { ?>
        <span class="text-danger">
          <?php } ?>
          <?php echo $value['pass_price'] ?>
        </span>
        </td>
   <td class="text-left"><?php echo $value['pte_price_remark'] ?></td>
   <td class="text-right">

     <?php 
     if(isset($first_price[$value['ptv_vendor_code']]['total_ppn'])) { 
      echo inttomoney($first_price[$value['ptv_vendor_code']]['total_ppn']);
    } else {
      echo inttomoney($value['amount']);
    } ?>

  </td>
  <td class="text-right">
<?php 
     if(isset($first_price[$value['ptv_vendor_code']]['total_ppn'])) {
     echo inttomoney($value['amount']);
     } ?>

  </td>

  <?php } ?>
</tr>

<?php } ?>