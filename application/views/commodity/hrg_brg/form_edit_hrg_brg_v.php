<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" action="<?php echo site_url($controller_name."/submit_edit_hrg_brg");?>"  class="form-horizontal">

    <?php //echo buttonsubmit('commodity/daftar_harga/daftar_harga_barang') ?>

    <?php foreach ($mat_price as $k => $v) {
      $i = $v['mat_price_id'];
      ?>

      <div class="row">
        <div class="col-lg-12">
          <div class="ibox float-e-margins">
            <div class="ibox-title">
              <h5>Form #<?php echo $i ?></h5>
              <div class="ibox-tools">
                <a class="collapse-link">
                  <i class="fa fa-chevron-up"></i>
                </a>
              </div>
            </div>
            <div class="ibox-content">

              <?php $curval = (isset($v['mat_catalog_code'])) ? $v['mat_catalog_code'] : set_value("catalog_inp[$i]") ?>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo lang('catalog') ?></label>
                <div class="col-sm-10">
                  <div class="input-group">
                    <span class="input-group-btn">
                      <button type="button" data-id="catalog_inp_<?php echo $i ?>" data-url="<?php echo site_url(COMMODITY_KATALOG_BARANG_PATH.'/picker') ?>" class="btn btn-primary picker">...</button> 
                    </span> 
                    <input readonly type="text" data-key="<?php echo $k ?>" class="form-control" id="catalog_inp_<?php echo $i ?>" name="catalog_inp[<?php echo $i ?>]" value="<?php echo $curval ?>"> 
                  </div>
                </div>
              </div>

              <?php $curval = (isset($v['del_point_id'])) ? $v['del_point_id'] : set_value("del_point_inp[$i]") ?>
              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo lang('office') ?> *</label>
                <div class="col-sm-10">
                  <select required data-key="<?php echo $k ?>" class="form-control select2" style="width:100%;" name="del_point_inp[<?php echo $i ?>]">
                    <option value=""><?php echo lang('choose') ?></option>
                    <?php foreach($list_del_point as $key => $val){
                      $selected = ($val['district_id'] == $curval) ? "selected" : ""; 
                      ?>
                      <option <?php echo $selected ?> value="<?php echo $val['district_id'] ?>"><?php echo $val['district_code'] ?> - <?php echo $val['district_name'] ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>

                <?php $curval = (isset($v['sourcing_id'])) ? $v['sourcing_id'] : set_value("sourcing_inp[$i]") ?>
                <div class="form-group">
                  <label class="col-sm-2 control-label"><?php echo lang('sourcing') ?> *</label>
                  <div class="col-sm-10">
                    <select required data-key="<?php echo $k ?>" class="form-control select2" style="width:100%;" name="sourcing_inp[<?php echo $i ?>]">
                      <option value=""><?php echo lang('choose') ?></option>
                      <?php foreach($list_sourcing as $key => $val){
                        $selected = ($val['sourcing_id'] == $curval) ? "selected" : ""; 
                        ?>
                        <option <?php echo $selected ?> value="<?php echo $val['sourcing_id'] ?>"><?php echo $val['sourcing_name'] ?> (<?php echo $val['sourcing_type'] ?>)</option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>

                  <?php $curval = (isset($v['sourcing_date'])) ? $v['sourcing_date'] : set_value("sourcing_date_inp[$i]") ?>
                  <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo lang('sourcing_date') ?></label>
                    <div class="col-sm-3">
                      <div class="input-group date">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input type="text" name="sourcing_date_inp[<?php echo $i ?>]" data-key="<?php echo $k ?>" class="form-control datetimepicker" value="<?php echo $curval ?>">
                      </div>
                    </div>
                  </div>

                  <?php $curval = (isset($v['currency'])) ? $v['currency'] : set_value("currency_inp[$i]") ?>
                  <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo lang('currency') ?> *</label>
                    <div class="col-sm-4">

                      <select required data-key="<?php echo $k ?>" class="form-control" name="currency_inp[<?php echo $i ?>]">
                        <option value=""><?php echo lang('choose') ?></option>
                        <?php foreach($default_currency as $key => $val){
                          $selected = ($key == $curval) ? "selected" : ""; 
                          ?>
                          <option <?php echo $selected ?> value="<?php echo $key ?>"><?php echo $val ?></option>
                          <?php } ?>
                        </select>

                      </div>
                    </div>

                    <?php $curval = (isset($v['unit_price'])) ? $v['unit_price'] : set_value("unit_price_inp[$i]") ?>

                    <div class="form-group">
                      <label class="col-sm-2 control-label"><?php echo lang('unit_price') ?></label>
                      <div class="col-sm-10">
                        <input type="text" data-key="<?php echo $k ?>" class="form-control money unit_price_inp" name="unit_price_inp[<?php echo $i ?>]" value="<?php echo $curval ?>">
                      </div>
                    </div>

                    <?php $curval = (isset($v['handling_cost'])) ? $v['handling_cost'] : set_value("handling_cost_inp[$i]") ?>
                    <div class="form-group">
                      <label class="col-sm-2 control-label"><?php echo lang('handling_cost') ?></label>
                      <div class="col-sm-10">
                        <input type="text" data-key="<?php echo $k ?>" class="form-control money handling_cost_inp" name="handling_cost_inp[<?php echo $i ?>]" value="<?php echo $curval ?>">
                      </div>
                    </div>

                    <?php $curval = (isset($v['insurance_cost'])) ? $v['insurance_cost'] : set_value("insurance_cost_inp[$i]") ?>
                    <div class="form-group">
                      <label class="col-sm-2 control-label"><?php echo lang('insurance_cost') ?></label>
                      <div class="col-sm-10">
                        <input type="text" data-key="<?php echo $k ?>" class="form-control money insurance_cost_inp" name="insurance_cost_inp[<?php echo $i ?>]" value="<?php echo $curval ?>">
                      </div>
                    </div>

                    <?php $curval = (isset($v['freight_cost'])) ? $v['freight_cost'] : set_value("freight_cost_inp[$i]") ?>
                    <div class="form-group">
                      <label class="col-sm-2 control-label"><?php echo lang('freight_cost') ?></label>
                      <div class="col-sm-10">
                        <input type="text" data-key="<?php echo $k ?>" class="form-control money freight_cost_inp" name="freight_cost_inp[<?php echo $i ?>]" value="<?php echo $curval ?>">
                      </div>
                    </div>

                    <?php $curval = (isset($v['tax_duty'])) ? $v['tax_duty'] : set_value("tax_duty_inp[$i]") ?>

                    <div class="form-group">
                      <label class="col-sm-2 control-label"><?php echo lang('tax_duty') ?></label>
                      <div class="col-sm-10">
                        <input type="text" data-key="<?php echo $k ?>" class="form-control money tax_duty_inp" name="tax_duty_inp[<?php echo $i ?>]" value="<?php echo $curval ?>">
                      </div>
                    </div>

                    <?php $curval = (isset($v['discount'])) ? $v['discount'] : set_value("discount_inp[$i]") ?>
                    <div class="form-group">
                      <label class="col-sm-2 control-label"><?php echo lang('discount') ?></label>
                      <div class="col-sm-10">
                        <input type="text" data-key="<?php echo $k ?>" class="form-control money discount_inp" name="discount_inp[<?php echo $i ?>]" value="<?php echo $curval ?>">
                      </div>
                    </div>

                    <?php $curval = (isset($v['total_cost'])) ? $v['total_cost'] : set_value("total_cost_inp[$i]") ?>

                    <div class="form-group">
                      <label class="col-sm-2 control-label"><?php echo lang('total_cost') ?></label>
                      <div class="col-sm-10">
                      <input type="text" data-key="<?php echo $k ?>" class="form-control money total_cost_inp" readonly name="total_cost_inp[<?php echo $i ?>]" value="<?php echo $curval ?>">
                      </div>
                    </div>

                    <?php $curval = (isset($v['vendor'])) ? $v['vendor'] : set_value("vendor_inp[$i]") ?>
                    <div class="form-group">
                      <label class="col-sm-2 control-label"><?php echo lang('vendor') ?></label>
                      <div class="col-sm-10">
                        <input type="text" data-key="<?php echo $k ?>" class="form-control" name="vendor_inp[<?php echo $i ?>]" value="<?php echo $curval ?>">
                      </div>
                    </div>

                    <?php $curval = (isset($v['notes'])) ? $v['notes'] : set_value("note_inp[$i]") ?>
                    <div class="form-group">
                      <label class="col-sm-2 control-label"><?php echo lang('note') ?></label>
                      <div class="col-sm-10">
                        <input type="text" data-key="<?php echo $k ?>" class="form-control" name="note_inp[<?php echo $i ?>]" value="<?php echo $curval ?>">
                      </div>
                    </div>

                    <?php $curval = (isset($v['attachment'])) ? $v['attachment'] : set_value("attachment_inp[$i]") ?>
                    <div class="form-group">
                      <label class="col-sm-2 control-label"><?php echo lang('attachment') ?></label>
                      <div class="col-sm-10">
                        <div class="input-group">
                          <span class="input-group-btn">
                            <button type="button" data-id="attachment_inp_<?php echo $i ?>" data-folder="<?php echo $dir ?>" data-preview="preview_file_<?php echo $i ?>" class="btn btn-primary upload">...</button> 
                          </span> 
                          <input readonly type="text" data-key="<?php echo $k ?>" class="form-control" id="attachment_inp_<?php echo $i ?>" name="attachment_inp[<?php echo $i ?>]" value="<?php echo $curval ?>">
                          <span class="input-group-btn">
                            <button type="button" data-url="<?php echo base_url("uploads/$dir/$curval") ?>" class="btn btn-primary preview_upload" id="preview_file_<?php echo $i ?>">Preview</button> 
                          </span> 
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
              </div>
            </div>

            <?php include(VIEWPATH."/comment_v.php") ?>

            <?php } ?>

            <?php echo buttonsubmit('commodity/daftar_harga/daftar_harga_barang',lang('back'),lang('save')) ?>

          </form>

        </div>

         <script type="text/javascript">

          $(document).ready(function(){

            var field = ['unit_price_inp','handling_cost_inp','insurance_cost_inp','freight_cost_inp','tax_duty_inp'];

            function hitung(){

              var total = [];

              for (var i = 0; i < <?php echo $jumlah ?>; i++) {

                total[i] = 0;

                $.each(field,function(x,val){
                  var sel = "."+val+'[data-key="'+i+'"]';
                  tot = $(sel).val();
                  tot = (tot != "") ? moneytoint(tot) : 0;
                  if(!isNaN(tot)){
                    total[i] += parseInt(tot);
                  }

                });

                var disc = $('.discount_inp[data-key="'+i+'"]').val();
                disc = (disc != "") ? moneytoint(disc) : 0;
                disc = (isNaN(disc)) ? 0 : parseInt(disc);
                total[i] = inttomoney(total[i]-disc);

                $('.total_cost_inp[data-key='+i+']').val(total[i]);

              }

            }

            hitung();

            $('.discount_inp').change(function(){
                hitung();
              });

            $.each(field,function(i,val){

              $('.'+val).change(function(){
                hitung();
              });

            });

          })

        </script>