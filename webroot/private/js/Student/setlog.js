/* jshint esversion: 6 */
// データの取得
const $script = $('#script');
const qnum = JSON.parse($script.attr('qnum'));
const quesnum = JSON.parse($script.attr('quesnum'));
const answer = JSON.parse($script.attr('answer'));
const field = JSON.parse($script.attr('field'));
const detail = JSON.parse($script.attr('detail'));
const exanum = JSON.parse($script.attr('exanum'));
const quenum = JSON.parse($script.attr('quenum'));
$(function() {
    "use strict";
    let falsehood = "未回答";
    let yourSelect = "未回答";
    //正誤処理
    $('.choice').click(function (){
        //全てのボタンの無効化
        $('.choice').prop('disabled', true);
        //正誤判定
        let ans = new Array("ア","イ","ウ","エ");
        if ($(this).val() == ans[answer-1]) {
            document.getElementById("qaa-falsehood").innerHTML = "正解";
            falsehood = "正解";
        } else {
            document.getElementById("qaa-falsehood").innerHTML = "不正解"+"<br>"+"正解："+ans[answer-1];
            falsehood = "不正解";
        }
	        yourSelect = $(this).val();
    });
    //セッションへの保存処理
    $('form').submit(function() {
        if (('sessionStorage' in window) && (window.sessionStorage !== null)) {
            // セッションストレージが使える
            let answerLog = {
                'qNum':qnum,
                'quesnum':quesnum,
                'answer':answer,
                'field':field,
                'detail':detail,
                'falsehood':falsehood,
                'exanum':exanum,
                'yourSelect':yourSelect
            };
            let list = JSON.stringify(answerLog);
            sessionStorage.setItem("num" + qnum,list);
        }
    });
});
