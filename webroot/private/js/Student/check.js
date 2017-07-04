//ジャンル選択で少なくとも１つはチェックがあるかどうか
$(function() {
    "use strict";
    // submit()に関数をバインド
    $('form').submit(function() {
        // もしチェックボックスにチェックがついていない場合
        if($('#genre-1:checked').val() !== '1' && $('#genre-2:checked').val() !== '2' && $('#genre-3:checked').val() !== '3') {
            // 警告を出す
            window.alert('ジャンルを選択してください。');
            // 処理を中断
            return false;
        }
    });
});