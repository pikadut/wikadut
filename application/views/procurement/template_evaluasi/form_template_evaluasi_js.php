<script type="text/javascript">

  $(document).ready(function(){

	  var bobot_teknis_awal = $("#bobot_teknis_inp").val();
	  var bobot_harga_awal = $("#bobot_harga_inp").val();

    function check_jenis(){

      var val = parseInt($("#jenis_inp").val());

      if(val == 2){
        $("#bobot_teknis_inp").prop("readonly",true).val(0);
        $("#bobot_harga_inp").prop("readonly",true).val(100);
      } else if(val == 1) {
        $("#bobot_teknis_inp").prop("readonly",false).val(bobot_teknis_awal);
        $("#bobot_harga_inp").prop("readonly",false).val(bobot_harga_awal);
      } else {
        $("#bobot_teknis_inp").prop("readonly",true).val(100);
        $("#bobot_harga_inp").prop("readonly",true).val(0);
      }

    }

    setTimeout(function(){
    check_jenis();
    },1000);

    $("#jenis_inp").change(function(){

      check_jenis();

    });

    function check_jenis_item(){

      var jenis = parseInt($(".jenis_item:checked").val());

      if(jenis == 0){
        $("#bobot").prop('readonly',true).val(0);
      } else {
        $("#bobot").prop('readonly',false);
      }

    }

    setTimeout(function(){
    check_jenis_item();
    },1000);

    $(".jenis_item").change(function(){
      check_jenis_item();
    });

    $(".action_item").click(function(){

      var current_item = $("#current_item").val();
      var no = current_item;

      if(current_item == ""){
        no = ($("#item_table tr").length) ? parseInt($("#item_table tr").length) : 1;
      }

      var bobot = parseFloat($("#bobot").val());
      var item = $("#item").val();
      var jenis = parseInt($(".jenis_item:checked").val());
      var jenis_name = (jenis == 0) ? "Administrasi" : "Teknis";
      bobot = (jenis == 0) ? 0 :  bobot;

      var total = bobot;

      $("#item_table tbody tr").each(function(){

        var jumlah = parseFloat($(this).find("input.item_bobot").val());
        total += jumlah;

      });

      if(item == ""){

        alert("Isi item");

      } else if(jenis == 1 && bobot == ""){

        alert("Isi bobot");

      } else if(isNaN(bobot)){

        alert("Bobot harus berupa angka");

      } else if(total > 100){

        alert("Bobot tidak boleh lebih dari 100");

      }  else {

        var html = "<tr><td><button type='button' class='btn btn-primary btn-xs edit_item' data-no='"+no+"'><i class='fa fa-edit'></i></button> ";
        html += "<button type='button' class='btn btn-primary btn-xs delete_item' data-no='"+no+"'><i class='fa fa-remove'></i></button></td>";
        html += "<td><input type='hidden' class='item_name' data-no='"+no+"' name='item_name["+no+"]' value='"+item+"'/>"+item+"</td>";
        html += "<td><input type='hidden' class='item_jenis' data-no='"+no+"' name='item_jenis["+no+"]' value='"+jenis+"'/>"+jenis_name+"</td>";
        html += "<td><input type='hidden' class='item_bobot' data-no='"+no+"' name='item_bobot["+no+"]' value='"+bobot+"'/>"+bobot+"</td>";
        html += "</tr>";

        $("#item_table").append(html);

        $("#current_item").val("");
        $("#bobot").val("");
        $("#item").val("");

        $(".edit_item,.delete_item").show();

      }

    });

$(document.body).on("click",".edit_item",function(){

  $(".edit_item,.delete_item").hide();

  var no = $(this).attr('data-no');
  var bobot = $(".item_bobot[data-no='"+no+"']").val();
  var item = $(".item_name[data-no='"+no+"']").val();
  var jenis = $(".item_jenis[data-no='"+no+"']").val();

  $("#current_item").val(no);
  $("#bobot").val(bobot);
  $("#item").val(item);
  $(".jenis_item[value='"+jenis+"']").prop("checked",true);

  $(this).parent().parent().remove();

  return false;

});

$(document.body).on("click",".delete_item",function(){

  if(confirm("Are you sure want to delete this item?")){

    $(this).parent().parent().remove();

  }

  return false;

});

$("button[type='submit']").click(function(e){

  var current_item = $("#current_item").val();
  if(current_item != ""){
    alert("Data item harus di simpan.");
    return false;
  }

})


})

</script>