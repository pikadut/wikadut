<div class="row">
  <div class="col-lg-12">

    <form class="form-horizontal" id="eval_tech_form">

      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>PERBANDINGAN PENAWARAN TEKNIS</h5>

        </div>

        <div class="ibox-content">

          <div class="row">

            <div class="col-xs-5">
              <p>Template Evaluasi : <strong><?php echo $evaltemp['evt_name'] ?></strong></p>
            </div>

            <div class="col-xs-2">
              <p>Bobot Teknis : <strong><?php echo $evaltemp['evt_tech_weight'] ?></strong></p>
            </div>

            <div class="col-xs-2">
              <p>Passing Grade : <strong><?php echo $evaltemp['evt_passing_grade'] ?></strong></p>
            </div>

          </div>
          <br>
          <div class="table-responsive">
            <table class="table table-bordered">
              <thead>
                <tr>
                  <th rowspan="2">No</th>
                  <th rowspan="2">Item</th>
                  <th rowspan="2">Bobot</th>
                  <?php foreach ($vendor as $key => $value) { ?>
                  <th colspan="3"><?php echo $value['vendor_name'] ?></th>
                  <?php } ?>
                </tr>
                <tr>
                  <?php foreach ($vendor as $key => $value) {
                   ?>
                   <th>Deskripsi</th>
                   <th>Nilai</th>
                   <th>Lampiran</th>
                   <?php } ?>
                 </tr>
               </thead>

               <tbody>

                <?php 
                $n = 1;
                foreach ($teknis as $key => $value) { ?>

                <tr>
                  <td><?php echo $n ?></td>
                  <td><?php echo $value['item'] ?></td>
                  <td class="text-center"><?php echo $value['weight'] ?>%</td>
                  <?php foreach ($value['child'] as $k => $v) { ?>
                  <td><?php echo $v['desc'] ?></td>
                  <td class="text-right">
                    <?php if($act == "edit"){ ?>
                    <input class="form-control money" style="width:72px" data-v-min="0" data-v-max="100" maxlength="5" name="eval_tech[<?php echo $v['id'] ?>]" value="<?php echo $v['value'] ?>">
                    <?php } else { ?>
                    <?php echo $v['value'] ?>
                    <?php } ?>
                  </td>
                  <td>
                    <?php if(!empty($v['file'])){ ?>
                    <!-- <a target="_blank" href="<?php //echo site_url('log/download_attachment_extranet/penawaran/'.$v['vendor_id'].'/'.$v['file']); ?>">Download<a/> -->
                      <!-- haqim -->
                      <a target="_blank" href="<?php echo site_url('log/download_attachment_extranet/teknis/'.$v['vendor_id'].'/'.$v['file']); ?>">Download<a/>
                      <!-- end -->
                      <?php } ?>
                    </td>
                    <?php } ?>
                  </tr>

                  <?php $n++; } ?>

                </tbody>
              </table> 
            </div>
          </div>
        </div>

        <div class="ibox float-e-margins">
          <div class="ibox-title">
            <h5>NILAI TEKNIS</h5>

          </div>

          <div class="ibox-content">
            <div class="table-responsive">  
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Nama Vendor</th>
                    <th>Nilai Teknis</th>
                    <th>Catatan</th>
                  </tr>
                </thead>

                <tbody>
                  <?php foreach ($nilai as $key => $value) { ?>
                  <tr>
                    <td><?php echo $key+1 ?></td>
                    <td><?php echo $value['vendor_name'] ?></td>
                    <td class="vendor_tech_value text-right" data-id="<?php echo $value['ptv_vendor_code'] ?>"><?php echo $value['pte_technical_value'] ?></td>
                    <td>
                      <?php if($act == "edit"){ ?>
                      <textarea class="form-control" name="eval_note[<?php echo $value['pte_id'] ?>]"><?php echo $value['pte_technical_remark'] ?></textarea>
                      <?php } else { ?>
                      <?php echo $value['pte_technical_remark'] ?>
                      <?php } ?>
                    </td>
                  </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
          <?php if($act == "edit"){ ?>
          <center>
            <a href="#" class="btn btn-primary" id="calculate_tech">Hitung Nilai Teknis</a>
          </center>
          <?php } ?>
        </div>

      </form>

      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>KOMENTAR EVALUASI TEKNIS</h5>

        </div>

        <div class="ibox-content">

          <?php if($act == "edit"){ ?>

          <form class="form-horizontal" id="eval_com_form">

            <div class="form-group">
              <label class="col-sm-2 control-label">Vendor</label>
              <div class="col-sm-5">
                <select class="form-control select2 vendor" style="width:100%;" name="vendor_eval_inp">
                  <?php foreach ($nilai as $kx => $vx) { ?>
                  <option value="<?php echo $vx['ptv_vendor_code'] ?>"><?php echo $vx['vendor_name'] ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label"><?php echo lang('comment') ?> *</label>
              <div class="col-sm-8">
                <textarea name="comment_eval_inp" id="comment_eval_inp" maxlength="1000" required class="form-control"></textarea>
              </div>
            </div>

            <div class="form-group">
              <label class="col-sm-2 control-label"> </label>
              <div class="col-sm-10">
                <input type="hidden" name="type_eval_inp" value="T">
                <a href="#" class="btn btn-primary" id="eval_com_btn">Simpan</a>
              </div>
            </div>

          </form>

          <br/>

          <?php } ?>

          <table id="eval_com_table" class="table table-bordered table-striped"></table>

        </div>
      </div>

      <hr/>
      <center>
        <button type="button" class="btn btn-primary reloadeval">Kembali</button>
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

  </script>

  <script type="text/javascript">

    var $eval_com_table = $('#eval_com_table'),
    selections = [];

  </script>

  <script type="text/javascript">

    $(function () {

      $eval_com_table.bootstrapTable({

        url: "<?php echo site_url('Procurement/data_eval_com') ?>/T",
        
        cookieIdTable:"eval_com",
        
        idField:"pec_id",
        
        <?php echo DEFAULT_BOOTSTRAP_TABLE_CONFIG ?>
        
        columns: [
        {
          field: 'pec_datetime',
          title: 'Tanggal & Waktu',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle'
        },
        {
          field: 'pec_name',
          title: 'Nama',
          sortable:true,
          order:true,
          searchable:true,
          align: 'left',
          valign: 'middle'
        },
        {
          field: 'pec_vendor_name',
          title: 'Nama Vendor',
          sortable:true,
          order:true,
          searchable:true,
          align: 'left',
          valign: 'middle'
        },
        
        {
          field: 'pec_comment',
          title: 'Komentar',
          sortable:true,
          order:true,
          searchable:true,
          align: 'center',
          valign: 'middle'
        },
        
        ]

      });

      setTimeout(function () {
        $eval_com_table.bootstrapTable('resetView');
      }, 200);

      $("#eval_com_btn").on("click",function(){
        var comment = $("#comment_eval_inp").val();
        if(comment == ""){
          alert("Isi komentar");
        } else {
          var data = $("#eval_com_form").serialize();
          $.ajax({
            url:"index.php/procurement/save_eval_com",
            data:data,
            type:"post",
            success:function(x){
              $("#comment_eval_inp").val("");
              $("#eval_com_table").bootstrapTable('refresh');
            }
          });
        }
        return false;
      }); 

      $("#calculate_tech").on("click",function(){
        var data = $("#eval_tech_form").serialize();
        $.ajax({
          url:"index.php/procurement/calculate_eval_tech",
          data:data,
          type:"post",
          dataType:"json",
          success:function(x){
            $(".vendor_tech_value").each(function(i,val){
              var id = $(this).attr("data-id");
              $(this).html(x[id]);
            });
            alert("Berhasil kalkulasi nilai teknis");
          }
        });
        return false;
      }); 

    });

  </script>