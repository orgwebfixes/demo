<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{
    /**
     * [__construct description]
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('sentinel.auth');
        $this->title = 'Dashboard';
        view()->share('title', $this->title);
    }

    /**
     * [index description]
     * @return [type] [description]
     */
    public function index()
    {
        return view('dashboard');
    }
}
