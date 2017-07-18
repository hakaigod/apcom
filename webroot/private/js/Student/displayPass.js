$(function() {
	"use strict";
	$('#show-pass').click(function() {
		if($("#old-pass").attr('type') === 'text') {
			$("#old-pass").attr('type','password');
			$("#new-pass").attr('type','password');
			$("#verify").attr('type','password');
			$(this).text("パスワード表示");
		} else {
			$("#old-pass").attr('type','text');
			$("#new-pass").attr('type','text');
			$("#verify").attr('type','text');
			$(this).text("パスワード非表示");
			
		}
	});
});
