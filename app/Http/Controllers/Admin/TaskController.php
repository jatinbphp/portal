<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Task;
use App\Models\Category;
use App\Http\Requests\TaskRequest;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        $data['menu'] = 'Tasks';
        if ($request->ajax()) {
            return Datatables::of(Task::select())
                ->addIndexColumn()
                ->editColumn('created_at', function($row){
                    return $row['created_at']->format('Y-m-d h:i:s');
                })
                ->editColumn('status', function($row){
                    $row['table_name'] = 'tasks';
                    return view('admin.common.status-buttons', $row);
                })
                ->editColumn('category_ids', function ($row) {
                    $row['buttons'] = $row->category_names;
                    return view('admin.task.category-buttons', $row);
                })    
                ->addColumn('action', function($row){
                    $row['section_name'] = 'tasks';
                    $row['section_title'] = 'Task';
                    $row['show'] = false;
                    return view('admin.common.action-buttons', $row);
                })
                ->make(true);
        }

        return view('admin.task.index', $data);
    }

    public function create()
    {
        $data['menu'] = 'Tasks';
        $data['categories'] = Category::where('status', 'active')->orderBy('name', 'ASC')->pluck('name','id'); 
        return view("admin.task.create", $data);
    }

    public function store(TaskRequest $request)
    {
        $input = $request->all();
        $input['category_ids'] = !empty($request->category_ids) ? implode(',', $request->category_ids) : '';
        Task::create($input);
        \Session::flash('success', 'Task has been inserted successfully!');
        return redirect()->route('tasks.index');
    }

    public function show($id) {
        $task = Task::findOrFail($id);
        $required_columns = ['id', 'name', 'status', 'created_at'];

        return view('admin.common.show_modal', [
            'section_info' => $task->toArray(),
            'type' => 'Task',
            'required_columns' => $required_columns
        ]);
    }

    public function edit(string $id)
    {
        $data['menu'] = 'Tasks';
        $data['task']   = Task::where('id',$id)->first();
        $data['categories'] = Category::where('status', 'active')->orderBy('name', 'ASC')->pluck('name','id'); 
        return view('admin.task.edit',$data);
    }

    public function update(TaskRequest $request, string $id)
    {
        $input = $request->all();
        $input['category_ids'] = !empty($request->category_ids) ? implode(',', $request->category_ids) : '';
        $task  = Task::find($id);
        $task->update($input);
        
        \Session::flash('success','Task has been updated successfully!');
        return redirect()->route('tasks.index');
    }

    public function destroy(string $id)
    {
        $task = Task::find($id);

        if(empty($task)){
            return response()->json(['status' => false], 200);
        }

        $task->delete();
        return response()->json(['status' => true], 200);
    }
}
