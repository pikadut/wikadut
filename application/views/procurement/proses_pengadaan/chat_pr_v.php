
<div class="modal fade" id="chatModal" data-backdrop="static" data-keyboard="false" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <!--Modal: Contact form-->
    <div class="modal-dialog" style="width: 70%;" role="document">

        <!--Content-->
        <div class="modal-content">

            <!--Header-->
            <div class="modal-header primary-color white-text">
               <button type="button" class="close waves-effect waves-light" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="title">
                    <i class="fa fa-pencil"></i> Chatting PR</h4>
            </div>
            <!--Body-->
            <div class="modal-body" style="max-height: calc(100vh - 210px);
            overflow-y: auto;">
                              
              <!-- Material form contact -->
                <form method="POST" id="modalForm" enctype="multipart/form-data" class="ws-validate" action="<?= site_url('procurement/submit_chat_pr')?>" >

                  <input type="hidden" name="pr_number" value="<?= $permintaan['pr_number']; ?>">

                  <!-- Material input text -->
                  <div class="md-form id_employee_to">
                      <i class="fa fa-user prefix grey-text"></i>
                      <label for="kepada">Kepada (*)</label>

                      <select multiple="multiple" name="employee_to[]" id="id_employee_to" class="form-control drop req" style="width:300px;">
                          <option value="">pilih...</option>
                      </select>
                  </div>

                  <!-- Material input email -->
                  <div class="md-form">
                      <i class="fa fa-users"></i>
                      <label for="cc">Cc</label>
                      <select multiple="multiple" name="employee_cc[]" class="form-control drop" style="width:300px;">
                    </select>
                  </div>
                  
                  <!-- Material textarea message -->
                  <div class="md-form required pesan">
                      <i class="fa fa-pencil prefix grey-text"></i>
                      <label for="pesan">Pesan (*)</label>
                      <textarea id="pesan" name="pesan" class="form-control md-textarea" rows="3"></textarea>
                  </div>

                  <div class="md-form">
                     <i class="fa fa-paperclip"></i>
                      <label for="pesan">Attachment</label>
                      <input type="file" id="attach" name="attach">
                  </div>

                  <br>

                  <div class="text-center mt-4 mb-2">
                    <!-- <button class="btn btn-primary submit" type="submit">Send
                        <i class="fa fa-send ml-2"></i>
                    </button> -->
                    <input type="submit" name="submit" value="Kirim" class="btn btn-primary">
                  </div>

              </form>
              <!-- Material form contact -->
              <br>
              <hr>
              <div style="overflow-x: auto">
              <table class="table table-responsive table-striped table-bordered table-hover table-hover table-chat">
                <thead>
                  <tr>
                    <td>No.</td>
                    <td>Dari</td>
                    <td>Kepada</td>
                    <td>Cc</td>
                    <td>Pesan</td>
                    <td>Tanggal Kirim</td>
                    <td>Attachment</td>
                  </tr>
                </thead>
                <tbody>
                  <!-- <tr>
                    <td class="mail-subject text-center" colspan="6">Belum ada pesan</td>
                    <td style="display: none;"></td>
                    <td style="display: none;"></td>
                    <td style="display: none;"></td>
                    <td style="display: none;"></td>
                  </tr> -->
              </tbody>
            </table>
          </div>

              <br>              
              <div class="modal-footer">
                <center><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button></center>
                <!-- <button type="button" class="btn btn-primary">Send message</button> -->
              </div>
            </div>
        </div>
        <!--/.Content-->
    </div>
    <!--/Modal: Contact form-->
</div>

<!-- loading chat -->
<div class="modal fade" id="loading" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-hidden="true" style="padding-top:10%; overflow-y:visible;">
    <div class="modal-dialog modal-m" style="width: 30%;">
    <div class="modal-content">
      <div class="modal-header"><h3 style="margin:0;">Loading</h3></div>
      <div class="modal-body">
        <div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>
      </div>
    </div>
  </div>
</div>


