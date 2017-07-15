var $script = $('#script' + num);
var selectAnswer = JSON.parse($script.attr('data-select'));
var correct = JSON.parse($script.attr('data-correct'));
var blue = 'rgba(54, 162, 235, 0.2)';
var red = 'rgba(255, 99, 132, 0.2)';
var boderBlue = 'rgba(54, 162, 235, 1)';
var boderRed = 'rgba(255,99,132,1)';
var label = ["未回答","ア", "イ", "ウ", "エ"];
var BackC = [blue,blue,blue,blue,blue];
var BoderC = [boderBlue,boderBlue,boderBlue,boderBlue,boderBlue];
BackC[correct] = red;
BoderC[correct] = boderRed;

var ctx = document.getElementById("myChart" + num).getContext('2d');
var myChart = new Chart(ctx, {
	type: 'horizontalBar',
	data: {
		labels: label,
		datasets: [{
			data: selectAnswer,
			backgroundColor: BackC,
			borderColor: BoderC,
			borderWidth: 1
		}]
	},
	options: {
		legend: {
			display: false
		},
		scales: {
			xAxes: [{
				ticks: {
					beginAtZero:true
				}
			}]
		}
	}
});
