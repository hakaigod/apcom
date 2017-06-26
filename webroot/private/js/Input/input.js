/*jshint esversion: 6 */
//上の行はES6を使うことを明示する
//上の行はjQueryの$の警告を抑制する

//IDがscriptのタグのアトリビュートからデータを取得する
//変わらないのでconst
const $script = $("#script");
const isAnsed = JSON.parse($script.attr("isAnsed"));
const pageNum = JSON.parse($script.attr("curNum"));
$(function(){
    "use strict";
    //完了ボタンが押されたとき
    $("#end_answer").click(function () {
        //
        if (isAnsed && isFinite(pageNum)) {
            //1や11,21など一番最初の問題番号が入る
            let firstNum = (pageNum - 1) *10 + 1;
            //最後の10問がすべて選択されているかどうか
            for (let qNum = firstNum; qNum < firstNum + 10; qNum++) {
                //各解答ラジオボタングループにcheckedクラスを持つものがあるか
                let selectedAns = $(`input[name=answer_${qNum}]`).is(':checked');
                //各自信度ラジオボタングループにcheckedクラスを持つものがあるか
                let selectedConf = $(`input[name=confidence_${qNum}]`).is(':checked');
                //どちらか一つでもないときは解答に不備がある
                if (!(selectedAns) || !(selectedConf)){
                    window.alert("このページに未解答の問題があります");
                    return false;
                }
            }
            if(window.confirm('解答を完了しますか？')) {
                $("#answer-form").submit();
            }
        }else {
            window.alert("未解答の問題ページがあります");
            return false;
        }
    });
});