
<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>REVIEW VENDOR</h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="ibox-content" style="overflow-x: auto">


        <table class="table table-bordered table-responsive">
          <thead>
            <tr class="text-center">
              <th width="10%">Kode</th>
              <th>Kriteria</th>
              <th colspan="2" width="20%">Review</th>
            </tr>
          </thead>
          <!-- //hlmifzi -->

          <tbody><!-- <?php if (strlen($kode_item['item_code']) == 14){?>
             <input type="hidden" value="<?php echo substr($kode_item['item_code'], 0,8) ?>" name="id_commodity_cat">
          
            <?php } else if (strlen($kode_item['item_code']) == 15){?>
            <input type="hidden" value="<?php echo substr($kode_item['item_code'], 0,9) ?>" name="id_commodity_cat">

            <?php } else if(strlen($kode_item['item_code']) == 16) {?>
            <input type="hidden" value="<?php echo substr($kode_item['item_code'], 0,10) ?>" name="id_commodity_cat">

            <?php } ?> -->

            <?php 
            $i = 0;
            foreach ($penilaian as $key => $value) {?>
            <tr <?php if(strlen($value['kode']) <= 3){?> style="color: #000; font-size: 30pt; font-weight: bold;" <?php }?>>
             <td><?php echo $value['kode']?></td>
             <td><?php echo $value['pertanyaan'] ?></td>    


             <input type="hidden" value="<?php echo $value['id']?>" name="id_question[]">


             <?php if(strlen($value['kode']) > 3){?>
             <td><input type="radio" name="jawaban[<?php print $i; ?>]" value="1" id="ya" disabled> IYA</td>
             <td><input type="radio" name="jawaban[<?php print $i; ?>]" value="0"  id="tidak" disabled> TIDAK</td>
             <?php } else {?>
             <td>
               <td><input type="hidden" name="jawaban[<?php print $i; ?>]" value="0"  id="tidak"> </td>
               <?php }?>

             </tr>

             <?php $i++;
           }?>
           

         </tbody>
       </table>

     </div>
   </div>
 </div>
</div>