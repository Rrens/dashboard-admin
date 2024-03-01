
var chartColors = {
    red: 'rgb(255, 99, 132)',
    orange: 'rgb(255, 159, 64)',
    yellow: 'rgb(255, 205, 86)',
    green: 'rgb(75, 192, 192)',
    info: '#41B1F9',
    blue: '#3245D1',
    purple: 'rgb(153, 102, 255)',
    grey: '#EBEFF6'
};

// CHEAT PERIODE
var ctxBarCheatPeriode = document.getElementById("barCheatPeriode").getContext("2d");
var myBarCheatPeriode = new Chart(ctxBarCheatPeriode, {
    type: 'bar',
    data: {
        labels: ["Verifikasi", "Tidak Verifikasi", "Mar", "Apr", "May", "Jun", "Jul"],
        datasets: [{
            label: 'Students',
            backgroundColor: [chartColors.orange, chartColors.yellow, chartColors.green, chartColors.grey, chartColors.info, chartColors.blue, chartColors.purple],
            data: [
                5,
                10,
                30,
                40,
                35,
                55,
                15,
            ]
        }]
    },
    options: {
        responsive: true,
        barRoundness: 1,
        title: {
            display: true,
            // text: "Students in 2020"
        },
        legend: {
            display: false
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    suggestedMax: 40 + 20,
                    padding: 10,
                },
                gridLines: {
                    drawBorder: false,
                }
            }],
            xAxes: [{
                gridLines: {
                    display: false,
                    drawBorder: false
                }
            }]
        }
    }
});

// AVERAGE MERCHANT PERIODE
var ctxBarAverageMerchantPeriode = document.getElementById("barAverageMerchantPeriode").getContext("2d");
var myBarAverageMerchantPeriode = new Chart(ctxBarAverageMerchantPeriode, {
    type: 'bar',
    data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
        datasets: [{
            label: 'Students',
            backgroundColor: [chartColors.orange, chartColors.yellow, chartColors.green, chartColors.grey, chartColors.info, chartColors.blue, chartColors.purple],
            data: [
                20,
                2,
                90,
                20,
                45,
                55,
                15,
            ]
        }]
    },
    options: {
        responsive: true,
        barRoundness: 1,
        title: {
            display: true,
            // text: "Students in 2020"
        },
        legend: {
            display: false
        },
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero: true,
                    suggestedMax: 40 + 20,
                    padding: 10,
                },
                gridLines: {
                    drawBorder: false,
                }
            }],
            xAxes: [{
                gridLines: {
                    display: false,
                    drawBorder: false
                }
            }]
        }
    }
});


// PIE MERCHANT VERIFY
var pieMerchantVerify = document.getElementById("pieMerchantVerify").getContext("2d");
var gradientMerchantVerify = pieMerchantVerify.createLinearGradient(0, 0, 0, 400);
gradientMerchantVerify.addColorStop(0, 'rgba(50, 69, 209,1)');
gradientMerchantVerify.addColorStop(1, 'rgba(265, 177, 249,0)');

var gradient2MerchantVerify = pieMerchantVerify.createLinearGradient(0, 0, 0, 400);
gradient2MerchantVerify.addColorStop(0, 'rgba(255, 91, 92,1)');
gradient2MerchantVerify.addColorStop(1, 'rgba(265, 177, 249,0)');

var myPieMerchantVerify = new Chart(pieMerchantVerify, {
    type: 'pie',
    data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
        datasets: [{
            label: 'Students',
            backgroundColor: [chartColors.orange, chartColors.yellow, chartColors.green, chartColors.grey, chartColors.info, chartColors.blue, chartColors.purple],
            data: [
                5,
                10,
                30,
                40,
                35,
                55,
                15,
            ]
        }]
    },
    options: {
    responsive: true,
    plugins: {
      legend: {
        position: 'top',
      },
      title: {
        display: true,
        text: 'Chart.js Pie Chart'
      }
    }
  },
});


// USER ACTIVE AND NO
var pieUserActiveAndNo = document.getElementById("pieUserActiveAndNo").getContext("2d");
var gradientUserActiveAndNo = pieUserActiveAndNo.createLinearGradient(0, 0, 0, 400);
gradientUserActiveAndNo.addColorStop(0, 'rgba(50, 69, 209,1)');
gradientUserActiveAndNo.addColorStop(1, 'rgba(265, 177, 249,0)');

var gradient2UserActiveAndNo = pieUserActiveAndNo.createLinearGradient(0, 0, 0, 400);
gradient2UserActiveAndNo.addColorStop(0, 'rgba(255, 91, 92,1)');
gradient2UserActiveAndNo.addColorStop(1, 'rgba(265, 177, 249,0)');

var myPieUserActiveAndNo = new Chart(pieUserActiveAndNo, {
    type: 'pie',
    data: {
        labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
        datasets: [{
            label: 'Students',
            backgroundColor: [chartColors.orange, chartColors.yellow, chartColors.green, chartColors.grey, chartColors.info, chartColors.blue, chartColors.purple],
            data: [
                50,
                30,
                10,
                20,
                95,
                25,
                5,
            ]
        }]
    },
    options: {
    responsive: true,
    plugins: {
      legend: {
        position: 'top',
      },
      title: {
        display: true,
        text: 'Chart.js Pie Chart'
      }
    }
  },
});
