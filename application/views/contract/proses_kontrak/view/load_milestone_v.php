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
    <?php echo date(DEFAULT_FORMAT_DATE,strtotime($value['target_date'])) ?>
  </td>
  <td class="text-right">
    <?php echo $value['percentage'] ?>
  </td>
  <td class="text-right">

      <?php echo (!empty($value['progress_percentage'])) ? $value['progress_percentage'] : 0 ?>

    
  </td>
  <td>
    <?php echo $value['progress_description'] ?>
  </td>

</tr>

<?php } } ?>
