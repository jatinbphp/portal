@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">

    @include('admin.common.header', [
        'menu' => $menu,
        'breadcrumb' => [
            ['route' => route('admin.dashboard'), 'title' => 'Dashboard']
        ],
        'active' => $menu
    ])

    <!-- Main content -->
    <section class="content">
        @include ('admin.common.error')
        <div class="row">
            <div class="col-12">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        @include('admin.common.card-header', ['title' => 'Manage ' . $menu, 'addNewRoute' => route('users.create')])
                    </div>
                    <div class="card-body table-responsive">
                        <input type="hidden" id="route_name" value="{{ route('users.index') }}">
                        <table id="usersTable" class="table table-bordered table-striped datatable-dynamic">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email Address</th>
                                    <th>Status</th>
                                    <th>Date Created</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection