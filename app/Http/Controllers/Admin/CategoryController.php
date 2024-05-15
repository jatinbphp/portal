<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CategoryRequest;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Illuminate\Http\Request;
use App\Models\Category;


class CategoryController extends Controller{
    
    public function index(Request $request){
        $data['menu'] = 'Categories';

        if ($request->ajax()) {
            return Datatables::of(Category::select())
                ->addIndexColumn()
                ->editColumn('created_at', function($row){
                    return $row['created_at']->format('Y-m-d h:i:s');
                })
                ->editColumn('status', function($row){
                    $row['table_name'] = 'categories';
                    return view('admin.common.status-buttons', $row);
                })
                ->addColumn('action', function($row){
                    $row['section_name'] = 'categories';
                    $row['section_title'] = 'Category';
                    $row['show'] = false;
                    return view('admin.common.action-buttons', $row);
                })
                ->make(true);
        }

        return view('admin.category.index', $data);
    }

    public function create(){
        $data['menu'] = 'Categories';
        return view("admin.category.create", $data);
    }

    public function store(CategoryRequest $request){
        $input = $request->all();
        Category::create($input);
        \Session::flash('success', 'Category has been inserted successfully!');
        return redirect()->route('categories.index');
    }

    public function show($id) {
        $category = Category::findOrFail($id);
        $required_columns = ['id', 'name', 'status', 'created_at'];

        return view('admin.common.show_modal', [
            'section_info' => $category->toArray(),
            'type' => 'Category',
            'required_columns' => $required_columns
        ]);
    }
   
    public function edit(string $id){
        $data['menu']       = 'Categories';
        $data['category']   = Category::findOrFail($id);        
        return view('admin.category.edit',$data);
    }

    public function update(CategoryRequest $request, string $id){
        $input      = $request->all();
        $category   = Category::findOrFail($id);

        if(empty($category)){
            return redirect()->route('categories.index');
        }

        $category->update($input);
        \Session::flash('success','Category has been updated successfully!');
        return redirect()->route('categories.index');
    }

    public function destroy(string $id){
        $category = Category::findOrFail($id);

        if(empty($category)){
            return response()->json(['status' => false], 200);
        }

        $category->delete();
        return response()->json(['status' => true], 200);
    }
}
