/* jshint esversion: 6 */

// データの取得
const $script = $("#script")
const $answer = JSON.parse($script.attr("answer"));

function selectAnswer(select) {
    "use strict"
    if(select === $answer){
        document.getElementById("qaa-falsehood").innerHTML = "正解";
    } else {
        document.getElementById("qaa-falsehood").innerHTML = "不正解"+"<br>"+"正解："+$answer;
    }
    //その他のボタンを
    $("#choice").prop("disabled",false);
}