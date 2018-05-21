<?php /*
<div class="row">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>Form Tagihan</h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>

        </div>
      </div>
      <div class="ibox-content">   

       <?php $curval = $kontrak['vendor_name']; ?>
       <div class="form-group">
        <label class="col-sm-2 control-label">Vendor</label>
        <div class="col-sm-4">
         <p class="form-control-static"><?php echo $curval ?></p>
       </div>
     </div>

     <?php $curval = date(DEFAULT_FORMAT_DATETIME_DB); ?>
     <div class="form-group">
      <label class="col-sm-2 control-label">Tanggal Penagihan</label>
      <div class="col-sm-3">
        <div class="input-group date">
          <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
          <input type="text" id="tgl_penagihan_inp" class="form-control datetimepicker" name="tgl_penagihan_inp" value="<?php echo $curval ?>">
        </div>
      </div>
    </div>

    <?php $curval = ""; ?>
    <div class="form-group">
      <label class="col-sm-2 control-label">No. Penagihan</label>
      <div class="col-sm-3">
       <input type="text" class="form-control" maxlength="40" name="no_penagihan_inp" name="no_penagihan_inp" id="no_penagihan_inp" value="<?php echo $curval ?>">
     </div>
   </div>

   <?php $curval = ""; ?>
   <div class="form-group">
    <label class="col-sm-2 control-label">Rekening Bank</label>
    <div class="col-sm-6">
     <input type="text" class="form-control" maxlength="50" name="rek_bank_inp" id="rek_bank_inp" value="<?php echo $curval ?>">
   </div>
 </div>

 <hr/>

 <div class="table-responsive">

 <?php if($kontrak['contract_type'] == "LUMPSUM"){ ?>

 <table id="milestone_done" class="table table-bordered table-striped"></table>

<script type="text/javascript">

  var $milestone_done = $('#milestone_done'),
  selections = [];

  $(function () {

    $milestone_done.bootstrapTable({

      url: "<?php echo site_url('contract/data_milestone/done') ?>",
      
      selectItemName:"milestone_done[]",

      cookieIdTable:"milestone_done",
      
      idField:"milestone_id",
      
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>

      columns: [
      {
        field: 'checkbox',
        title:'#',
        checkbox:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'description',
        title: 'Deskripsi Milestone',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      {
        field: 'target_date',
        title: 'Tanggal Target',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'percentage',
        title: 'Bobot (%)',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'total',
        title: 'Nominal',
        sortable:true,
        order:true,
        searchable:true,
        align: 'right',
        valign: 'middle'
      },
      ]

    });
    setTimeout(function () {
      $milestone_done.bootstrapTable('resetView');
    }, 200);

    $milestone_done.on('expand-row.bs.table', function (e, index, row, $detail) {
      $detail.html(detailFormatter(index,row,"alias_vendor"));
    });

    $milestone_done.on('check.bs.table  check-all.bs.table', function () {

      selections = getIdSelections();
      var param = "";
      $.each(selections,function(i,val){
        param += val+"=1&";
      });
      $.ajax({
        url:"<?php echo site_url('contract/selection/selection_milestone') ?>",
        data:param,
        type:"get"
      });

    });

    $milestone_done.on('uncheck.bs.table uncheck-all.bs.table', function () {

      selections = getIdSelections();

      var param = "";
      $.each(selections,function(i,val){
        param += val+"=0&";
      });
      $.ajax({
        url:"<?php echo site_url('contract/selection/selection_milestone') ?>",
        data:param,
        type:"get"
      });
    });

    $milestone_done.on('expand-row.bs.table', function (e, index, row, $detail) {
      $detail.html(detailFormatter(index,row));

    });

    function getIdSelections() {
  return $.map($milestone_done.bootstrapTable('getSelections'), function (row) {
    return row.milestone_id
  });
}

});
   
</script>

<?php } else { ?>

 <table id="wo_done" class="table table-bordered table-striped"></table>

<script type="text/javascript">

  var $wo_done = $('#wo_done'),
  selections = [];

  $(function () {

    $wo_done.bootstrapTable({

      url: "<?php echo site_url('contract/data_work_order/done') ?>",
      
      selectItemName:"wo_done[]",

      cookieIdTable:"wo_done",
      
      idField:"po_id",
      
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>

      columns: [
      {
        field: 'checkbox',
        title:'#',
        checkbox:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'description',
        title: 'Deskripsi Milestone',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle'
      },
      {
        field: 'target_date',
        title: 'Tanggal Target',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'percentage',
        title: 'Bobot (%)',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle'
      },
      {
        field: 'total',
        title: 'Nominal',
        sortable:true,
        order:true,
        searchable:true,
        align: 'right',
        valign: 'middle'
      },
      ]

    });
    setTimeout(function () {
      $wo_done.bootstrapTable('resetView');
    }, 200);

    $wo_done.on('expand-row.bs.table', function (e, index, row, $detail) {
      $detail.html(detailFormatter(index,row,"alias_vendor"));
    });

    $wo_done.on('check.bs.table  check-all.bs.table', function () {

      selections = getIdSelections();
      var param = "";
      $.each(selections,function(i,val){
        param += val+"=1&";
      });
      $.ajax({
        url:"<?php echo site_url('contract/selection/selection_wo') ?>",
        data:param,
        type:"get"
      });

    });
    $wo_done.on('uncheck.bs.table uncheck-all.bs.table', function () {

      selections = getIdSelections();

      var param = "";
      $.each(selections,function(i,val){
        param += val+"=0&";
      });
      $.ajax({
        url:"<?php echo site_url('contract/selection/selection_wo') ?>",
        data:param,
        type:"get"
      });
    });
    $wo_done.on('expand-row.bs.table', function (e, index, row, $detail) {
      $detail.html(detailFormatter(index,row));

    });

});

</script>

<?php } ?>

</div>

<div class="row">
  <div class="col-lg-12">
    <center>
      <a class="btn btn-primary tambah_dok_lampiran">Tambah Lampiran</a>
      <br/>
      <br/>
    </center>
  </div>
</div>

<div id="lampiran_container">

  <?php 
  $sisa = 5;
  if(isset($document_tagihan) && !empty($document_tagihan)){
    foreach ($document_tagihan as $k => $v) {
      $show = ($k == 0 || !empty($v['filename'])) ? "" : "display:none;";
      ?>

      <div class="row lampiran_tagihan" style="<?php echo $show ?>" data-no="<?php echo $k ?>">
        <div class="col-lg-12">
          <div class="ibox float-e-margins">
            <div class="ibox-title">
              <h5>DOKUMEN #<?php echo $k ?></h5>
              <div class="ibox-tools">

                <a class="tutup" data-no="<?php echo $k ?>">
                  <i class="fa fa-times"></i>
                </a>

                <a class="collapse-link">
                  <i class="fa fa-chevron-up"></i>
                </a>
              </div>
            </div>
            <div class="ibox-content">

              <?php $curval = (isset($v['category'])) ? $v['category'] :  set_value("doc_category_tagihan_inp[$k]"); ?>

              <div class="form-group">
                <label class="col-sm-2 control-label"><?php echo lang('category') ?></label>
                <div class="col-sm-4">
                 <select class="form-control" name="doc_category_tagihan_inp[<?php echo $k ?>]" >
                   <option value=""><?php echo lang('choose') ?></option>
                   <?php foreach($doc_category as $key => $val){
                    $selected = ($val['cdt_name'] == $curval) ? "selected" : ""; 
                    ?>
                    <option <?php echo $selected ?> value="<?php echo $val['cdt_name'] ?>"><?php echo $val['cdt_name'] ?></option>
                    <?php } ?>
                  </select>
                </div>

                <?php $curval = (isset($v['publish'])) ? $v['publish'] :  set_value("doc_vendor_tagihan_inp[$k]"); ?>
                <label class="col-sm-2 control-label">Kirim ke Vendor</label>
                <div class="col-sm-2">
                 <select class="form-control" name="doc_vendor_tagihan_inp[<?php echo $k ?>]" >
                   <?php $selected = (0 == $curval) ? "selected" : "";  ?>
                   <option <?php echo $selected ?> value="0">Tidak</option>
                   <?php $selected = (1 == $curval) ? "selected" : "";  ?>
                   <option <?php echo $selected ?> value="1">Ya</option>
                 </select>
               </div>
             </div>

             <?php $curval = (isset($v['description'])) ? $v['description'] :  set_value("doc_desc_tagihan_inp[$k]"); ?>

             <div class="form-group">
              <label class="col-sm-2 control-label"><?php echo lang('description') ?></label>
              <div class="col-sm-10">
               <textarea class="form-control" maxlength="1000" name="doc_desc_tagihan_inp[<?php echo $k ?>]"><?php echo $curval ?></textarea>
             </div>
           </div>

           <?php $curval = (isset($v['filename'])) ? $v['filename'] :  set_value("doc_attachment_tagihan_inp[$k]"); ?>

           <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('attachment') ?></label>
            <div class="col-sm-10">
              <div class="input-group">
                <span class="input-group-btn">
                  <button type="button" data-id="doc_attachment_tagihan_inp_<?php echo $k ?>" data-folder="<?php echo "contract/tagihan" ?>" data-preview="preview_file_<?php echo $k ?>" class="btn btn-primary upload">
                    <i class="fa fa-cloud-upload"></i>
                  </button> 
                  <button type="button" data-id="doc_attachment_tagihan_inp_<?php echo $k ?>" data-folder="<?php echo "contract/tagihan" ?>" data-preview="preview_file_<?php echo $k ?>" class="btn btn-danger removefile">
                    <i class="fa fa-remove"></i>
                  </button> 
                </span> 
                <input readonly type="text" class="form-control" id="doc_attachment_tagihan_inp_<?php echo $k ?>" name="doc_attachment_tagihan_inp[<?php echo $k ?>]" value="<?php echo $curval ?>">
                <span class="input-group-btn">
                  <button type="button" data-url="<?php echo INTRANET_UPLOAD_FOLDER."/contract/tagihan/$curval" ?>" class="btn btn-primary preview_upload" id="preview_file_<?php echo $k ?>">
                    <i class="fa fa-share"></i>
                  </button> 
                </span> 
              </div>
            </div>
          </div>

          <?php $curval = (isset($v['doc_id'])) ? $v['doc_id'] :  ""; ?>
          <input type="hidden" name="doc_id_tagihan_inp[<?php echo $k ?>]" value="<?php echo $curval ?>"/>

        </div>
      </div>
    </div>
  </div>

  <?php $sisa--;} } ?>

  <?php for ($k = 5-$sisa; $k <= 5; $k++) { 
    $show = ($k == 0) ? "" : "display:none;";
    ?>

    <div class="row lampiran_tagihan" style="<?php echo $show ?>" data-no="<?php echo $k ?>">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
          <div class="ibox-title">
            <h5>DOKUMEN #<?php echo $k ?></h5>
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

          <?php $curval = set_value("doc_category_tagihan_inp[$k]"); ?>
          <div class="form-group">
            <label class="col-sm-2 control-label"><?php echo lang('category') ?></label>
            <div class="col-sm-4">
             <select class="form-control" name="doc_category_tagihan_inp[<?php echo $k ?>]">
               <option value=""><?php echo lang('choose') ?></option>
               <?php foreach($doc_category as $key => $val){
                $selected = ($val['cdt_name'] == $curval) ? "selected" : ""; 
                ?>
                <option <?php echo $selected ?> value="<?php echo $val['cdt_name'] ?>"><?php echo $val['cdt_name'] ?></option>
                <?php } ?>
              </select>
            </div>
            <?php $curval = set_value("doc_vendor_tagihan_inp[$k]"); ?>
            <label class="col-sm-2 control-label">Kirim ke Vendor</label>
            <div class="col-sm-2">
             <select class="form-control" name="doc_vendor_tagihan_inp[<?php echo $k ?>]" >
               <?php $selected = (0 == $curval) ? "selected" : "";  ?>
               <option <?php echo $selected ?> value="0">Tidak</option>
               <?php $selected = (1 == $curval) ? "selected" : "";  ?>
               <option <?php echo $selected ?> value="1">Ya</option>
             </select>
           </div>
         </div>

         <?php $curval = set_value("doc_desc_tagihan_inp[$k]"); ?>
         <div class="form-group">
          <label class="col-sm-2 control-label"><?php echo lang('description') ?></label>
          <div class="col-sm-10">
           <textarea class="form-control" maxlength="1000" name="doc_desc_tagihan_inp[<?php echo $k ?>]"><?php echo $curval ?></textarea>
         </div>
       </div>


       <?php $curval = set_value("doc_attachment_tagihan_inp[$k]"); ?>
       <div class="form-group">
        <label class="col-sm-2 control-label"><?php echo lang('attachment') ?></label>
        <div class="col-sm-10">
          <div class="input-group">
            <span class="input-group-btn">
              <button type="button" data-id="doc_attachment_tagihan_inp_<?php echo $k ?>" data-folder="<?php echo "contract/tagihan" ?>" data-preview="preview_file_<?php echo $k ?>" class="btn btn-primary upload">
                <i class="fa fa-cloud-upload"></i>
              </button> 
              <button type="button" data-id="doc_attachment_tagihan_inp_<?php echo $k ?>" data-folder="<?php echo "contract/tagihan" ?>" data-preview="preview_file_<?php echo $k ?>" class="btn btn-danger removefile">
                <i class="fa fa-remove"></i>
              </button> 
            </span> 
            <input readonly type="text" class="form-control" id="doc_attachment_tagihan_inp_<?php echo $k ?>" name="doc_attachment_tagihan_inp[<?php echo $k ?>]" value="<?php echo $curval ?>">
            <span class="input-group-btn">
              <button type="button" data-url="<?php echo INTRANET_UPLOAD_FOLDER."/contract/tagihan/$curval" ?>" class="btn btn-primary preview_upload" id="preview_file_<?php echo $k ?>">
                <i class="fa fa-share"></i>
              </button> 
            </span> 
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
</div>

<?php } ?>

</div>

<div class="row">
  <div class="col-lg-12">
    <center>
      <a class="btn btn-success btn-lg" id="add_invoice_btn">Tambah Tagihan</a>
    </center>
  </div>
</div>

</div>
</div>
</div>
</div>


<script type="text/javascript">


  $(document).ready(function(){

    $(".tambah_dok_lampiran").click(function(){

      var total = parseInt($("div.lampiran_tagihan:visible").length);
      var find = parseInt($("div.lampiran_tagihan:hidden").attr("data-no"));

      if(total == 4){
        $(".tambah_dok_lampiran").hide();
      }
      $("div.lampiran_tagihan[data-no='"+find+"']").show();
      return false;

    });

    $(".tutup").click(function(){

      $(".tambah_dok_lampiran").show();
      var no = parseInt($(this).attr("data-no"));
      $("div.lampiran_tagihan[data-no='"+no+"']").hide();

      return false;

    });

  });
</script>

<script type="text/javascript">

  jQuery.extend({
    getCustomJSON: function(url) {
      var result = null;
      $.ajax({
        url: url,
        type: 'get',
        dataType: 'json',
        async: false,
        success: function(data) {
          result = data;
        }
      });
      return result;
    }
  });

  function detailFormatter(index, row, url) {

    var mydata = $.getCustomJSON("<?php echo site_url('contract') ?>/"+url);

    var html = [];
    $.each(row, function (key, value) {
     var data = $.grep(mydata, function(e){ 
       return e.field == key; 
     });

     if(typeof data[0] !== 'undefined'){

       html.push('<p><b>' + data[0].alias + ':</b> ' + value + '</p>');
     }
   });

    return html.join('');

  }


    $("#add_invoice_btn").on("click",function(){

      if(confirm("Apakah anda yakin membuat tagihan? Tagihan yang sudah dibuat tidak dapat diubah")){

        var data = $("form.ajaxform").serialize();

        $.ajax({
          url:"<?php echo site_url('contract/save_invoice') ?>",
          data:data,
          type:"post",
          dataType:"json",
          success:function(x){

            if(x.message === ""){

              $(".ajaxform input:text,.ajaxform textarea").each(function(){
                $(this).val("");
              });

              toastr.success("Berhasil membuat tagihan", "Success");
              $("#milestone_done").bootstrapTable('refresh');
              $("#tagihan_list").bootstrapTable('refresh');
            } else {
              toastr.error(x.message, "Error");
            }

          }
        });

      }

      return false;

    }); 

</script>

*/ ?>