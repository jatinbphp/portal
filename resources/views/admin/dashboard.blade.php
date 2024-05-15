@extends('admin.layouts.app')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                @include ('admin.common.error')
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-3 mt-2">
                        <div class="info-box">
                            <span class="info-box-icon bg-info elevation-1">
                                <i class="fas fa-user-circle"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Employees</span>
                                <span class="info-box-number">{{$total_employees}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 mt-2">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-danger elevation-1">
                                <i class="fas fa-list-alt"></i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Categories</span>
                                <span class="info-box-number">{{$total_categories}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix hidden-md-up">
                    </div>
                    <div class="col-12 col-sm-6 col-md-3 mt-2">
                        <div class="info-box mb-3">
                            <span class="info-box-icon bg-success elevation-1">
                                <i class="fas fa-tasks">
                                </i>
                            </span>
                            <div class="info-box-content">
                                <span class="info-box-text">Total Tasks</span>
                                <span class="info-box-number">{{$total_tasks}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection