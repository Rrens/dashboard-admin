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
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="name_edit_verify" class="form-label">Name</label>
                                <input type="text" class="form-control" name="name_edit_active_or_not" value="${value.name}">
                                <input type="text" class="form-control" name="id_edit_active_or_not" value="${value.id}" hidden>
                            </div>
                            <div class="mb-3">
                                <label for="email_edit_active_or_not" class="form-label">Email address</label>
                                <input type="email" class="form-control" name="email_edit_active_or_not" value="${value.email}">
                            </div>
                            <div class="mb-3">
                                <label for="telp_edit_active_or_not" class="form-label">No Telp</label>
                                <input type="number" class="form-control" name="telp_edit_active_or_not" value="${value.phone_number}">
                            </div>
                            <div class="mb-3">
                                <label for="address_edit_active_or_not" class="form-label">Alamat</label>
                                <input type="text" class="form-control" name="address_edit_active_or_not" value="${value.address}">
                            </div>
                            <div class="mb-3">
                                <label for="city_edit_active_or_not" class="form-label">Kota</label>
                                <input type="text" class="form-control" name="city_edit_active_or_not" value="${value.city}">
                            </div>
                            <div class="mb-3">
                                <label for="province_edit_active_or_not" class="form-label">Provinsi</label>
                                <input type="text" class="form-control" name="province_edit_active_or_not" value="${value.province}">
                            </div>
                            <div class="mb-3">
                                <label for="picture_edit_active_or_not" class="form-label">Profile Picture</label>
                                <input type="file" class="form-control" name="picture_edit_active_or_not" value="${value.profile_picture}">
                            </div>
                            <div class="mb-3">
                                <label for="id_card_edit_active_or_not" class="form-label">ID Card Number</label>
                                <input type="text" class="form-control" name="id_card_edit_active_or_not" value="${value.id_card_number}">
                            </div>
                            <div class="mb-3">
                                <label for="npwp_edit_active_or_not" class="form-label">NPWP</label>
                                <input type="text" class="form-control" name="npwp_edit_active_or_not" value="${value.npwp}">
                            </div>
                            <div class="mb-3">
                                <label for="last_login_edit_active_or_not" class="form-label">Last Login</label>
                                <input type="text" class="form-control" readonly name="last_login_edit_active_or_not" value="${value.last_login}">
                            </div>
                            <div class="mt-3 d-flex justify-content-end">
                                <button type="submit" class="btn btn-warning" data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Update</span>
                                </button>
                                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Close</span>
                                </button>
                            </div>
                        </div>
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
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="name_edit_verify" class="form-label">Name</label>
                                <input type="text" class="form-control" name="name_edit_average_detail" value="${value.name}">
                                <input type="text" class="form-control" name="id_edit_average_detail" value="${value.id}" hidden>
                            </div>
                            <div class="mb-3">
                                <label for="email_edit_average_detail" class="form-label">Email address</label>
                                <input type="email" class="form-control" name="email_edit_average_detail" value="${value.email}">
                            </div>
                            <div class="mb-3">
                                <label for="telp_edit_average_detail" class="form-label">No Telp</label>
                                <input type="number" class="form-control" name="telp_edit_average_detail" value="${value.phone_number}">
                            </div>
                            <div class="mb-3">
                                <label for="address_edit_average_detail" class="form-label">Alamat</label>
                                <input type="text" class="form-control" name="address_edit_average_detail" value="${value.address}">
                            </div>
                            <div class="mb-3">
                                <label for="city_edit_average_detail" class="form-label">Kota</label>
                                <input type="text" class="form-control" name="city_edit_average_detail" value="${value.city}">
                            </div>
                            <div class="mb-3">
                                <label for="province_edit_average_detail" class="form-label">Provinsi</label>
                                <input type="text" class="form-control" name="province_edit_average_detail" value="${value.province}">
                            </div>
                            <div class="mb-3">
                                <label for="picture_edit_average_detail" class="form-label">Profile Picture</label>
                                <input type="file" class="form-control" name="picture_edit_average_detail" value="${value.profile_picture}">
                            </div>
                            <div class="mb-3">
                                <label for="id_card_edit_average_detail" class="form-label">ID Card Number</label>
                                <input type="text" class="form-control" name="id_card_edit_average_detail" value="${value.id_card_number}">
                            </div>
                            <div class="mb-3">
                                <label for="npwp_edit_average_detail" class="form-label">NPWP</label>
                                <input type="text" class="form-control" name="npwp_edit_average_detail" value="${value.npwp}">
                            </div>
                            <div class="mb-3">
                                <label for="last_login_edit_average_detail" class="form-label">Last Login</label>
                                <input type="text" class="form-control" readonly name="last_login_edit_average_detail" value="${value.last_login}">
                            </div>
                            <div class="mt-3 d-flex justify-content-end">
                                <button type="submit" class="btn btn-warning" data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Update</span>
                                </button>
                                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Close</span>
                                </button>
                            </div>
                        </div>
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
                        <div class="card-body">
                            <div class="mb-3">
                                <label for="name_edit_verify" class="form-label">Name</label>
                                <input type="text" class="form-control" name="name_edit_verify" value="${value.name}">
                                <input type="text" class="form-control" name="id_edit_verify" value="${value.id}" hidden>
                            </div>
                            <div class="mb-3">
                                <label for="email_edit_verify" class="form-label">Email address</label>
                                <input type="email" class="form-control" name="email_edit_verify" value="${value.email}">
                            </div>
                            <div class="mb-3">
                                <label for="telp_edit_verify" class="form-label">No Telp</label>
                                <input type="number" class="form-control" name="telp_edit_verify" value="${value.phone_number}">
                            </div>
                            <div class="mb-3">
                                <label for="address_edit_verify" class="form-label">Alamat</label>
                                <input type="text" class="form-control" name="address_edit_verify" value="${value.address}">
                            </div>
                            <div class="mb-3">
                                <label for="city_edit_verify" class="form-label">Kota</label>
                                <input type="text" class="form-control" name="city_edit_verify" value="${value.city}">
                            </div>
                            <div class="mb-3">
                                <label for="province_edit_verify" class="form-label">Provinsi</label>
                                <input type="text" class="form-control" name="province_edit_verify" value="${value.province}">
                            </div>
                            <div class="mb-3">
                                <label for="picture_edit_verify" class="form-label">Profile Picture</label>
                                <input type="file" class="form-control" name="picture_edit_verify" value="${value.profile_picture}">
                            </div>
                            <div class="mb-3">
                                <label for="id_card_edit_verify" class="form-label">ID Card Number</label>
                                <input type="text" class="form-control" name="id_card_edit_verify" value="${value.id_card_number}">
                            </div>
                            <div class="mb-3">
                                <label for="npwp_edit_verify" class="form-label">NPWP</label>
                                <input type="text" class="form-control" name="npwp_edit_verify" value="${value.npwp}">
                            </div>
                            <div class="mb-3">
                                <label for="last_login_edit_verify" class="form-label">Last Login</label>
                                <input type="text" class="form-control" readonly name="last_login_edit_verify" value="${value.last_login}">
                            </div>
                            <div class="mt-3 d-flex justify-content-end">
                                <button type="submit" class="btn btn-warning" data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Update</span>
                                </button>
                                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Close</span>
                                </button>
                            </div>
                        </div>
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
                        <div class="mt-3 d-flex justify-content-center">
                            <input type="number" name="id" value="${value}" hidden>
                            <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Delete</span>
                            </button>
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                        </div>
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
                        <div class="mt-3 d-flex justify-content-center">
                            <input type="number" name="id" value="${value}" hidden>
                            <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Delete</span>
                            </button>
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                        </div>
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
                        <div class="mt-3 d-flex justify-content-center">
                            <input type="number" name="id" value="${value}" hidden>
                            <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Delete</span>
                            </button>
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                        </div>
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
