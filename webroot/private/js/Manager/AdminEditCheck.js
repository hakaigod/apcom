$(function(){
	$("input").focusin(function(){
		// inputにフォーカスが当たったら色を変える
		$(this).css('border-color', '#1abc9c');
	});

	// admnum
	//暫定的に設置
	$("input[name='admnum']").blur(function(){
		if($(this).val() == "" || !$(this).val().match(/^[0-9]+$/)){
			// 空白・数字以外のとき赤線に変える
			$(this).css('border-color', 'red');
		} else {
			$(this).css('border-color', 'steelblue');
		}
	});

	// stuname
	$("input[name='admname']").blur(function(){
		if(checkname() != ""){
			// 空白、ひらがな・カタカナ・漢字以外のとき赤線に変える
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
		if(checkpass() != ""){
			// 空白・不正文字のとき赤線に変える
			$("input[name='admNewPass']").css('border-color', 'red');
		} else if(checkpassmatch() != "") {
			// 再入力したパスワードが違ったら
			$("input[name='admNewPass']").css('border-color', 'red');
		} else {
			$("input[name='admNewPass']").css('border-color', 'steelblue');
		}
	});
	// renewpass
	$('#renew').blur(function(){
		if(checkpass() != ""){
			// 空白・不正文字のとき赤線に変える
			$("input[name='admNewPass']").css('border-color', 'red');
		} else if(checkpassmatch() != "") {
			// 再入力したパスワードが違ったら
			$("input[name='admNewPass']").css('border-color', 'red');
		} else {
			$("input[name='admNewPass']").css('border-color', 'steelblue');
		}
	});

	$('#addadmin').submit(function(){
		// エラーメッセージ
		var errorMessage = "";
		errorMessage = errorMessage + checkname();
		errorMessage = errorMessage + checkpassmatch();
		errorMessage = errorMessage + checkpass();

		return checkerror(errorMessage);
	});

	$('#modadmin').submit(function(){
		// エラーメッセージ
		var errorMessage = "";
		errorMessage = errorMessage + checkname();
		errorMessage = errorMessage + checkpassmatch();

		return checkerror(errorMessage);
	});

	$('#resetpass').submit(function(){
		// エラーメッセージ
		var errorMessage = "";

		// 暫定設置
		if($("input[name='admnum']").val() == "" || !$("input[name='admnum']").val().match(/^[0-9]+$/)){
			errorMessage = errorMessage + "・管理者連番が半角数字以外です\n";
		}


		if($("input[name='admOldPass']").val() == ""){
			errorMessage = errorMessage + "・古いパスワードが未入力です\n";
		}
		errorMessage = errorMessage + checkpass();
		errorMessage = errorMessage + checkpassmatch();

		return checkerror(errorMessage);
	});


	function checkname() {
		if($("input[name='admname']").val() == ""){
			return "・氏名が未入力です\n";
		} else if (!$("input[name='admname']").val().match(/^[ぁ-んァ-ヶー一-龠　\r\n\t]+$/)) {
			return "・氏名の文字が不正です\n";
		}
		return "";
	}
	function checkpass() {
		if (!$("input[name='admNewPass']").val().match(/^[a-z\d]{8,20}$/i)) {
			return "・パスワードは8文字以上20文字の英数半角で入力してください\n";
		}
		return "";
	}
	function checkpassmatch() {
		errorMessage = "";
		if($("input[name='admNewPass']").val() == ""){
			errorMessage = errorMessage + "・新しいパスワードが未入力です\n";
		}
		if($('#new').val() != $('#renew').val()) {
			errorMessage = errorMessage + "・新しいパスワードが一致しません\n";
		}
		return errorMessage;
	}
	function checkerror(errorMessage) {
		if (errorMessage != "") {
			alert(errorMessage);
			return false;
		} else {
			return true;
		}
	}

});
