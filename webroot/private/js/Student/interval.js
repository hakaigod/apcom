/* jshint esversion: 6 */
const $script = $('#script');
const webroot = JSON.parse($script.attr('webroot'));
/*警告画面で指定数秒後にジャンル選択画面に遷移*/
$(function () {
    "use strict";
    let count = 3;
    // setTimeout(webroot,count);
    location.href = webroot;
});