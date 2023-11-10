<div class="card-body">
    <div class="mb-3">
        <label for="name_edit_verify" class="form-label">Name</label>
        <input type="text" class="form-control" name="name_edit" value="${value.name}">
        <input type="text" class="form-control" name="id_edit" value="${value.id}" hidden>
    </div>
    <div class="mb-3">
        <label for="email_edit" class="form-label">Email address</label>
        <input type="email" class="form-control" name="email_edit" value="${value.email}">
    </div>
    <div class="mb-3">
        <label for="telp_edit" class="form-label">No Telp</label>
        <input type="number" class="form-control" name="telp_edit" value="${value.phone_number}">
    </div>
    <div class="mb-3">
        <label for="address_edit" class="form-label">Alamat</label>
        <input type="text" class="form-control" name="address_edit" value="${value.address}">
    </div>
    <div class="mb-3">
        <label for="city_edit" class="form-label">Kota</label>
        <input type="text" class="form-control" name="city_edit" value="${value.city}">
    </div>
    <div class="mb-3">
        <label for="province_edit" class="form-label">Provinsi</label>
        <input type="text" class="form-control" id="province_edit" name="province_edit" value="${value.province}">
    </div>
    {{-- <div class="mb-3">
        <label for="picture_edit" class="form-label">Profile Picture</label>
        <input type="file" class="form-control" id="picture_edit" name="picture_edit"
            value="${value.profile_picture}">
    </div> --}}
    <div class="mb-3">
        <label for="id_card_edit" class="form-label">ID Card Number</label>
        <input type="text" class="form-control" id="id_card_edit" name="id_card_edit"
            value="${value.id_card_number}">
    </div>
    <div class="mb-3">
        <label for="npwp_edit" class="form-label">NPWP</label>
        <input type="text" class="form-control" id="npwp_edit" name="npwp_edit" value="${value.npwp}">
    </div>
    <div class="mb-3">
        <label for="last_login_edit" class="form-label">Last Login</label>
        <input type="text" class="form-control" readonly name="last_login_edit" value="${value.last_login}">
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
