<?php

use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\User;
use App\Models\Account;
use App\Models\Branch;
use App\Models\Truck;
use App\Models\Trailer;
use App\Models\Driver;
use App\Models\WheelPosition;

if (!function_exists('getAccessRights')) {
    function getAccessRights()
    {
        if (!Auth::check()) {
            return [];
        }

        $accessRights = [];
        $loginUserRole = Auth::user()->role;
        $roleRights = Role::where('alias', $loginUserRole)->first();
    
        if (!empty($roleRights)) {
            $accessRights = json_decode($roleRights->access_rights, true);
        }
            
        return $accessRights;
    }
}

// get Active User
if (!function_exists('getActiveUsers')) {
    function getActiveUsers($conditions){

        $query = User::where('status', 'active');

        if(!empty($conditions)){
            foreach ($conditions as $key => $value) {
                $query->where($key, $value);
            }
        }

        $companies = $query->orderBy('name', 'ASC')
                         ->get()
                         ->pluck('full_name', 'id');

        return $companies;
    }
}

// get Active Companies Account
if (!function_exists('getActiveCompaniesWithConditions')) {
    function getActiveCompaniesWithConditions($conditions){

        $query = Account::where('status', 'active');

        if(!empty($conditions)){
            foreach ($conditions as $key => $value) {
                $query->where($key, $value);
            }
        }

        $companies = $query->orderBy('name', 'ASC')
                         ->get()
                         ->pluck('full_name', 'id');

        return $companies;
    }
}

if (!function_exists('getActiveCompanies')) {
    function getActiveCompanies($userType){
        $companies = [];

        $companies = Account::where('status', 'active')
            ->where('user_type', $userType)
            ->orderBy('name', 'ASC')
            ->get()
            ->pluck('full_name', 'id');

        return $companies;
    }
}

if (!function_exists('getActiveBranches')) {
    function getActiveBranches($conditions, $ids = null){

        $query = Branch::where('status', 'active');

        if(!empty($conditions)){
            foreach ($conditions as $key => $value) {
                $query->where($key, $value);
            }
        }

        if (!empty($ids)) {
            $query->whereIn('id', $ids);
        }

        $branches = $query->orderBy('name', 'ASC')
                         ->get()
                         ->pluck('full_name', 'id');

        return $branches;
    }
}

// get Active Trucks
if (!function_exists('getActiveTrucks')) {
    function getActiveTrucks($conditions){

        $query = Truck::where('status', 'active');

        if(!empty($conditions)){
            foreach ($conditions as $key => $value) {
                $query->where($key, $value);
            }
        }

        $trucks = $query->orderBy('fleet_number', 'ASC')
                         ->get()
                         ->pluck('full_name', 'id');

        return $trucks;
    }
}

// get Active Trailers
if (!function_exists('getActiveTrailers')) {
    function getActiveTrailers($conditions){

        $query = Trailer::where('status', 'active');

        if(!empty($conditions)){
            foreach ($conditions as $key => $value) {
                $query->where($key, $value);
            }
        }

        $trailers = $query->orderBy('trailer_number', 'ASC')
                         ->get()
                         ->pluck('full_name', 'id');

        return $trailers;
    }
}

// get Active Drivers
if (!function_exists('getActiveDrivers')) {
    function getActiveDrivers($conditions){

        $query = Driver::where('status', 'active');

        if(!empty($conditions)){
            foreach ($conditions as $key => $value) {
                $query->where($key, $value);
            }
        }

        $drivers = $query->orderBy('driver_name', 'ASC')
                         ->get()
                         ->pluck('full_name', 'id');

        return $trailers;
    }
}

if (!function_exists('formatCreatedAt')) {
    function formatCreatedAt($createdAt){
        return Carbon::parse($createdAt)->format('Y-m-d H:i:s');
    }
}

if(!function_exists('getWheelPositions')) {
    function getWheelPositions(){
        $wheelPositions = WheelPosition::orderBy('id', 'ASC')
                         ->get()
                         ->pluck('name', 'id');

        return $wheelPositions;
    }
}