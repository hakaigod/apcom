/* jshint esversion: 6 */
//sessionStorageの情報を表示
$(function(){
    "use strict";
    for (let i = 1; i <= sessionStorage.length; i++) {
        if(i > sessionStorage.length){
            break;
        }
        let log = JSON.parse(sessionStorage.getItem('num'+i));
        //ログ情報1行表示
        $('#log-table').append(
            '<tr>'+
            `<td><button class="btn-detail" id="${log.qNum}">問:${log.qNum}</button></td>`+
            '<td>'+log.detail+ '第' +log.quesnum + '問目' +'</td>'+
            '<td>'+log.field+'</td>'+
            '<td>'+log.falsehood+'</td>'+
            '</tr>'
        );
    }
    //作成したボタンをクリックした時モーダル表示 ＋ ajaxでコントローラーに値を渡す
    $('.btn-detail').click(function(){
        let qBtnId = $(this).attr("id");
        window.console.log(qBtnId);
        let log = sessionStorage.getItem('num' + qBtnId);
        let logArray = [log.qNum,log.exanum,log.quenum];
        //値を送信
        $.ajax({
            url:"http://localhost:8080/apcom/student/qaaResult/1",
            type:"POST",
            data:{"logArray":logArray},
            dataType:"json"
        }).done(function(){
            
            });
        // window.console.log(webroot);
        // return false;
    });
});