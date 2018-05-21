
pubnub.addListener({
  status: function(statusEvent) {
    //console.log(statusEvent);
    if (statusEvent.category === "PNConnectedCategory") {
        $("#chat .right .top").text(tenderid_aanwijzing);
        $('#chat .right').scrollTop($('#chat .right')[0].scrollHeight);
      }
    },
    message: function(message) {

      var substring = "#"+tenderid_aanwijzing+"#";
      var msg = message.message;
      var rep = msg.replace("1"+substring, "");
      var res = msg.split("#");
      var user = res[2];
      var status = res[3];

      if(msg.indexOf("1"+substring) !== -1){
        var class_ = (user == username_aanwijzing) ? "me" : "you";
        if(class_ == "you"){
          status = user+"<br/>"+status;
        }
        writeToScreen("<div class='bubble "+class_+"'>"+status+'</div>');
      }
      if(msg.indexOf("0"+substring) !== -1){

       if(status.toLowerCase() == "online"){
          $("li.person[data-user='"+user+"'] .time").addClass("active");
        } else {
          $("li.person[data-user='"+user+"'] .time").removeClass("active");
        }
        $("li.person[data-user='"+user+"'] .time").text(status);

      }

    },
    presence: function(presenceEvent) {
            // handle presence
          }
        })      
pubnub.subscribe({
  channels: [tenderid_aanwijzing] 
});

$('.chat[data-chat=chat-aanwijzing]').addClass('active-chat');

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

function changestatus(){

   var label = checkonline();
   var message_p = "0#"+tenderid_aanwijzing+"#"+username_aanwijzing+"#"+label;
   var publishConfig = {
    channel : tenderid_aanwijzing,
    message : message_p
  }

  $.ajax({
  url:submiturl_aanwijzing,
  data:"message="+message_p,
  method:"post",
  success:function(res){
    if(res != ""){
     var publishConfig = {
      channel : tenderid_aanwijzing,
      message : res
    }
    pubnub.publish(publishConfig, function(status, response) {

    });
  }
}
});

}

$(document).ready(function(){

 changestatus();

 $('#checkonline').on('change',function() {

  changestatus();

});

 $('#chat-input').keypress(function(e){

  if(e.keyCode == 13)
  {
    sendMessage($('#chat-input').val());
    e.preventDefault();
  }
});

 $(".send").on("click",function(){
   sendMessage($('#chat-input').val());
 });

});

function htmlEntities(str) {
  return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
}

function sendMessage(message){

 message_p = "1#"+tenderid_aanwijzing+"#"+username_aanwijzing+"#"+message;
 message_c = "<div class='bubble me'>"+htmlEntities(message)+"</div>";
 $('#chat-input').val("");

 $.ajax({
  url:submiturl_aanwijzing,
  data:"message="+message_p,
  method:"post",
  success:function(res){
    if(res != ""){
     var publishConfig = {
      channel : tenderid_aanwijzing,
      message : res
    }
    pubnub.publish(publishConfig, function(status, response) {

    });
  }
}
});

}

function writeToScreen(message)
{
  $(".chat").append(message);
  $('#chat .right').scrollTop($('#chat .right')[0].scrollHeight);
}
