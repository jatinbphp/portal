<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Category;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(){
        $data['menu'] = "Dashboard";
        $data['total_employees'] = User::where('role','employees')->count();
        $data['total_categories'] = Category::count();
        $data['total_tasks'] = Task::count();
        return view('admin.dashboard', $data);
    }
}