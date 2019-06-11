var ctx = document.getElementById('chart_1').getContext('2d');
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datasets: [{
            label: 'Monthly Itineraries Quoted',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor:'rgba(2,117,216, 0.2)',
            borderColor:'rgba(2,117,216, 0.5)',
            borderWidth: 1
        },
        {
          label: 'Monthly Itineraries Converted',
          data: [10, 9, 13, 5.5, 2.2, 13],
          backgroundColor:'rgba(217,83,79, 0.2)',
          borderColor:'rgba(255, 99, 132, 1)',
          borderWidth: 1
        }
        ],


    },

    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
var ctx_1 = document.getElementById('chart_2').getContext('2d');
var myChart = new Chart(ctx_1, {
    type: 'line',
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datasets: [{
            fill:false,
            label: 'Monthly Volume Quoted',
            data: [12, 19, 3, 5, 2, 3],
            backgroundColor:'rgba(2,117,216, 0.2)',
            borderColor:'rgba(2,117,216, 0.5)',
            borderWidth: 1
        },
        {
          fill:false,
          label: 'Monthly Volume Converted',
          data: [10, 9, 13, 5.5, 2.2, 13],
          backgroundColor:'rgba(217,83,79, 0.2)',
          borderColor:'rgba(255, 99, 132, 1)',
          borderWidth: 1
        }
        ],


    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true
                }
            }]
        }
    }
});
