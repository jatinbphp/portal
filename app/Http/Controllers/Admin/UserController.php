<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UserRequest;

class UserController extends Controller
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
                    $row['section_name'] = 'users';
                    $row['section_title'] = 'User';
                    return view('admin.common.action-buttons', $row);
                })
                ->make(true);
        }

        return view('admin.user.index', $data);
    }

    public function create(){
        $data['menu'] = 'Employees';
        return view("admin.user.create",$data);
    }

    public function store(UserRequest $request){        
        $input = $request->all();
        $user = User::create($input);

        // Flash success message and redirect
        \Session::flash('success', 'Employee has been inserted successfully!');
        return redirect()->route('users.index');
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
        $data['menu'] = 'Employees';
        $data['user'] = User::findOrFail($id);
        return view('admin.user.edit',$data);
    }

    public function update(UserRequest $request, $id){
        // Retrieve the user by ID
        $user = User::findOrFail($id);

        // Remove password field if empty
        if(empty($request->password)){
            unset($request['password']);
        }

        // Retrieve all input data from the request
        $input = $request->all();

        // Update the user data
        $user->update($input);

        // Flash success message and redirect
        \Session::flash('success', 'Employee has been updated successfully!');
        return redirect()->route('users.index');
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