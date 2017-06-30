$(function(){
	$("input").focusin(function(){
		// inputにフォーカスが当たったら色を変える
		$(this).css('border-color', '#1abc9c');
	});
	// depnum
	$("input[name='admnum']").blur(function(){
		if($(this).val() == "" || !$(this).val().match(/^[0-9]+$/)){
			// 空白・数字以外のとき赤線に変える
			$(this).css('border-color', 'red');
		} else {
			$(this).css('border-color', 'steelblue');
		}
	});
	// admOldPass
	$("input[name='admOldPass']").blur(function(){
		if($(this).val() == ""){
			// 空白のとき赤線に変える
			$(this).css('border-color', 'red');
		} else {
			$(this).css('border-color', 'steelblue');
		}
	});
	// newpass
	$('#new').blur(function(){
		if($(this).val() == ""){
			// 空白のとき赤線に変える
			$("input[name='admNewPass']").css('border-color', 'red');
		} else if($('#new').val() != $('#renew').val()) {
			// 再入力したパスワードが違ったら
			$("input[name='admNewPass']").css('border-color', 'red');
		} else if (!$(this).val().match(/^[a-z\d]{8,20}$/i)) {
			// passが8文字以上20文字の英数半角ではなかったら
			$("input[name='admNewPass']").css('border-color', 'red');
		} else {
			$("input[name='admNewPass']").css('border-color', 'steelblue');
		}
	});
	// newpass
	$('#renew').blur(function(){
		if($(this).val() == ""){
			// 空白のとき赤線に変える
			$("input[name='admNewPass']").css('border-color', 'red');
		} else if($('#new').val() != $('#renew').val()) {
			// 再入力したパスワードが違ったら
			$("input[name='admNewPass']").css('border-color', 'red');
		} else if (!$(this).val().match(/^[a-z\d]{8,20}$/i)) {
			// passが8文字以上20文字の英数半角ではなかったら
			$("input[name='admNewPass']").css('border-color', 'red');
		} else {
			$("input[name='admNewPass']").css('border-color', 'steelblue');
		}
	});

	$("#submit").click(function(){
		// エラーメッセージ
		var errorMessage = "";
		if($("input[name='admnum']").val() == "" || !$("input[name='admnum']").val().match(/^[0-9]+$/)){
			errorMessage = errorMessage + "・管理者連番が半角数字以外です\n";
		}
		if($("input[name='admOldPass']").val() == ""){
			errorMessage = errorMessage + "・古いパスワードが未入力です\n";
		}
		if($("input[name='admNewPass']").val() == ""){
			errorMessage = errorMessage + "・新しいパスワードが未入力です\n";
		}
		if($('#new').val() != $('#renew').val()) {
			errorMessage = errorMessage + "・新しいパスワードが一致しません\n";
		}
		if (!$("input[name='admNewPass']").val().match(/^[a-z\d]{8,20}$/i)) {
			errorMessage = errorMessage + "・パスワードは8文字以上20文字の英数半角で入力してください\n";
		}

		if (errorMessage != "") {
			alert(errorMessage);
		} else {
			alert("OK");
			$('#resetpass').submit();
		}
	});
});
