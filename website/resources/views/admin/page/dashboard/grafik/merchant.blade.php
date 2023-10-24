<script>
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
    var ctxbarCountRatingAdsPerPeriode = document.getElementById("barCountRatingAdsPerPeriode").getContext("2d");
    var mybarCountRatingAdsPerPeriode = new Chart(ctxbarCountRatingAdsPerPeriode, {
        type: 'bar',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
            datasets: [{
                    label: 'Verifikasi',
                    backgroundColor: [chartColors.orange, chartColors.yellow, chartColors.green, chartColors
                        .grey, chartColors.info, chartColors.blue, chartColors.purple
                    ],
                    data: [
                        5,
                        10,
                        30,
                        40,
                        35,
                        55,
                        15,
                    ],
                    id: [
                        1,
                        23,
                        4,
                        4,
                        2,
                        2,
                        12
                    ],
                },
                {
                    label: 'Tidak Verifikasi',
                    backgroundColor: [chartColors.orange, chartColors.yellow, chartColors.green, chartColors
                        .grey, chartColors.info, chartColors.blue, chartColors.purple
                    ],
                    data: [
                        12,
                        3,
                        3,
                        4,
                        3,
                        5,
                        3,
                    ],
                    id: [
                        1,
                        23,
                        4,
                        4,
                        2,
                        2,
                        12
                    ],
                },
            ]
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
            'onClick': function(evt, item) {
                // console.log ('legend onClick', evt);
                // console.log('legd item', item);
                if (item && item.length > 0) {
                    // console.log(item);
                    // Ambil data dari data poin yang diklik
                    var datasetIndex = item[0]._datasetIndex;
                    var index = item[0]._index;
                    // var chartData = this.data.datasets[datasetIndex].data[index];
                    var id = this.data.datasets[datasetIndex].data[index];
                    var verified = this.data.datasets[0].data[index];
                    var notVerified = this.data.datasets[1].data[index];
                    console.log(this.data.datasets)

                    // console.log('Data yang diklik:', index);

                    // alert(`data yang di kik ${index}`)
                    // alert(`Data yang diklik: ${id}`);
                    // $('#myModal').modal('show');
                    // $('#modalBody').html(`Data yang diklik: ${chartData}`);

                }
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
    var pieFavoriteAdsPerCategory = document.getElementById("pieFavoriteAdsPerCategory").getContext("2d");
    var gradientMerchantVerify = pieFavoriteAdsPerCategory.createLinearGradient(0, 0, 0, 400);
    gradientMerchantVerify.addColorStop(0, 'rgba(50, 69, 209,1)');
    gradientMerchantVerify.addColorStop(1, 'rgba(265, 177, 249,0)');

    var gradient2MerchantVerify = pieFavoriteAdsPerCategory.createLinearGradient(0, 0, 0, 400);
    gradient2MerchantVerify.addColorStop(0, 'rgba(255, 91, 92,1)');
    gradient2MerchantVerify.addColorStop(1, 'rgba(265, 177, 249,0)');

    var mypieFavoriteAdsPerCategory = new Chart(pieFavoriteAdsPerCategory, {
        type: 'pie',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
            datasets: [{
                label: 'Students',
                backgroundColor: [chartColors.orange, chartColors.yellow, chartColors.green, chartColors
                    .grey, chartColors.info, chartColors.blue, chartColors.purple
                ],
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
            },
            'onClick': function(evt, item) {
                // console.log ('legend onClick', evt);
                // console.log('legd item', item);
                if (item && item.length > 0) {
                    // Ambil data dari data poin yang diklik
                    var datasetIndex = item[0]._datasetIndex;
                    var index = item[0]._index;
                    // var chartData = this.data.datasets[datasetIndex].data[index];
                    var id = this.data.datasets[datasetIndex].data[index];

                    // console.log('Data yang diklik:', id);

                    alert(`data yang di kik ${id}`)
                    // alert(`Data yang diklik: ${id}`);
                    // $('#myModal').modal('show');
                    // $('#modalBody').html(`Data yang diklik: ${chartData}`);

                }
            },
        },
    });


    // USER ACTIVE AND NO
    var pieAdsApproveAndNotApprove = document.getElementById("pieAdsApproveAndNotApprove").getContext("2d");
    var gradientUserActiveAndNo = pieAdsApproveAndNotApprove.createLinearGradient(0, 0, 0, 400);
    gradientUserActiveAndNo.addColorStop(0, 'rgba(50, 69, 209,1)');
    gradientUserActiveAndNo.addColorStop(1, 'rgba(265, 177, 249,0)');

    var gradient2UserActiveAndNo = pieAdsApproveAndNotApprove.createLinearGradient(0, 0, 0, 400);
    gradient2UserActiveAndNo.addColorStop(0, 'rgba(255, 91, 92,1)');
    gradient2UserActiveAndNo.addColorStop(1, 'rgba(265, 177, 249,0)');

    var mypieAdsApproveAndNotApprove = new Chart(pieAdsApproveAndNotApprove, {
        type: 'pie',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
            datasets: [{
                label: 'Students',
                backgroundColor: [chartColors.orange, chartColors.yellow, chartColors.green, chartColors
                    .grey, chartColors.info, chartColors.blue, chartColors.purple
                ],
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
            },
            'onClick': function(evt, item) {
                // console.log ('legend onClick', evt);
                // console.log('legd item', item);
                if (item && item.length > 0) {
                    // Ambil data dari data poin yang diklik
                    var datasetIndex = item[0]._datasetIndex;
                    var index = item[0]._index;
                    // var chartData = this.data.datasets[datasetIndex].data[index];
                    var id = this.data.datasets[datasetIndex].data[index];

                    // console.log('Data yang diklik:', id);

                    alert(`data yang di kik ${id}`)
                    // alert(`Data yang diklik: ${id}`);
                    // $('#myModal').modal('show');
                    // $('#modalBody').html(`Data yang diklik: ${chartData}`);

                }
            },
        },
    });
</script>
