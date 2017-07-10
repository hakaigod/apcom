$(function() {
	$('#passcheck').mousedown(function(){
		$("input[name='admOldPass']").attr('type','text');
		$("input[name='admNewPass']").attr('type','text');
	});
	$('#passcheck').mouseup(function(){
		$("input[name='admOldPass']").attr('type','password');
		$("input[name='admNewPass']").attr('type','password');
	});
});
