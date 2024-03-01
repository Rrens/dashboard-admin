<script>
    function editAds(data) {
        $('#card section').empty();
        $.ajax({
            url: `{{ env('API_URL') . 'dashboard/iklan/ads-detail/${data}' }}`,
            method: 'GET',
            success: function(data) {
                let value = data.data
                let html = `
                    <form enctype="multipart/form-data" id="form" method="POST" action="{{ route('ads.update') }}">
                        @csrf
                        @include('admin.page.dashboard.script.form.iklan')
                    </form>
                `;
                $('#card section').append(html);
            },
            error: function(xhr, status, error) {
                console.log("AJAX request error:");
                console.log(`Status: ${status}`);
                console.log(`Error" ${error}`);
            }
        })
    }

    function EditratingAdsPeriode(data) {
        $('#card section').empty();
        $.ajax({
            url: `{{ env('API_URL') . 'dashboard/iklan/ads-detail/${data}' }}`,
            method: 'GET',
            success: function(data) {
                let value = data.data
                let html = `
                    <form enctype="multipart/form-data" id="form" method="POST" action="{{ route('ads.update') }}">
                        @csrf
                        @include('admin.page.dashboard.script.form.iklan')
                    </form>
                `;
                $('#card section').append(html);
            },
            error: function(xhr, status, error) {
                console.log("AJAX request error:");
                console.log(`Status: ${status}`);
                console.log(`Error" ${error}`);
            }
        })
    }

    function editMerchant(data) {
        $('#card section').empty();
        $.ajax({
            url: `{{ env('API_URL') . 'dashboard/merchant/merchant-detail/${data}' }}`,
            method: 'GET',
            success: function(data) {
                let value = data.data
                let html = `
                    <form enctype="multipart/form-data" id="form" method="POST" action="{{ route('merchant.update') }}">
                        @csrf
                        @include('admin.page.dashboard.script.form.merchant')
                    </form>
                `;
                $('#card section').append(html);
            },
            error: function(xhr, status, error) {
                console.log("AJAX request error:");
                console.log(`Status: ${status}`);
                console.log(`Error" ${error}`);
            }
        })
    }
</script>
