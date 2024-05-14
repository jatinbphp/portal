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

    <section class="content">
        @include ('admin.common.error')
        <div class="row">
            <div class="col-md-12">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        @include('admin.common.card-header', ['title' => 'Edit ' . $menu])
                    </div>
                    {!! Form::model($user,['url' => route('users.update',['user'=>$user->id]),'method'=>'patch','id' => 'usersForm','class' => 'form-horizontal','files'=>true]) !!}
                        <div class="card-body">
                            @include ('admin.user.form')
                        </div>
                        <div class="card-footer">
                            @include('admin.common.footer-buttons', ['route' => 'users.index', 'type' => 'update'])
                        </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </section>
</div>
@endsection