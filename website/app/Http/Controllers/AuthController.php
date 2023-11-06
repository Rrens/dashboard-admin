<?php

namespace App\Http\Controllers;

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
        $data = User::findOrFail($id);
        $data->last_login = Carbon::now();
        $data->save();
        return redirect()->route('admin.profile');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
