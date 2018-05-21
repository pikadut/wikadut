$(function(){
$("table.comment,table.default").bootstrapTable({
	pagination:true,
	search:true,
	sortable:true
});

$("input.money").autoNumeric({
	aSep: '.',
	aDec: ',', 
	aSign: ''
});

$(".datetimepicker").datetimepicker({format:"YYYY-MM-DD HH:mm:ss"});

$(".datepicker").datepicker({ format: 'yyyy-mm-dd' }).prop("readonly",true);

$("[type='date']").datepicker({ format: 'yyyy-mm-dd' }).prop("readonly",true);

$('.summernote').summernote();

$('select.select2').select2();

$('[data-toggle="tooltip"]').tooltip();

});