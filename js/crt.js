$(document).ready(function(){
var lng = $('html').attr('lang');
//IF USER CHANGE LANGUAGE
$('body').on('click', 'select', function(e){
	var lc = $(this).val();
	var lg = $(e.target[lc]).attr('lang');
	$(this).attr('id',lg);
	$(this).attr('data-id',lc);
});
//
$('body').on('click', 'select', function(e){
	var l = $(this).attr('id');//lang
	var lid = $(this).attr('data-id');//lang id
	$.get("./help/lang.php",{"getlang":l, "langid":lid}).done(function(data){
	var newdt = $.parseJSON(data);
	if (newdt.resultrequest === 'OK'){
		$('.crtclass').html(newdt.crtlist);
		$('html').attr('lang',newdt.Language);
	}
});
});
//
$('body').on('mouseover', '.country, .region, .city', function(){
	var descr = $(this).attr('data-info');
	$('.descript').text(descr);
});
//
$('body').on('mouseleave', '.country, .region, .city', function(){
	$('.descript').text('');
});
});