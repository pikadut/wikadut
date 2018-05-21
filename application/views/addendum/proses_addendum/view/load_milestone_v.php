<?php 
$subtotal = 0;
if(isset($milestone) && !empty($milestone)){
foreach ($milestone as $key => $value) { ?>

<tr>
  <td>
    <?php echo $key+1 ?>
  </td>
  <td>
    <?php echo $value['description'] ?>
  </td>
  <td>
    <?php echo date("Y-m-d H:i:s",strtotime($value['target_date'])) ?>
  </td>
  <td class="text-right">
    <?php echo $value['percentage'] ?>
  </td>
  <td class="text-right">

    <a href="#" data-url="<?php echo site_url(CONTRACT_UPDATE_MILESTONE_PATH.'/'.$value['milestone_id'].'/'.$act) ?>" class="dialog">
      <?php echo (!empty($value['progress_percentage'])) ? $value['progress_percentage'] : 0 ?>
    </a>
    
  </td>
  <td>
    <?php echo $value['progress_description'] ?>
  </td>

</tr>

<?php } } ?>
