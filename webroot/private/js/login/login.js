$(function() {
    "use strict";
    // 「全てにチェック」のチェックボックスをチェックしたら発動
    function changeadm() {
        var ch =$('#admin').prop('checked');
        //チェックが入ったら
        if (ch) {
            /*          $('#num').html("");
             $('#pass').html("");*/
            $('#regnum').attr('name', "admnum");
            $('#regnum').attr('id', "admnum");
            $('#stupass').attr('name', "admpass");
            $('#stupass').attr('id', "admpass");
            var admin1 = $('#text1').text().replace(/学籍/g, '管理者');
            $('#text1').text(admin1);

        } else {
            /*          $('#num').html("");
             $('#pass').html("");*/
            $('#admnum').attr('name', "regnum");
            $('#admnum').attr('id', "regnum");
            $('#admpass').attr('name', "stupass");
            $('#admpass').attr('id', "stupass");
            var stu1 = $('#text1').text().replace(/管理者/g, '学籍');
            $('#text1').text(stu1);
        }
    }
    $('#admin').change(function() {
        changeadm();
    });
    changeadm();


    $('#regnum').on('input', function(){

        var defaultsrc = $('#img').attr('src');
        var imgurl = $('#regnum').val();

        if(imgurl.length === 8 && imgurl.length === (imgurl.replace(/[^0-9]+/)).length) {
            $('#img').attr('src', $('#img').attr('src').replace(/[0-9]+/, imgurl));

            $('#img').error(function() {
                //置換処理
                $('#img').attr('src',defaultsrc);
            });
        }
    });



    $('#forget').click(function(){
        window.alert("先生に聞いてねはーと");
        return false;
    });

});