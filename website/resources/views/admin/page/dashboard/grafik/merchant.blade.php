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
            labels: ["Verifikasi", "Tidak"],
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
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            var label = context.dataset.label || '';
                            if (label) {
                                label += ': ';
                            }
                            if (context.parsed.y !== null) {
                                label += context.parsed.y + '%';
                            }
                            return label;
                        }
                    }
                }
            },
            'onClick': function(evt, item) {
                if (item && item.length > 0) {
                    let datasetIndex = item[0]._datasetIndex;
                    let index = item[0]._index;
                    let id = this.data.datasets[datasetIndex].data[index];

                    let label = null;
                    // console.log(this.data.labels[index])
                    if (this.data.labels[index] == 'Verifikasi') {
                        window.location.href = '{{ route('merchant.detail', 'verify') }}';
                        label = 'Verifikasi'
                    } else {
                        window.location.href = '{{ route('merchant.detail', 'not-verify') }}';
                        label = 'tidak'
                    }

                    // $.ajax({
                    //     url: "{{ env('API_URL') . 'dashboard/merchant/data-verify' }}",
                    //     method: 'GET',
                    //     success: function(data) {
                    //         let data_api = null
                    //         $("#verify-merchant").empty()
                    //         if (label == 'active') {
                    //             data_api = data.data;
                    //             $("#verify-merchant").append(
                    //                 `<a href="{{ route('print.verify-merchant', 'verify') }}" target="_blank" class="btn btn-primary">Print</a>`
                    //             );
                    //         } else {
                    //             data_api = data.data_not_active;
                    //             $("#verify-merchant").append(
                    //                 `<a href="{{ route('print.verify-merchant', 'not-verify') }}" target="_blank" class="btn btn-primary">Print</a>`
                    //             );
                    //         }
                    //         let newRow = null;

                    //         $('#table_data_verify tbody').empty();
                    //         data_api.forEach(value => {
                    //             newRow += `
                    //                 <tr>
                    //                     <td class="text-bold-500">
                    //                         ${value.id}
                    //                     </td>
                    //                     <td class="text-bold-500">
                    //                         ${value.name}
                    //                     </td>
                    //                     <td class="text-bold-500">
                    //                         ${value.email}
                    //                     </td>
                    //                     <td class="text-bold-500">
                    //                         ${value.phone_number}
                    //                     </td>
                    //                     <td class="text-bold-500">
                    //                         ${value.address}
                    //                     </td>
                    //                     <td class="text-bold-500">
                    //                         ${value.city}
                    //                     </td>
                    //                     <td class="text-bold-500">
                    //                         ${value.province}
                    //                     </td>
                    //                     <td class="text-bold-500">
                    //                         ${value.id_card_number}
                    //                     </td>
                    //                     <td class="text-bold-500">
                    //                         ${value.npwp}
                    //                     </td>
                    //                     <td class="text-bold-500">
                    //                         ${value.last_login}
                    //                     </td>
                    //                     <td>
                    //                         <button class="btn btn-light-warning btn-sm" onclick="VerifyEdit(${value.id})"
                    //                             data-bs-toggle="modal" data-bs-target="#modalEdit">
                    //                             <i class="bi bi-pencil-fill"></i>
                    //                         </button>
                    //                     </td>
                    //                 </tr>
                    //             `;
                    //         });

                    //         $('#table_data_verify tbody').append(newRow);
                    //     }
                    // })
                    // $("#modalViewVerifyAndNot").modal("show");
                    // $("#modalChartSecondVerify").modal("show");
                }
            },
        },
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
                    // chartColors.orange,
                    // chartColors.yellow,
                    // chartColors.green,
                    // chartColors.grey,
                    // chartColors.info,
                    // chartColors.blue,
                    // chartColors.purple,
                    // chartColors.teal,
                    // chartColors.pink,
                    // chartColors.lavender,
                    // chartColors.gold,
                    chartColors.silver,
                    chartColors.silver,
                    chartColors.silver,
                    chartColors.silver,
                    chartColors.silver,
                    chartColors.silver,
                    chartColors.silver,
                    chartColors.silver,
                    chartColors.silver,
                    chartColors.silver,
                    chartColors.silver,
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

                    let month_ajax = month
                    let year_ajax = year
                    let newRow = null;
                    if (month != null && year != null) {
                        $("#average-merchant").empty();
                        $("#average-merchant").append(
                            `<a href="{{ env('APP_WEBSITE') . '/dashboard/merchant/print-average-transaction/${month}/${year}' }}" target="_blank" class="btn btn-primary">Print</a>`
                        );
                    }
                    // console.log(this.data.labels[index]);
                    let for_month = month ? month : 1;
                    window.location.href =
                        `{{ route('merchant.detail', ':for_month') }}`.replace(':for_month', for_month);
                    // if (this.data.labels[index] != null) {

                    // }
                    // console.log(month);
                    // modalViewTransactionMerchantPerPeriode
                    // $.ajax({
                    //     url: `{{ env('API_URL') . 'dashboard/merchant/data-average-transaction-merchant-periode/${month}/${year}' }}`,
                    //     method: 'GET',
                    //     success: function(data) {
                    //         const data_api = data.data;

                    //         $('#table_data_average_per_periode tbody').empty();
                    //         data_api.forEach(value => {
                    //             newRow += `
                    //                 <tr>
                    //                     <td class="text-bold-500">
                    //                         ${value.id}
                    //                     </td>
                    //                     <td class="text-bold-500">
                    //                         ${value.merchant_id}
                    //                     </td>
                    //                     <td class="text-bold-500">
                    //                         ${value.ads_id}
                    //                     </td>
                    //                     <td class="text-bold-500">
                    //                         ${value.total_transaction}
                    //                     </td>
                    //                     <td class="text-bold-500">
                    //                         ${monthNames[value.month]}
                    //                     </td>
                    //                     <td>
                    //                         <button class="btn btn-light-warning btn-sm" onclick="averageEdit(${value.merchant_id})"
                    //                             data-bs-toggle="modal" data-bs-target="#modalEdit">
                    //                             <i class="bi bi-pencil-fill"></i>
                    //                         </button>
                    //                     </td>
                    //                 </tr>
                    //             `;
                    //         });

                    //         $('#table_data_average_per_periode tbody').append(newRow);
                    //     }
                    // })

                    // $("#modalViewTransactionMerchantPerPeriode").modal("show");
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
            labels: ["Aktif", "Tidak"],
            datasets: [{
                label: 'Pengguna Aktif dan tidak',
                backgroundColor: [chartColors.silver, chartColors.gold],
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
                    // console.log(this.data.labels[index])
                    let label = null;
                    if (this.data.labels[index] == 'ACTIVE') {
                        window.location.href = '{{ route('merchant.detail', 'aktif') }}';
                        label = 'Aktif'

                    } else {
                        window.location.href = '{{ route('merchant.detail', 'tidak') }}';
                        label = 'Tidak'
                    }
                    // Pengguna Aktif dan tidak
                    $.ajax({
                        url: "{{ env('API_URL') . 'dashboard/merchant/data-merchant-active' }}",
                        method: 'GET',
                        success: function(data) {
                            let newRow = null;
                            // console.log(label)
                            let data_api = null
                            $("#active-merchant").empty()
                            if (label == 'active') {
                                data_api = data.data;
                                $("#active-merchant").append(
                                    `<a href="{{ route('print.active-merchant', 'active') }}" target="_blank" class="btn btn-primary">Print</a>`
                                );
                            } else {
                                data_api = data.data_not_active;
                                $("#active-merchant").append(
                                    `<a href="{{ route('print.active-merchant', 'not-active') }}" target="_blank" class="btn btn-primary">Print</a>`
                                );
                            }
                            // console.log(data)
                            $('#table_data_active_and_not tbody').empty();

                            data_api.forEach(value => {
                                newRow += `
                                    <tr>
                                        <td class="text-bold-500">
                                            ${value.id}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.name}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.email}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.phone_number}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.address}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.city}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.province}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.id_card_number}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.npwp}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.last_login}
                                        </td>
                                        <td>
                                            <button class="btn btn-light-warning btn-sm" onclick="UserActiveOrNotedit(${value.id})"
                                                data-bs-toggle="modal" data-bs-target="#modalEdit">
                                                <i class="bi bi-pencil-fill"></i>
                                            </button>
                                        </td>
                                    </tr>
                                `;
                            });

                            $('#table_data_active_and_not tbody').append(newRow);

                        }
                    })
                    $("#modalViewMerchantActiveAndNot").modal("show");

                }
            },
        },
    });
</script>
