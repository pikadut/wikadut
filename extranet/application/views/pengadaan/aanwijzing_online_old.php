<div class="row" id="aanwijzing_online">
  <div class="col-lg-12">
    <div class="ibox float-e-margins">
      <div class="ibox-title">
        <h5>Aanwijzing Online</h5>
        <div class="ibox-tools">
          <a class="collapse-link">
            <i class="fa fa-chevron-up"></i>
          </a>
        </div>
      </div>
      <div class="ibox-content">
        <div id="chat" class="wrapper">
          <div class="container">
            <div class="left">
              <?php $online_status = (isset($online_aanwijzing[$userdata['nama_vendor']])) ? $online_aanwijzing[$userdata['nama_vendor']] : "Offline"; ?>
              <div class="top">
                <h1>Chat <input type="checkbox" id="checkonline" <?php echo ($online_status == "Online") ? "checked" : "" ?> data-toggle="toggle"></h1>
              </div>

              <ul class="people">
               <?php foreach ($user_aanwijzing as $key => $value) { ?>
               <li class="person" data-user="<?php echo $key ?>">
                <span class="name"><?php echo $key ?></span>
                <span class="time">
                  <?php echo $value; ?>
                </span>
              </li>
              <?php } ?>
            </ul>
          </div>
          <div class="right">

            <div class="top"></div>

            <div class="chat" data-chat="chat-aanwijzing">

             <br/>

             <?php foreach ($chat_aanwijzing as $key => $value) {
              $isyou = ($userdata['nama_vendor'] == $value['name_ac']); ?>
              <div class='bubble <?php echo ($isyou) ? "me" : "you" ?>'>
                <?php if($isyou){ ?>
                <?php echo $value['message_ac'] ?>
                <?php } else { ?>
                <?php echo $value['name_ac'] ?><br/><?php echo $value['message_ac'] ?><br/><small>(<?php echo date("d/m/Y H:i",strtotime($value['datetime_ac'])) ?>)</small>
                <?php } ?>
              </div>
              <?php } ?>

            </div>


          </div>
          <div class="write">
            <input type="text" id="chat-input"/>
            <a class="write-link send"></a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>  

<script type="text/javascript">
  $('.chat[data-chat=chat-aanwijzing]').addClass('active-chat');
  $('.person[data-user="<?php echo $userdata['nama_vendor'] ?>"]').addClass('active');

  var wsUri = "<?php echo WEBSOCKET_URL ?>";
  var output;

  function init()
  {
    output = document.getElementById("output");
    testWebSocket();
    $('#chat .right').scrollTop($('#chat .right')[0].scrollHeight);

  }

  function testWebSocket()
  {
    websocket = new WebSocket(wsUri);
    websocket.onopen = function(evt) { onOpen(evt) };
    websocket.onclose = function(evt) { onClose(evt) };
    websocket.onmessage = function(evt) { onMessage(evt) };
    websocket.onerror = function(evt) { onError(evt) };
  }

  function onOpen(evt)
  {
    //console.log(evt);
    //writeToScreen("<div class='conversation-start'><span>TERKONEKSI DENGAN SERVER</span></div>");
  }

  function onClose(evt)
  {
    //console.log(evt);
    //writeToScreen("<div class='conversation-start'><span>TERPUTUS DENGAN SERVER</span></div>");
  }

  function onMessage(evt)
  {

    var substring = "#<?php echo $userdata['tenderid'] ?>#";
    var msg = evt.data;
    var rep = msg.replace("1"+substring, "");
  //alert(msg);
  if(msg.indexOf("1"+substring) !== -1){
    writeToScreen("<div class='bubble you'>"+rep+'</div>');
  }
  if(msg.indexOf("0"+substring) !== -1){
    var res = msg.split("#");
    var user = res[2];
    var status = res[3];
    $("li.person[data-user='"+user+"'] .time").text(status);
    //console.log(res);
  }
  ///websocket.close();
}

function onError(evt)
{
  //console.log(evt);
  writeToScreen('<span style="color: red;">ERROR:</span> ' + evt.data);
}

function checkonline(){
  var checked = $('#checkonline').prop('checked');
  var label = (checked) ? "Online" : "Offline";
  $(".people .person.active .time").text(label);
  if(checked){
    $(".write").show();
  } else {
   $(".write").hide();
 }
 return label;
}

