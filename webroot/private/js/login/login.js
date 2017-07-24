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
        var ch =$('#admin').prop('checked');
        //チェックが入ったら
        var defaultsrc = "/apcom/private/img/00000000.png";
        var imgurl;
        var nextimg;

        if (ch) {
            imgurl = $('#admnum').val();
            nextimg = $('#img').attr('src').replace(/[0-9]+/, imgurl);
            if ((imgurl.length === 1 || imgurl.length === 2) && imgurl.length === (imgurl.replace(/[^0-9]+/)).length) {

                $("#img").fadeOut("slow", function () {
                    $('#img').fadeIn();
                    $('#img').attr("src", nextimg).error(function () {
                        $('#img').attr('src', defaultsrc);
                    });
                    $('#img').load(function () {
                        $('#img').fadeIn();
                    });
                });

            }else{
                if ( $('#img').attr('src') !== defaultsrc) {
                    $("#img").fadeOut("slow", function () {
                        $('#img').attr('src', defaultsrc);
                        $('#img').fadeIn();
                    });
                }
            }
        }else{
            imgurl = $('#regnum').val();
            nextimg = $('#img').attr('src').replace(/[0-9]+/, imgurl);
            if (imgurl.length === 8 && imgurl.length === (imgurl.replace(/[^0-9]+/)).length) {

                $("#img").fadeOut("slow", function () {
                    $('#img').fadeIn();
                    $('#img').attr("src", nextimg).error(function () {
                        $('#img').attr('src', defaultsrc);
                    });
                    $('#img').load(function () {
                        $('#img').fadeIn();
                    });
                });

            }else{
                window.console.log($('#img').attr('src') );
                if ($('#img').attr('src') !== defaultsrc) {
                    $("#img").fadeOut("slow", function () {
                        $('#img').attr('src', defaultsrc);
                        $('#img').fadeIn();
                    });
                }
            }

        }
    });


});

