<script>
    // $('#btn_confirm').on('click', function() {
    //     let id = $('#id_acc').val();
    //     console.log(id);
    // });
    // $('#modalAprrove').click(function() {
    //     var dataId = $(this).data('id');
    //     // Di sini Anda dapat mengganti ini dengan data sesuai dengan elemen yang diklik.
    //     var data = "Data sesuai dengan ID " + dataId;
    //     console.log(data);
    //     // $('#data-details').html(data);
    // });

    function approve(dataId) {
        // $('#data-details').html("Data sesuai dengan ID " + dataId);
        // $('#detailModal').modal('show');
        console.log(dataId)
    }

    function not_approve(dataId) {
        console.log(dataId)
    }

    $(document).ready(function() {
        $('#modalAprrove').click(function() {
            var dataId = $(this).data('id');
            $('#data-details').html("Data sesuai dengan ID " + dataId);
        });
    });

    const _URL = "{{ env('API_URL') . 'verify/change-approve' }}"
    $('#btn_confirm_approve').on('click', function() {
        // console.log('approve');
        let data = $('#approve').val();
        let id = $('#id_approve').val();
        console.log(data, id)

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
                console.log(response)
            },
            error: function(xhr, status, error) {
                console.log(error, xhr, status);
            }
        })
    })

    $('#btn_confirm_not_approve').on('click', function() {
        let id = $('#id_not_approve').val();
        let data = $('#not_approve').val();

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
                console.log(response)
            },
            error: function(xhr, status, error) {
                console.log(error, xhr, status);
            }
        })

    })
</script>
