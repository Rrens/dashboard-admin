@extends('admin.auth.components.master')
@section('title', 'LOGIN')

@section('container')
    <h1 class="auth-title">Log in.</h1>
    {{-- <p class="auth-subtitle mb-5">Log in with your data that you entered during registration.</p> --}}

    <div class="center">
        <form action="{{ route('post-login') }}" method="POST">
            @csrf
            <div class="form-group position-relative has-icon-left mb-4">
                <input name="email" type="email" class="form-control form-control-xl" placeholder="Email"
                    value="{{ old('email') }}">
                <div class="form-control-icon">
                    <i class="bi bi-person"></i>
                </div>
            </div>
            <div class="form-group position-relative has-icon-left mb-4">
                <input name="password" type="password" class="form-control form-control-xl" placeholder="Password">
                <div class="form-control-icon">
                    <i class="bi bi-shield-lock"></i>
                </div>
            </div>
            <button type="submit" class="btn btn-primary btn-block btn-lg shadow-lg mt-5">Log in</button>
        </form>
    </div>
@endsection
