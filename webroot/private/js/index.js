$(function(){
	$('#list').click(function (){
		$('#list').slideUp();
		$('#sidebar').slideDown();
	});
	$('#cross').click(function (){
		$('#list').slideDown();
		$('#sidebar').slideUp();
	});
	
});