<!-- haqim -->
<script>
  $(document).ready(function(){
   var table =  $('.table-chat').DataTable({
        "language": {
          "emptyTable": "Belum ada pesan",
          "sClass": "text-center",
        },
        autoWidth: false,
        pageLength: 10,
        responsive: true,
        ajax: '<?= site_url('procurement/chat_pr')."?id=".$permintaan['pr_number']; ?>',
        "processing": true,
        "columnDefs": [   ////define column 1 , make searchable false 
          {
              "searchable": false,
              "targets": 0,
              "width": "6%",
          },
          { "width": "10%", "targets": 1 },
          { "width": "15%", "targets": 2 },
          { "width": "15%", "targets": 3 },
          { "width": "44%", "targets": 4 },
          { "width": "10%", "targets": 5 },
          { "width": "5%", "targets": 6},

        ],
        "columns": [
            { 'data': null },
            { "data": "employee_from"},
            { "data": "employee_to"
            //  return data == "<? //$this->data['userdata']['complete_name']?>" ? data : "Cc : "+row.employee_cc
            // }
             },
            { "data": "employee_cc"},
            { "data": "pesan"},
            { "data": "date"},
            { "data": "attach", "render": function ( data, type, row, meta ) {
              return data != null ? '<a href="<?= site_url('log/download_attachment/procurement/chat_PR')."/"?>'+data+ '" target="_blank">'+data+'</a>' : ' - ';
            }
          }
        ],
        // dom: '<"html5buttons"B>lTfgitp',
      });

    table.on( 'order.dt search.dt', function () {
      table.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
          cell.innerHTML = i+1;
      } );
  } ).draw();

      var $select_elem = $(".drop");
          $select_elem.empty();
      var url = "<?= site_url('procurement/proses_pengadaan/data_employee_chat') ?>";
      $.getJSON(url, function(json){
          $.each(json, function (i, obj) {
            if (obj.pos_name != null) {
              $select_elem.append('<option value="' + obj.fullname + '">' + obj.fullname + ' ('+obj.pos_name+')</option>');
            } else {
              $select_elem.append('<option value="' + obj.fullname + '">' + obj.fullname +'</option>');
            }
              // console.log(json[i]['id'])
            
          });
          $select_elem.chosen({ width: "100%" });
      })
      // $('.drop').chosen({width: "100%"});

      $('[data-dismiss=modal]').on('click', function (e) {
          reset();
      })

      function reset(){
        var $t = $(this),
           target = $t[0].href || $t.data("target") || $t.parents('.modal') || [];

        $(target)
          .find("textarea#pesan,select")
             .val('')
             .end()
          .find("input[type=checkbox],input[type=file], input[type=radio]")
             .prop("checked", "")
             .end();
             $(".drop").val('').trigger("chosen:updated");
             $(".error").remove();
        $('#modalForm').trigger("reset");
          // $('li.search-choice').remove()
      }

      $('#id_employee_to').on('change', function(){
         $(".error").remove();
      })
      $('#pesan').on('change', function(){
         $(".error").remove();
      })

      $('#modalForm').on('submit', function(e){
        e.preventDefault();
        if ($('#id_employee_to').val() == null) {
          $(".error").remove();
          html = "<div class='error' ><span id='helpBlock' class='help-block' style='color:red'>Harus diisi !!</span></div>";
          $('.id_employee_to').append(html);
        } 
        else if ($('#pesan').val() == '') {
          $(".error").remove();
          html = "<div class='error' ><span id='helpBlock' class='help-block' style='color:red'>Pesan Harus diisi !!</span></div>";
            $('.pesan').append(html);
        } else {
            var form_data = new FormData(this);
            $.each($('#attach')[0].files, function(i, file) {
                form_data.append(i, file);
            });
            $.ajax( {
              url: '<?= site_url('procurement/submit_chat_pr')?>',
              type: 'POST',
              data:form_data,
              contentType: false,  
              cache: false,  
              processData:false,
              beforeSend: function(){
                  // waitingDialog($).show()
                  $('#loading').modal('show');
              },  
              success:function(res){
                // alert(res);
                console.log(res);
                // result = res.replace('\r','');
                if (res == 'success') {
                  alert("Berhasil mengirim pesan");
                  reset();
                  table.ajax.reload( null, false );
                } else{
                  alert("Gagal mengirim pesan");
                }
              },
              complete: function(){
                  // waitingDialog($).hide()
                  $('#loading').modal('hide');
              }
            });  
        }
      });
  });
</script>