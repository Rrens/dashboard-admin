<script>
    var chartColors = {
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
        silver: 'rgb(192, 192, 192)',
        custom: 'rgb(128, 128, 128)'
    };


    // CHEAT PERIODE
    const data_month = [{{ $rating_month }}]
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
    var ctxbarCountRatingAdsPerPeriode = document.getElementById("barCountRatingAdsPerPeriode").getContext("2d");
    var mybarCountRatingAdsPerPeriode = new Chart(ctxbarCountRatingAdsPerPeriode, {
        type: 'bar',
        data: {
            labels: data_month.map(function(value) {
                return monthNames[value];
            }),
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
                data: [{{ $rating_periode }}],
                month: [{{ $rating_month }}],
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
                    var datasetIndex = item[0]._datasetIndex;
                    var index = item[0]._index;
                    var month = this.data.datasets[datasetIndex].month[index];
                    $("#rating-ads").empty();
                    $("#rating-ads").append(
                        `<a href="{{ env('APP_WEBSITE') . 'dashboard/iklan/print-rating/${month}' }}" target="_blank" class="btn btn-primary">Print</a>`
                    );
                    $.ajax({
                        url: `{{ env('API_URL') . 'dashboard/iklan/data-rating-ads-periode/${month}' }}`,
                        method: 'GET',
                        success: function(data) {
                            const data_api = data.data;
                            let newRow = null;
                            $('#table_data_verify tbody').empty();
                            data_api.forEach(value => {
                                newRow += `
                                    <tr>
                                        <td class="text-bold-500">
                                            ${value.name}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.merchant_id}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.category_id}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.merchant[0].province}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.merchant[0].city}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.description}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.notes}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.price}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.picture}
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
                                            <button class="btn btn-light-warning btn-sm" onclick="countRatingEdit(${value.id})"
                                                data-bs-toggle="modal" data-bs-target="#modalEdit">
                                                <i class="bi bi-pencil-fill"></i>
                                            </button>
                                            <button class="btn btn-light-danger btn-sm" data-bs-toggle="modal"
                                                onclick="countRatingdelete(${value.id})" data-bs-target="#modalDelete">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </td>
                                    </tr>
                                `;
                            });

                            $('#table_data_verify tbody').append(newRow);
                        }
                    })

                    $("#modalbarCountRatingAdsPerPeriode").modal("show");
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

    // PIE MERCHANT VERIFY
    var pieFavoriteAdsPerCategory = document.getElementById("pieFavoriteAdsPerCategory").getContext("2d");
    var gradientMerchantVerify = pieFavoriteAdsPerCategory.createLinearGradient(0, 0, 0, 400);
    gradientMerchantVerify.addColorStop(0, 'rgba(50, 69, 209,1)');
    gradientMerchantVerify.addColorStop(1, 'rgba(265, 177, 249,0)');

    var gradient2MerchantVerify = pieFavoriteAdsPerCategory.createLinearGradient(0, 0, 0, 400);
    gradient2MerchantVerify.addColorStop(0, 'rgba(255, 91, 92,1)');
    gradient2MerchantVerify.addColorStop(1, 'rgba(265, 177, 249,0)');
    let labelFavoriteAds = {!! json_encode($name_categories) !!}
    var decodedString = JSON.parse(labelFavoriteAds);

    var mypieFavoriteAdsPerCategory = new Chart(pieFavoriteAdsPerCategory, {
        type: 'pie',
        data: {
            labels: decodedString,
            datasets: [{
                label: 'Students',
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
                data: [{{ $rating_categories }}],
                id: [{{ $id }}],
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false, // Menonaktifkan legend
                },
                title: {
                    display: false,
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
                    var id = this.data.datasets[datasetIndex].id[index];
                    $("#favorite-ads").empty();
                    $("#favorite-ads").append(
                        `<a href="{{ env('APP_WEBSITE') . 'dashboard/iklan/print-ads-favorite/${id}' }}" target="_blank" class="btn btn-primary">Print</a>`
                    );

                    // Iklan Favorite Berdasarkan kategori
                    $.ajax({
                        url: `{{ env('API_URL') . 'dashboard/iklan/data-average-favorite-ads/${id}' }}`,
                        method: 'GET',
                        success: function(data) {
                            // console.log(data.data)
                            const data_api = data.data;
                            let newRow = null;
                            $('#table_data_verify tbody').empty();
                            data_api.forEach(value => {
                                newRow += `
                                    <tr>
                                        <td class="text-bold-500">
                                            ${value.name}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.merchant_id}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.category_id}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.merchant[0].province}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.merchant[0].city}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.description}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.notes}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.price}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.picture}
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
                                            <button class="btn btn-light-warning btn-sm" onclick="favoriteAdsEdit(${value.id})"
                                                data-bs-toggle="modal" data-bs-target="#modalEdit">
                                                <i class="bi bi-pencil-fill"></i>
                                            </button>
                                            <button class="btn btn-light-danger btn-sm" data-bs-toggle="modal"
                                                onclick="favoriteAdsdelete(${value.id})" data-bs-target="#modalDelete">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </td>
                                    </tr>
                                `;
                            });

                            $('#table_data_verify tbody').append(newRow);
                        }
                    })

                    $("#modalAdsFavoritePerCategories").modal("show");
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
            labels: ["Approve", "Not Approve"],
            datasets: [{
                label: 'Iklan Verifikasi dan tidak',
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
                    text: 'Jumlah Iklan lolos dan tidak'
                }
            },
            'onClick': function(evt, item) {
                if (item && item.length > 0) {
                    var datasetIndex = item[0]._datasetIndex;
                    var index = item[0]._index;
                    var id = this.data.datasets[datasetIndex].data[index];
                    let label = null;
                    if (this.data.labels[index] == 'Approve') {
                        label = 'active'
                    } else {
                        label = 'not_active'
                    }

                    $.ajax({
                        url: "{{ env('API_URL') . 'dashboard/iklan/data-verify' }}",
                        method: 'GET',
                        success: function(data) {
                            // console.log(data.data)
                            let data_api = null
                            $("#verify-ads").empty();
                            if (label == 'active') {
                                data_api = data.data;
                                $("#verify-ads").append(
                                    `<a href="{{ env('APP_WEBSITE') . 'dashboard/iklan/print-verify/approve' }}" target="_blank" class="btn btn-primary">Print</a>`
                                );
                            } else {
                                data_api = data.data_not_active;
                                $("#verify-ads").append(
                                    `<a href="{{ env('APP_WEBSITE') . 'dashboard/iklan/print-verify/not-approve' }}" target="_blank" class="btn btn-primary">Print</a>`
                                );
                            }
                            let newRow = null;
                            $('#table_data_verify tbody').empty();
                            data_api.forEach(value => {
                                newRow += `
                                    <tr>
                                        <td class="text-bold-500">
                                            ${value.name}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.merchant_id}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.category_id}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.merchant[0].province}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.merchant[0].city}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.description}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.notes}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.price}
                                        </td>
                                        <td class="text-bold-500">
                                            ${value.picture}
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
                                            <button class="btn btn-light-warning btn-sm" onclick="verifyOrNotEdit(${value.id})"
                                                data-bs-toggle="modal" data-bs-target="#modalEdit">
                                                <i class="bi bi-pencil-fill"></i>
                                            </button>
                                            <button class="btn btn-light-danger btn-sm" data-bs-toggle="modal"
                                                onclick="verifyOrNotdelete(${value.id})" data-bs-target="#modalDelete">
                                                <i class="bi bi-trash-fill"></i>
                                            </button>
                                        </td>
                                    </tr>
                                `;
                            });

                            $('#table_data_verify tbody').append(newRow);
                        }
                    })
                    $("#modalViewVerifyAndNot").modal("show");
                }
            },
        },
    });
</script>
