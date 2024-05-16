@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">

    @include('admin.common.header', [
        'menu' => $menu,
        'breadcrumb' => [
            ['route' => route('admin.dashboard'), 'title' => 'Dashboard'],
            ['route' => route('daily-performance.index'), 'title' => $menu]
        ],
        'active' => 'Add'
    ])

    <section class="content">
        @include ('admin.common.error')
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title">
                            <span class=" btn bg-danger">{{ strtoupper($employee->name) . " - " . strtoupper(implode(", ", $categories)) }}</span>
                        </h3>
                    </div>
                    {!! Form::open(['url' => route('daily-performance.store'), 'id' => 'dailPerformanceForm', 'class' => 'form-horizontal','files'=>true]) !!}
                        <div class="card-body">
                            @include ('admin.daily-performance.form')
                        </div>
                        <div class="card-footer">
                            @include('admin.common.footer-buttons', ['route' => 'daily-performance.index', 'type' => 'create'])
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>
</div>
@endsection