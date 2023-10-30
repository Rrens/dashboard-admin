<script>
    let chartColors = {
        red: 'rgb(255, 99, 132)',
        orange: 'rgb(255, 159, 64)',
        yellow: 'rgb(255, 205, 86)',
        green: 'rgb(75, 192, 192)',
        info: '#41B1F9',
        blue: '#3245D1',
        purple: 'rgb(153, 102, 255)',
        grey: '#EBEFF6',
        teal: 'rgb(1, 192, 205)',
        pink: 'rgb(255, 105, 180)',
        lavender: 'rgb(182, 102, 210)',
        gold: 'rgb(255, 215, 0)',
        silver: 'rgb(192, 192, 192)'
    };


    // CHEAT PERIODE (BELUM)
    let ctxBarCheatPeriode = document.getElementById("barCheatPeriode").getContext("2d");
    let myBarCheatPeriode = new Chart(ctxBarCheatPeriode, {
        type: 'bar',
        data: {
            labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul"],
            datasets: [{
                    label: 'Jumlah Pengguna melakukan kecurangan berdasarkan periode',
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
                text: "Jumlah Pengguna melakukan kecurangan berdasarkan periode"
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
                    let datasetIndex = item[0]._datasetIndex;
                    let index = item[0]._index;
                    // let chartData = this.data.datasets[datasetIndex].data[index];
                    let id = this.data.datasets[datasetIndex].data[index];
                    let verified = this.data.datasets[0].data[index];
                    let notVerified = this.data.datasets[1].data[index];
                    console.log(this.data.datasets)
                    $("#modalViewDataDashboard").modal("show");

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

    // AVERAGE MERCHANT PERIODE
    let ctxBarAverageMerchantPeriode = document.getElementById("barAverageMerchantPeriode").getContext("2d");
    const data_month = [{{ $month }}]
    let monthNames = {
        1: "Jan",
        2: "Feb",
        3: "Mar",
        4: "Apr",
        5: "Mei",
        6: "Jun",
        7: "Jul",
        8: "Ags",
        9: "Sep",
        10: "Okt",
        11: "Nov",
        12: "Des",
    };
    let myBarAverageMerchantPeriode = new Chart(ctxBarAverageMerchantPeriode, {
        type: 'bar',
        data: {
            labels: data_month.map(function(value) {
                return monthNames[value];
            }),
            datasets: [{
                label: 'Rata-rata transaksi merchant berdasarkan periode',
                backgroundColor: [
                    chartColors.orange,
                    chartColors.yellow,
                    chartColors.green,
                    chartColors.grey,
                    chartColors.info,
                    chartColors.blue,
                    chartColors.purple,
                    chartColors.teal,
                    chartColors.pink,
                    chartColors.lavender,
                    chartColors.gold,
                    chartColors.silver
                ],
                data: [{{ $totalTransactionsString }}],
                month: data_month,
                year: [{{ $yearTransactionString }}],
            }]
        },
        options: {
            responsive: true,
            barRoundness: 1,
            title: {
                display: true,
                text: "Rata-rata transaksi merchant berdasarkan periode"
            },
            legend: {
                display: false
            },
            'onClick': function(evt, item) {
                // console.log ('legend onClick', evt);
                // console.log('legd item', item);
                if (item && item.length > 0) {
                    // Ambil data dari data poin yang diklik
                    let datasetIndex = item[0]._datasetIndex;
                    let index = item[0]._index;
                    // let chartData = this.data.datasets[datasetIndex].data[index];
                    let data = this.data.datasets[datasetIndex].data[index];
                    let month = this.data.datasets[datasetIndex].month[index];
                    let year = this.data.datasets[datasetIndex].year[index];

                    // modalViewTransactionMerchantPerPeriode
                    $.ajax({
                        url: `{{ env('API_URL') . 'dashboard/merchant/data-average-transaction-merchant-periode/${month}/${year}' }}`,
                        method: 'GET',
                        success: function(data) {
                            const data_api = data.data;
                            let newRow = null;

                            $('#table_data_average_per_periode tbody').empty();
                            data_api.forEach(value => {
                                newRow += `
                                    <tr>
                                        <td class="text-bold-500">
                                            ${value.id}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.merchant_id}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.ads_id}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.total_transaction}
                                        </td>
                                        <td class="text-bold-500">
                                            ${monthNames[value.month]}
                                        </td>
                                        <td>
                                            <button class="btn btn-light-warning btn-sm" onclick="detail(this)"
                                                data-bs-toggle="modal" data-bs-target="#modalDetail">
                                                <i class="bi bi-info-circle-fill"></i>
                                            </button>
                                            <button class="btn btn-light-danger btn-sm" data-bs-toggle="modal"
                                                onclick="delete(this)" data-bs-target="#modalDelete">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </td>
                                    </tr>
                                `;
                            });

                            $('#table_data_average_per_periode tbody').append(newRow);
                        }
                    })

                    $("#modalViewTransactionMerchantPerPeriode").modal("show");
                    // alert(`data yang di kik ${id}`)

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
    let pieMerchantVerify = document.getElementById("pieMerchantVerify").getContext("2d");
    let gradientMerchantVerify = pieMerchantVerify.createLinearGradient(0, 0, 0, 400);
    gradientMerchantVerify.addColorStop(0, 'rgba(50, 69, 209,1)');
    gradientMerchantVerify.addColorStop(1, 'rgba(265, 177, 249,0)');

    let gradient2MerchantVerify = pieMerchantVerify.createLinearGradient(0, 0, 0, 400);
    gradient2MerchantVerify.addColorStop(0, 'rgba(255, 91, 92,1)');
    gradient2MerchantVerify.addColorStop(1, 'rgba(265, 177, 249,0)');

    let myPieMerchantVerify = new Chart(pieMerchantVerify, {
        type: 'pie',
        data: {
            labels: ["Approve", "Not Approve"],
            datasets: [{
                label: 'Merchant Verifikasi dan tidak',
                backgroundColor: [chartColors.orange, chartColors.blue],
                data: [{{ $data_verify_and_not[0]['approve'] }},
                    {{ $data_verify_and_not[0]['not_approve'] }}
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
                    text: "Jumlah Merchant Verifikasi Atau tidak"
                },
            },
            'onClick': function(evt, item) {
                if (item && item.length > 0) {
                    let datasetIndex = item[0]._datasetIndex;
                    let index = item[0]._index;
                    let id = this.data.datasets[datasetIndex].data[index];
                    $("#modalViewVerifyAndNot").modal("show");
                }
            },
        },
    });


    // USER ACTIVE AND NO
    let pieUserActiveAndNo = document.getElementById("pieUserActiveAndNo").getContext("2d");
    let gradientUserActiveAndNo = pieUserActiveAndNo.createLinearGradient(0, 0, 0, 400);
    gradientUserActiveAndNo.addColorStop(0, 'rgba(50, 69, 209,1)');
    gradientUserActiveAndNo.addColorStop(1, 'rgba(265, 177, 249,0)');

    let gradient2UserActiveAndNo = pieUserActiveAndNo.createLinearGradient(0, 0, 0, 400);
    gradient2UserActiveAndNo.addColorStop(0, 'rgba(255, 91, 92,1)');
    gradient2UserActiveAndNo.addColorStop(1, 'rgba(265, 177, 249,0)');

    let myPieUserActiveAndNo = new Chart(pieUserActiveAndNo, {
        type: 'pie',
        data: {
            labels: ["ACTIVE", "NOT ACTIVE"],
            datasets: [{
                label: 'Pengguna Aktif dan tidak',
                backgroundColor: [chartColors.orange, chartColors],
                data: [{{ $data_merchant_active_or_not[0]['active'] }},
                    {{ $data_merchant_active_or_not[0]['not_active'] }}
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
                    text: 'Pengguna Aktif dan tidak'
                }
            },
            'onClick': function(evt, item) {
                if (item && item.length > 0) {
                    let datasetIndex = item[0]._datasetIndex;
                    let index = item[0]._index;
                    let id = this.data.datasets[datasetIndex].data[index];
                    $("#modalViewMerchantActiveAndNot").modal("show");
                }
            },
        },
    });
</script>
