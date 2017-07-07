/* jshint esversion: 6 */
//モーダルにsessionStorageの情報を表示させる
$(function(){
    "use strict";
    $('#qaa-detail').click(function () {
        for (let i = 1; i <= sessionStorage.length; i++) {
            // let array = JSON.parse(sessionStorage.getItem('num'+i));
            // window.alert(array);
            console.log(sessionStorage.getItem('num' + i));
            $('#test1').text("aaaaaaaaaaaa");
        }
    });
});