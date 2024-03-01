@extends('admin.auth.components.master')
@section('title', 'CHANGE PASSWORD')

@section('container')
    <h1 class="auth-title">Change Password</h1>
    {{-- <p class="auth-subtitle mb-5">Log in with your data that you entered during registration.</p> --}}

    <div class="center">
        <form action="{{ route('change-password.store') }}" method="POST">
            @csrf
            <div class="form-group position-relative has-icon-left mb-4">
                <input name="password" type="text" class="form-control form-control-xl" placeholder="Enter new password"
                    value="{{ old('password') }}">
                <input type="email" name="email" value="{{ $data->email }}" hidden>
                <div class="form-control-icon">
                    <i class="bi bi-person"></i>
                </div>
            </div>
            <div class="form-group position-relative has-icon-left mb-4">
                <input name="repassword" type="text" class="form-control form-control-xl"
                    placeholder="Enter the password again">
                <div class="form-control-icon">
                    <i class="bi bi-shield-lock"></i>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Change Password</button>
        </form>
        <div class="text-center mt-5 text-lg fs-4">
            <p><a class="" href="{{ route('login') }}">Login?</a>.</p>
        </div>
    </div>
@endsection
