@extends('admin.layouts.app')
@section('content')
    <div class="content-wrapper">
        @include('admin.common.header', ['menu' => $menu, 'breadcrumb' => [['route' => route('categories.index'), 'title' => $menu]], 'active' => 'Edit'])
        
        <section class="content">
            @include ('admin.common.error')
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Edit Category</h3>
                        </div>

                        {!! Form::model($category,['url' => route('categories.update',['category'=>$category->id]),'method'=>'patch','id' => 'categorysForm','class' => 'form-horizontal','files'=>true]) !!}
                        
                            <div class="card-body">
                                @include ('admin.category.form')
                            </div>

                            <div class="card-footer">
                                @include('admin.common.footer-buttons', ['route' => 'categories.index', 'type' => 'update'])
                            </div>

                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection