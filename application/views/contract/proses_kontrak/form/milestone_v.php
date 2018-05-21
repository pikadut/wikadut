<?php $contract_type = (isset($kontrak['contract_type'])) ? $kontrak["contract_type"] : "";
if($contract_type != "HARGA SATUAN"){ ?>

  <div class="row">
    <div class="col-lg-12">
      <div class="ibox float-e-margins">
        <div class="ibox-title">
          <h5>MILESTONE / TERMIN PEMBAYARAN</h5>
          <div class="ibox-tools">
            <a class="collapse-link">
              <i class="fa fa-chevron-up"></i>
            </a>
          </div>
        </div>
        <div class="ibox-content">


          <?php $curval = ""; ?>
          <div class="form-group">
            <label class="col-sm-2 control-label">Deskripsi Milestone</label>
            <div class="col-sm-10">
              <textarea class="form-control" id="deskripsi_milestone_inp"></textarea>
            </div>
          </div>

          <?php $curval = date(DEFAULT_FORMAT_DATETIME_DB); ?>
          <div class="form-group">
          <label class="col-sm-2 control-label">Target Tanggal</label>
            <div class="col-sm-3">
              <div class="input-group date">
                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                <input type="date" id="tanggal_milestone_inp" class="form-control" value="<?php echo $curval ?>">
              </div>
            </div>
          </div>

          <?php $curval = ""; ?>
          <div class="form-group">
            <label class="col-sm-2 control-label">Bobot (%)</label>
            <div class="col-sm-2">
              <input class="form-control money" id="bobot_milestone_inp" maxlength="3">
            </div>
          </div>

          <center>
            <a class="btn btn-primary action_milestone">Add</a>
            <a class="btn btn-default empty_milestone">Clear</a>
            <input type="hidden" id="current_milestone" value=""/>
            <br>
          </center>

          <hr>

          <table class="table table-bordered" id="milestone_table">
            <thead>
              <tr>
                <th>#</th>
                <th>Deskripsi</th>
                <th>Target Tanggal</th>
                <th>Bobot (%)</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $subtotal = 0;
              if(isset($milestone) && !empty($milestone)){
                foreach ($milestone as $key => $value) { 
                $myid = $key+1;
                 ?>

                <tr>
                  <td>
                    <button data-no="<?php echo $myid ?>" class="btn btn-primary btn-xs edit_milestone" type="button">
                      <i class="fa fa-edit"></i>
                      <?php  ?>
                      <input type="hidden" name="milestone_id[<?php echo $myid ?>]" value="<?php echo $myid ?>"/>
                    </button>
                  </td>
                  <td>
                    <input type="hidden" value="<?php echo $value['description'] ?>" name="milestone_desc[<?php echo $myid ?>]" data-no="<?php echo $myid ?>" class="milestone_desc">
                    <?php echo $value['description'] ?>
                  </td>
                  <td>
                    <input type="hidden" value="<?php echo date("Y-m-d",strtotime($value['target_date'])) ?>" name="milestone_date[<?php echo $myid ?>]" data-no="<?php echo $myid ?>" class="milestone_date">
                   <?php echo date("Y-m-d",strtotime($value['target_date'])) ?>
                  </td>
                  <td class="money">
                    <input type="hidden" value="<?php echo inttomoney($value['percentage']) ?>" name="milestone_percent[<?php echo $myid ?>]" data-no="<?php echo $myid ?>" class="milestone_percent">
                    <?php echo inttomoney($value['percentage']) ?>
                  </td>
                </tr>

                <?php } } ?>

              </tbody>
            </table>

            <hr>

          </div>

        </div>
      </div>
    </div>

    <script type="text/javascript">

      $(document).ready(function(){

        $(".action_milestone").click(function(){

          var current_milestone = $("#current_milestone").val();
          var no = current_milestone;

          if(current_milestone == ""){
            no = ($("#milestone_table tr").length) ? parseInt($("#milestone_table tr").length) : 1;
          }

          var mybobot = 0;

          $("#milestone_table tbody tr").each(function(i,val){
            
            var v = $(this).find(".milestone_percent").val();
            mybobot += moneytoint(v);

          });

          var deskripsi = $("#deskripsi_milestone_inp").val();
          var tanggal = $("#tanggal_milestone_inp").val();
          var bobot = moneytoint($("#bobot_milestone_inp").val());

          if(deskripsi == ""){

            alert("Isi deskripsi milestone");

          } else if(tanggal == ""){

            alert("Isi tanggal milestone");

          } else if(bobot == ""){

            alert("Isi bobot milestone");

          } else if(parseFloat(mybobot+bobot) > 100){

            alert("Bobot harus dibawah 100");

          } else {

            bobot = inttomoney(bobot);

            var html = "<tr><td><button type='button' class='btn btn-primary btn-xs edit_milestone' data-no='"+no+"'><i class='fa fa-edit'></i></button></td>";
            html += "<td><input type='hidden' class='milestone_desc' data-no='"+no+"' name='milestone_desc["+no+"]' value='"+deskripsi+"'/>"+deskripsi+"</td>";
            html += "<td><input type='hidden' class='milestone_date' data-no='"+no+"' name='milestone_date["+no+"]' value='"+tanggal+"'/>"+tanggal+"</td>";
            html += "<td class='money'><input type='hidden' class='milestone_percent' data-no='"+no+"' name='milestone_percent["+no+"]' value='"+bobot+"'/>"+bobot+"</td>";
            html += "</tr>";
            $("#milestone_table").append(html);

            $("#deskripsi_milestone_inp").val("");
            $("#tanggal_milestone_inp").val("");
            $("#bobot_milestone_inp").val("");
            $("#current_milestone").val("");
            
          }

        });

  $(document.body).on("click",".empty_milestone",function(){

    $("#deskripsi_milestone_inp").val("");
    $("#tanggal_milestone_inp").val("");
    $("#bobot_milestone_inp").val("");
    $("#current_milestone").val("");

  });

  $(document.body).on("click",".edit_milestone",function(){

    var no = $(this).attr('data-no');
    var deskripsi = $(".milestone_desc[data-no='"+no+"']").val();
    var tanggal = $(".milestone_date[data-no='"+no+"']").val();
    var bobot = $(".milestone_percent[data-no='"+no+"']").val();

    $("#current_milestone").val(no);
    $("#deskripsi_milestone_inp").val(deskripsi);
    $("#tanggal_milestone_inp").val(tanggal);
    $("#bobot_milestone_inp").val(bobot);

    $(this).parent().parent().remove();

    return false;

  });
})

</script>

<?php } ?>