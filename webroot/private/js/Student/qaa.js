/**
 * Created by 15110014 on 2017/06/14.
 */
// 正誤の表示
function SelectAns(btnNo) {
    "use strict";
    if (btnNo === 1) {
        // 正解
        document.getElementById("qaa-falsehood").innerHTML = "正解";
        document.getElementById("qaa-falsehood").style.color("red");
    } else {
        // 誤り
        document.getElementById("qaa-falsehood").innerHTML = "不正解";
        document.getElementById("qaa-falsehood").style.color("blue");
    }
}

