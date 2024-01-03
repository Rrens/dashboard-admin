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
                {{-- @if ($status == 'not-verify' || $status == 'verify') --}}
                @if ($status == 'verify' || $status == 'not-verify')
                    <div class="col-10">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <h4 class="card-title">jumlah merchant
                                        {{ $status == 'verify' ? 'lolos' : 'tidak lolos' }} berdasarkan periode</h4>
                                    <a href="{{ route('merchant.dashboard') }}" class="btn btn-primary">Kembali</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="pieMerchantVerify"></canvas>
                            </div>
                        </div>
                    </div>
                @elseif ($status == 'aktif' || $status == 'tidak')
                    <div class="col-10">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <h4 class="card-title">jumlah merchant
                                        {{ $status == 'aktif' ? 'aktif' : 'tidak aktif' }} berdasarkan
                                        periode</h4>
                                    <a href="{{ route('merchant.dashboard') }}" class="btn btn-primary">Kembali</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="pieMerchantDetail"></canvas>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-10">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between">
                                    <h4 class="card-title">Merchant tramsaksi per periode</h4>
                                    <a href="{{ route('merchant.dashboard') }}" class="btn btn-primary">Kembali</a>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="merchantCategory"></canvas>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- @endif --}}
                {{-- @if ($status == 'aktif' || $status == 'tidak')
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
                @endif --}}

                {{-- <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Rata-rata transaksi merchant berdasarkan periode</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="barAverageMerchantPeriode"></canvas>
                        </div>
                    </div>
                </div> --}}
            </div>
        </section>
    </div>

    @if (!empty($data_categories[0]))
        @foreach ($data_categories as $item)
            <div class="modal fade" id="modalDetailCategories{{ $item['category_id'] }}" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Kategori</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="card-body table-responsive">
                                    <table class="table " id="table1">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $for_data = [];
                                                foreach ($data_categories as $key) {
                                                    $key['category_id'] == $item['category_id'] ? array_push($for_data, $key) : '';
                                                }
                                            @endphp
                                            @foreach ($for_data as $row)
                                                <tr>
                                                    <td class="text-bold-500">
                                                        {{ $row['name'] }}

                                                    </td>
                                                </tr>
                                            @endforeach
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
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    @include('admin.page.dashboard.grafik-detail.merchant.modal-tables')
    @include('admin.page.dashboard.script.index')

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="{{ asset('assets/extensions/chart.js/Chart.min.js') }}"></script>
        @include('admin.page.dashboard.grafik-detail.merchant.grafik')
    @endpush
@endsection
