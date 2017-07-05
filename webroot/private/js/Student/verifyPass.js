/*jshint esversion: 6 */

$(function(){
	"use strict";


	$(".pass-form").blur(function () {
        console.log("started");
        let borderColor = 'red';
        let text = $(this).val();
        console.log(text);
		if (isNotNull(text)) {
            console.log("old is not null");

            if (isAlphaNum(text)) {
				borderColor = 'steelblue';
                console.log("old is alphanum");
			}else {
                //TODO:エラーメッセージ表示
                console.log("old is not alphanum");
            }
        }else{
			//TODO:エラーメッセージ表示
            console.log("old is null");
		}
        $(this).css("border-color",borderColor);
    });

	// admnum
	$(".newers").blur(function(){
        let borderColor = 'red';
        let firstForm = $('#new-pass').val();
        let secondForm = $('#verify').val();
        //一つ目のフォームが未入力だったら何もしない
        if (!(isNotNull(firstForm))) {
        	return;
		}
		//
		if (isNotNull(secondForm)) {
			if (isAlphaNum(firstForm) && isAlphaNum(secondForm)) {
                borderColor = 'steelblue';
			}else{
                //TODO:エラーメッセージ表示
			}
		}else{
            //TODO:エラーメッセージ表示
        }
        $("#verify").css("border-color",borderColor);

    });
    function isNotNull(text){
        return text !== "";
    }
	function isAlphaNum(text){
        return text.match(/^[a-z\d]{8,20}$/i);
    }
});
