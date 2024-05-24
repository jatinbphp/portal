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
    public function categories_report(Request $request){
        $data['menu'] = 'Infringements by Category Report';
        if ($request->ajax()) {
            return $this->handle_category_ajax_request($request);
        }

        $data['menu'] = 'Infringements by Category Report';
        $data['category']= Category::where('status', 'active')->pluck('name', 'id');
        return view('admin.reports.category.index', $data);
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
            ->when($request->input('category'), function ($query, $category_id) {
                return $query->whereJsonContains('category_ids', $category_id); 
            })
            ->get();
        if(!empty($request->daterange))
        {
            $users=$this->filter_users_with_date_range($users, $request);
        }
        return Datatables::of($users)
            ->addIndexColumn()
            ->addColumn('employee_category', function($row){
                return $this->get_employee_categories($row);
            })
            ->addColumn('action', function($row) use ($request) {
                return $this->get_employee_tasks($row, $request);
            })
            ->make(true);
    }

    private function handle_category_ajax_request(Request $request){
        $users = User::where('role','employees')->where('status','active')
        ->when($request->input('category'), function ($query, $category_id) {
            return $query->whereJsonContains('category_ids', $category_id);
        })
        ->get();

        if(!empty($request->daterange))
        {
            $users=$this->filter_users_with_date_range($users, $request);
        }
        
        return Datatables::of($users)
            ->addIndexColumn()
            ->addColumn('employee_category', function($row) use($request) {
                return $this->get_categories($row,$request);
            })
            ->addColumn('action', function($row) use ($request) {
                return $this->get_tasks_by_category($row, $request);
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
            $date = explode('-', $request->daterange);
            $startDate= date('Y-m-d 00:00:00', strtotime($date[0] ?? 0));
            $endDate = date('Y-m-d 23:59:59', strtotime($date[1] ?? 0));
            $dailyPerformances = DailyPerformance::with('tasks')->where('user_id', $user->id)
                ->whereBetween('datetime', [$startDate, $endDate])
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

    private function get_categories($row, $request){
        $category_ids = json_decode($row->category_ids, true);
        $categories = Category::whereIn('id', $category_ids)->pluck('name')->toArray();
        $category_name = implode(', ', $categories);
        if(!empty($request->category)){
            $category_id = $request->category;
            $category = Category::find($category_id);
    
            if ($category) {
                $category_name = $category->name;
            }
        }
        return $row->name . " - " . rtrim($category_name, ', ');
    }
    
    private function get_employee_tasks($row, $request){

        $query = DailyPerformance::with('tasks')->where('user_id', $row->id);
        
        if ($request->daterange) {
            $date = explode('-', $request->daterange);
            $startDate = trim($date[0]) . ' 00:00:00';
            $endDate = trim($date[1]) . ' 23:59:59';
            
            $query->whereBetween('datetime', [$startDate, $endDate]);
        }

        $daily_performances = $query->get();
        
        return view('admin.reports.employee.tasks', compact('daily_performances'));    
    }

    public function exportEmployeeReport(Request $request){
        $userId = $request->query('userId');
        $dateRange = $request->query('dateRange');
        $users = User::where('role', 'employees')->where('status','active');
        if (!empty($userId)) {
            $users->where('id', $userId);
        }
        $users = $users->orderBy('name', 'asc')->get();

        if(empty($users)){
            \Session::flash('danger','No data found!');
            return redirect()->route('reports.employees');
        }

        $headers = ['#', 'Name', 'Task Description', 'Date of Entry', 'Comments'];
        $exportData = [];
        foreach($users as $key => $val) {
            $getUserCat = $this->get_employee_categories($val);
            $daily_performances = DailyPerformance::with('tasks')->where('user_id', $val->id);

            if ($request->dateRange) {
                $date = explode('-', $request->dateRange);
                $startDate = trim($date[0]) . ' 00:00:00';
                $endDate = trim($date[1]) . ' 23:59:59';
                
                $daily_performances->whereBetween('datetime', [$startDate, $endDate]);
            }

            $daily_performances = $daily_performances->get();
            $getUserTask = [];
            if(!$daily_performances->isEmpty()){
                foreach($daily_performances as $dlKey => $dlVal){
                    $reportdata = [];
                    $id = '';
                    $name = '';
                    if($dlKey==0){
                        $id = $val->id;
                        $name = $getUserCat;
                    }

                    $taskNm = (isset($dlVal->task->name)) ? $dlVal->task->name : '';
                    $dateTime = (isset($dlVal->datetime)) ? formatCreatedAt($dlVal->datetime) : '';
                    $comment = (isset($dlVal->comment)) ? $dlVal->comment : '';

                    $reportdata = [
                        $id,
                        $name,
                        $taskNm,
                        $dateTime,
                        $comment,
                    ];

                    $exportData[] = $reportdata;
                }
            }
        }

        $temp_file = tempnam(sys_get_temp_dir(), 'export_');
        $file = fopen($temp_file, 'w');

        fputcsv($file, $headers);
    
        foreach ($exportData as $row) {
            fputcsv($file, $row);
        }

        fclose($file);

        header('Content-Description: File Transfer');
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="exported_employee_report_data.csv"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($temp_file));

        readfile($temp_file);

        unlink($temp_file);
        exit;
    }

    public function exportCategoryReport(Request $request) {
        $category_id = $request->query('categoryId');
        $dateRange = $request->query('dateRange');

        $category = User::where('role', 'employees')->where('status', 'active')
            ->when($category_id, function ($query, $category_id) {
                return $query->whereJsonContains('category_ids', $category_id);
            })
            ->orderBy('name', 'asc')
            ->get();
    
        if ($category->isEmpty()) {
            \Session::flash('danger', 'No data found!');
            return redirect()->route('reports.categories');
        }
    
        $headers = ['#', 'Name', 'Task Description', 'Date of Entry', 'Comments'];
        $exportData = [];
    
        foreach ($category as $key => $user) {
            $userCategories = $this->get_categories($user, $request);
            $categoryNames = [];

            if ($category_id) {
                $categoryNames = Category::whereIn('id', (array)$category_id)->pluck('name')->toArray();
            } else {
                $userCategoryIds = json_decode($user->category_ids, true);
                $categoryNames = Category::whereIn('id', $userCategoryIds)->pluck('name')->toArray();
            }

            $categoriesToShow = implode(', ', $categoryNames);
            
            if(!empty($category_id))
            {
                $query = DailyPerformance::with('tasks')->where('user_id', $user->id)->whereJsonContains('category_id', $category_id);

            }
            else{
                $query = DailyPerformance::with('tasks')->where('user_id', $user->id);
            }
            if ($request->dateRange) {
                $date = explode('-', $request->dateRange);
                $startDate = trim($date[0]) . ' 00:00:00';
                $endDate = trim($date[1]) . ' 23:59:59';
                
                $query->whereBetween('datetime', [$startDate, $endDate]);
            }
    
            $daily_performances = $query->get();
    
            if ($daily_performances->isNotEmpty()) {
                foreach ($daily_performances as $dlcKey => $dlcVal) {
                    $reportData = [
                        $dlcKey == 0 ? $user->id : '',
                        $dlcKey == 0 ? $user->name . '-' . $categoriesToShow : '',
                        $dlcVal->task->name ?? '',
                        isset($dlcVal->datetime) ? formatCreatedAt($dlcVal->datetime) : '',
                        $dlcVal->comment ?? '',
                    ];
    
                    $exportData[] = $reportData;
                }
            }
        }
    
        $temp_file = tempnam(sys_get_temp_dir(), 'export_');
        $file = fopen($temp_file, 'w');

        fputcsv($file, $headers);
    
        foreach ($exportData as $row) {
            fputcsv($file, $row);
        }

        fclose($file);

        header('Content-Description: File Transfer');
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="exported_category_report_data.csv"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($temp_file));

        readfile($temp_file);

        unlink($temp_file);
        exit;
    }
    
    private function get_tasks_by_category($row,$request) {
        $category = [$request->category];
        if(empty($request->category))
        {
            $query = DailyPerformance::with('tasks')
            ->where('user_id', $row->id);
            if ($request->daterange) {
                $date = explode('-', $request->daterange);
                $startDate = trim($date[0]) . ' 00:00:00';
                $endDate = trim($date[1]) . ' 23:59:59';
                
                $query->whereBetween('datetime', [$startDate, $endDate]);
            }
              $daily_performances = $query->get();
        }
        else
        {
            $query = DailyPerformance::with('tasks')
            ->where('user_id', $row->id)
            ->whereJsonContains('category_id', $category); 
                if ($request->daterange) {
                    $date = explode('-', $request->daterange);
                    $startDate = trim($date[0]) . ' 00:00:00';
                    $endDate = trim($date[1]) . ' 23:59:59';
                    
                    $query->whereBetween('datetime', [$startDate, $endDate]);
                }
              $daily_performances = $query->get();
        }

        return view('admin.reports.category.tasks', compact('daily_performances'));
    }
  
}
