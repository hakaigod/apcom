$(function() {
	$('#show-pass').mousedown(function(){
		$("input[name='old-pass']").attr('type','text');
		$("input[name='new-pass']").attr('type','text');
		$("input[name='verify']").attr('type','text');
	});
	$('#show-pass').mouseup(function(){
        $("input[name='old-pass']").attr('type','password');
        $("input[name='new-pass']").attr('type','password');
        $("input[name='verify']").attr('type','password');
	});
});
