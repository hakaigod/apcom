/* jshint esversion: 6 */

// データの取得
const $script = $("#script")
const $select = JSON.parse($script.attr("select"));
const $answer = JSON.parse($script.attr("answer"));

$(function () {
   "use strict";
    //選択肢ボタンが押された時の処理
    $(".btn-embossed").click(function () {
        //回答があっていた場合
        if ($select === $answer){
            $("#qaa-falsehood").
        } else {

        }
    });
});