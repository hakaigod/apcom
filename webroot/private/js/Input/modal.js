/*jshint esversion: 6 */
const $modalScript = $("#modal-script");
const exanum =  $modalScript.attr("exanum");

$(function() {
	"use strict";
//作成したボタンをクリックした時モーダル表示 ＋ ajaxでコントローラーに値を渡す
	$('.btn-detail').click(function () {
		
		let qBtnVal = $(this).val();
		// //値を送信
		$.ajax({
			url: "http://"+ location.host +"/apcom/student/qaaResult/1",
			type: "POST",
			data: {"exanum": exanum, "quenum": qBtnVal},
			dataType: "json",
			success: function (data) {
				//タイトル
				$('#question-title').text($('#log-detail' + qBtnVal).text());
				//問題文
				$('#question-sentence').html(
					data.question
				);
				//選択肢画像がある場合表示
				$('#qaa-answerpic').html(data.answer_pic);
				//answer_picに画像がある場合の処理
				$('#result-table').show();
				for (let i = 1; i <= 4; i++) {
					let key = "choice" + i;
					$('#question-' + key).html(data[key]);
				}
				//選択肢文章ない場合
				if (data.answer_pic !== "") {
					$('#result-table').hide();
				}
			},
			error: function (data) {
			}
		});
	});
});