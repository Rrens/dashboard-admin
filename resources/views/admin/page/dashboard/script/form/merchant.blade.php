<div class="card-body">
    <div class="mb-3">
        <label for="name" class="form-label">Name</label>
        <input type="text" class="form-control" name="name" value="${value.name}">
        <input type="text" class="form-control" name="id" value="${value.id}" hidden>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" class="form-control" name="email" value="${value.email}">
    </div>
    <div class="mb-3">
        <label for="telp" class="form-label">No Telp</label>
        <input type="number" class="form-control" name="telp" value="${value.phone_number}">
    </div>
    <div class="mb-3">
        <label for="address" class="form-label">Alamat</label>
        <input type="text" class="form-control" name="address" value="${value.address}">
    </div>
    <div class="mb-3">
        <label for="city" class="form-label">Kota</label>
        <input type="text" class="form-control" name="city" value="${value.city}">
    </div>
    <div class="mb-3">
        <label for="province" class="form-label">Provinsi</label>
        <input type="text" class="form-control" id="province" name="province" value="${value.province}">
    </div>
    <div class="mb-3">
        <label for="id_card" class="form-label">ID Card Number</label>
        <input type="text" class="form-control" id="id_card" name="id_card" value="${value.id_card_number}">
    </div>
    <div class="mb-3">
        <label for="npwp" class="form-label">NPWP</label>
        <input type="text" class="form-control" id="npwp" name="npwp" value="${value.npwp}">
    </div>
    <div class="mb-3">
        <label for="last_login" class="form-label">Last Login</label>
        <input type="text" class="form-control" readonly name="last_login" value="${value.last_login}">
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
