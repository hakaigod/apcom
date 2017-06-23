/*jshint esversion: 6 */
//上の行はES6を使うことを明示する

//scriptIDのタグのアトリビュートからデータを取得する
//変わらないのでconst
const $script = $("#script");
const isAnsed = JSON.parse($script.attr("isAnsed"));
const pageNum = JSON.parse($script.attr("curNum"));
$(function(){
    "use strict";
    //完了ボタンが押されたとき
    $("#end_answer").click(function () {
        let firstNum = (pageNum - 1) *10;
        if (isAnsed && isFinite(pageNum)) {
            for (let qnum = firstNum; qnum < firstNum + 10; qnum++) {
                //各ラジオボタングループにcheckedクラスを持つ部品が存在するか確認
                if ($(`answer_${qnum} input:checked`).length <= 0){
                    window.alert("おえん");
                }
            }
        }else {
            window.alert("おえん");
        }
    });
});