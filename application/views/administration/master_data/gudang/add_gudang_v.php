<div class="wrapper wrapper-content animated fadeInRight" ng-controller="form_gudang">
  <form method="post" action="<?php echo site_url($controller_name."/submit_add_gudang");?>"  class="form-horizontal" novalidate>

    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
          <div class="ibox-title">
            <h5>Tambah Gudang</h5>
            <div class="ibox-tools">
              <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
              </a>
            </div>
          </div> 
          <div class="ibox-content">

           <?php $curval = set_value("code_inp"); ?>
           <div class="form-group">
             <label class="col-sm-2 control-label">Kode Gudang</label>
             <div class="col-sm-4">
              <input type="text" class="form-control" id="code_inp" maxlength="5" name="code_inp" value="<?php echo $curval ?>">
            </div>
          </div>

          <?php $curval = set_value("name_inp"); ?>
          <div class="form-group">
            <label class="col-sm-2 control-label">Nama Gudang</label>
            <div class="col-sm-4">
              <input type="text" class="form-control" id="name_inp" maxlength="50" name="name_inp" value="<?php echo $curval ?>">
            </div>
          </div>

          <?php $curval = set_value("lokasi_inp"); ?>
          <div class="form-group">
            <label class="col-sm-2 control-label">Lokasi Gudang</label>
            <div class="col-sm-6">
              <textarea class="form-control" id="lokasi_inp" name="lokasi_inp"><?php echo $curval ?></textarea>
            </div>
          </div> 

          <?php $curval = set_value("tipe_inp"); ?>
          <div class="form-group">
            <label class="col-sm-2 control-label">Tipe Gudang</label>
            <div class="col-sm-3">
              <select required class="form-control" ng-model="tipe" name="tipe_inp">
                <option value="">Pilih</option>
                <?php 
                foreach($gudang_type as $key => $val){
                  $selected = ($key == $curval) ? "selected" : ""; 
                  ?>
                  <option <?php echo $selected ?> value="<?php echo $key ?>"><?php echo $val ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <?php $curval = set_value("district_inp"); ?>
            <div class="form-group" ng-show="tipe == 0">
              <label class="col-sm-2 control-label">Kantor</label>
              <div class="col-sm-8">
                <select required class="form-control select2" style="width:100%;" name="district_inp">
                  <option value="">Pilih</option>
                  <?php foreach($office as $key => $val){
                    $selected = ($val['district_id'] == $curval) ? "selected" : ""; ?>
                    <option <?php echo $selected ?> value="<?php echo $val['district_id'] ?>">
                      <?php echo $val['district_code'] ?> - <?php echo $val['district_name'] ?>
                    </option>
                    <?php } ?>
                  </select>
                </div>
              </div>  

              <?php $curval = set_value("ship_inp"); ?>
              <div class="form-group" ng-show="tipe == 1">
                <label class="col-sm-2 control-label">Kapal</label>
                <div class="col-sm-8">
                  <select required class="form-control select2" style="width:100%;" name="ship_inp">
                    <option value="">Pilih</option>
                    <?php foreach($ship as $key => $val){
                      $selected = ($val['id_ship'] == $curval) ? "selected" : ""; ?>
                      <option <?php echo $selected ?> value="<?php echo $val['id_ship'] ?>">
                        <?php echo $val['code_ship'] ?> - <?php echo $val['name_ship'] ?> (<?php echo $val['district_name'] ?>)
                      </option>
                      <?php } ?>
                    </select>
                  </div>
                </div>  

              </div>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-md-12">
            <div style="margin-bottom: 60px;">
              <?php echo buttonsubmit('administration/master_data/gudang',lang('back'),lang('save')) ?>
            </div>
          </div>
        </div>

      </form>
    </div>