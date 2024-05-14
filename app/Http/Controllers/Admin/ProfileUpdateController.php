<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\User;
use App\Models\Account;
use App\Models\Branch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Auth;

class ProfileUpdateController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function edit($id){
        $data['menu'] = "Edit Profile";
        $user = User::findorFail($id);

        // added restriction
        if(!empty(Auth::user()->id) && isset($user->id) && !empty($user->id)){
            if(Auth::user()->id != $user->id){
                return redirect()->route('errors.404');
            }
        }
        
        if(in_array($user->role,['companies','service_providers'])){
            $user->load('company');

            if(!empty(Auth::user()->branch_ids)){
                $ids = json_decode(Auth::user()->branch_ids);
                $data['branches'] = getActiveBranches([], $ids);
            }
        }
        $data['user'] = $user;
        return view('admin.employee.profile_edit',$data);
    }

    public function update(ProfileUpdateRequest $request, $id){        
        $input = $request->all();

        if(empty($request['password'])){
            unset($input['password']);
        } else {
            $input['password']= Hash::make($request->password);    
        }
        $user = User::findorFail($id);

        if(in_array($user->role,['companies','service_providers'])){
            $input['branch_ids'] = isset($request->branch_ids) && !empty($request->branch_ids) ? json_encode($request->branch_ids) : [];
        }
        
        if($file = $request->file('image')){
            if (!empty($user['image']) && file_exists($user['image'])) {
                unlink($user['image']);
            }
            $input['image'] = $this->fileMove($file,'users');
        }
        $user->update($input);
        \Session::flash('success','Profile has been updated successfully!');
        return redirect('admin/profile_update/'.$id."/edit");
    }
}
