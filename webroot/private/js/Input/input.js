/*jshint esversion: 6 */
//上の行はES6を使うことを明示する
//上の行はjQueryの$の警告を抑制する

//IDがscriptのタグのアトリビュートからデータを取得する
//変わらないのでconst
const $script = $("#check-script");
const isAnsed = JSON.parse($script.attr("isAnsed"));
const pageNum = JSON.parse($script.attr("curNum"));
$(function(){
    "use strict";
    //完了ボタンが押されたとき
    $("#end_answer").click(function () {
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
                $('<input>').attr({
                    type: 'hidden',
                    name: 'curNum',
                    value: pageNum
                }).appendTo('#finish-answer');
                $("#answer-form").submit();
            }
        }else {
            window.alert("未解答の問題ページがあります");
            return false;
        }
    });
    
    $('.answers-div > label').click(function ()  {
        console.log("clicked");
        let clickedValue = $(this).children('input').eq(0).val();
        console.log(clickedValue);
        $(this)
            .closest('tr')
            .children('td').eq(3)
            .find('input')
            .each(function () {
                let yetClicked = clickedValue === '0';
                $(this).prop("disabled",yetClicked);
                if (yetClicked) {
                    $(this).closest('label').addClass('disabled');
                }else{
                    $(this).closest('label').removeClass('disabled');
                }
            });
    });
    
    
});