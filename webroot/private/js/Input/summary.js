/*jshint esversion: 6 */
const $script = $("#check-script");
const userName = $script.attr("user-name");
const lineDates = JSON.parse($script.attr("line-dates"));
const lineStudentScore = JSON.parse($script.attr("line-student-score"));
const lineAverages = JSON.parse($script.attr("line-averages"));

const radarAverages = JSON.parse($script.attr("radar-averages"));
const radarUser = JSON.parse($script.attr("radar-user"));

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
                label: '全体平均',
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
            animation:false,
            scales: {
                yAxes: [{
                    ticks: {
                        max:100,
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
            labels: ["テクノロジ","マネジメント","ストラテジ"],
            datasets: [{
                label: userName,
                backgroundColor: "rgba(201,60,58,0)",
                borderColor: "rgba(201,60,58,0.8)",
                data: radarUser
            }, {
                label: '全体平均',
                backgroundColor: "rgba(2,63,138,0)",
                borderColor: "rgba(2,63,138,0.8)",
                data:radarAverages
            }]
        },
	    options:{
		    responsive:true,
		    animation:false,
		    scale:{
			    ticks:{
				    stepSize:20,
				    beginAtZero:true,
				    max:100,
				    min:0
			    }
		    }
	    }
    });
}
drawRadarChart();
drawLineChart();
