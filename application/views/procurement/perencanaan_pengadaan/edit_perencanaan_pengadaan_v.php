<div class="wrapper wrapper-content animated fadeInRight">
  <form method="post" action="<?php echo site_url($controller_name."/submit_ubah_perencanaan_pengadaan");?>"  class="form-horizontal ajaxform">
  <input type="hidden" name="id" value="<?php echo $id ?>">
    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
          <div class="ibox-title">
            <h5>HEADLINE</h5>
            <div class="ibox-tools">
              <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
              </a>
            </div>
          </div>
          <div class="ibox-content">

            <?php $curval = (isset($perencanaan['ppm_planner'])) ? $perencanaan['ppm_planner'] : $userdata['complete_name']; ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">User *</label>
              <div class="col-sm-10">
               <input type="text" disabled class="form-control" required name="user_inp" value="<?php echo $curval ?>">
             </div>
           </div>

           <?php $curval = (isset($perencanaan['ppm_dept_name'])) ? $perencanaan['ppm_dept_name'] : $userdata['dept_name']; ?>
           <div class="form-group">
            <label class="col-sm-2 control-label">Divisi/Departemen *</label>
            <div class="col-sm-10">
              <input type="text" disabled class="form-control" required name="birounit_inp" value="<?php echo $curval ?>" maxlength="10">
            </div>
          </div>

         <!-- haqim -->
         <?php $curval = $perencanaan["ppm_type_of_plan"]; ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Jenis Rencana*</label>
              <div class="col-sm-10">
               <input type="radio" name="jenis_rencana" value="rkp" <?= $curval == 'rkp' ? "checked" : '' ?> class="jenis_rencana"> RKP 
               <input type="radio" name="jenis_rencana" value="rkap" class="jenis_rencana" <?= $curval == 'rkap' ? "checked" : '' ?>> RKAP
             </div>
           </div>

            <div class="form-group" id="nama_proyek_form">
            <?php $curval = set_value("nama_proyek"); ?>
              <label class="col-sm-2 control-label">Nama Proyek*</label>
              <div class="col-sm-9">
               <input type="text" class="form-control" name="nama_proyek" id="nama_proyek" value="" readonly>
             </div>
             <div class="col-sm-1">
              <?php $curval = set_value("proyek_id"); ?>
              <input readonly required type="hidden" class="form-control"  id="proyek_id" name="proyek_id" value="<?php echo $curval ?>">
             <button type="button" data-id="proyek_id" data-url="<?php echo site_url('administration/picker_nama_proyek') ?>" class="btn btn-primary picker">
                <i class="fa fa-search"></i>
              </button>
              </div>
           </div>
           
           <!-- end -->

          <?php $curval = (isset($perencanaan['ppm_subject_of_work'])) ? $perencanaan['ppm_subject_of_work'] : set_value("nama_rencana_pekerjaan_inp"); ?>
          <div class="form-group">
            <label class="col-sm-2 control-label">Nama Program *</label>
            <div class="col-sm-10">
             <input type="text" class="form-control" maxlength="120" required name="nama_rencana_pekerjaan_inp" value="<?php echo $curval ?>">
           </div>
         </div>

         <?php $curval = (isset($perencanaan['ppm_scope_of_work'])) ? $perencanaan['ppm_scope_of_work'] : set_value("deskripsi_rencana_pekerjaan_inp"); ?>
         <div class="form-group">
          <label class="col-sm-2 control-label">Deskripsi Rencana Pekerjaan *</label>
          <div class="col-sm-10">
           <textarea class="form-control" required maxlength="1000" name="deskripsi_rencana_pekerjaan_inp"><?php echo $curval ?></textarea>
         </div>
       </div>

       <div class="form-group">
        <label class="col-sm-2 control-label">Mata Anggaran *</label>
        <div class="col-sm-3">
          <?php $curval = (isset($perencanaan['ppm_mata_anggaran'])) ? $perencanaan['ppm_mata_anggaran'] : set_value("mata_anggaran_code_inp"); ?>
          <input readonly type="text" required class="form-control" id="mata_anggaran_code_inp" name="mata_anggaran_code_inp" value="<?php echo $curval ?>">

        </div>
        <div class="col-sm-6">

          <?php $curval = (isset($perencanaan['ppm_nama_mata_anggaran'])) ? $perencanaan['ppm_nama_mata_anggaran'] : set_value("mata_anggaran_label_inp"); ?>
          <input readonly type="text" required class="form-control" id="mata_anggaran_label_inp" name="mata_anggaran_label_inp" value="<?php echo $curval ?>">

        </div>
        <div class="col-sm-1">

          <?php $curval = set_value("mata_anggaran_inp"); ?>
          <input readonly required type="hidden" class="form-control" id="mata_anggaran_inp" name="mata_anggaran_inp" value="<?php echo $curval ?>">
          <button type="button" data-id="mata_anggaran_inp" data-url="<?php echo site_url(PROCUREMENT_MATA_ANGGARAN_PATH.'/picker') ?>" class="btn btn-primary picker"><i class="fa fa-search"></i></button> 

        </div>
      </div>

      <?php $curval = (isset($perencanaan['ppm_sub_mata_anggaran'])) ? $perencanaan['ppm_sub_mata_anggaran'] : set_value("sub_mata_anggaran_code_inp"); ?>
      <div class="form-group">
        <label class="col-sm-2 control-label">Sub Mata Anggaran *</label>
        <div class="col-sm-3">

          <input readonly required type="text" class="form-control" id="sub_mata_anggaran_code_inp" name="sub_mata_anggaran_code_inp" value="<?php echo $curval ?>">

        </div>
        <div class="col-sm-6">

          <?php $curval = (isset($perencanaan['ppm_nama_sub_mata_anggaran'])) ? $perencanaan['ppm_nama_sub_mata_anggaran'] : set_value("sub_mata_anggaran_label_inp"); ?>

          <input readonly required type="text" class="form-control" id="sub_mata_anggaran_label_inp" name="sub_mata_anggaran_label_inp" value="<?php echo $curval ?>">

        </div>
      </div>

      <?php $curval = (isset($perencanaan['ppm_currency'])) ? $perencanaan['ppm_currency'] : set_value("mata_uang_inp"); ?>

      <div class="form-group">
        <label class="col-sm-2 control-label">Mata Uang *</label>
        <div class="col-sm-3">
         <select required class="form-control select2" name="mata_uang_inp">
          <option value=""><?php echo lang('choose') ?></option>
          <?php foreach($default_currency as $key => $val){
            $selected = ($key == $curval) ? "selected" : ""; 
            ?>
            <option <?php echo $selected ?> value="<?php echo $key ?>"><?php echo $val ?></option>
            <?php } ?>
          </select>
        </div>
      </div>

      <?php $curval = (isset($perencanaan['ppm_pagu_anggaran'])) ? $perencanaan['ppm_pagu_anggaran'] : set_value("pagu_anggaran_inp"); ?>

      <div class="form-group">
        <label class="col-sm-2 control-label">Nilai Anggaran *</label>
        <div class="col-sm-4">
         <input type="text" class="form-control money" required name="pagu_anggaran_inp" value="<?php echo $curval ?>">
       </div>
     </div>


    <?php $curval = (isset($perencanaan['ppm_renc_pelaksanaan'])) ? substr($perencanaan["ppm_renc_pelaksanaan"], 4, 2) : set_value("rencana_pelaksanaan_kebutuhan_month_inp"); ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Rencana Pelaksanaan Pengadaan *</label>
      <div class="col-sm-3">

       <?php echo month_select_box('rencana_pelaksanaan_kebutuhan_month_inp',$curval) ?>

     </div>
     <div class="col-sm-2">
       <?php $curval = (isset($perencanaan['ppm_renc_pelaksanaan'])) ? substr($perencanaan["ppm_renc_pelaksanaan"], 0, 4) : set_value("rencana_pelaksanaan_kebutuhan_year_inp"); ?>
       <select class="form-control" name="rencana_pelaksanaan_kebutuhan_year_inp" value="<?php echo $curval ?>">
         <?php for ($i=date("Y"); $i <= date("Y")+5; $i++) { 
          $selected = ($i == $curval) ? "selected" : ""; 
          ?>
          <option <?php echo $selected ?>><?php echo $i ?></option>
          <?php } ?>
        </select>
      </div>

    </div>

     <?php $curval = (isset($perencanaan['ppm_renc_kebutuhan'])) ? substr($perencanaan["ppm_renc_kebutuhan"], 4, 2) : set_value("rencana_kebutuhan_month_inp"); ?>
     <div class="form-group">
      <label class="col-sm-2 control-label">Rencana Kebutuhan *</label>
      <div class="col-sm-3">

        <?php echo month_select_box('rencana_kebutuhan_month_inp',$curval) ?>

      </div>
      <div class="col-sm-2">
        <?php $curval = (isset($perencanaan['ppm_renc_kebutuhan'])) ? substr($perencanaan["ppm_renc_kebutuhan"], 0, 4) : set_value("rencana_kebutuhan_year_inp"); ?>
        <select class="form-control" name="rencana_kebutuhan_year_inp">
         <?php for ($i=date("Y"); $i <= date("Y")+5; $i++) { 
          $selected = ($i == $curval) ? "selected" : ""; 
          ?>
          <option <?php echo $selected ?>><?php echo $i ?></option>
          <?php } ?>
        </select>
      </div>
    </div>

    <?php /* $curval = (isset($perencanaan['ppm_swakelola'])) ? $perencanaan['ppm_swakelola'] : set_value("swakelola_inp"); ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">Swakelola *</label>
      <div class="col-sm-10">
        <div class="radio">
         <label>
           <?php $selected = (1 == $curval) ? "checked" : "";  ?>
           <input type="radio" <?php echo $selected ?> required name="swakelola_inp" value="1"> Ya
         </label>
         <label>
           <?php $selected = (0 == $curval) ? "checked" : "";  ?>
           <input type="radio" <?php echo $selected ?> required name="swakelola_inp" value="0"> Tidak
         </label>
       </div>
     </div>
   </div>*/ ?>

 </div>
</div>
</div>
</div>

<div class="row">
  <div class="col-lg-12">
    <center>
      <a class="btn btn-primary tambah_dok">Tambah Lampiran</a>
      <br/>
      <br/>
    </center>
  </div>

</div>

<div id="lampiran_container">

  <?php 
  $sisa = 5;
  if(!empty($document)){
    foreach ($document as $k => $v) {
      if($k == 0 || !empty($v['ppd_file_name'])){
      $show = "";
      $sisa--;
    } else {
      $show = "display:none;";
    }
      ?>

      <div class="row lampiran" style="<?php echo $show ?>" data-no="<?php echo $k ?>">
        <div class="col-lg-12">
          <div class="ibox float-e-margins">
            <div class="ibox-title">
              <h5>LAMPIRAN DOKUMEN #<?php echo $k ?></h5>
              <div class="ibox-tools">
                <?php if($k > 0){ ?>
                <a class="tutup" data-no="<?php echo $k ?>">
                  <i class="fa fa-times"></i>
                </a>
                <?php } ?>
                <a class="collapse-link">
                  <i class="fa fa-chevron-up"></i>
                </a>
              </div>
            </div>
            <div class="ibox-content">

              <?php $curval = (isset($v['ppd_category'])) ? $v['ppd_category'] :  set_value("doc_category_inp[$k]"); ?>

              <div class="form-group">
                <label class="col-sm-1 control-label"><?php echo lang('category') ?></label>
                <div class="col-sm-4">
                 <select class="form-control" name="doc_category_inp[<?php echo $k ?>]" value="<?php echo $curval ?>">
                   <option value=""><?php echo lang('choose') ?></option>
                   <?php foreach($doc_category as $key => $val){
                    $selected = ($val['ldc_name'] == $curval) ? "selected" : ""; 
                    ?>
                    <option <?php echo $selected ?> value="<?php echo $val['ldc_name'] ?>"><?php echo $val['ldc_name'] ?></option>
                    <?php } ?>
                  </select>
                </div>
                <?php $curval = (isset($v['ppd_file_name'])) ? $v['ppd_file_name'] :  set_value("doc_attachment_inp[$k]"); ?>

                <label class="col-sm-1 control-label"><?php echo lang('attachment') ?></label>
              <div class="col-sm-6">
                <div class="input-group">
                  <span class="input-group-btn">
                    <button type="button" data-id="doc_attachment_inp_<?php echo $k ?>" data-folder="<?php echo $dir ?>" data-preview="preview_file_<?php echo $k ?>" class="btn btn-primary upload">
                      <i class="fa fa-cloud-upload"></i>
                    </button> 
                    <button type="button" data-id="doc_attachment_inp_<?php echo $k ?>" data-folder="<?php echo $dir ?>" data-preview="preview_file_<?php echo $k ?>" class="btn btn-danger removefile">
                      <i class="fa fa-remove"></i>
                    </button> 
                  </span> 
                  <input readonly type="text" class="form-control" id="doc_attachment_inp_<?php echo $k ?>" name="doc_attachment_inp[<?php echo $k ?>]" value="<?php echo $curval ?>">
                  <span class="input-group-btn">
                    <button type="button" data-url="<?php echo site_url('log/download_attachment/procurement/'.$curval) ?>" class="btn btn-primary preview_upload" id="preview_file_<?php echo $k ?>">
                      <i class="fa fa-share"></i>
                    </button> 
                  </span> 
                </div>
                 <div class="col-sm-0" style="font-size: 11px">
                  <i>Max file 5 MB 
                  <br>
                    Tipe file : doc, docx, xls, xlsx, ppt, pptx, pdf, jpg, jpeg, PNG, Zip, rar, tgz, 7zip, tar
                  </i>
                </div>
              </div>
              </div>

              <?php $curval = (isset($v['ppd_description'])) ? $v['ppd_description'] :  set_value("doc_desc_inp[$k]"); ?>

              <div class="form-group">
                <label class="col-sm-1 control-label"><?php echo lang('description') ?></label>
                <div class="col-sm-11">
                 <textarea class="form-control" maxlength="1000" name="doc_desc_inp[<?php echo $k ?>]"><?php echo $curval ?></textarea>
               </div>
             </div>

            <?php $curval = (isset($v['ppd_id'])) ? $v['ppd_id'] :  ""; ?>
            <input type="hidden" name="doc_id_inp[<?php echo $k ?>]" value="<?php echo $curval ?>"/>

          </div>
        </div>
      </div>
    </div>

    <?php 
    } } ?>

    <?php for ($k = 5-$sisa; $k <= 5; $k++) { 
    $show = ($k == 0) ? "" : "display:none;";
    ?>

    <div class="row lampiran" style="<?php echo $show ?>" data-no="<?php echo $k ?>">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
          <div class="ibox-title">
            <h5>LAMPIRAN DOKUMEN #<?php echo $k ?></h5>
            <div class="ibox-tools">
              <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
              </a>
              <?php if($k > 0){ ?>
              <a class="tutup" data-no="<?php echo $k ?>">
                <i class="fa fa-times"></i>
              </a>
              <?php } ?>
            </div>
          </div>
          <div class="ibox-content">

            <?php $curval = set_value("doc_category_inp[$k]"); ?>
            <div class="form-group">
              <label class="col-sm-2 control-label"><?php echo lang('category') ?></label>
              <div class="col-sm-3">
               <select class="form-control" name="doc_category_inp[<?php echo $k ?>]" value="<?php echo $curval ?>">
                 <option value=""><?php echo lang('choose') ?></option>
                 <?php foreach($doc_category as $key => $val){
                  $selected = ($val['ldc_name'] == $curval) ? "selected" : ""; 
                  ?>
                  <option <?php echo $selected ?> value="<?php echo $val['ldc_name'] ?>"><?php echo $val['ldc_name'] ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <?php $curval = set_value("doc_desc_inp[$k]"); ?>
            <div class="form-group">
              <label class="col-sm-2 control-label"><?php echo lang('description') ?></label>
              <div class="col-sm-10">
               <textarea class="form-control" maxlength="1000" name="doc_desc_inp[<?php echo $k ?>]"><?php echo $curval ?></textarea>
             </div>
           </div>


           <?php $curval = set_value("doc_attachment_inp[$k]"); ?>
           <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('attachment') ?></label>
            <div class="col-sm-10">
              <div class="input-group">
                <span class="input-group-btn">
                  <button type="button" data-id="doc_attachment_inp_<?php echo $k ?>" data-folder="<?php echo $dir ?>" data-preview="preview_file_<?php echo $k ?>" class="btn btn-primary upload">
                     <i class="fa fa-cloud-upload"></i>
                  </button> 
                  <button type="button" data-id="doc_attachment_inp_<?php echo $k ?>" data-folder="<?php echo $dir ?>" data-preview="preview_file_<?php echo $k ?>" class="btn btn-remove removefile">
                     <i class="fa fa-remove"></i>
                  </button> 
                </span> 
                <input readonly type="text" class="form-control" id="doc_attachment_inp_<?php echo $k ?>" name="doc_attachment_inp[<?php echo $k ?>]" value="<?php echo $curval ?>">
                <span class="input-group-btn">
                  <button type="button" data-url="<?php echo site_url('log/download_attachment/procurement/'.$curval) ?>" class="btn btn-primary preview_upload" id="preview_file_<?php echo $k ?>">
                    <i class="fa fa-share"></i>
                  </button> 
                </span> 
              </div>
               <div class="col-sm-0" style="font-size: 11px">
                <i>Max file 5 MB 
                <br>
                  Tipe file : doc, docx, xls, xlsx, ppt, pptx, pdf, jpg, jpeg, PNG, Zip, rar, tgz, 7zip, tar
                </i>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

  <?php } ?>

  </div>

  <?php 
$i = 0;
include(VIEWPATH."/comment_workflow_v.php") ?>

  <?php echo buttonsubmit('procurement/perencanaan_pengadaan/daftar_perencanaan_pengadaan',lang('back'),lang('save')) ?>

</form>
</div>


<script type="text/javascript">
  $(document).ready(function(){

    $('#nama_proyek_form').hide();
    $('.jenis_rencana').click(function(){
      if ($(this).val() == 'rkp') {
           $('#nama_proyek_form').show();
           $('[name=nama_proyek]').attr('required','required');
      }else{
        $('#nama_proyek_form').hide();
        $('[name=nama_proyek]').removeAttr('required');

      }
    })

    $(document.body).on("change","#mata_anggaran_inp",function(){

      var id = $(this).val();
      var url = "<?php echo site_url('Procurement/data_mata_anggaran') ?>";
      $.ajax({
        url : url+"?id="+id,
        dataType:"json",
        success:function(data){
          var mydata = data.rows[0];
          $("#mata_anggaran_code_inp").val(mydata.code_cc);
          $("#mata_anggaran_label_inp").val(mydata.name_cc);
          $("#sub_mata_anggaran_code_inp").val(mydata.subcode_cc);
          $("#sub_mata_anggaran_label_inp").val(mydata.subname_cc);
        }
      });

    });

    $(".tambah_dok").click(function(){

      var total = parseInt($("div.lampiran:visible").length);
      var find = parseInt($("div.lampiran:hidden").attr("data-no"));

      if(total == 4){
        $(".tambah_dok").hide();
      }
      $(".lampiran[data-no='"+find+"']").show();
      return false;

    });

    $(".tutup").click(function(){

      $(".tambah_dok").show();
       var no = parseInt($(this).attr("data-no"));
      $(".lampiran[data-no='"+no+"']").hide();

      return false;

    });

  });
</script>
