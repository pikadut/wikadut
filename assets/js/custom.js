function responsive_filemanager_callback(field_id){
	var url = $('#'+field_id).val();
	var id = $("#upload_id").val();
	var preview = $("#upload_preview").val();
	var filename = url.split('/').pop();
	$("#"+id).val(filename);
	$("#"+preview).attr("data-url",url);
	var dialogshow = localStorage.getItem('dialogshow');
	//$("#upload").modal("hide");
	if(dialogshow == true || dialogshow != ""){
		setTimeout(function(){
			localStorage.setItem('dialogshow', "");
			$("#dialog").modal("show");
		},1000);
	}
	return false;
} 

function monthDiff(d1, d2) {
    var months;
    months = (d2.getFullYear() - d1.getFullYear()) * 12;
    months -= d1.getMonth() + 1;
    months += d2.getMonth();
    return months <= 0 ? 0 : months;
}


$('form').on('keyup keypress', function(e) {
  var keyCode = e.keyCode || e.which;
  if (keyCode === 13) { 
    e.preventDefault();
    return false;
  }
});

function get_name_by_id(arraylist,index){

  var res = arraylist.filter(function (item) { return item.id == index });

  return res[0].name;

}


function parent_child(curlvl){

	var selector = (curlvl != "") ? "[data-level='"+curlvl+"']" : "";

	$("select.level"+selector).each(function(i,v){

		var group = $(v).attr("data-group");

		var lvl = $(v).attr("data-level");

		var max_lvl = parseInt($("select.level[data-group='"+group+"']:last").attr('data-level'));

		$("select.level[data-group='"+group+"']"+selector).each(function(){

			var level = parseInt($(this).attr("data-level"));
			var selected = $(this).val();

			$("input.level[data-group='"+group+"']").val(selected);

			var nextlvl = (level+1);

			if(selected != ""){
				
				$("select.level[data-group='"+group+"'][data-level="+nextlvl+"] option[data-parent!='"+selected+"']").hide();
				$("select.level[data-group='"+group+"'][data-level="+nextlvl+"] option[data-parent='"+selected+"']").show();
				$("select.level[data-group='"+group+"'][data-level="+nextlvl+"] option[value='']").prop("selected",true).show();

			} else {
				for (var i = nextlvl; i <= max_lvl; i++) {
					$("select.level[data-group='"+group+"'][data-level="+i+"] option[value!='']").hide();
					$("select.level[data-group='"+group+"'][data-level="+i+"] option[value='']").show();
				}
			}

		});

	});

}

function isInt(n){
	return Number(n) === n && n % 1 === 0;
}

function isFloat(n){
	return n === Number(n) && n % 1 !== 0;
}

function inttomoney(money){

/*
	if(!isInt(money)){

		money = money.replace(".","");

		money = money.replace(",",".");

	}
	
	*/

	money = parseFloat(money);

	//alert("0 = "+money);

	money = numeral(money).format('0,0.00');

	//alert("1 = "+money);
	
	money = money.replace(".","_");

	//alert("2 = "+money);

	money = money.replace(/,/g,".");

	//alert("3 = "+money);

	money = money.replace("_",",");

	//alert("4 = "+money);

	return money;
}

function moneytoint(money){

    	if (typeof money  !== "undefined"){

        money = money.replace(/\./g,"");

        //alert("4 = "+money);

        money = money.replace(",",".");

        //alert("5 = "+money);

        money = parseInt(money);

    //alert("6 = "+money);

} else {
	money = 0;
}

return (!isNaN(money)) ? money : 0;
}

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

