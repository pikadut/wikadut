<script type="text/javascript">localStorage.setItem('dialogshow', true);</script>
<div class="row">
  <div class="col-lg-12">

    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>DETAIL UPDATE MILESTONE</h5>

      </div>

      <div class="ibox-content">

        <?php if($act != "view"){ ?>

        <form class="form-horizontal" id="milestone_progress_form">

         <?php $curval = ""; ?>
         <div class="form-group">
          <label class="col-sm-2 control-label">Progress (%)</label>
          <div class="col-sm-2">
            <input class="form-control money" name="progress_milestone_inp" id="progress_milestone_inp" maxlength="3">
          </div>
        </div>

        <?php $curval = date(DEFAULT_FORMAT_DATETIME_DB); ?>
        <div class="form-group">
          <label class="col-sm-2 control-label">Tanggal Progress</label>
          <div class="col-sm-3">
            <div class="input-group date">
              <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
              <input type="text" id="tanggal_milestone_inp" class="form-control datetimepicker" name="tgl_progress_inp" value="<?php echo $curval ?>">
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Deskripsi</label>
          <div class="col-sm-8">
            <textarea name="deskripsi_milestone_inp" maxlength="1000" required class="form-control"></textarea>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label">Lampiran</label>
          <div class="col-sm-5">
            <div class="input-group">
              <span class="input-group-btn">
                <button type="button" data-id="milestone_file_inp" data-folder="<?php echo "contract/jaminan" ?>" data-preview="preview_file" class="btn btn-primary upload">...</button> 
              </span> 
              <input readonly type="text" class="form-control" id="milestone_file_inp" name="milestone_file_inp" value="">
              <span class="input-group-btn">
                <button type="button" data-url="<?php echo INTRANET_UPLOAD_FOLDER."/contract/jaminan/$curval" ?>" class="btn btn-primary preview_upload" id="preview_file">Lihat</button> 
              </span> 
            </div>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label"> </label>
          <div class="col-sm-10">
            <input type="hidden" name="milestone_id" value="<?php echo $milestone_id ?>">
            <a href="#" class="btn btn-primary" id="milestone_progress_btn">Simpan</a>
          </div>
        </div>

      </form>

      <br/>

      <?php } ?>

      <table id="milestone_progress_table" class="table table-bordered table-striped"></table>

    </div>
  </div>


  <div class="ibox float-e-margins">
    <div class="ibox-title">
      <h5>KOMENTAR PROGRESS MILESTONE</h5>

    </div>

    <div class="ibox-content">

      <?php if($act != "view"){ ?>

      <form class="form-horizontal" id="milestone_comment_form">

        <div class="form-group">
          <label class="col-sm-2 control-label">Komentar</label>
          <div class="col-sm-8">
            <textarea name="komentar_milestone_inp" maxlength="1000" required class="form-control"></textarea>
          </div>
        </div>

        <div class="form-group">
          <label class="col-sm-2 control-label"> </label>
          <div class="col-sm-10">
            <input type="hidden" name="milestone_id" value="<?php echo $milestone_id ?>">
            <a href="#" class="btn btn-primary" id="milestone_comment_btn">Simpan</a>
          </div>
        </div>

      </form>

      <br/>

      <?php } ?>

      <table id="milestone_comment_table" class="table table-bordered table-striped"></table>

    </div>
  </div>


  <hr/>
  <center>
    <button type="button" class="btn btn-primary" data-dismiss="modal">Kembali</button>
  </center>

</div>
</div>


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

  toastr.options = {
    closeButton: true,
    progressBar: false,
    showEasing: 'swing',
    hideEasing: 'linear',
    showMethod: 'fadeIn',
    hideMethod: 'fadeOut',
    newestOnTop: false,
    timeOut: 20000,
    preventDuplicates: true,
  };

</script>

<script type="text/javascript">

  var $milestone_progress_table = $('#milestone_progress_table'),
  $milestone_comment_table = $('#milestone_comment_table')
  selections = [];


  $("input.money").autoNumeric({
    aSep: '.',
    aDec: ',', 
    aSign: ''
  });
  $(".datetimepicker").datetimepicker({format:"YYYY-MM-DD HH:mm:ss"});



</script>

<script type="text/javascript">

  $(function () {

    $milestone_progress_table.bootstrapTable({

      url: "<?php echo site_url('contract/data_progress_milestone/'.$milestone_id) ?>",
     
      cookieIdTable:"milestone_progress",
      
      idField:"progress_id",

      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      
      columns: [
      {
        field: 'progress_date',
        title: 'Tanggal & Waktu',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'20%'
      },
      {
        field: 'percentage',
        title: 'Progress (%)',
        sortable:true,
        order:true,
        searchable:true,
        align: 'right',
        valign: 'middle',
        width:'15%'
      },
      {
        field: 'description',
        title: 'Deskripsi',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'65%'
      },
      {
        field: 'attachment',
        title: 'Lampiran',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'65%'
      },
      ]

    });

setTimeout(function () {
  $milestone_progress_table.bootstrapTable('resetView');
}, 200);

$("#milestone_progress_btn").on("click",function(){
  localStorage.setItem('dialogshow', true);
  var data = $("#milestone_progress_form").serialize();
  $.ajax({
    url:"<?php echo site_url('contract/save_milestone_progress') ?>",
    data:data,
    type:"post",
    dataType:"json",
    success:function(x){
      if(x.message === ""){
        $("#milestone_progress_form input:text,#milestone_progress_form textarea").each(function(){
          $(this).val("");
        });
        toastr.success("Berhasil update progress milestone", "Success");
        $("#milestone_progress_table").bootstrapTable('refresh');
        
      } else {
        toastr.error(x.message, "Error");
      }
    }
  });
  return false;
}); 

});

</script>

<script type="text/javascript">

  $(function () {

    $milestone_comment_table.bootstrapTable({

      url: "<?php echo site_url('contract/data_comment_milestone/'.$milestone_id) ?>",
     
      cookieIdTable:"milestone_comment",
      
      idField:"comment_id",
      
      <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
      
      columns: [
      {
        field: 'comment_date',
        title: 'Tanggal & Waktu',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'20%'
      },
      {
        field: 'comment_name',
        title: 'User',
        sortable:true,
        order:true,
        searchable:true,
        align: 'center',
        valign: 'middle',
        width:'20%'
      },
      {
        field: 'comments',
        title: 'Komentar',
        sortable:true,
        order:true,
        searchable:true,
        align: 'left',
        valign: 'middle',
        width:'60%'
      },
      
      ]

    });

setTimeout(function () {
  $milestone_comment_table.bootstrapTable('resetView');
}, 200);

$("#milestone_comment_btn").on("click",function(){
  var data = $("#milestone_comment_form").serialize();
  $.ajax({
    url:"<?php echo site_url('contract/save_milestone_comment') ?>",
    data:data,
    type:"post",
    dataType:"json",
    success:function(x){
      if(x.message === ""){
        $("#milestone_comment_form input:text,#milestone_comment_form textarea").each(function(){
          $(this).val("");
        });
        $("#milestone_comment_table").bootstrapTable('refresh');
        toastr.success("Berhasil komentar milestone", "Success");
      } else {
        toastr.error(x.message, "Error");
      }
    }
  });
  return false;
}); 

});

</script>