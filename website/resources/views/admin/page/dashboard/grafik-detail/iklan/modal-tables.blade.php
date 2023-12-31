<div class="modal fade" id="modalAds" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h1 class="modal-title fs-5" id="exampleModalLabel">
                    @if ($status == 'verify')
                        VERIFY
                    @elseif ($status == 'not verify')
                        NOT VERIFY
                    @elseif ($status != 'verify' && $status != 'not verify')
                        KATEGORI
                    @endif

                </h1>
                <div>
                    <span id="average-transaction">

                    </span>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body table-responsive">
                <div class="card-body ">
                    <table class="table " id="tableAds">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>ID Merchant</th>
                                <th>ID Category</th>
                                <th>ID Provinsi</th>
                                <th>Kota</th>
                                <th>Deskripsi</th>
                                <th>Notes</th>
                                <th>Jumlah Pesanan</th>
                                <th>Rating</th>
                                <th>Jumlah View</th>
                                <th>Manage</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalRateAdsCategory" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h1 class="modal-title fs-5" id="exampleModalLabel">VERIFY ACTIVE</h1>
                <div>
                    <span id="rating-print">

                    </span>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body table-responsive">
                <div class="card-body ">
                    <table class="table " id="table_data_rate_ads_category">
                        <thead>
                            <tr>
                                <th>Transaksi ID</th>
                                <th>Merchant ID</th>
                                <th>ID Category</th>
                                <th>ADS ID</th>
                                <th>Total Transaksi</th>
                                <th>Bulan</th>
                                <th>Manage</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalViewMerchantPerPeriode" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h1 class="modal-title fs-5" id="exampleModalLabel">AVERAGE TRANSACTIONS PER PERIODE</h1>
                <div>
                    <span id="verify-ads">

                    </span>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body table-responsive">
                <div class="card-body ">
                    <p id="year"></p>
                    <p id="month"></p>
                    <table class="table " id="table_data_merchant_per_periode">
                        <thead>
                            <tr>
                                <th>ID Merchant</th>
                                <th>ID Category</th>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>No Telp</th>
                                <th>Alamat</th>
                                <th>Kota</th>
                                <th>Provinsi</th>
                                <th>ID Card Number</th>
                                <th>NPWP</th>
                                <th>Last Login</th>
                                <th>Manage</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                    <i class="bx bx-x d-block d-sm-none"></i>
                    <span class="d-none d-sm-block">Close</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
        <div class="modal-content" id="card">
            <div class="modal-header d-flex justify-content-between align-items-center">
                <h1 class="modal-title fs-5" id="exampleModalLabel">AVERAGE TRANSACTIONS PER PERIODE</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="card">
                <section></section>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Hapus</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body table-responsive">
                <div class="card-body" id="card">
                    <section>
                    </section>
                </div>
            </div>
        </div>
    </div>
</div>
