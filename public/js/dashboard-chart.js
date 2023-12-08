
// Monthly Transaction Statistics
var monthNames = [
    "January", "February", "March", "April", "May", "June",
    "July", "August", "September", "October", "November", "December"
];

var statistics_chart = document.getElementById("montly-transaction").getContext('2d');

var montlyTransaction = new Chart(statistics_chart, {
    type: 'line',
    data: {
        labels: monthlyData.map(item => monthNames[item.month - 1]),
        datasets: [{
            label: 'Total Transaction',
            data: monthlyData.map(item => item.total_amount),
            borderWidth: 5,
            borderColor: '#6777ef',
            backgroundColor: 'transparent',
            pointBackgroundColor: '#fff',
            pointBorderColor: '#6777ef',
            pointRadius: 4
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    callback: function(value, index, values) {
                        return 'IDR ' + value.toLocaleString('id-ID');
                    }
                }
            }]
        },
        tooltips: {
            callbacks: {
                label: function(tooltipItem, data) {
                    var value = data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index];
                    return 'IDR ' + value.toLocaleString('id-ID', { minimumFractionDigits: 0, maximumFractionDigits: 2 });
                }
            }
        }
    }
});
