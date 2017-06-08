var ctx = document.getElementById("myChart" + qno);
var myChart = new Chart(ctx, {
	type: 'doughnut',
	data: {
		labels: ["ア", "イ", "ウ", "エ"],
		datasets: [{
			data: [12, 19, 3, 5],
			backgroundColor: [
				'rgba(255, 99, 132, 0.2)',
				'rgba(54, 162, 235, 0.2)',
				'rgba(255, 206, 86, 0.2)',
				'rgba(75, 192, 192, 0.2)'
			],
			borderColor: [
				'rgba(255,99,132,1)',
				'rgba(54, 162, 235, 1)',
				'rgba(255, 206, 86, 1)',
				'rgba(255, 159, 64, 1)'
			],
			borderWidth: 1
		}]
	},
	options: {
		legend: {
			display: false
		},
		animation: false
	}
});
