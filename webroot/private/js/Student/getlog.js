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
    //テーブルに出題ログを追加する
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
    //テクノロジ
    if(genreCorrectRate.technology[1] === 0) {
        //該当ジャンルの問題が出題されていない場合、プログレスバーを表示しない
        $('#technology-topic').html("");
    } else {
        let rate = CalculateAccRate(genreCorrectRate.technology[0],genreCorrectRate.technology[1]);
        $('#progress-technology').append(
            '<div class="progress-bar progress-bar-info" style="width:'+rate+'%;">' +
            '<div class="accuracy-rate">'+
            rate+'%</div></div>'
        );
        $('#progress-technology').append(
            '<div class="progress-bar progress-bar-danger" style="width:'+(100-rate)+'%;">'+
            '<div class="accuracy-rate">'+
            (100-rate)+'%</div></div>'
        );
    }
    //マネジメント
    if(genreCorrectRate.management[1] === 0) {
        $('#management-topic').html("");
    } else {
        let rate = CalculateAccRate(genreCorrectRate.management[0],genreCorrectRate.management[1]);
        $('#progress-management').append(
            '<div class="progress-bar progress-bar-success" style="width:'+rate+'%;">'+
            '<div class="accuracy-rate">'+
            rate+'%</div></div>'
        );
        $('#progress-management').append(
            '<div class="progress-bar progress-bar-danger" style="width:'+(100-rate)+'%;">'+
            '<div class="accuracy-rate">'+
            (100-rate)+'%</div></div>'
        );
    }
    //ストラテジ
    if(genreCorrectRate.strategy[1] === 0) {
        $('#strategy-topic').html("");
    }else {
        let rate = CalculateAccRate(genreCorrectRate.strategy[0],genreCorrectRate.strategy[1]);
        $('#progress-strategy').append(
            '<div class="progress-bar progress-bar" style="width:'+rate+'%;">'+
            '<div class="accuracy-rate">'+
            rate+'%</div></div>'
        );
        $('#progress-strategy').append(
            '<div class="progress-bar progress-bar-danger" style="width:'+(100-rate)+'%;">'+
            '<div class="accuracy-rate">'+
            (100-rate)+'%</div></div>'
        );
    }
});

//各ジャンルごとの正答数と正解数をカウントして正答率を出す
function CountFalsehood(genreCorrectRate,log) {
    "use strict";
    switch (log.field){
        case "テクノロジー":
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

//正解率の計算
function CalculateAccRate(accuracy,total) {
    "use strict";
    //ゼロ除算回避
    if (accuracy === 0){
        return 0;
    }else{
        return Math.round(accuracy/total*100);
    }
}