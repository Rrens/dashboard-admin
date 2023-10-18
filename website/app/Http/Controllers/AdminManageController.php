<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class AdminManageController extends Controller
{
    public function index()
    {
        $active = 'admin management';
        $data = User::whereIn('role', ['admin', 'superadmin'])->get();
        // User::onlyTrashed()->restore();
        return view('admin.page.admin_management', compact('active', 'data'));
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
        if ($request->has('password')) {
            $rules = [
                'id' => 'required',
                'name' => 'required',
                'email' => 'required|email',
                'password' => 'required',
                'role' => 'required|in:superadmin,admin'
            ];
        } else {
            $rules = [
                'id' => 'required',
                'name' => 'required',
                'email' => 'required|email',
                'role' => 'required|in:superadmin,admin'
            ];
        }

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            if ($validator->fails()) {
                Alert::error($validator->messages()->all());
                return back()->withInput();
            }
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
}
