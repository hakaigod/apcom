$(function() {
    "use strict";
    // 「全てにチェック」のチェックボックスをチェックしたら発動
    $('#checkbox').change(function() {

        var ch =$('#checkbox').prop('checked');
        //チェックが入ったら
        if (ch) {
            var admin1 = $('#text1').text().replace(/学籍/g, '管理者');
            $('#text1').text(admin1);
            $(document).ready(function(){
            $('#regnum').attr('placeholder','管理者番号を入力');
        });

            // window.alert("kanrisya");
        } else {
            var stu1 = $('#text1').text().replace(/管理者/g, '学籍');
            $('#text1').text(stu1);
            $(document).ready(function(){
                $('#regnum').attr('placeholder','学籍番号を入力');
            });
        }
    });
});