$(document).ready(function(){

 checkonline();

 $('#checkonline').on('change',function() {
   var label = checkonline();
   var message_p = "0#<?php echo $userdata['tenderid'] ?>#<?php echo $userdata['nama_vendor'] ?>#"+label;
   websocket.send(message_p);
 });

 $('#chat-input').keypress(function(e){

  if(e.keyCode == 13)
  {
    sendWS($('#chat-input').val());
    e.preventDefault();
  }
});

 $(".send").on("click",function(){
   sendWS($('#chat-input').val());
 });

});

function htmlEntities(str) {
  return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}


function sendWS(message){
 message_p = "1#<?php echo $userdata['tenderid'] ?>#<?php echo $userdata['nama_vendor'] ?>#"+message;
 message_c = "<div class='bubble me'>"+htmlEntities(message)+"</div>";
 $('#chat-input').val("");
 writeToScreen(message_c,0);
 websocket.send(message_p);
}

function writeToScreen(message)
{
  $(".chat").append(message);
  $('#chat .right').scrollTop($('#chat .right')[0].scrollHeight);
}

window.addEventListener("load", init, false);

</script>
<style type="text/css">
  @import url(https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600);
  *,
  *:before,
  *:after {
    box-sizing: border-box;

  }

  #aanwijzing_online #chat {
    background-color: none;
    -webkit-font-smoothing: antialiased;
    -moz-osx-font-smoothing: grayscale;
    text-rendering: optimizeLegibility;
    font-family: 'Source Sans Pro', sans-serif;
    font-weight: 400;
    background-size: cover;
    background-repeat: none;
  }

  #aanwijzing_online .wrapper {
    padding: 0;
  }

  #aanwijzing_online .container {
    padding: 0;
    top: 50%;
    left: 50%;
    width: 100%;
    height: 75%;
    background-color: #fff;

  }
  #aanwijzing_online .container .left {
    float: left;
    width: 37.6%;
    height: 100%;
    border: 1px solid #e6e6e6;
    background-color: #fff;
  }
  #aanwijzing_online .container .left .top {
    position: relative;
    width: 100%;
    height: 96px;
    padding: 29px;
  }
  #aanwijzing_online .container .left .top:after {
    position: absolute;
    bottom: 0;
    left: 50%;
    display: block;
    width: 80%;
    height: 1px;
    content: '';
    background-color: #e6e6e6;
    -webkit-transform: translate(-50%, 0);
    transform: translate(-50%, 0);
  }
  #aanwijzing_online .container .left input {
    float: left;
    width: 188px;
    height: 42px;
    padding: 0 15px;
    border: 1px solid #e6e6e6;
    background-color: #eceff1;
    border-radius: 21px;
    font-family: 'Source Sans Pro', sans-serif;
    font-weight: 400;
  }
  #aanwijzing_online .container .left input:focus {
    outline: none;
  }
  #aanwijzing_online .container .left a.search {
    display: block;
    float: left;
    width: 42px;
    height: 42px;
    margin-left: 10px;
    border: 1px solid #e6e6e6;
    background-color: #00b0ff;
    background-image: url("http://s11.postimg.org/dpuahewmn/name_type.png");
    background-repeat: no-repeat;
    background-position: top 12px left 14px;
    border-radius: 50%;
  }
  #aanwijzing_online .container .left .people {
    margin-left: -1px;
    border-right: 1px solid #e6e6e6;
    border-left: 1px solid #e6e6e6;
    width: calc(100% + 2px);
    list-style-type: none;
    height: 200px;
    overflow-y: auto; 
  }
  #aanwijzing_online .container .left .people .person {
    position: relative;
    width: 100%;
    padding: 12px 10% 16px;
    cursor: pointer;
    background-color: #fff;
  }
  #aanwijzing_online .container .left .people .person:after {
    position: absolute;
    bottom: 0;
    left: 50%;
    display: block;
    width: 80%;
    height: 1px;
    content: '';
    background-color: #e6e6e6;
    -webkit-transform: translate(-50%, 0);
    transform: translate(-50%, 0);
  }
  #aanwijzing_online .container .left .people .person img {
    float: left;
    width: 40px;
    height: 40px;
    margin-right: 12px;
    border-radius: 50%;
  }
  #aanwijzing_online .container .left .people .person .name {
    font-size: 14px;
    line-height: 22px;
    color: #1a1a1a;
    font-family: 'Source Sans Pro', sans-serif;
    font-weight: 600;
  }
  #aanwijzing_online .container .left .people .person .time {
    font-size: 14px;
    position: absolute;
    top: 16px;
    right: 10%;
    padding: 0 0 5px 5px;
    color: #999;
    background-color: #fff;
  }
  #aanwijzing_online .container .left .people .person .preview {
    font-size: 14px;
    display: inline-block;
    overflow: hidden !important;
    width: 70%;
    white-space: nowrap;
    text-overflow: ellipsis;
    color: #999;
  }
  #aanwijzing_online .container .left .people .person.active, #aanwijzing_online .container .left .people .person:hover {
    margin-top: -1px;
    margin-left: -1px;
    padding-top: 13px;
    border: 0;
    background-color: #00b0ff;
    width: calc(100% + 2px);
    padding-left: calc(10% + 1px);
  }
  #aanwijzing_online .container .left .people .person.active span, #aanwijzing_online .container .left .people .person:hover span {
    color: #fff;
    background: transparent;
  }
  #aanwijzing_online .container .left .people .person.active:after, #aanwijzing_online .container .left .people .person:hover:after {
    display: none;
  }
  #aanwijzing_online .container .right {
    position: relative;
    float: left;
    width: 62.4%;
    height: 100%;
    overflow-y: scroll;
    height: 320px;
  }
  #aanwijzing_online .container .right .top {
    width: 100%;
    height: 47px;
    padding: 15px 29px;
    background-color: #eceff1;
  }
  #aanwijzing_online .container .right .top span {
    font-size: 15px;
    color: #999;
  }
  #aanwijzing_online .container .right .top span .name {
    color: #1a1a1a;
    font-family: 'Source Sans Pro', sans-serif;
    font-weight: 600;
  }
  #aanwijzing_online .container .right .chat {
    position: relative;
    display: none;
    overflow: hidden;
    padding: 0 35px 92px;
    border-width: 1px 1px 1px 0;
    border-style: solid;
    border-color: #e6e6e6;
    height: auto;
    -webkit-box-pack: end;
    -webkit-justify-content: flex-end;
    -ms-flex-pack: end;
    justify-content: flex-end;
    -webkit-box-orient: vertical;
    -webkit-box-direction: normal;
    -webkit-flex-direction: column;
    -ms-flex-direction: column;
    flex-direction: column;
  }
  #aanwijzing_online .container .right .chat.active-chat {
    display: block;
    display: -webkit-box;
    display: -webkit-flex;
    display: -ms-flexbox;
    display: flex;


  }
  #aanwijzing_online .container .right .chat.active-chat .bubble {
    -webkit-transition-timing-function: cubic-bezier(0.4, -0.04, 1, 1);
    transition-timing-function: cubic-bezier(0.4, -0.04, 1, 1);
  }
  #aanwijzing_online .container .right .chat.active-chat .bubble:nth-of-type(1) {
    -webkit-animation-duration: 0.15s;
    animation-duration: 0.15s;
  }
  #aanwijzing_online .container .right .chat.active-chat .bubble:nth-of-type(2) {
    -webkit-animation-duration: 0.3s;
    animation-duration: 0.3s;
  }
  #aanwijzing_online .container .right .chat.active-chat .bubble:nth-of-type(3) {
    -webkit-animation-duration: 0.45s;
    animation-duration: 0.45s;
  }
  #aanwijzing_online .container .right .chat.active-chat .bubble:nth-of-type(4) {
    -webkit-animation-duration: 0.6s;
    animation-duration: 0.6s;
  }
  #aanwijzing_online .container .right .chat.active-chat .bubble:nth-of-type(5) {
    -webkit-animation-duration: 0.75s;
    animation-duration: 0.75s;
  }
  #aanwijzing_online .container .right .chat.active-chat .bubble:nth-of-type(6) {
    -webkit-animation-duration: 0.9s;
    animation-duration: 0.9s;
  }
  #aanwijzing_online .container .right .chat.active-chat .bubble:nth-of-type(7) {
    -webkit-animation-duration: 1.05s;
    animation-duration: 1.05s;
  }
  #aanwijzing_online .container .right .chat.active-chat .bubble:nth-of-type(8) {
    -webkit-animation-duration: 1.2s;
    animation-duration: 1.2s;
  }
  #aanwijzing_online .container .right .chat.active-chat .bubble:nth-of-type(9) {
    -webkit-animation-duration: 1.35s;
    animation-duration: 1.35s;
  }
  #aanwijzing_online .container .right .chat.active-chat .bubble:nth-of-type(10) {
    -webkit-animation-duration: 1.5s;
    animation-duration: 1.5s;
  }
  #aanwijzing_online .container .write {
    position: absolute;
    bottom: 29px;
    left: 30px;
    height: 42px;
    padding-left: 8px;
    border: 1px solid #e6e6e6;
    background-color: #eceff1;
    width: calc(100% - 100px);
    border-radius: 5px;
    margin: 20px 10px;
  }
  #aanwijzing_online .container .write input {
    font-size: 16px;
    float: left;
    width: 94%;
    height: 40px;
    padding: 0 10px;
    color: #1a1a1a;
    border: 0;
    outline: none;
    background-color: #eceff1;
    font-family: 'Source Sans Pro', sans-serif;
    font-weight: 400;
  }
  #aanwijzing_online .container .write .write-link.attach:before {
    display: inline-block;
    float: left;
    width: 20px;
    height: 42px;
    content: '';
    background-image: url("http://s1.postimg.org/s5gfy283f/attachemnt.png");
    background-repeat: no-repeat;
    background-position: center;
  }
  #aanwijzing_online .container .write .write-link.smiley:before {
    display: inline-block;
    float: left;
    width: 20px;
    height: 42px;
    content: '';
    background-image: url("http://s14.postimg.org/q2ug83h7h/smiley.png");
    background-repeat: no-repeat;
    background-position: center;
  }
  #aanwijzing_online .container .write .write-link.send:before {
    display: inline-block;
    float: left;
    width: 20px;
    height: 42px;
    margin-left: 11px;
    content: '';
    background-image: url("http://s30.postimg.org/nz9dho0pp/send.png");
    background-repeat: no-repeat;
    background-position: center;
  }
  #aanwijzing_online .container .right .bubble {
    font-size: 16px;
    position: relative;
    display: inline-block;
    clear: both;
    margin-bottom: 8px;
    padding: 13px 14px;
    vertical-align: top;
    border-radius: 5px;
  }
  #aanwijzing_online .container .right .bubble:before {
    position: absolute;
    top: 19px;
    display: block;
    width: 8px;
    height: 6px;
    content: '\00a0';
    -webkit-transform: rotate(29deg) skew(-35deg);
    transform: rotate(29deg) skew(-35deg);
  }
  #aanwijzing_online .container .right .bubble.you {
    float: left;
    color: #fff;
    background-color: #00b0ff;
    -webkit-align-self: flex-start;
    -ms-flex-item-align: start;
    align-self: flex-start;
    -webkit-animation-name: slideFromLeft;
    animation-name: slideFromLeft;
  }
  #aanwijzing_online .container .right .bubble.you:before {
    left: -3px;
    background-color: #00b0ff;
  }
  #aanwijzing_online .container .right .bubble.me {
    float: right;
    color: #1a1a1a;
    background-color: #eceff1;
    -webkit-align-self: flex-end;
    -ms-flex-item-align: end;
    align-self: flex-end;
    -webkit-animation-name: slideFromRight;
    animation-name: slideFromRight;
  }
  #aanwijzing_online .container .right .bubble.me:before {
    right: -3px;
    background-color: #eceff1;
  }
  #aanwijzing_online .container .right .conversation-start {
    position: relative;
    width: 100%;
    margin-bottom: 27px;
    text-align: center;
  }
  #aanwijzing_online .container .right .conversation-start span {
    font-size: 14px;
    display: inline-block;
    color: #999;
  }
  #aanwijzing_online .container .right .conversation-start span:before, #aanwijzing_online .container .right .conversation-start span:after {
    position: absolute;
    top: 10px;
    display: inline-block;
    width: 30%;
    height: 1px;
    content: '';
    background-color: #e6e6e6;
  }
  #aanwijzing_online .container .right .conversation-start span:before {
    left: 0;
  }
  #aanwijzing_online .container .right .conversation-start span:after {
    right: 0;
  }

  @keyframes slideFromLeft {
    0% {
      margin-left: -200px;
      opacity: 0;
    }
    100% {
      margin-left: 0;
      opacity: 1;
    }
  }
  @-webkit-keyframes slideFromLeft {
    0% {
      margin-left: -200px;
      opacity: 0;
    }
    100% {
      margin-left: 0;
      opacity: 1;
    }
  }
  @keyframes slideFromRight {
    0% {
      margin-right: -200px;
      opacity: 0;
    }
    100% {
      margin-right: 0;
      opacity: 1;
    }
  }
  @-webkit-keyframes slideFromRight {
    0% {
      margin-right: -200px;
      opacity: 0;
    }
    100% {
      margin-right: 0;
      opacity: 1;
    }
  }

</style>
