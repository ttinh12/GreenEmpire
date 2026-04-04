<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
// danh sách ticket

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('client.layouts.master');
    }
    public function service()
    {
        return view('client.services.index');
    }
    public function dashboard()
    {
        return view('client.dashboard');
    }
    public function profile()
    {
        return view('client.profile');
    }
    public function setting()
    {
        return view('client.setting');
    }
    public function logout()
    {
        return view('client.logout');
    }
    public function ticket()
    {
        return view('client.tickets.index');
    }
}
