<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\EmployeeRequest;

class EmployeeController extends Controller
{
    public function __construct(Request $request){
        $this->middleware('auth');
    }

    public function index(Request $request){
        $data['menu'] = 'Employees';

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
                    $row['section_name'] = 'employees';
                    $row['section_title'] = 'Employee';
                    $row['show'] = false;
                    return view('admin.common.action-buttons', $row);
                })
                ->make(true);
        }

        return view('admin.employee.index', $data);
    }

    public function create(){
        $data['menu']       = 'Employees';
        $data['categories'] = Category::where('status', 'active')->orderBy('name', 'ASC')->pluck('name','id'); 
        return view("admin.employee.create",$data);
    }

    public function store(EmployeeRequest $request){        
        $input                  = $request->all();
        $input['category_ids']  = !empty($request->category_ids) ? implode(',', $request->category_ids) : null;
        $user                   = User::create($input);

        // Flash success message and redirect
        \Session::flash('success', 'Employee has been inserted successfully!');
        return redirect()->route('employees.index');
    }

    public function show($id) {
        $user = User::findOrFail($id);
        $required_columns = ['id', 'name', 'email', 'status', 'created_at'];

        return view('admin.common.show_modal', [
            'section_info' => $user->toArray(),
            'type' => 'Employee',
            'required_columns' => $required_columns
        ]);
    }

    public function edit($id){
        $data['menu']       = 'Employees';
        $data['categories'] = Category::where('status', 'active')->orderBy('name', 'ASC')->pluck('name','id'); 
        $data['user']       = User::findOrFail($id);
        return view('admin.employee.edit',$data);
    }

    public function update(EmployeeRequest $request, $id){
        // Retrieve the user by ID
        $user = User::findOrFail($id);

        // Remove password field if empty
        if(empty($request->password)){
            unset($request['password']);
        }

        // Retrieve all input data from the request
        $input                  = $request->all();
        $input['category_ids']  = !empty($request->category_ids) ? implode(',', $request->category_ids) : null;

        // Update the user data
        $user->update($input);

        // Flash success message and redirect
        \Session::flash('success', 'Employee has been updated successfully!');
        return redirect()->route('employees.index');
    }

    public function destroy($id){
        $user = User::findOrFail($id);
        if(!empty($user)){
            $user->delete();
            return 1;
        } else {
            return 0;
        }
    }
}