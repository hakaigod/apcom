/* jshint esversion: 6 */
//sessionStorageの情報を表示
const $script = $('#script');
const pgNum = JSON.parse($script.attr('pgNum'));
const serverAddr = JSON.parse($script.attr('server-addr'));
const serverPort = JSON.parse($script.attr('server-port'));

$(function(){
	"use strict";
	let ansArray = ["ア","イ","ウ","エ"];
	for (let i=(pgNum-1)*10; i<(pgNum-1)*10+10; i++) {
		if(i >= sessionStorage.length){
			break;
		}
		let log = JSON.parse(sessionStorage.getItem('num'+(i+1)));
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
	//ページネーター作成
	if(sessionStorage.length < 11){
		//問題数11未満の場合はページネーター表示しない
		$('.pagination-plain').hide();
	}else{
		$('#form-pgnation').append(`<li class="pgtop"><button type="submit" class="pgnation-btn btn btn-embossed btn-primary" id="pgtop" value="1" formaction="1"><<</button></li>`);
		for(let i=1;i<=(sessionStorage.length-1)/10+1 ; i++) {
			if(i == pgNum){
				$('#form-pgnation').append(`<li><button type="submit" class="pgnation-btn btn btn-embossed btn-primary" id="pagination-btn${i}" value="${i}" formaction="${i}" disabled = disabled>${i}</button></li>`);
			} else {
				$('#form-pgnation').append(`<li><button type="submit" class="pgnation-btn btn btn-embossed btn-primary" id="pagination-btn${i}" value="${i}" formaction="${i}">${i}</button></li>`);
			}
		}
		$('#form-pgnation').append(`<li class="pgbottom"><button type="submit" class="pgnation-btn btn btn-embossed btn-primary" id="pgbottom" value="${Math.floor((sessionStorage.length-1)/10+1)}" formaction="${Math.floor((sessionStorage.length-1)/10+1)}">>></button></li>`);
	}
	
	//作成したボタンをクリックした時モーダル表示 ＋ ajaxでコントローラーに値を渡す
	$('.btn-detail').click(function(){
		let qBtnId = $(this).attr("id");
		let log =  JSON.parse(sessionStorage.getItem('num' + qBtnId));
		// //値を送信
		$.ajax({
			url: "http://" + serverAddr + ":"+ serverPort + "/apcom/student/qaaResult/1",
			type: "POST",
			data: {"exanum": log.exanum, "quenum": log.quesnum},
			dataType: "json",
			success : function(data) {
				//タイトル
				$('#question-title').html($('#log-detail'+qBtnId).text());
				//問題文
				$('#question-sentence').html(
					data.question
				);
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
			},
			error: function(data) {
			}
		});
	});
});