/*jshint esversion: 6 */
const $script = $("#script");
const isAnsed = JSON.parse($script.attr("isAnsed"));
const pageNum = JSON.parse($script.attr("curNum"));
$(function(){
    "use strict";
    $("#end_answer").click(function () {
        let firstNum = (pageNum - 1) *10;
        if (isAnsed && isFinite(pageNum)) {
            for (let qnum = firstNum; qnum < firstNum + 10; qnum++) {
                if ($(`answer_${qnum} input:checked`).length <= 0){
                    window.alert("おえん");
                }
            }

        }else {
            window.alert("おえん");
        }

    });
});