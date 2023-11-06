@extends('admin.components.master')
@section('title', 'Admin Management')
@push('head')
    <style>
        .color-card {
            background-color: rgb(14, 12, 27);
        }

        img {
            max-width: 500px;
        }

        body.theme-dark a {
            color: inherit;
            text-decoration: none !important;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('assets/extensions/simple-datatables/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/simple-datatables.css') }}">
@endpush

@section('container')
    <div class="page-heading d-flex justify-content-between">
        <div class="flex-start">
            <h3>Profile</h3>
        </div>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card" style="margin-top:2.2rem">
                            <div class="card-body">
                                <form action="{{ route('profile.store') }}" method="post">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label for="name">Nama</label>
                                        <input type="text" class="form-control mt-3" id="name"
                                            name="name"value="{{ $data->name }}" required>
                                        <input type="number" value="{{ $data->id }}" name="id" hidden>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control mt-3" id="email"
                                            name="email"value="{{ $data->email }}" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="Password">Password</label>
                                        <input type="text" class="form-control mt-3" id="Password"
                                            name="password"value="{{ old('password') }}">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="last_login">Last Login</label>
                                        <input type="text" class="form-control mt-3" id="last_login"
                                            value="{{ $data->last_login }}" readonly>
                                    </div>
                                    <div style="float: right" class="mt-3">
                                        <button type="submit" class="btn btn-warning ml-1">
                                            Update
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
@endpush
