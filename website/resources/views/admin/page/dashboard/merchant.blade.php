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
@endsection

@push('scripts')
    <script src="{{ asset('assets/extensions/chart.js/Chart.min.js') }}"></script>
    @include('admin.page.dashboard.grafik.merchant')
    {{-- <script src="{{ asset('assets/js/pages/ui-chartjs.js') }}"></script> --}}
@endpush
