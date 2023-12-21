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

<script>
    // PIE MERCHANT VERIFY
    let ctxBarAverageMerchantVerify = document.getElementById("pieMerchantVerify").getContext("2d");
    const data_month_verify = [{{ $month }}]
    let monthNamesVerify = {
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

    let myBarAverageMerchantVerify = new Chart(ctxBarAverageMerchantVerify, {
        type: 'bar',
        data: {
            labels: data_month_verify.map(function(value) {
                return monthNamesVerify[value];
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
                ],
                data: [{{ $is_approve }}],
                month: data_month_verify,
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

                    let status = '{{ $status }}';
                    _url = null;

                    let linkHref =
                        `{{ env('APP_WEBSITE') . 'dashboard/merchant/print/merchant-verify/${status}/${month}/${year}' }}`;
                    let newLink = $('<a/>', {
                        href: linkHref,
                        target: '_blank',
                        class: 'btn btn-primary',
                        text: 'Print'
                    });
                    // console.log(newLink)
                    $('#merchant-verify').empty();
                    $('#merchant-verify').append(newLink);

                    _url =
                        `dashboard/merchant/data-verify/${status}/${month}/${year}`

                    let url = _url ? _url : null;
                    url =
                        `{{ env('API_URL') . ':url' }}`.replace(':url', url);
                    console.log(url)
                    $.ajax({
                        url: `${url}`,
                        method: 'GET',
                        success: function(data) {
                            const data_api = data.data;
                            console.log(data_api);
                            $('#table_data_merchant_Verify tbody').empty();
                            data_api.forEach(value => {
                                newRow += `
                                    <tr>
                                        <td class="text-bold-500">
                                            ${value.id}
                                        </td>
                                        <td class="text-bold-500">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#modalDetailCategories${value.category_id}">${value.category_id}</a>
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
                                            <button class="btn btn-light-warning btn-sm" onclick="editMerchant(${value.id})"
                                                data-bs-toggle="modal" data-bs-target="#modalEdit">
                                                <i class="bi bi-pencil-fill"></i>
                                            </button>
                                        </td>
                                    </tr>
                                `;
                            });

                            $('#table_data_merchant_Verify tbody').append(
                                newRow);
                        }
                    })

                    $("#modalVerify").modal("show");

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

<script>
    // PIE MERCHANT VERIFY
    let ctxBarAverageMerchantCategory = document.getElementById("merchantCategory").getContext("2d");

    let myBarAverageMerchantCategoryAgain = new Chart(ctxBarAverageMerchantCategory, {
        type: 'bar',
        data: {
            labels: [{!! $month !!}],
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
                    chartColors.silver,
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
                    chartColors.blue,
                ],
                data: [{{ $is_approve }}],
                month: [{!! $month !!}],
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

                    let status = '{{ $status }}';

                    _url = null;

                    let linkHref =
                        `{{ env('APP_WEBSITE') . 'dashboard/merchant/print/merchant-category/${month}/${status}' }}`
                    let newLink = $('<a/>', {
                        href: linkHref,
                        target: '_blank',
                        class: 'btn btn-primary',
                        text: 'Print'
                    });
                    $('#merchant-category').empty();
                    $('#merchant-category').append(newLink);

                    _url =
                        `dashboard/merchant/detail/data-merchant-category/${status}/${month}`;

                    let url = _url ? _url : null;
                    url =
                        `{{ env('API_URL') . ':url' }}`.replace(':url', url);
                    console.log(this.data.datasets[datasetIndex].data)

                    $.ajax({
                        url: `${url}`,
                        method: 'GET',
                        success: function(data) {
                            const data_api = data.data;
                            // console.log(data_api);
                            $('#table_data_rate_merchant_category tbody').empty();
                            data_api.forEach(value => {
                                // console.log(value)
                                newRow += `
                                    <tr>
                                        <td class="text-bold-500">
                                            ${value.id}
                                        </td>
                                        <td class="text-bold-500">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#modalDetailCategories${value.category_id}">${value.category_id}</a>
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
                                            <button class="btn btn-light-warning btn-sm" onclick="editMerchant(${value.merchant_id})"
                                                data-bs-toggle="modal" data-bs-target="#modalEdit">
                                                <i class="bi bi-pencil-fill"></i>
                                            </button>
                                        </td>
                                    </tr>
                                `;
                            });

                            $('#table_data_rate_merchant_category tbody').append(
                                newRow);
                        }
                    })

                    $("#modalMerchantCategory").modal("show");

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

<script>
    // PIE MERCHANT VERIFY
    let ctxBarAverageMerchantPeriode = document.getElementById("pieMerchantDetail").getContext("2d");
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
    let myBarAverageMerchantCategory = new Chart(ctxBarAverageMerchantPeriode, {
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
                    // if (month != null && year != null) {
                    //     $("#average-merchant").empty();
                    //     $("#average-merchant").append(
                    //         `<a href="{{ env('APP_WEBSITE') . '/dashboard/merchant/print-average-transaction/${month}/${year}' }}" target="_blank" class="btn btn-primary">Print</a>`
                    //     );
                    // }
                    // modalViewTransactionMerchantPerPeriode
                    let status = '{{ $status }}';
                    _url = null;

                    let linkHref =
                        `{{ env('APP_WEBSITE') . 'dashboard/merchant/print/merchant-active/${status}/${month}/${year}' }}`
                    let newLink = $('<a/>', {
                        href: linkHref,
                        target: '_blank',
                        class: 'btn btn-primary',
                        text: 'Print'
                    });
                    // console.log(newLink)
                    $('#merchant-active').empty();
                    $('#merchant-active').append(newLink);

                    _url =
                        `dashboard/merchant/data-merchant-active/${status}/${month}/${year}`;

                    let url = _url ? _url : null;
                    url =
                        `{{ env('API_URL') . ':url' }}`.replace(':url', url);
                    $.ajax({
                        url: `${url}`,
                        method: 'GET',
                        success: function(data) {
                            const data_api = data.data;
                            console.log(data_api);
                            $('#table_data_merchant_active tbody').empty();
                            data_api.forEach(value => {
                                newRow += `
                                    <tr>
                                        <td class="text-bold-500">
                                            ${value.id}
                                        </td>
                                        <td class="text-bold-500">
                                            <a href="#" data-bs-toggle="modal"
                                                data-bs-target="#modalDetailCategories${value.category_id}">${value.category_id}</a>
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
                                            <button class="btn btn-light-warning btn-sm" onclick="editMerchant(${value.id})"
                                                data-bs-toggle="modal" data-bs-target="#modalEdit">
                                                <i class="bi bi-pencil-fill"></i>
                                            </button>
                                        </td>
                                    </tr>
                                `;
                            });

                            $('#table_data_merchant_active tbody').append(
                                newRow);
                        }
                    })

                    $("#modalActive").modal("show");

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
