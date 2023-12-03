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
                <div class="col-10">
                    <div class="card">
                        <div class="card-header">
                            @if ($status == 'not-verify' || $status == 'verify')
                                <h4 class="card-title">Merchant Verifikasi dan tidak</h4>
                            @elseif ($status == 'aktif' || $status == 'tidak')
                                <h4 class="card-title">Merchant Aktif dan tidak</h4>
                            @endif
                        </div>
                        <div class="card-body">
                            <canvas id="pieMerchantDetail"></canvas>
                        </div>
                    </div>
                </div>
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

    @include('admin.page.dashboard.modal-tables')

    @push('scripts')
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"
            integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
        <script src="{{ asset('assets/extensions/chart.js/Chart.min.js') }}"></script>
        @include('admin.page.dashboard.grafik-detail.merchant')
    @endpush
@endsection
