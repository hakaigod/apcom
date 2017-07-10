$(function(){
	$("input").focusin(function(){
		// inputにフォーカスが当たったら色を変える
		$(this).css('border-color', '#1abc9c');
	});
	// stuname
	$("input[name='depname']").blur(function(){
		if(checkname() != ""){
			// 空白、ひらがな・カタカナ・漢字以外のとき赤線に変える
			$(this).css('border-color', 'red');
		} else {
			$(this).css('border-color', 'steelblue');
		}
	});

	$('#depManager').submit(function(){
		// エラーメッセージ
		var errorMessage = "";
		errorMessage = errorMessage + checkname();

		return checkerror(errorMessage);
	});

	function checkname() {
		if($("input[name='depname']").val() == ""){
			return "・学科名が未入力です\n";
		} else if (!$("input[name='depname']").val().match(/^[ぁ-んァ-ヶー一-龠　\r\n\t]+$/)) {
			return "・学科名の文字が不正です\n";
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
