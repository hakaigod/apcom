/* jshint esversion: 6 */
// データの取得
const $script = $('#script');
const qnum = JSON.parse($script.attr('qnum'));
const answer = JSON.parse($script.attr('answer'));
const field = JSON.parse($script.attr('field'));
const detail = JSON.parse($script.attr('detail'));
$(function() {
    "use strict";
    $('form').submit(function() {
        if (('sessionStorage' in window) && (window.sessionStorage !== null)) {
            // セッションストレージが使える
            let answerLog =
                new Array(
                    {
                        "qNum": qnum,
                        "field": field,
                        "detail": detail,
                        "falsehood": 'a'
                    }
                );
            let list = JSON.stringify(answerLog);
            // sessionStorage.setItem("Runa","ルナだよ");
            sessionStorage.setItem("list",answerLog);
        }
        window.alert("ルナだよ");
    });
});