<script>
    function UserActiveOrNotedit(data) {
        $('#card section').empty();
        $.ajax({
            url: `{{ env('API_URL') . 'dashboard/merchant/merchant-detail/${data}' }}`,
            method: 'GET',
            success: function(data) {
                let value = data.data
                let html = `
                    <form enctype="multipart/form-data" id="form" method="POST" action="{{ route('merchant.update-active-or-not') }}">
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

    function averageEdit(data) {
        $('#card section').empty();
        $.ajax({
            url: `{{ env('API_URL') . 'dashboard/merchant/merchant-detail/${data}' }}`,
            method: 'GET',
            success: function(data) {
                let value = data.data
                let html = `
                    <form enctype="multipart/form-data" id="form" method="POST" action="{{ route('merchant.update-average') }}">
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

    function VerifyEdit(data) {
        $('#card section').empty();
        $.ajax({
            url: `{{ env('API_URL') . 'dashboard/merchant/merchant-detail/${data}' }}`,
            method: 'GET',
            success: function(data) {
                let value = data.data
                let html = `
                    <form enctype="multipart/form-data" id="form" method="POST" action="{{ route('merchant.update-verify') }}">
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

    function UserActiveOrNotdestroy(data) {
        $('#card section').empty();

        $.ajax({
            url: `{{ env('API_URL') . 'dashboard/merchant/merchant-detail/${data}' }}`,
            method: 'GET',
            success: function(data) {
                let value = data.data.id
                let html = `
                    <form enctype="multipart/form-data" id="form" method="POST" action="{{ route('merchant.destroy-active') }}">
                        @csrf
                        @include('admin.page.dashboard.script.form.delete')
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

    function averageDestroy(data) {
        $('#card section').empty();
        $.ajax({
            url: `{{ env('API_URL') . 'dashboard/merchant/merchant-detail/${data}' }}`,
            method: 'GET',
            success: function(data) {
                let value = data.data.id
                let html = `
                    <form enctype="multipart/form-data" id="form" method="POST" action="{{ route('merchant.destroy-average') }}">
                        @csrf
                        @include('admin.page.dashboard.script.form.delete')
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

    function VerifyDestroy(data) {
        $('#card section').empty();
        $.ajax({
            url: `{{ env('API_URL') . 'dashboard/merchant/merchant-detail/${data}' }}`,
            method: 'GET',
            success: function(data) {
                let value = data.data.id
                let html = `
                    <form enctype="multipart/form-data" id="form" method="POST" action="{{ route('merchant.destroy-verify') }}">
                        @csrf
                        @include('admin.page.dashboard.script.form.delete')
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
