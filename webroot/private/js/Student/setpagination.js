/* jshint esversion: 6 */
//sessionStorageの情報を表示
$(function(){
	"use strict";
	let ansArray = ["ア","イ","ウ","エ"];
	for (let i = 1; i <= 10; i++) {
		if(i > sessionStorage.length){
			break;
		}
		let log = JSON.parse(sessionStorage.getItem('num'+i));
		//ログ情報1行表示
		$('#log-table').append(
			`<tr>
			<td><button class="btn-detail btn btn-info full" data-toggle="modal" data-target="#myModal" id="${log.qNum}">問:${log.qNum}</button></td>
			<td><div id="log-detail${log.qNum}">${log.detail}第${log.quesnum}問目</div></td>
			<td>${log.field}</td>
			<td><div id="log-selectans${log.qNum}">${log.falsehood}</td>
			</tr>`
		);
	}
	//作成したボタンをクリックした時モーダル表示 ＋ ajaxでコントローラーに値を渡す
	$('.btn-detail').click(function(){
		let qBtnId = $(this).attr("id");
		let log =  JSON.parse(sessionStorage.getItem('num' + qBtnId));
		// //値を送信
		$.ajax({
			url: "http://localhost:8080/apcom/student/qaaResult/1",
			type: "POST",
			data: {"exanum": log.exanum, "quenum": log.quesnum},
			dataType: "json",
			success : function(data) {
				window.console.log(data);
				//タイトル
				$('#question-title').html($('#log-detail'+qBtnId).text());
				//問題文
				$('#question-sentence').html(
					data.question
				);
				//選択肢
				//選択肢画像がある場合表示
				$('#qaa-answerpic').html(data.answer_pic);
				//answer_picに画像がある場合の処理
				$('#result-table').show();
				for(let i = 1; i <= 4; i++){
					let key = "choice" + i;
					$('#question-' + key).html(data[key]);
				}
				//選択肢文章ない場合
				if(data.answer_pic !== "") {
					$('#result-table').hide();
				}
				$('#log-yourans').html(`あなたの回答：<b>${log.yourSelect}</b>`);
				$('#log-ans').html(`正解：<b>${ansArray[data.answer - 1]}</b>`);
				window.console.log(data.answer);
			},
			error: function(data) {
			}
		});
	});
});