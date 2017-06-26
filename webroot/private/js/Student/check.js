//ジャンル選択で少なくとも１つはチェックがあるかどうか
$(function() {
    "use strict";
    // submit()に関数をバインド
    $('form').submit(function() {
        // もしチェックボックスにチェックがついていない場合
        if($('.genre:checked').val() === '0' ) {
            // 警告を出す
            window.alert('ジャンルを選択してください。');
            // 処理を中断
            return false;
        }
    }).get();
});