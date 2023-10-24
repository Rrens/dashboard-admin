@extends('admin.components.master')
@section('title', 'Verifikasi Iklan')
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
            <h3>Verifikasi Iklan</h3>
        </div>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card" style="margin-top:2.2rem">
                            <div class="card-body table-responsive">
                                <table class="table table-striped" id="table1">
                                    <thead>
                                        <tr>
                                            <th>ID User</th>
                                            <th>Kota</th>
                                            <th>Provinsi</th>
                                            <th>Category ID</th>
                                            <th>Deskripsi</th>
                                            <th>Note</th>
                                            <th>Price</th>
                                            <th>Picture</th>
                                            <th>Approve</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($data[0]))
                                            @foreach ($data as $item)
                                                <tr>
                                                    <td class="text-bold-500">
                                                        {{ $item['merchant_id'] }}
                                                    </td>
                                                    <td class="text-bold-500">
                                                        {{ $item['city'] }}
                                                    </td>
                                                    <td class="text-bold-500">
                                                        {{ $item['province'] }}
                                                    </td>
                                                    <td class="text-bold-500">
                                                        <a href="#" data-bs-toggle="modal"
                                                            data-bs-target="#modalDetailCategories{{ $item['category_id'] }}">{{ $item['category_id'] }}</a>
                                                    </td>
                                                    <td class="text-bold-500">
                                                        {{ $item['description'] }}
                                                    </td>
                                                    <td class="text-bold-500">
                                                        {{ $item['notes'] }}
                                                    </td>
                                                    <td class="text-bold-500">
                                                        Rp.{{ number_format($item['price']) }}
                                                    </td>
                                                    <td class="text-bold-500">
                                                        {{ $item['picture'] }}
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-light-warning btn-sm"
                                                            onclick="approve({{ $item['id'] }})" data-bs-toggle="modal"
                                                            data-bs-target="#modalAprrove">Setuju
                                                        </button>
                                                        <button class="btn btn-light-danger btn-sm" data-bs-toggle="modal"
                                                            onclick="not_approve({{ $item['id'] }})"
                                                            data-bs-target="#modalNotAprrove">Tidak Setuju
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>

    <div class="modal fade" id="Add_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah FAQ</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control" id="name"
                                name="name"value="{{ old('name') }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email"
                                name="email"value="{{ old('email') }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="Password">Password</label>
                            <input type="text" class="form-control" id="Password"
                                name="password"value="{{ old('password') }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="Password">Role</label>
                            <select name="role" class="form-select">
                                <option selected hidden>Pilih Role</option>
                                <option value="superadmin">Super Admin</option>
                                <option value="admin">admin</option>
                            </select>
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
                </form>
            </div>
        </div>
    </div>

    @if (!empty($data[0]))
        @foreach ($data as $item)
            <div class="modal fade" id="modalDetailCategories{{ $item['category_id'] }}" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah FAQ</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="" method="post">
                            @csrf
                            <div class="modal-body">
                                <div class="card-body table-responsive">
                                    <table class="table table-striped" id="table1">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($item['sub_category'] as $row)
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
                                <button type="submit" class="btn btn-primary ml-1" data-bs-dismiss="modal">
                                    <i class="bx bx-check d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block">Save</span>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    @endif

    <div class="modal fade" id="modalAprrove" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Approve Merchant</h5>
                </div>
                <form id="myForm" method="post">
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <input type="number" name="id" value="" id="id_approve" hidden>
                        <input type="text" value="approve" name="approve" id="approve" hidden>
                        <button type="button" id="btn_confirm_approve" class="btn btn-success ml-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalNotAprrove" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header d-flex justify-content-center">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Tidak Approve Merchant</h5>
                </div>
                <form id="myForm" method="post">
                    <div class="modal-footer d-flex justify-content-center">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Close</span>
                        </button>
                        <input type="number" name="id" id="id_not_approve" hidden>
                        <input type="text" value="not_approve" name="not_approve" id="not_approve" hidden>
                        <button type="button" id="btn_confirm_not_approve" class="btn btn-success ml-1"
                            data-bs-dismiss="modal">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@push('scripts')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/js/pages/simple-datatables.js') }}"></script>
    @include('admin.page.verifikasi.script.iklan')
@endpush
