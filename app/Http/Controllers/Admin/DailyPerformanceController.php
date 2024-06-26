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
use Carbon\Carbon;



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
                ->addColumn('action', function($row){
                    $row['section_name'] = 'daily-performance';
                    $row['section_title'] = 'Daily Performance';
                    $row['add'] = true;
                    $row['listing'] = true;
                    return view('admin.common.action-buttons', $row);
                })
                ->make(true);
        }

        return view('admin.daily-performance.index', $data);
    }

    public function create(Request $request){ 
        $data['menu']       = 'Daily Performance'; 
        $employee           = User::where('id', $request->id)->first();
        if(!isset($employee->category_ids) || !is_string($employee->category_ids)) return redirect()->route('daily-performance.index')->with('warning', 'Error occured in retrieving employees data');
        $category_ids       = json_decode($employee->category_ids, true);
        $data['categories'] = Category::whereIn('id', $category_ids)->pluck('name','id')->toArray();
        $data['tasks']      = Task::where(function ($query) use ($category_ids) {
                    foreach ($category_ids as $category_id) {
                        $query->orWhereJsonContains('category_ids', $category_id);
                    }
                })->orderBy('id','ASC')->get();
        $data['employee'] = $employee;
        $data['category_ids']= $category_ids;

        if(empty($data['tasks'])) return redirect()->back()->with('warning', 'The selected candidate does not have tasks assigned to him');
        return view('admin.daily-performance.create', $data);
    }

    public function store(DailyPerformanceRequest $request){
        $input = $request->all();
        $category_data = $request->category_data;
        
        if(!isset($input['task_id'])) return redirect()->back()->with('danger', 'Error occured while saving the data');
        foreach($input['task_id'] as $key => $value){
           
            if(isset($input['comment'][$key])){
                $data['user_id']        = $input['user_id'];
                $category_ids = explode(', ', $category_data[$key]);
                $data['category_id'] = json_encode($category_ids);
                $data['task_id']        = $input['task_id'][$key] ?? null;
                $data['comment']        = $input['comment'][$key];
                $data['datetime']       = isset($input['datetime'][$key])? Carbon::parse($input['datetime'][$key])->format('Y-m-d H:i'): Carbon::now()->format('Y-m-d H:i');           
                DailyPerformance::create($data);
            }
        }

        \Session::flash('success', 'Daily derformance data has been inserted successfully!');
        return redirect()->route('daily-performance.index');
    }

    public function view_tasks(Request $request, $id){
        $data['menu'] = 'Employee Tasks';
        $data['id'] = $id;
        $performance= DailyPerformance::with('task')->where('user_id', $id)->orderBy('datetime','desc')->get();
    
        if ($request->ajax()) {
            return Datatables::of($performance)
                ->addIndexColumn()
                ->editColumn('created_at', function($row) {
                    return \Carbon\Carbon::parse($row->datetime)->format('Y-m-d H:i');
                })
                ->addColumn('task_name', function($row) {
                    return $row->task->name;
                })
                ->addColumn('action', function($row){
                    $row['section_name'] = 'daily-performance';
                    $row['section_title'] = 'Daily Performance';
                    $row['popup_edit'] = true;
                    $row['delete'] = true;
                    return view('admin.common.action-buttons', $row);
                })
                ->make(true);
        }
   
        $data['employee']       = User::where('id', $id)->first();
        $data['categories']     = Category::whereIn('id', json_decode($data['employee']->category_ids, true))->pluck('name','id')->toArray();
        return view('admin.daily-performance.tasks', $data);
    }

    public function show($id){
        $daily_performance = DailyPerformance::findOrFail($id);
        $data['daily_performance']  = $daily_performance;
        $data['title']              = "Task";
        $data['section_name']       = "daily-performance";
        return view('admin.daily-performance.modal',$data);
    }

    public function update(DailyPerformanceRequest $request, string $id){
        $daily_performance = DailyPerformance::findOrFail($id);
        if(empty($request->comment)) return response()->json(['status' => false]);
        $input = [
            'comment'   => $request->comment,
            'datetime'  => isset($request->datetime) ? Carbon::parse($request->datetime)->format('Y-m-d H:i:s') : Carbon::now()
        ];
        $daily_performance->update($input);
        return response()->json([
            'status' => 'success',
            'message' => 'Daily performance data has been updated successfully!',
        ]);
    }

    public function destroy($id){
        $daily_performance = DailyPerformance::findOrFail($id);
        
        if(empty($daily_performance)){
            return response()->json(['status' => false], 200);
        }

        $daily_performance->delete();
        return response()->json(['status' => true], 200);
    }
}
