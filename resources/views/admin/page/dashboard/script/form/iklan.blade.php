<div class="card-body">
    <div class="mb-3">
        <label for="name_edit_verify" class="form-label">Name</label>
        <input type="text" class="form-control" name="name" value="${value.name}">
        <input type="number" class="form-control" name="id_ads" value="${value.id}" hidden>
    </div>
    <div class="mb-3">
        <label for="id_merchant" class="form-label">ID Merchant</label>
        <input type="number" class="form-control" name="id_merchant" value="${value.merchant_id}">
    </div>
    <div class="mb-3">
        <label for="city" class="form-label">Kota</label>
        <input type="text" class="form-control" name="city" value="${value.city}">
    </div>
    <div class="mb-3">
        <label for="province" class="form-label">Provinsi</label>
        <input type="text" class="form-control" name="province" value="${value.province}">
    </div>
    <div class="mb-3">
        <label for="id_category" class="form-label">ID Category</label>
        <input type="number" class="form-control" name="id_category" value="${value.category_id}">
    </div>
    <div class="mb-3">
        <label for="description" class="form-label">Deskripsi</label>
        <input type="text" class="form-control" name="description" value="${value.description}">
    </div>
    <div class="mb-3">
        <label for="notes" class="form-label">Notes</label>
        <input type="text" class="form-control" name="notes" value="${value.notes}">
    </div>
    <div class="mb-3">
        <label for="price" class="form-label">Price</label>
        <input type="text" class="form-control" name="price" value="${value.price}">
    </div>
    <div class="mb-3">
        <label for="count_order" class="form-label">Jumlah Pesanan</label>
        <input type="number" class="form-control" name="count_order" value="${value.count_order}">
    </div>
    <div class="mb-3">
        <label for="rating" class="form-label">Rating</label>
        <input type="text" class="form-control" name="rating" value="${value.rating}">
    </div>
    <div class="mb-3">
        <label for="count_view" class="form-label">Jumlah View</label>
        <input type="number" class="form-control" name="count_view" value="${value.count_view}">
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
