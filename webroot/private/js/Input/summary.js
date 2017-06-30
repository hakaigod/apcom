/*jshint esversion: 6 */
const $script = $("#check-script");
const userName = $script.attr("user-name");
const lineDates = JSON.parse($script.attr("line-dates"));
const lineStudentScore = JSON.parse($script.attr("line-student-score"));
const lineAverages = JSON.parse($script.attr("line-averages"));

function drawLineChart() {
    "use strict";
    let ctx = document.getElementById('lineChart').getContext('2d');

    let lineChart = new Chart(ctx, {
        type: 'line',
        data: {
            //模擬試験実施の日付(平成24年 春 二回目?)など
            labels: lineDates,
            datasets: [{
                //生徒の名前
                label: userName,
                data: lineStudentScore,
                fill: false,
                borderWidth: 3,
                borderColor: "rgba(201,60,58,0.8)",
                pointBackgroundColor: "rgba(201,60,58,0.6)",
                pointBorderColor: "rgba(201,60,58,0.4)",
                pointBorderWidth: 8,
                lineTension: 0
            }, {
                //
                label: '平均点',
                data: lineAverages,
                fill: false,
                borderWidth: 3,
                borderColor: "rgba(2,63,138,0.8)",
                pointBackgroundColor: "rgba(2,63,138,0.6)",
                pointBorderColor: "rgba(2,63,138,0.4)",
                pointBorderWidth: 8,
                lineTension: 0
            }]
        },
        options:{
            responsive:true,
            animation:{
                easing:'easeOutQuint',
                duration:500
            },
            scales: {
                yAxes: [{
                    ticks: {
                        max:80,
                        beginAtZero:true
                    }
                }]
            }
        }
    });
}

function drawRadarChart() {
    "use strict";
    let ctx = document.getElementById("radarChart");
    let radarChart = new Chart(ctx, {
        type: 'radar',
        data: {
            labels: ["M", "T", "W", "T", "F", "S", "S"],
            datasets: [{
                label: 'apples',
                backgroundColor: "rgba(153,255,51,0.4)",
                borderColor: "rgba(153,255,51,1)",
                data: [12, 19, 3, 17, 28, 24, 7]
            }, {
                label: 'oranges',
                backgroundColor: "rgba(255,153,0,0.4)",
                borderColor: "rgba(255,153,0,1)",
                data: [30, 29, 5, 5, 20, 3, 10]
            }]
        }
    });
}
drawRadarChart();
drawLineChart();