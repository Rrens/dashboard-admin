<script>
    function approve(dataId) {
        $('#id_approve').val(dataId);
    }

    function not_approve(dataId) {
        $('#id_not_approve').val(dataId);
    }

    const _URL = "{{ env('API_URL') . 'verify/ads/change-approve' }}"
    $('#btn_confirm_approve').on('click', function() {

        let data = $('#approve').val();
        let id = $('#id_approve').val();

        $.ajax({
            url: _URL,
            type: 'POST',
            dataType: "json",
            data: {
                data: data,
                id: id,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                location.reload();
            },
            error: function(xhr, status, error) {
                console.log(error, xhr, status);
            }
        })
    })

    $('#btn_confirm_not_approve').on('click', function() {
        let id = $('#id_not_approve').val();
        let data = $('#not_approve').val();
        let message = $('#message').val();

        $.ajax({
            url: _URL,
            type: 'POST',
            dataType: "json",
            data: {
                data: data,
                id: id,
                message: message,
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                // console.log(response)
                location.reload();
            },
            error: function(xhr, status, error) {
                console.log(error, xhr, status);
            }
        })

    })
</script>
