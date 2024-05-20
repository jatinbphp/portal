<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Models\Category;
use App\Models\User;
use App\Models\Task;
use App\Models\DailyPerformance;
use Illuminate\Support\Facades\Auth;


class ReportController extends Controller
{
    public function index_category_report(Request $request){
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


    public function employees_report(Request $request){
        if ($request->ajax()) {
            return $this->handle_ajax_request($request);
        }
        $data['menu'] = 'Infringements by Employee Report';
        $data['employees'] = User::where(['role'=>'employees','status'=>'active'])->pluck('name', 'id');
        return view('admin.reports.employee.index', $data);
    }

    private function handle_ajax_request(Request $request){
        $users = User::where('id', '!=', Auth::user()->id)
            ->when($request->input('user_id'), function ($query, $user_id) {
                return $query->where('id', $user_id);
            })
            ->get();

        $filtered_users = $request->daterange ? $this->filter_users_with_date_range($users, $request) :
                            $this->filter_users_with_daily_performances($users);

        return Datatables::of($filtered_users)
            ->addIndexColumn()
            ->addColumn('employee_category', function($row){
                return $this->get_employee_categories($row);
            })
            ->addColumn('action', function($row) use ($request) {
                return $this->get_employee_tasks($row, $request);
            })
            ->make(true);
    }

    private function filter_users_with_daily_performances($users){
        return $users->filter(function($user) {
            $dailyPerformances = DailyPerformance::with('tasks')->where('user_id', $user->id)->get();
            return $dailyPerformances->isNotEmpty();
        });
    }

    private function filter_users_with_date_range($users, $request){
        return $users->filter(function($user) use($request) {
            $dates      = explode("-", $request->daterange);
            $start_date = trim(str_replace("/", "-", $dates[0]));
            $end_date   = trim(str_replace("/", "-", $dates[1]));
            $dailyPerformances = DailyPerformance::with('tasks')->where('user_id', $user->id)
                ->where('datetime', '>=', $start_date)
                ->where('datetime', '<=', $end_date)
                ->get();
            return $dailyPerformances->isNotEmpty();
        });
    }

    private function get_employee_categories($row){
        $category_ids = json_decode($row->category_ids, true);
        $categories = Category::whereIn('id', $category_ids)->pluck('name')->toArray();
        $category_name = implode(', ', $categories);
        return $row->name . " - " . rtrim($category_name, ', ');
    }

    private function get_employee_tasks($row, $request){
        $daily_performances = DailyPerformance::with('tasks')->where('user_id', $row->id)
            ->when($request->daterange, function ($query, $daterange) {
                $dates = explode("-", $daterange);
                $start_date = trim(str_replace("/", "-", $dates[0]));
                $end_date = trim(str_replace("/", "-", $dates[1]));
                $query->where('datetime', '>=', $start_date)->where('datetime', '<=', $end_date);
            })
            ->get();

        return view('admin.reports.employee.tasks', compact('daily_performances'));    
    }
}
