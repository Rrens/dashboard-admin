@extends('admin.components.master')
@section('title', 'Verifikasi Merchant')
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
            <h3>Verifikasi Merchant</h3>
        </div>
    </div>
    <div class="page-content">
        <section class="row">
            <div class="col-12 col-lg-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card" style="margin-top:2.2rem">
                            <div class="card-body">
                                <table class="table " id="table1">
                                    <thead>
                                        <tr>
                                            <th>ID User</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>No.Telp</th>
                                            <th>Alamat</th>
                                            <th>Kota</th>
                                            <th>Provinsi</th>
                                            <th>Category ID</th>
                                            <th>Profile Picture</th>
                                            <th>ID Card Number</th>
                                            <th>NPWP</th>
                                            <th>Approve</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!empty($data[0]))
                                            @foreach ($data as $item)
                                                <tr>
                                                    <td class="text-bold-500">
                                                        {{ $item['id'] }}
                                                    </td>
                                                    <td class="text-bold-500">
                                                        {{ $item['name'] }}
                                                    </td>
                                                    <td class="text-bold-500">
                                                        {{ $item['email'] }}
                                                    </td>
                                                    <td class="text-bold-500">
                                                        {{ $item['phone_number'] }}
                                                    </td>
                                                    <td class="text-bold-500">
                                                        {{ $item['address'] }}
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
                                                        {{ $item['profile_picture'] }}
                                                    </td>
                                                    <td class="text-bold 500">
                                                        {{ $item['id_card_number'] }}
                                                    </td>
                                                    <td class="text-bold-500">
                                                        {{ $item['npwp'] }}
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
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="message" class="mb-3">Pesan</label>
                            <textarea id="message" class="form-control" cols="30" rows="10"></textarea>
                        </div>
                    </div>
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

    @if (!empty($data[0]))
        @foreach ($data as $item)
            <div class="modal fade" id="modalDetailCategories{{ $item['category_id'] }}" tabindex="-1"
                aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Detail Kategori</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
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


@endsection

@push('scripts')
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4="
        crossorigin="anonymous"></script>
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/js/pages/simple-datatables.js') }}"></script>
    @include('admin.page.verifikasi.script.merchant')
@endpush
