/*jshint esversion: 6 */
const $script = $("#graph-script");
const userName = $script.attr("user-name");

const radarAverages = JSON.parse($script.attr("radar-averages"));
const radarUser = JSON.parse($script.attr("radar-user"));

function drawRadarChart() {
    "use strict";
    let ctx = document.getElementById("radarChart");
    let radarChart = new Chart(ctx, {
        type: 'radar',
        data: {
            labels: ["テクノロジ","マネジメント","ストラテジ"],
            datasets: [{
                label: userName,
                backgroundColor: "rgba(153,255,51,0.4)",
                borderColor: "rgba(153,255,51,1)",
                data: radarUser
            }, {
                label: '受験者平均',
                backgroundColor: "rgba(255,153,0,0.4)",
                borderColor: "rgba(255,153,0,1)",
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
