<div class="wrapper wrapper-content animated fadeInRight">
<form method="post" action="<?php echo site_url($controller_name."/submit_approval_kat_brg");?>"  class="form-horizontal">

  
  <?php foreach ($mat_catalog as $k => $v) {
    $i = $v['mat_catalog_code'];
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

        <?php $curval = (isset($v['mat_catalog_code'])) ? $v['mat_catalog_code'] : set_value("code_inp[$i]") ?>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('code') ?></label>
            <div class="col-sm-10">
              <input type="text" disabled class="form-control" name="code_inp[<?php echo $i ?>]" maxlength="10" value="<?php echo $curval ?>">
            </div>
          </div>

          <?php $curval = (isset($v['mat_group_code'])) ? $v['mat_group_code'] : set_value("code_inp[$i]") ?>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('group') ?></label>
            <div class="col-sm-10">
              <select disabled class="form-control select2" style="width:100%;" name="group_inp[<?php echo $i ?>]">
                <option value=""><?php echo lang('choose') ?></option>
                <?php foreach($list_group as $key => $val){ 
                  $selected = ($curval == $val['mat_group_code']) ? "selected" : "";
                  ?>
                  <option <?php echo $selected ?> value="<?php echo $val['mat_group_code'] ?>"><?php echo $val['mat_group_code'] ?> - <?php echo $val['mat_group_name'] ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <?php $curval = (isset($v['short_description'])) ? $v['short_description'] : set_value("desc_inp[$i]") ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Deskripsi Barang</label>
              <div class="col-sm-10">
                <textarea disabled name="desc_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
              </div>
            </div>
			
			<?php $curval = (isset($v['long_description'])) ? $v['long_description'] : set_value("info_inp[$i]") ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Nama Barang</label>
              <div class="col-sm-10">
                <textarea disabled name="info_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
              </div>
            </div>
			
			<?php $curval = (isset($v['brand'])) ? $v['brand'] : set_value("merek_inp[$i]") ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Merek</label>
              <div class="col-sm-10">
                <textarea disabled name="merek_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
              </div>
            </div>
			
			<?php $curval = (isset($v['tipe'])) ? $v['tipe'] : set_value("tipe_inp[$i]") ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Tipe/Jenis</label>
              <div class="col-sm-10">
                <textarea disabled name="tipe_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
              </div>
            </div>
			
			<?php $curval = (isset($v['part_number'])) ? $v['part_number'] : set_value("part_inp[$i]") ?>
			<div class="form-group">
            <label class="col-sm-2 control-label">Nomor Part</label>
            <div class="col-sm-10">
              <textarea disabled name="part_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
            </div>
          </div>
		  
		  <?php $curval = (isset($v['model_number'])) ? $v['model_number'] : set_value("model_inp[$i]") ?>
		  <div class="form-group">
            <label class="col-sm-2 control-label">Nomor Model</label>
            <div class="col-sm-10">
              <textarea disabled name="model_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
            </div>
          </div>
		  
		  <?php $curval = (isset($v['serial_number'])) ? $v['serial_number'] : set_value("serial_inp[$i]") ?>
		  <div class="form-group">
            <label class="col-sm-2 control-label">Nomor Serial</label>
            <div class="col-sm-10">
              <textarea disabled name="serial_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
            </div>
          </div>
		  
		  <?php $curval = (isset($v['manufacturer'])) ? $v['manufacturer'] : set_value("pabrik_inp[$i]") ?>
		  <div class="form-group">
            <label class="col-sm-2 control-label">Pabrik</label>
            <div class="col-sm-10">
              <textarea disabled name="pabrik_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
            </div>
          </div>
		  
		  <?php $curval = (isset($v['material'])) ? $v['material'] : set_value("material_inp[$i]") ?>
		  <div class="form-group">
            <label class="col-sm-2 control-label">Material</label>
            <div class="col-sm-10">
              <textarea disabled name="material_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
            </div>
          </div>
		  
		  <?php $curval = (isset($v['ukuran'])) ? $v['ukuran'] : set_value("ukuran_inp[$i]") ?>
		  <div class="form-group">
            <label class="col-sm-2 control-label">Ukuran/Dimensi/Kapasitas</label>
            <div class="col-sm-10">
              <textarea disabled name="ukuran_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
            </div>
          </div>
		  
		  <?php $curval = (isset($v['warna'])) ? $v['warna'] : set_value("warna_inp[$i]") ?>
		  <div class="form-group">
            <label class="col-sm-2 control-label">Warna</label>
            <div class="col-sm-10">
              <textarea disabled name="warna_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
            </div>
          </div>
		  
		  <?php $curval = (isset($v['uom'])) ? $v['uom'] : set_value("uom_inp[$i]") ?>
		  <div class="form-group">
			<label class="col-sm-2 control-label">Satuan</label>
			<div class="col-sm-10">
				<input disabled type="text" class="form-control" name="uom_inp[<?php echo $i ?>]" value="<?php echo $curval ?>">
			</div>
		  </div>
		  
		  <?php $curval = (isset($v['spesifikasi'])) ? $v['spesifikasi'] : set_value("spesifikasi_inp[$i]") ?>
		  <div class="form-group">
            <label class="col-sm-2 control-label">Spesifikasi</label>
            <div class="col-sm-10">
              <textarea disabled name="spesifikasi_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
            </div>
          </div>
		  
		  <?php $curval = (isset($v['lokasi'])) ? $v['lokasi'] : set_value("lokasi_inp[$i]") ?>
		  <div class="form-group">
            <label class="col-sm-2 control-label">Lokasi</label>
            <div class="col-sm-10">
              <textarea disabled name="lokasi_inp[<?php echo $i ?>]" class="form-control"><?php echo $curval ?></textarea>
            </div>
          </div>

            <?php $curval = (isset($v['image'])) ? $v['image'] : set_value("image_inp[$i]") ?>
            <div class="form-group">
              <label class="col-sm-2 control-label"><?php echo lang('image') ?></label>
              <div class="col-sm-10">
                <div class="input-group">
                  <input disabled type="text" class="form-control" id="image_inp_<?php echo $i ?>" name="image_inp[<?php echo $i ?>]"
                  value="<?php echo $curval ?>">
                  <span class="input-group-btn">
                    <button type="button" data-url="<?php echo base_url("uploads/$dir/".$curval) ?>" class="btn btn-primary preview_upload" id="preview_img_file_<?php echo $i ?>">Preview</button> 
                  </span> 
                </div>
              </div>
            </div>

            <?php $curval = (isset($v['attachment'])) ? $v['attachment'] : set_value("attachment_inp[$i]") ?>
            <div class="form-group">
              <label class="col-sm-2 control-label"><?php echo lang('attachment') ?></label>
              <div class="col-sm-10">
                <div class="input-group">
                  <input disabled type="text" class="form-control" id="attachment_inp_<?php echo $i ?>" name="attachment_inp[<?php echo $i ?>]"
                  value="<?php echo $curval ?>">
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

    <?php include(VIEWPATH."/comment_workflow_v.php") ?>

    <?php } ?>

<?php echo buttonsubmit('commodity/daftar_pekerjaan',lang('back'),lang('save')) ?>

  </form>

  </div>