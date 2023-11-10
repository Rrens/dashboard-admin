<?php

namespace App\Http\Controllers;

use App\Models\Log_login;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('admin.profile');
        }
        return view('admin.auth.login');
    }

    public function post_login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return redirect()->route('login');
        }

        $data = [
            'email' => $request->email,
            'password' => $request->password
        ];

        if (!Auth::attempt($data)) {
            Session::flash('error', 'Email or Password is wrong');
            Alert::toast('Email or Password is wrong', 'error');
            return redirect()->route('login')->withInput();
        }

        $id = Auth::user()->id;
        $log_login = new Log_login();
        $log_login->user_id = $id;
        $log_login->ip_address = request()->getClientIp();
        $log_login->last_login = Carbon::now();
        $log_login->save();
        $log_login = Log_login::latest()->get();
        if (!empty($log_login[1])) {
            $data = User::findOrFail($id);
            $data->last_login = $log_login[0]->last_login;
            $data->save();
        }

        return redirect()->route('admin.profile');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function forgot_password()
    {
        return view('admin.auth.forgot-password');
    }

    public function forgot_post(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        $data = User::where('email', $request->email)->first();

        if (empty($data)) {
            Alert::toast('Email Not Found', 'error');
            return back()->withInput();
        }

        $data->is_forgot_password = 1;
        $data->save();

        Alert::toast('Success Request Password to Superadmin', 'success');
        return back();
    }
}
