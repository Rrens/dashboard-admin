<?php

namespace App\Http\Controllers;

use App\Mail\ForgotPassword;
use App\Models\Log_login;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

use function PHPSTORM_META\map;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect()->route('home');
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

        return redirect()->route('home');
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

        $date = Carbon::now();
        $formattedDate = $date->formatLocalized('%A, %d %B %Y');
        $request["date"] = $formattedDate;

        $data = User::where('email', $request->email)->first();

        if (empty($data)) {
            Alert::toast('Email Not Found', 'error');
            return back()->withInput();
        }

        $token = Str::random(10);

        $data->is_forgot_password = sha1($token);
        $request["token"] = route('change-password', $data->is_forgot_password);
        $data->save();

        Mail::send(new ForgotPassword($request));

        Alert::toast('Success will be sent to email', 'success');
        return back();
    }

    public function change_password($token)
    {
        $data = User::where("is_forgot_password", $token)->first();
        if (empty($data)) {
            Alert::error('Token Tidak Valid');
            return redirect()->route('login');
        }
        // dd($data);
        return view('admin.auth.change-password', compact('data'));
    }

    public function store_change_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'repassword' => 'required',
        ]);

        if ($validator->fails()) {
            Alert::toast($validator->messages()->all(), 'error');
            return back()->withInput();
        }

        if ($request->password != $request->repassword) {
            Alert::error('Password not same');
            return back()->withInput();
        }

        $data = User::where('email', $request->email)->first();
        $data->password = Hash::make($request->password);
        $data->save();
        Alert::toast('Success change Password', 'success');
        return redirect()->route('login');
        // dd($data);
    }
}
