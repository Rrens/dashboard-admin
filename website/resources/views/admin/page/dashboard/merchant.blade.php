@extends('admin.components.master')
@section('title', 'DASHBOARD MERCHANT')

@section('container')
    <div class="page-heading">
        <div class="page-title mb-4">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Dashboard Merchant</h3>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Merchant Verifikasi dan tidak</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="pieMerchantVerify"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Merchant Aktif dan tidak</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="pieUserActiveAndNo"></canvas>
                        </div>
                    </div>
                </div>

                {{-- <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Jumlah Pengguna melakukan kecurangan berdasarkan periode</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="barCheatPeriode"></canvas>
                        </div>
                    </div>
                </div> --}}
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Rata-rata transaksi merchant berdasarkan periode</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="barAverageMerchantPeriode"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade" id="modalViewVerifyAndNot" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">VERIFY MERCHANT</h1>
                    <div>
                        <span id="verify-merchant">

                        </span>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body table-responsive">
                    <div class="card-body ">
                        <table class="table " id="table_data_verify">
                            <thead>
                                <tr>
                                    <th>ID Merchant</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>No Telp</th>
                                    <th>Alamat</th>
                                    <th>Kota</th>
                                    <th>Provinsi</th>
                                    <th>ID Card Number</th>
                                    <th>NPWP Number</th>
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

    <div class="modal fade" id="modalViewMerchantActiveAndNot" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">VERIFY ACTIVE</h1>
                    <div>
                        <span id="active-merchant">

                        </span>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body table-responsive">
                    <div class="card-body ">
                        <table class="table " id="table_data_active_and_not">
                            <thead>
                                <tr>
                                    <th>ID Merchant</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>No Telp</th>
                                    <th>Alamat</th>
                                    <th>Kota</th>
                                    <th>Provinsi</th>
                                    <th>ID Card Number</th>
                                    <th>NPWP Number</th>
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

    <div class="modal fade" id="modalViewTransactionMerchantPerPeriode" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-between align-items-center">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">AVERAGE TRANSACTIONS PER PERIODE</h1>
                    <div>
                        <span id="average-merchant">

                        </span>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                </div>
                <div class="modal-body table-responsive">
                    <div class="card-body ">
                        <p id="year"></p>
                        <p id="month"></p>
                        <table class="table " id="table_data_average_per_periode">
                            <thead>
                                <tr>
                                    <th>Transaction ID</th>
                                    <th>Merchant ID</th>
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

@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/extensions/chart.js/Chart.min.js') }}"></script>
    @include('admin.page.dashboard.grafik.merchant')
    @include('admin.page.dashboard.script.merchant')
    {{-- <script src="{{ asset('assets/js/pages/ui-chartjs.js') }}"></script> --}}
@endpush
