/* jshint esversion: 6 */
//モーダルにsessionStorageの情報を表示させる
$(function(){
    "use strict";
    //モーダルに今までの問題の情報ログを表示する
    //正解総数と総回答数を格納["正解数",”総回答数”]
    let genreCorrectRate =
        {
            "technology":[0,0],
            "management":[0,0],
            "strategy":[0,0]
        };
    for (let i = 1; i <= sessionStorage.length; i++) {
        let log = JSON.parse(sessionStorage.getItem('num'+i));
        //ログ情報1行分を追加
        $('#log-table').append(
            '<tr>'+
            '<td>'+log.qNum+'</td>'+
            '<td>'+log.quesnum+'</td>'+
            '<td>'+log.detail+'</td>'+
            '<td>'+log.field+'</td>'+
            '<td>'+log.falsehood+'</td>'+
            '</tr>'
        );
        CountFalsehood(genreCorrectRate,JSON.parse(sessionStorage.getItem('num'+i)));
    }
    //モーダルに正誤情報を記載したプログレスバーを表示する
    $('#total-info').append(
        '<div class="col-md-3">'+
            '<div style="font-size:16px;">テクノロジ:</div>'+
        '</div>'+
        '<div class="col-md-9">'+
            '<div class="progress">'+
                '<div class="progress-bar progress-bar-info" style="width:'+
                    genreCorrectRate.strategy[0]/genreCorrectRate.strategy[1]+'%;'+'">"'+
                '</div>'+
            </div>
            </div>
            </div>
            <div class="row">
            <div class="col-md-3">
            <div style="font-size:16px">マネジメント：</div>
        </div>
        <div class="col-md-9">
            <div class="progress">
            <div class="progress-bar progress-bar-warning" style="width: 100%;"></div>
            </div>
            </div>
            </div>
            <div class="row">
            <div class="col-md-3">
            <div style="font-size:16px">ストラテジ：</div>
        </div>
        <div class="col-md-9">
            <div class="progress">
            <div class="progress-bar progress-bar-success" style="width: 100%;"></div>
            </div>
            </div>
        );

});

//各ジャンルごとの正答数と正解数をカウントする
function CountFalsehood(genreCorrectRate,log) {
    "use strict";
    switch (log.falsehood){
        case "テクノロジ":
            genreCorrectRate.technology[1]+=1;
            if(log.falsehood==="正解") {
                genreCorrectRate.technology[0]+= 1;
            }
            break;
        case "マネジメント":
            genreCorrectRate.management[1]+=1;
            if(log.falsehood==="正解") {
                genreCorrectRate.management[0]+= 1;
            }
            break;
        case "ストラテジ":
            genreCorrectRate.strategy[1]+=1;
            if(log.falsehood==="正解") {
                genreCorrectRate.strategy[0]+= 1;
            }
    }
}