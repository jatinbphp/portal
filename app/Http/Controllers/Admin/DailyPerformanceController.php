<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\DailyPerformanceRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Task;
use App\Models\Category;
use App\Models\DailyPerformance;


class DailyPerformanceController extends Controller{
    
    public function index(Request $request){
        $data['menu'] = 'Daily Performance';

        if ($request->ajax()) {
            return Datatables::of(User::where('id', '!=', Auth::user()->id))
                ->addIndexColumn()
                ->editColumn('created_at', function($row) {
                    return formatCreatedAt($row->created_at);
                })
                ->editColumn('role', function($row) {
                    return ucwords(str_replace("_", " ", $row->role)); 
                })
                ->editColumn('status', function($row){
                    $row['table_name'] = 'users';
                    return view('admin.common.status-buttons', $row);
                })
                ->addColumn('action', function($row){
                    $row['section_name'] = 'daily-performance';
                    $row['section_title'] = 'Daily Performance';
                    $row['add'] = true;
                    return view('admin.common.action-buttons', $row);
                })
                ->make(true);
        }

        return view('admin.daily-performance.index', $data);
    }

    public function create(Request $request){ 
        $data['menu']       = 'Daily Performance'; 
        $employee           = User::where('id', $request->id)->first();
        if(!isset($employee->category_ids)) return redirect()->route('daily-performance.index')->with('warning', 'Error occured in retrieving employees data');
        $category_ids       = explode(',', $employee->category_ids);
        $data['categories'] = Category::whereIn('id', $category_ids)->pluck('name', 'id')->toArray();
        $data['tasks']      = Task::where(function ($query) use ($category_ids) {
                    foreach ($category_ids as $category_id) {
                        $query->orWhere('category_ids', 'like', '%' . $category_id . '%');
                    }
                })->get();

        $data['employee'] = $employee;
        if(empty($data['tasks'])) return redirect()->back()->with('warning', 'The selected candidate does not have tasks assigned to him');
        return view('admin.daily-performance.create', $data);
    }

    public function store(DailyPerformanceRequest $request){
        $input = $request->all();
        if(!isset($input['task_id'])) return redirect()->back()->with('danger', 'Error occured while saving the data');

        foreach($input['task_id'] as $key => $value){
            if(isset($input['comment'][$key])){
                $data['user_id']    = $input['user_id'];
                $data['task_id']    = $input['task_id'][$key] ?? null;
                $data['datetime']   = $input['datetime'][$key] ?? date("Y-m-d H:i:s");
                $data['comment']    = $input['comment'][$key];
                DailyPerformance::create($data);
            }
        }

        \Session::flash('success', 'Daily derformance data has been inserted successfully!');
        return redirect()->route('daily-performance.index');
    }
}
