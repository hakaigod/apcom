/* jshint esversion: 6 */
//問題を始めるボタンを押した時にsessionStorageを消す
$(function(){
    "use strict";
    $('form').submit(function (){
        window.sessionStorage.clear();
    });
});