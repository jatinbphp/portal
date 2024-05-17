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
                    $row['edit']    = true;
                    $row['delete']  = true;
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
        $input['category_ids'] = !empty($request->category_ids) ? json_encode($request->category_ids) : [];
        Task::create($input);
        \Session::flash('success', 'Task has been inserted successfully!');
        return redirect()->route('tasks.index');
    }

    public function show($id) {
        $task = Task::findOrFail($id);
        $category_ids= json_decode($task['category_ids']);
        $category_name= "";

        if(!empty($category_ids))
        {
            $category_name= Category::whereIn('id', $category_ids)->pluck('name')->toArray();
        }

        $required_columns = ['id', 'category_name' , 'name', 'status','created_at',];

        $section_info = $task->toArray();
        $section_info['category_name'] = $category_name;

        return view('admin.common.show_modal', [
            'section_info' => $section_info,
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
        $input['category_ids'] = !empty($request->category_ids) ? json_encode($request->category_ids) : [];
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
