/* jshint esversion: 6 */

// データの取得
const $script = $("#script");
const $answer = JSON.parse($script.attr("answer"));

$(function() {
    "use strict";
    $('.choice').click(function () {
        //その他のボタンを無効にする
        $('.choice').prop('disabled', true);
        if ($(this).val() == $answer) {
            document.getElementById("qaa-falsehood").innerHTML = "正解";
        } else {
            let ans = "";
            switch ($answer) {
                case 1:
                    ans = "ア";
                    break;
                case  2:
                    ans = "イ";
                    break;
                case  3:
                    ans = "ウ";
                    break;
                default:
                    ans = "エ";
                    break;
            }
            document.getElementById("qaa-falsehood").innerHTML = "不正解" + "<br>" + "正解：" + ans;
        }
    });
});
