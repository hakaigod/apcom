/*jshint esversion: 6 */


$(function(){
	"use strict";
	
	const NOT_INPUTTED = "パスワードが未入力です。";
	const NOT_ALPHANUM = "パスワードは8～20文字の英数字で入力してください。";
	const INCONSISTENT = "パスワードが一致していません。";
	$("#old-pass").blur(function () {
        let text = $(this).val();
		let errorMessage = checkText(text);
		if (errorMessage === null) {
			$(this).css("border-color","steelblue");
			$("#old-pass-text").text("");
		}else{
			$(this).css("border-color","red");
			$("#old-pass-text").text(errorMessage);
			
		}
    });

	$(".newer").blur(function(){
		let idArray = {
			0 : {
				"id":"#new-pass",
				"color":"",
				"text":""
			},
			1 : {
				"id":"#verify",
				"color":"",
				"text":""
			}
		};
		
        let firstForm = $(idArray[0].id).val();
        let secondForm = $(idArray[1].id).val();
		
		let firstFormError = checkText(firstForm);
        let secondFormError = checkText(secondForm);
        
        if (firstFormError !== null) {
	        idArray[0].color = 'red';
	        idArray[0].text = firstFormError;
        }else if (secondFormError !== null) {
	        idArray[1].color = 'red';
	        idArray[1].text = secondFormError;
        }else if (firstForm !== secondForm) {
	        idArray[1].color = 'red';
	        idArray[1].text = INCONSISTENT;
        }else{
	        idArray[0].color = 'steelblue';
	        idArray[1].color = 'steelblue';
        }
        $.each(idArray,function (key, val) {
	        $(val.id + "-text").text(val.text);
	        $(val.id).css("border-color", val.color);
        });
    });
	$("#register-button").click(function () {
		let validate_success = true;
		$.each(["#old-pass","#new-pass","#verify"],function (key,val) {
			let text = $(val).val();
			let errorMessage = checkText(text);
			if (errorMessage !== null) {
				window.alert(errorMessage);
				validate_success = false;
				return false;
			}
		});
		if (validate_success) {
			console.log("waaa");

			if ($("#new-pass").val() !== $("#verify").val()) {
				window.alert(INCONSISTENT);
				return false;
			}
			console.log("aa");
			$("#change-pass").submit();
		}
	});
	function checkText(text) {
		if (!(isNotNull(text))) {
			return NOT_INPUTTED;
		}
		if (!(isAlphaNum(text))){
			return NOT_ALPHANUM;
		}
		return null;
	}
	
    function isNotNull(text){
        return text !== "";
    }
	function isAlphaNum(text){
        return text.match(/^[a-z\d]{8,20}$/i);
    }
});
