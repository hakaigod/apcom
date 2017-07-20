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
            '<td>'+log.detail+ ' 第' +log.quesnum + '問目' +'</td>'+
            '<td>'+log.field+'</td>'+
            '<td>'+log.falsehood+'</td>'+
            '</tr>'
        );
        CountFalsehood(genreCorrectRate,JSON.parse(sessionStorage.getItem('num'+i)));
    }
    //モーダルに正誤情報を記載したプログレスバーを表示する
    SetProgressBar("technology",genreCorrectRate.technology);
    SetProgressBar("management",genreCorrectRate.management);
    SetProgressBar("strategy",genreCorrectRate.strategy);
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

function SetProgressBar(selector,genreCorrectRate){
    "use strict";
    if(genreCorrectRate[1]===0) {
        //該当ジャンルの問題が出題されていない場合、プログレスバーを表示しない
        $('#'+selector+'-topic').html("");
    } else {
        let rate = CalculateAccRate(genreCorrectRate[0],genreCorrectRate[1]);
        $('#progress-'+selector).append(
            '<div class="progress-bar progress-bar-info" style="width:'+rate+'%;">'+
            '<div class="accuracy-rate">'+
            rate + '%</div></div>'
        );
        $('#progress-'+selector).append(
            '<div class="progress-bar progress-bar-danger" style="width:'+(100-rate)+'%;">'+
            '<div class="accuracy-rate">'+
            (100 - rate)+'%</div></div>'
        );
    }
}