{!! Form::hidden('redirects_to', URL::previous()) !!}
<div class="row">
    <div class="col-md-4">
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'name', 'labelText' => 'Name', 'isRequired' => true])

            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter Name', 'id' => 'name']) !!}
            
            @include('admin.common.errors', ['field' => 'name'])
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'status', 'labelText' => 'Status', 'isRequired' => true])
            
            @include('admin.common.active-inactive-buttons', [                
                'checkedKey' => isset($category) ? $category->status : 'active'
            ])
        </div>
    </div>
</div>
