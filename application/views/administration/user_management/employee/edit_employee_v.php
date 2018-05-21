<div class="wrapper wrapper-content">
  <form method="post" action="<?php echo site_url($controller_name."/submit_edit_employee");?>" class="form-horizontal">

    <input type="hidden" name="id" value="<?php echo $id ?>">

    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
          <div class="ibox-title">
            <h5>Ubah Employee</h5>
            <div class="ibox-tools">
              <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
              </a>
            </div>
          </div>

          <div class="ibox-content">


            <?php $curval = $data['npp'];?>
            <div class="form-group">
              <label class="col-sm-2 control-label">NPP</label>
              <div class="col-sm-10">
                <input type="text" class="form-control" id="npp_employee_inp" maxlength="10" name="npp_employee_inp" value="<?php echo $curval ?>">
              </div>
            </div>

            <?php $curval = $data["adm_salutation_id"]; ?>
            <div class="form-group">
              <label class="col-sm-2 control-label">Salutation</label>
              <div class="col-sm-2">
                <select required class="form-control" name="salutation_employee_inp">
                  <option value="">Pilih</option>
                  <?php 
                  foreach($salutation as $key => $val){
                    $selected = ($val['adm_salutation_id'] == $curval) ? "selected" : ""; 
                    ?>
                    <option <?php echo $selected ?> value="<?php echo $val['adm_salutation_id'] ?>"><?php echo $val['adm_salutation_name'] ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <?php $curval = $data["firstname"]; ?>
              <div class="form-group">
                <label class="col-sm-2 control-label">Nama Depan</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" required name="firstname_employee_inp" value="<?php echo $curval ?>">
                </div>
              </div>

              <?php $curval = $data["lastname"]; ?>
              <div class="form-group">
                <label class="col-sm-2 control-label">Nama Belakang</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="lastname_employee_inp" value="<?php echo $curval ?>">
                </div>
              </div>

              <?php $curval = $data["phone"]; ?>
              <div class="form-group">
                <label class="col-sm-2 control-label">Telepon</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" name="phone_employee_inp" value="<?php echo $curval ?>">
                </div>
              </div>

              <?php $curval = $data['employee_type_id']; ?>
              <div class="form-group">
                <label class="col-sm-2 control-label">Tipe</label>
                <div class="col-sm-3">
                 <select required class="form-control" name="type_employee_inp">
                  <option value="">Pilih</option>
                  <?php 
                  foreach($type as $key => $val){
                    $selected = ($val['employee_type_id'] == $curval) ? "selected" : ""; 
                    ?>
                    <option <?php echo $selected ?> value="<?php echo $val['employee_type_id'] ?>"><?php echo $val['employee_type_name'] ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <?php $curval = $data["status"]; ?>
              <div class="form-group">
                <label class="col-sm-2 control-label">Status</label>
                <div class="col-sm-3">
                  <select required class="form-control" name="status_inp">
                    <?php $selected = ($curval == 1) ? "selected" : ""; ?>
                    <option <?php echo $selected ?> value="1">Aktif</option>
                    <?php $selected = ($curval == 0) ? "selected" : ""; ?>
                    <option <?php echo $selected ?> value="0">Nonaktif</option>
                  </select>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>

      <br>

      <div class="row">
        <div class="col-lg-12">
          <div class="ibox float-e-margins">
            <div class="ibox-title">
              <h5>Company Information</h5>
              <div class="ibox-tools">
                <a class="collapse-link">
                  <i class="fa fa-chevron-up"></i>
                </a>
              </div>
            </div>
            <div class="ibox-content">

              <?php $curval = $data["email"]; ?>
              <div class="form-group">
                <label class="col-sm-2 control-label">Email Address</label>
                <div class="col-sm-10">
                  <input type="email" class="form-control" id="email_employee_inp" name="email_employee_inp" value="<?php echo $curval ?>">
                </div>
              </div>

              <?php $curval = $data["officeextension"]; ?>
              <div class="form-group">
                <label class="col-sm-2 control-label">Office Extention</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="offc_ext_employee_inp" name="offc_ext_employee_inp" value="<?php echo $curval ?>">
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>


    <div class="row">
      <div class="col-lg-12">
        <div class="ibox float-e-margins">
          <div class="ibox-title">
            <h5>Job Position</h5>
            <div class="ibox-tools">
              <a class="collapse-link">
                <i class="fa fa-chevron-up"></i>
              </a>
            </div>
          </div>        

          <div class="ibox-content">

            <div class="table-responsive">
              <a class="btn btn-primary" href="<?php echo site_url('administration/user_management/employee/add_job_post/'.$id) ?>" role="button">Tambah</a>               

              <table id="job_post" class="table table-bordered table-striped"></table>

            </div>

          </div>
        </div>


      </div>
    </div>

      <div class="row">
        <div class="col-md-12">
          <div>
            <?php echo buttonsubmit('administration/user_management/employee',lang('back'),lang('save')) ?>
          </div>
        </div>
      </div>
       </div>
    </form>


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

      var mydata = $.getCustomJSON("<?php echo site_url('administration') ?>/"+url);

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

    function operateFormatter(value, row, index) {
      var link = "<?php echo site_url('administration/user_management/employee') ?>";
      return [
      '<a class="btn btn-danger btn-xs action" onclick="return confirm(\'Anda yakin ingin menghapus data?\')" href="'+link+'/hapus_job_post/'+value+'">',
      'Hapus',
      '</a>  ',
      ].join('');
    }

    function totalTextFormatter(data) {
      return 'Total';
    }
    function totalNameFormatter(data) {
      return data.length;
    }
    function totalPriceFormatter(data) {
      var total = 0;
      $.each(data, function (i, row) {
        total += +(row.price.substring(1));
      });
      return '$' + total;
    }

  </script>

  <script type="text/javascript">

    var $job_post = $('#job_post'),
    selections = [];

  </script>

  <script type="text/javascript">

    $(function () {

      $job_post.bootstrapTable({

        url: "<?php echo site_url('administration/data_job_post/'.$id) ?>",
        cookieIdTable:"adm_employee_pos",
        idField:"employee_pos_id",
        <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
        columns: [
        {
          field: 'employee_pos_id',
          title: '<?php echo DEFAULT_BOOTSTRAP_TABLE_FIRST_COLUMN_NAME ?>',
          align: 'center',
          formatter: operateFormatter,
        },
        {
          field: 'pos_name',
          title: 'Posisi',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'dept_name',
          title: 'Departemen',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'district_name',
          title: 'Kantor',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'is_active',
          title: 'Aktif ',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'is_main_job',
          title: 'Posisi Utama',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle'
        },
        ]

      });
      setTimeout(function () {
        $job_post.bootstrapTable('resetView');
      }, 200);

      $job_post.on('expand-row.bs.table', function (e, index, row, $detail) {
        $detail.html(detailFormatter(index,row,"alias_employee"));
      });

    });

  </script>