$(function(){
	$("input").focusin(function(){
		// inputにフォーカスが当たったら色を変える
		$(this).css('border-color', '#1abc9c');
	});
	// stunum
	$("input[name='stunum']").blur(function(){
		if(checknum() != ""){
			// 空白、数字以外、8桁以外のとき赤線に変える
			$(this).css('border-color', 'red');
		} else {
			$(this).css('border-color', 'steelblue');
		}
	});
	// stuname
	$("input[name='stuname']").blur(function(){
		if(checkname() != ""){
			// 空白、ひらがな・カタカナ・漢字以外のとき赤線に変える
			$(this).css('border-color', 'red');
		} else {
			$(this).css('border-color', 'steelblue');
		}
	});

	$('#stuManager').submit(function(){
		// エラーメッセージ
		var errorMessage = "";
		errorMessage = errorMessage + checknum();
		errorMessage = errorMessage + checkname();

		return checkerror(errorMessage);
	});
	$('#reIssuPass').submit(function(){
		// エラーメッセージ
		var errorMessage = "";
		errorMessage = errorMessage + checknum();

		return checkerror(errorMessage);
	});


	function checknum() {
		errorMessage = "";
		if($("input[name='stunum']").val() == ""){
			return "・学籍番号が未入力です\n";
		} else if(!$("input[name='stunum']").val().match(/^[0-9]+$/)) {
			return "・学籍番号が半角数字以外です\n";
		} else if($("input[name='stunum']").val().length != 8) {
			return "・学籍番号は８桁で入力してください\n";
		}
		return "";
	}
	function checkname() {
		if($("input[name='stuname']").val() == ""){
			return "・氏名が未入力です\n";
		} else if (!$("input[name='stuname']").val().match(/^[ぁ-んァ-ヶー一-龠　\r\n\t]+$/)) {
			return "・氏名の文字が不正です\n";
		}
		return "";
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
