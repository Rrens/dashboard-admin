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
</script>

@if (in_array($status, $month_name))
    <script>
        var ctxbarCountRatingAdsPerPeriode = document.getElementById("pieRateAdsPeriode").getContext("2d");
        var mybarCountRatingAdsPerPeriode = new Chart(ctxbarCountRatingAdsPerPeriode, {
            type: 'bar',
            data: {
                labels: [{!! $month !!}],
                datasets: [{
                    label: 'Jumlah rating iklan berdasarkan periode',
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
                        chartColors.silver,
                        chartColors.custom
                    ],
                    data: [{{ $is_approve }}],
                    month: [{!! $month !!}],
                }, ]
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
                    if (item && item.length > 0) {
                        let datasetIndex = item[0]._datasetIndex;
                        let index = item[0]._index;
                        let month = this.data.datasets[datasetIndex].month[index];
                        let category = this.data.labels[index];

                        $("#rating-ads").empty();
                        $("#rating-ads").append(
                            `<a href="{{ env('APP_WEBSITE') . 'dashboard/iklan/print-rating/${month}' }}" target="_blank" class="btn btn-primary">Print</a>`
                        );
                        $.ajax({
                            url: `{{ env('API_URL') . 'dashboard/iklan/data-rating-ads-periode/${month}' }}`,
                            method: 'GET',
                            success: function(data) {
                                const data_api = data.data;
                                console.log(data_api)
                                let newRow = null;
                                $('#table_data_rate_ads_category tbody').empty();
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
                                            ${value.month}
                                        </td>
                                        <td>
                                            <button class="btn btn-light-warning btn-sm" onclick="EditratingAdsPeriode(${value.ads_id})"
                                                data-bs-toggle="modal" data-bs-target="#modalEdit">
                                                <i class="bi bi-pencil-fill"></i>
                                            </button>
                                        </td>
                                    </tr>
                                `;
                                });

                                $('#table_data_rate_ads_category tbody').append(newRow);
                            }
                        })

                        $("#modalRateAdsCategory").modal("show");
                    }
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            // suggestedMax: 40 + 20,
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
    </script>
@else
    <script>
        // PIE MERCHANT VERIFY
        let ctxBarAverageMerchantPeriode = document.getElementById("pieAdsDetail").getContext("2d");
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
                    data: [{{ $is_approve }}],
                    month: data_month,
                    year: [{{ $year }}],
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
                        // modalViewTransactionMerchantPerPeriode
                        let status = '{{ $status }}';
                        let _url = null;
                        if (status == 'not verify') {
                            _url =
                                `dashboard/iklan/data-verify/not_approve/${month}/${year}`;
                        }

                        if (status == 'verify') {
                            _url =
                                `dashboard/iklan/data-verify/approve/${month}/${year}`;
                        }

                        if (status != 'verify' && status != 'not verify') {
                            console.log(status)
                            _url =
                                `dashboard/iklan/data-average-favorite-ads/${status}/${month}/${year}`
                        }

                        let url = _url ? _url : null;
                        url =
                            `{{ env('API_URL') . ':url' }}`.replace(':url', url);

                        $.ajax({
                            url: `${url}`,
                            method: 'GET',
                            success: function(data) {
                                const data_api = data.data;
                                console.log(data_api)


                                if (status != 'verify' && status != 'not verify') {
                                    $('#modalAds tbody').empty();
                                }

                                data_api.forEach(value => {

                                    newRow += `
                                    <tr>
                                        <td class="text-bold-500">
                                            ${value.merchant[0].name}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.merchant_id}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.category_id}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.province}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.city}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.description}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.notes}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.count_order}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.rating}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.count_view}
                                        </td>
                                        <td>
                                            <button class="btn btn-light-warning btn-sm" onclick="editAds(${value.id})"
                                                data-bs-toggle="modal" data-bs-target="#modalEdit">
                                                <i class="bi bi-pencil-fill"></i>
                                            </button>
                                        </td>
                                    </tr>
                                `;
                                });

                                $('#tableAds tbody').append(newRow);
                            }
                        })

                        $("#modalAds").modal("show");
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
    </script>
@endif

<script></script>
