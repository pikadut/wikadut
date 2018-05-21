
<div class="small-chat-box fadeInRight animated">

	<div class="heading" draggable="true">
		<small class="chat-date pull-right">
			<?php echo ($userdata['complete_name']) ?>
		</small>
		Internal Chat
	</div>

	<div class="content"></div>

  <div class="form-chat">
   <div class="input-group input-group-sm">
     <input type="text" id="inp-chat" class="form-control"> 
     <span class="input-group-btn"> 
       <button class="btn btn-primary" id="btn-send" type="button">Send</button> 
       /span></div>
     </div>

   </div>
   <div id="small-chat">

     <span class="badge badge-warning pull-right"></span>
     <a class="open-small-chat">
      <i class="fa fa-comments"></i>

    </a>
  </div>


  <script type="text/javascript">


    $(document).ready(function(){

      function init(){

      }

      function template(type,user,chat,time){

       var pos = (type == 1) ? "left" : "right";
       var act = (type == 1) ? "active" : "";
       user = (type == 1) ? user : "";

       html = "<div class='"+pos+"'>"+
       "<div class='author-name'>"+
       user+
       " <small class='chat-date'> "+
       time+
       " </small></div>"+
       "<div class='chat-message "+act+"'>"+
       chat+
       "</div></div>";

       return html;

     }

     function reloader(){

      $.ajax({
        url:"<?php echo site_url('procurement/data_chat') ?>",
        data:"reload=1",
        type:"post",
        dataType:"json",
        success:function(mydata){

          var html = "";
          var total = 0;
          $.each(mydata,function(i,v){
            total++;
            html += template(v.type,v.user,v.chat,v.time);
          });

          $(".small-chat-box .content").html(html);

        }

      });

    }

    function gobot(){
      var height = 99999;
      var body = $('.small-chat-box .content');
      body.animate({ scrollTop: height }, 1000);
    }

    window.setTimeout(function(){
      gobot();
    },2000);

    window.setInterval(function(){
      reloader();
    },2000);

    $('#inp-chat').keydown(function(event){    
      if(event.keyCode==13){
       $('#btn-send').trigger('click');
     }
   });

    $("#btn-send").live("click",function(){

      var text = $("#inp-chat").val();

      if(text != ""){

        $.ajax({
          url:"<?php echo site_url('procurement/data_chat') ?>",
          data:"text="+text+"&chat=1",
          type:"post",
          success:function(mydata){

            $("#inp-chat").val("");
            reloader();
            gobot();

          }

        });

      } else {
        alert("Text cannot be empty");
      }

    });

  });

</script>
