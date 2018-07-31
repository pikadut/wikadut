
<!-- Modal -->
<div class="modal fade" id="upload" tabindex="-3" role="dialog" aria-labelledby="uploadLabel">
  <div class="modal-dialog modal-lg" style="width:30%" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="uploadLabel">File Uploader</h4>
      </div>
      <div class="modal-body">
        <input type="file" name="file" id="file-uploader" accept=".doc, .docx, .xls, .xlsx, .ppt, .pptx, .pdf, image/jpg, image/jpeg, image/png, .Zip, .rar, .tgz, .7zip, .tar" >
        <input type="hidden" name="upload_id" id="upload_id">
        <input type="hidden" name="upload_preview" id="upload_preview">
        <input type="hidden" name="uploader" id="uploader">
        
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="assets/js/jquery.ajaxfileupload.js"></script>

<script type="text/javascript">
  $(document).ready(function(){

  $('#file-uploader').bind('change', function(e) {
  //this.files[0].size gets the size of your file.
  // alert(this.files[0].size);
  if (this.files[0].size > 5000000) {
    alert('Ukuran file tidak boleh lebih dari 5 MB');
    $('#file-uploader').val('');
    fail
  }
})

  var interval;
  applyAjaxFileUpload("#file-uploader");
  function applyAjaxFileUpload(element) {
    $(element).AjaxFileUpload({
      action: "<?php echo site_url('log/doupload') ?>",
      dataType:"json",
      onChange: function(filename) {
            // Create a span element to notify the user of an upload in progress
            var $span = $("<span />")
            .attr("class", $(this).attr("id"))
            .text("Uploading")
            .insertAfter($(this));

            $(this).remove();

            interval = window.setInterval(function() {
              var text = $span.text();
              if (text.length < 13) {
                $span.text(text + ".");
              } else {
                $span.text("Uploading");
              }
            }, 200);
          },
          onSubmit: function(filename) {
            // Return false here to cancel the upload
            /*var $fileInput = $("<input />")
              .attr({
                type: "file",
                name: $(this).attr("name"),
                id: $(this).attr("id")
              });

            $("span." + $(this).attr("id")).replaceWith($fileInput);

            applyAjaxFileUpload($fileInput);

            return false;*/

            // Return key-value pair to be sent along with the file
            return true;
          },
          onComplete: function(filename, response) {
            //response = JSON.parse(response);
            window.clearInterval(interval);

            var $span = $("span." + $(this).attr("id")).text(response.filename + " ");
            var $fileInput = $("<input/>")
            .attr({
              type: "file",
              name: $(this).attr("name"),
              id: $(this).attr("id"),
              accept: $(this).attr("accept"),
            });

            if (response.status == "error") {

              setTimeout(function() {
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

                toastr.error(response.message, "Error");

              }, 1300);

              var $fileInput = $("<input />")
              .attr({
                type: "file",
                name: $(this).attr("name"),
                id: $(this).attr("id"),
                accept: $(this).attr("accept"),
              });

            $("span." + $(this).attr("id")).replaceWith($fileInput);

            applyAjaxFileUpload($fileInput);

              return;

            } else {
              var url = response.url;
              var id = $("#upload_id").val();
              var preview = $("#upload_preview").val();
              var filename = response.message;
              $("#"+id).val(filename).trigger('input').trigger('change');
              $("#"+preview).attr("data-url",url);
              var dialogshow = localStorage.getItem('dialogshow');
              $("#upload").modal("hide");
              if(dialogshow == true || dialogshow != ""){
                setTimeout(function(){
                  localStorage.setItem('dialogshow', "");
                  //$("#dialog").modal("show");
                },1000);
              }

            }

            $span.replaceWith($fileInput);
            applyAjaxFileUpload($fileInput);

          }

        });

}


});

</script>