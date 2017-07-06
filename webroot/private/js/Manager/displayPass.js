$(function() {
	$('#passcheck').click(function() {
		if($("input[name$='Pass']").attr('type') == 'text') {
			$("input[name$='Pass']").attr('type','password');
			$(this).text("パスワード表示");
		} else {
			$("input[name$='Pass']").attr('type','text');
			$(this).text("パスワード非表示");
		}
	});
});
