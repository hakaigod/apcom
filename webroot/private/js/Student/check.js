//ジャンル選択で少なくとも１つはチェックがあるかどうか
$(function() {
    "use strict";
    // submit()に関数をバインド
    $('form').submit(function() {
        // もしチェックボックスにチェックがついていない場合
        if($('.technology:checked').val() !== '1' && $('.strategy:checked').val() !== '2' && $('.management:checked').val() !== '3') {
            // 警告を出す
            window.alert('ジャンルを選択してください。');
            // 処理を中断
            return false;
        }
    });
});