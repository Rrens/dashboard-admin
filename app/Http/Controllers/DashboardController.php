<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $active = 'dashboard';
        return view('admin.page.dashboard', compact('active'));
    }
}
