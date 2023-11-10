<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class AdminManageController extends Controller
{
    public function index()
    {
        $active = 'admin management';
        $data = User::whereIn('role', ['admin', 'superadmin'])->get();
        $data_forgot_password = User::whereIn('role', ['admin', 'superadmin'])
            ->where('is_forgot_password', 1)
            ->get();
        // User::onlyTrashed()->restore();
        return view('admin.page.admin_management', compact('active', 'data', 'data_forgot_password'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'role' => 'required|in:superadmin,admin'
        ]);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return back()->withInput();
        }

        $user = new User();
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = Hash::make($request->get('password'));
        $user->role = $request->get('role');
        $user->save();

        Alert::toast('Sukses menyimpan data', 'success');
        return back();
    }

    public function update(Request $request)
    {
        if ($request->password != null) {
            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'name' => 'required',
                'email' => 'required|email',
                // 'role' => 'required|in:superadmin,admin',
                'password' => 'required',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'id' => 'required',
                'name' => 'required',
                'email' => 'required|email',
                // 'role' => 'required|in:superadmin,admin'
            ]);
        }

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return back()->withInput();
        }

        $user = User::findOrFail($request->id);
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        !empty($user->password) ? $user->password = Hash::make($request->get('password')) : '';
        $user->role = $request->get('role');
        $user->save();

        Alert::toast('Sukses mengupdate data', 'success');
        return back();
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            if ($validator->fails()) {
                Alert::error($validator->messages()->all());
                return back()->withInput();
            }
        }

        User::where('id', $request->id)->delete();
        Alert::toast('Sukses menghapus data', 'success');
        return back();
    }

    public function profile()
    {
        $active = 'profile';
        $data = Auth::user();
        return view('admin.page.profile', compact('active', 'data'));
    }

    public function profile_store(Request $request)
    {
        if ($request->password == null) {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'id' => 'required',
                'email' => 'required|email',
            ]);
        } else {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string',
                'id' => 'required',
                'email' => 'required|email',
                'password' => 'required',
            ]);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'id' => 'required',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return back()->withInput();
        }

        $data = User::findOrFail($request->id);
        $data->name = $request->name;
        $data->email = $request->email;
        $request->password != null ? $data->password = Hash::make($request->password) : '';
        $data->save();

        Alert::toast('Update Profile Successfully', 'success');
        return back();
    }

    public function update_password(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required',
            'id' => 'required'
        ]);

        if ($validator->fails()) {
            Alert::error($validator->messages()->all());
            return back();
        }

        $data = User::findOrFail($request->id);
        $data->password = Hash::make($request->password);
        $data->is_forgot_password = 0;
        $data->save();

        Alert::toast('Change Password Successfully', 'success');
        return back();
    }
}
