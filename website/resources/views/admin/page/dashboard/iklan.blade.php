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
                            <h4 class="card-title">Pengguna Aktif dan tidak</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="pieUserActiveAndNo"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Jumlah Pengguna melakukan kecurangan berdasarkan periode</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="barCheatPeriode"></canvas>
                        </div>
                    </div>
                </div>
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
@endsection

@push('scripts')
    <script src="{{ asset('assets/extensions/chart.js/Chart.min.js') }}"></script>
    @include('admin.page.dashboard.grafik.iklan')
    {{-- <script src="{{ asset('assets/js/pages/ui-chartjs.js') }}"></script> --}}
@endpush
