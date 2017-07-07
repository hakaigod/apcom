/* jshint esversion: 6 */
// データの取得
const $script = $('#script');
const qnum = JSON.parse($script.attr('qnum'));
const answer = JSON.parse($script.attr('answer'));
const field = JSON.parse($script.attr('field'));
const detail = JSON.parse($script.attr('detail'));
$(function() {
    "use strict";
    let falsehood = "未回答";
    //正誤処理
    $('.choice').click(function (){
        //全てのボタンの無効化
        $('.choice').prop('disabled', true);
        //正誤判定
        let ans = new Array("ア","イ","ウ","エ");
        if ($(this).val() == ans[answer]) {
            document.getElementById("qaa-falsehood").innerHTML = "正解";
            falsehood = "O";
        } else {
            document.getElementById("qaa-falsehood").innerHTML = "不正解"+"<br>"+"正解："+ans[answer];
            falsehood = "X";
        }
    });
    //セッションへの保存処理
    $('form').submit(function() {
        if (('sessionStorage' in window) && (window.sessionStorage !== null)) {
            // セッションストレージが使える
            let answerLog = {
                    'answer':answer,
                    'field':field,
                    'detail':detail,
                    'falsehood':falsehood
            };

            let list = JSON.stringify(answerLog);
            sessionStorage.setItem("num" + qnum,list);
        }
    });
});
