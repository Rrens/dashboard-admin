<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminManageController extends Controller
{
    public function index()
    {
        $active = 'admin management';
        return view('admin.page.admin_management', compact('active'));
    }
}
