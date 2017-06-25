/*jshint esversion: 6 */
//上の行はES6を使うことを明示する
//上の行はjQueryの$の警告を抑制する

//scriptIDのタグのアトリビュートからデータを取得する
//変わらないのでconst
const $script = $("#script");
const isAnsed = JSON.parse($script.attr("isAnsed"));
const pageNum = JSON.parse($script.attr("curNum"));
$(function(){
    "use strict";
    //完了ボタンが押されたとき
    $("#end_answer").click(function () {
        //1や11,21など一番最初の問題番号が入る
        let firstNum = (pageNum - 1) *10 + 1;
        if (isAnsed && isFinite(pageNum)) {
            let isAllAnsed = true;
            for (let qNum = firstNum; qNum < firstNum + 10; qNum++) {
                //各ラジオボタングループにcheckedクラスを持つ部品が存在するか確認
                if (!($(`input[name=answer_${qNum}]`).is(':checked'))){
                    isAllAnsed = false;
                    break;
                }
            }
            // if(){
            //     $("#end_answer").submit();
            // }else {
            //     return;
            // }
            if (isAllAnsed) {
                if(window.confirm('解答を完了しますか？')) {
                    $("#answer-form").submit();
                }
            }else{
                window.alert("このページに未解答の問題があります");
            }
        }else {
            window.alert("未解答の問題ページがあります");
        }
        return false;
    });
});