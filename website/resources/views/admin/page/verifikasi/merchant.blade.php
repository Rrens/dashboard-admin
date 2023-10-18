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
                                <table class="table table-striped" id="table1">
                                    <thead>
                                        <tr>
                                            <th>ID User</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>No.Telp</th>
                                            <th>Alamat</th>
                                            <th>Kota</th>
                                            <th>Provinsi</th>
                                            <th>Profile Picture</th>
                                            <th>ID Card Number</th>
                                            <th>NPWP</th>
                                            <th>Approve</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            @php
                                                // dd($item);
                                            @endphp
                                            <tr>
                                                <td class="text-bold-500">
                                                    {{ $item['user_id'] }}
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
                                                    {{ $item['profile_picture'] }}
                                                </td>
                                                <td class="text-bold 500">
                                                    {{ $item['id_card_number'] }}
                                                </td>
                                                <td class="text-bold-500">
                                                    {{ $item['npwp'] }}
                                                </td>
                                                <td>
                                                    <button class="btn btn-light-warning btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#modalUpdate{{ $item['id'] }}">Setuju
                                                    </button>
                                                    <button class="btn btn-light-danger btn-sm" data-bs-toggle="modal"
                                                        data-bs-target="#modalDelete{{ $item['id'] }}">Tidak Setuju
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>

    {{-- <div class="modal fade" id="Add_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
    </div> --}}

    {{-- @foreach ($data as $item)
        <div class="modal fade" id="modalUpdate{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah FAQ</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form action="{{ route('faq.update') }}" method="post">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="pertanyaan">Pertanyaan</label>
                                <input type="number" value="{{ $item->id }}" name="id" hidden>
                                <input type="text" class="form-control mt-3" id="pertanyaan" name="question"
                                    value="{{ $item->question }}" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="jawaban">Jawaban</label>
                                <input type="text" class="form-control mt-3" id="jawaban"
                                    name="answer"value="{{ $item->answer }}" required>
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
    @endforeach --}}

    @foreach ($data as $item)
        <div class="modal fade" id="modalDelete{{ $item['id'] }}" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header d-flex justify-content-center">
                        <h5 class="modal-title" id="exampleModalScrollableTitle">Tidak Verifikasi Merchant
                            {{ $item['name'] . ' ?' }}</h5>
                    </div>
                    <form id="myForm" method="post">
                        <div class="modal-footer d-flex justify-content-center">
                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Close</span>
                            </button>
                            <input type="number" value="{{ $item['id'] }}" name="id" id="id_acc" hidden>
                            <button type="button" id="btn_confirm" class="btn btn-danger ml-1" data-bs-dismiss="modal">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Delete</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    @include('admin.page.verifikasi.script.merchant')
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.min.js"
        integrity="sha512-3gJwYpMe3QewGELv8k/BX9vcqhryRdzRMxVfq6ngyWXwo03GFEzjsUm8Q7RZcHPHksttq7/GFoxjCVUjkjvPdw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/simple-datatables/umd/simple-datatables.js') }}"></script>
    <script src="{{ asset('assets/js/pages/simple-datatables.js') }}"></script>
@endpush
