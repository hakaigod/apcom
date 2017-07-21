/* jshint esversion: 6 */
const $script = $('#script');
const webroot = $script.attr('webroot');
/*警告画面で指定数秒後にジャンル選択画面に遷移*/
$(function () {
    "use strict";
    let count=4;
    setInterval(function () {
        //1秒ごとにカウントダウンのため画面の更新を行う
        $('#countdown').text(count);
        count--;
        if(count===-1){
            window.location.href=webroot;
        }
    },1000);
});