$(function(){

	var options = { 
        //target:        '',   // target element(s) to be updated with server response 
        beforeSubmit:  showRequest,  // pre-submit callback 
        success:       showResponse,  // post-submit callback 
        error:       showError,  // post-submit callback 
        dataType:  'json', 
        // other available options: 
        //url:       url         // override for form's 'action' attribute 
        //type:      type        // 'get' or 'post', override for form's 'method' attribute 
        //dataType:  null        // 'xml', 'script', or 'json' (expected server response type) 
        //clearForm: true        // clear all form fields after successful submit 
        //resetForm: true        // reset the form after successful submit 

        // $.ajax options can be used here too, for example: 
        //timeout:   3000 
    }; 

    // bind form using 'ajaxForm' 
    $('.ajaxform').ajaxForm(options); 

// pre-submit callback 
function showRequest(formData, jqForm, options) { 
    // formData is an array; here we use $.param to convert it to a string to display it 
    // but the form plugin does this for you automatically when it submits the data 
    var queryString = $.param(formData); 

    $("#myLoader").modal('show');
    // jqForm is a jQuery object encapsulating the form element.  To access the 
    // DOM element for the form do this: 
    // var formElement = jqForm[0]; 

    //alert('About to submit: \n\n' + queryString); 

    // here we could return false to prevent the form from being submitted; 
    // returning anything other than false will allow the form submit to continue 
    return true; 
} 


function showResponse(responseText, statusText, xhr, $form)  { 

	$("#myLoader").modal('hide');

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

		if(responseText.status == "error"){
			toastr.error(responseText.message, "Error");
		} else {
			toastr.success(responseText.message, "Success");
		}

		if(responseText.redirect != ""){
			setTimeout(function() {
				window.location = responseText.redirect;
			},2000);
		}

	}, 1300);

} 


function showError()  { 

	$("#myLoader").modal('hide');

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

		toastr.error("Gagal memproses data. Silahkan coba kembali", "Error");

	}, 1300);

} 



/*
$("input[type='text']:disabled,textarea:disabled").each(function(){
	var val = $(this).val();
	$("<p class='form-control-static'>"+val+"</p>").insertAfter(this);
	$(this).closest('input,textarea').remove();
});

$("select:disabled").each(function(){
	var val = $(this).val();
	var html = (val != "") ? $(this).find("option:selected").html() : "";
	$("<p class='form-control-static'>"+html+"</p>").insertAfter(this);
	$(this).closest('select').remove();
});

$("input[type='radio']:disabled").each(function(){
	var val = $(this).prop('checked');
	var html = (val == true) ? $(this).parent().text() : "";
	if(val != true){
		$(this).closest('input[type="radio"]').parent().remove();
	} else {
		$(this).closest('input[type="radio"]').remove();
	}
});
*/

if($("input[name='jumlah']").length > 0){
	parent_child("");
}

$("select.level").change(function(){
	var lvl = parseInt($(this).attr('data-level'));
	parent_child(lvl);
})


$(document.body).on("click",".preview_upload",function(){
	var url = $(this).attr('data-url');
	window.open(url, '_blank');
});

$(document.body).on("click",".upload",function(){
	var id = $(this).attr('data-id');
	$("#upload_id").val(id);
	var preview = $(this).attr('data-preview');
	$("#upload_preview").val(preview);
	var folder = $(this).attr("data-folder").replace(/\//g,"_");
	//$("#upload_iframe").attr("src","filemanager/dialog.php?type=0&field_id=uploader&fldr="+folder);
	//$(this).closest(".modal").modal("hide");
	$.ajax({
		url:"index.php/log/set_session/dir_upload/"+folder,
		success:function(data){
			$("#upload").modal("show");
		}
	})
	
	return false;
});

$(".removefile").on("click",function(){
	if(confirm("Apakah anda yakin ingin menghapus file?")){

		var id = $(this).attr('data-id');
		var preview = $(this).attr('data-preview');
		var file = $("#"+id).val();
		var folder = $(this).attr('data-folder');

		$.ajax({
			url:"index.php/log/remove_file",
			type:"post",
			data:{
				file:file,
				folder:folder
			},
			success:function(data){
				$("#"+id).val("");
				$("#"+preview).val("");
			}
		})


	}
	return false;
});

$(document.body).on("click",".picker",function(){
	var id = $(this).attr('data-id');
	$("#picker_id").val(id);
	var url = $(this).attr("data-url");
	$("#picker_content").load(url);
	$("#picker").modal("show");
	return false;
});

$(document.body).on("click",".dialog",function(){
	var url = $(this).attr("data-url");
	$("#dialog_content").load(url);
	$("#dialog").modal("show");
	return false;
});

$(document.body).on("click","#picker_pick",function(){
	var id = $("#picker_id").val();
	$.ajax({
		url:"index.php/log/picker",
		dataType:"json",
		success:function(data){
			$("#"+id).val(data).trigger("change").trigger('input');
		}
	});
	$("#picker").modal("hide");
	return false;
})

});