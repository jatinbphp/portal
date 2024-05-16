<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Category;
use App\Models\User;

class ReportController extends Controller
{
    public function index_category_report(Request $request)
    {
        $data['menu'] = 'Infringements by Category Report';

        if ($request->ajax()) {
            return Datatables::of(Category::select())
                ->addIndexColumn()
                ->editColumn('status', function($row){
                    $row['table_name'] = 'categories';
                    return view('admin.common.status-buttons', $row);
                })
                ->make(true);
        }
        $data['category']= Category::where('status', 'active')->pluck('name', 'id');
        return view('admin.reports.index_categories_report', $data);
    }

    public function index_employee_report(Request $request)
    {
        $data['menu'] = 'Infringements by Employee Report';
        if ($request->ajax()) {
            return Datatables::of(User::select())
                ->addIndexColumn()
                ->editColumn('status', function($row){
                    $row['table_name'] = 'users';
                    return view('admin.common.status-buttons', $row);
                })
                ->make(true);
        }
        $data['employees']= User::where(['role'=>'employees','status'=>'active'])->pluck('name', 'id');
        return view('admin.reports.index_employees_report', $data);
    }
}
