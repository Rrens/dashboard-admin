@extends('admin.components.master')
@section('title', 'DASHBOARD IKLAN')

@section('container')
    <div class="page-heading">
        <div class="page-title mb-4">
            <div class="row">
                <div class="col-12 col-md-12 order-md-1 order-last">

                    <h3>Dashboard Iklan</h3>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Jumlah Iklan lolos dan tidak</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="pieAdsApproveAndNotApprove"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Jumlah iklan favorit berdasarkan kategori</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="pieFavoriteAdsPerCategory"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Jumlah rating iklan berdasarkan periode</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="barCountRatingAdsPerPeriode"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>


    <div class="modal fade" id="modalViewDataDashboard" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah FAQ</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body table-responsive">
                    <div class="card-body ">
                        <table class="table table-striped" id="table1">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>ID Merchant</th>
                                    <th>Kota</th>
                                    <th>Provinsi</th>
                                    <th>Category ID</th>
                                    <th>Deskripsi</th>
                                    <th>Note</th>
                                    <th>Price</th>
                                    <th>Jumlah Pesanan</th>
                                    <th>Rating</th>
                                    <th>Jumlah view</th>
                                    <th>Manage</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-bold-500">
                                    </td>
                                    <td class="text-bold-500">
                                    </td>
                                    <td class="text-bold-500">
                                    </td>
                                    <td class="text-bold-500">
                                    </td>
                                    <td class="text-bold-500">
                                    </td>
                                    <td class="text-bold-500">
                                    </td>
                                    <td class="text-bold-500">
                                    </td>
                                    <td class="text-bold-500">
                                    </td>
                                    <td class="text-bold-500">
                                    </td>
                                    <td class="text-bold-500">
                                    </td>
                                    <td class="text-bold-500">
                                    </td>
                                    <td>
                                        <button class="btn btn-light-warning btn-sm" onclick="detail()"
                                            data-bs-toggle="modal" data-bs-target="#modalDetail">Detail
                                        </button>
                                        <button class="btn btn-light-danger btn-sm" data-bs-toggle="modal"
                                            onclick="delete()" data-bs-target="#modalDelete">Delete
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Close</span>
                    </button>
                    <button type="submit" class="btn btn-primary ml-1" data-bs-dismiss="modal">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Save</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/extensions/chart.js/Chart.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/chart.js/Chart.min.js') }}"></script>
    @include('admin.page.dashboard.grafik.iklan')
    {{-- <script src="{{ asset('assets/js/pages/ui-chartjs.js') }}"></script> --}}
@endpush
