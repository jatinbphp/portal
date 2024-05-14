<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Truck;
use App\Models\Trailer;
use App\Models\Driver;
use App\Models\CallOuts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        $data['menu'] = "Dashboard";
        return view('admin.dashboard', $data);
    }
}