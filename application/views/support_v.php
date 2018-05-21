
<!-- /.panel -->
<div class="chat-panel panel panel-default">
  <div class="panel-heading">
    <i class="fa fa-comments fa-fw"></i>
    Chat
    <div class="pull-right">
      <img src="assets/img/ajax-loader.gif" id="loader"/>
    </div>
    <?php /*
    <div class="btn-group pull-right">
      <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-chevron-down"></i>
      </button>
      <ul class="dropdown-menu slidedown">
        <li>
          <a href="#">
            <i class="fa fa-refresh fa-fw"></i> Refresh
          </a>
        </li>
        <li>
          <a href="#">
            <i class="fa fa-check-circle fa-fw"></i> Available
          </a>
        </li>
        <li>
          <a href="#">
            <i class="fa fa-times fa-fw"></i> Busy
          </a>
        </li>
        <li>
          <a href="#">
            <i class="fa fa-clock-o fa-fw"></i> Away
          </a>
        </li>
        <li class="divider"></li>
        <li>
          <a href="#">
            <i class="fa fa-sign-out fa-fw"></i> Sign Out
          </a>
        </li>
      </ul>
    </div>
    <?php */ ?>
  </div>
  <!-- /.panel-heading -->
  <div class="panel-body">
    <div class="row">
      <div class="col-lg-2">

        <div class="thumbnail">

          <div class="caption">
            <p>
             You are <strong>online</strong>
             <br/>
             <br/>
             <span class="name-cust"></span>
             <br/>
             <a href="mailto:" class="email-cust"></a>
             <br/>
             <span class="phone-cust"></span>
           </p>
         </div>
       </div>

       <ul class="nav nav-pills nav-stacked" id="userchat"></ul>
     </div>
     <div class="col-lg-10">

       <ul class="chat"></ul>

     </div>
   </div>
   <!-- /.panel-body -->
   <div class="panel-footer">
    <div class="input-group">
      <input id="inp-chat" type="text" class="form-control input-sm" placeholder="Type your message here..." />
      <span class="input-group-btn">
        <button class="btn btn-warning btn-sm" id="btn-send">
          Send
        </button>
      </span>
    </div>
  </div>
  <!-- /.panel-footer -->
</div>
<!-- /.panel .chat-panel -->

<script type="text/javascript">


$(document).ready(function(){

  function init(){

    $.ajax({
      url:"<?php echo site_url('support/chat') ?>",
      data:"init=1",
      type:"post",
      success:function(mydata){
        if(mydata != ''){
          $(".chat-input,.listchat").show();
          $(".login").hide();
        } else {
          $(".chat-input,.listchat").hide();
          $(".login").show();
        }
      }
    });

  }

  function template(type,user,chat,time){


    if(type == 1){

    var html =  '<li class="left clearfix">'+
    '<div class="chat-body clearfix">'+
    '<div class="header">'+
    '<strong class="primary-font">'+user+'</strong>'+
    '<small class="pull-right text-muted">'+
    '<i class="fa fa-clock-o fa-fw"></i> '+time+
    '</small></div><p>'+
    chat+
    '</p></div></li>';

  } else {

    var html =  '<li class="right clearfix">'+
    '<div class="chat-body clearfix">'+
    '<div class="header">'+
    '<strong class="primary-font pull-right">'+user+'</strong>'+
    '<small class="pull-left text-muted">'+
    '<i class="fa fa-clock-o fa-fw"></i> '+time+
    '</small></div><div class="clearfix"></div><p style="text-align:right;">'+
    chat+
    '</p></div></li>';

  }

    return html;

  }

  function reloader(){

    $.ajax({
      url:"<?php echo site_url('support/chat') ?>",
      data:"reload=1",
      type:"post",
      dataType:"json",
      success:function(mydata){
        var html = "";
        $.each(mydata.chat,function(i,v){
          html += template(v.type,v.user,v.chat,v.time);
        });
        $("ul.chat").html(html);

        var html = "";
        var id_cust = mydata.customer.id_cu;

        var selected = "";

        $.each(mydata.user,function(i,v){

          selected = (id_cust == v.id_cu) ? "active" : "";

          html += '<li class="'+selected+'"><a href="#" data-id="'+v.id_cu+'">'+v.name_cu+'</a></li>';

        });

        $("#userchat").html(html);

        if(selected != ""){

        $(".name-cust").html(mydata.customer.name_cu);
        $(".email-cust").html(mydata.customer.email_cu);
        $(".email-cust").attr("href","mailto:"+mydata.customer.email_cu);
        $(".phone-cust").html(mydata.customer.phone_cu);
        

      } else {

        $(".name-cust").html("");
        $(".email-cust").html("");
        $(".email-cust").attr("");
        $(".phone-cust").html("");
        $("ul.chat").html("");

      }

      }

    });

  }

  window.setInterval(function(){
    reloader();
  },2000);

  window.setTimeout(function(){
    $("#loader").hide();
  },3000);

  $("#userchat li a").live("click",function(e){

    e.preventDefault();

    $("#loader").show();

    var id = $(this).attr("data-id");

    $.ajax({
      url:"<?php echo site_url('support/chat') ?>",
      data:"customer="+id,
      type:"post",
      success:function(mydata){
        reloader();
        $("#loader").hide();
      }
    });

    return false;

  });

  $('.panel-footer').keydown(function(event){    
    if(event.keyCode==13){
     $('#btn-send').trigger('click');
   }
 });

  $("#btn-send").live("click",function(){

    var text = $("#inp-chat").val();

    if(text != ""){

      $.ajax({
        url:"<?php echo site_url('support/chat') ?>",
        data:"text="+text+"&chat=1",
        type:"post",
        success:function(mydata){
          $("#inp-chat").val("");
          reloader();
        }
      });

    } else {
      alert("Text cannot be empty");
    }

  });

  $("#logout").live("click",function(){

    $.ajax({
      url:"<?php echo site_url('support/chat') ?>",
      data:"logout=1",
      type:"post",
      success:function(mydata){
        init();
        reloader();
      }
    });

  });

  $(".form-signin").submit(function(e){
    e.preventDefault();
    var data = $(this).serialize();
    $.ajax({
      url:"<?php echo site_url('support/chat') ?>",
      data:data+"&signin=1",
      type:"post",
      success:function(mydata){
        init();
        reloader();
      }
    });
  });

});


</script>