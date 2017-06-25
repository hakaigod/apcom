//ジャンル選択で少なくとも１つはチェックがあるかどうか
$(function() {
    "use strict";
    // submit()に関数をバインド
    $('form').submit(function() {
        // もしテキストボックスが空欄だったら…
        // console.log($('#technology:checked').val());?
        if($('.genre:checked').val() !== '1' ) {
            // 警告を出す
            window.alert('ジャンルを選択してください。');
            // 処理を中断
            return false;
        }
    }).get();
});