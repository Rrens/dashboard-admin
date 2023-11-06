<script>
    function verifyOrNotEdit(data) {
        $('#card section').empty();
        $.ajax({
            url: `{{ env('API_URL') . 'dashboard/iklan/ads-detail/${data}' }}`,
            method: 'GET',
            success: function(data) {
                let value = data.data
                let html = `
                    <form enctype="multipart/form-data" id="form" method="POST" action="{{ route('ads.update-verify') }}">
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

    function favoriteAdsEdit(data) {
        $('#card section').empty();
        $.ajax({
            url: `{{ env('API_URL') . 'dashboard/iklan/ads-detail/${data}' }}`,
            method: 'GET',
            success: function(data) {
                let value = data.data
                let html = `
                    <form enctype="multipart/form-data" id="form" method="POST" action="{{ route('ads.update-favorite') }}">
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

    function countRatingEdit(data) {
        $('#card section').empty();
        $.ajax({
            url: `{{ env('API_URL') . 'dashboard/iklan/ads-detail/${data}' }}`,
            method: 'GET',
            success: function(data) {
                let value = data.data
                let html = `
                    <form enctype="multipart/form-data" id="form" method="POST" action="{{ route('ads.update-count-rating') }}">
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
</script>
