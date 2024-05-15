{!! Form::hidden('redirects_to', URL::previous()) !!}
@if(isset($user))
    @include('admin.common.password-alert')
@endif
<div class="row">
    <div class="col-md-3">
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'name', 'labelText' => 'Name', 'isRequired' => true])

            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter Name', 'id' => 'name']) !!}

            @include('admin.common.errors', ['field' => 'name'])
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'email', 'labelText' => 'Email Address', 'isRequired' => true])
            
            {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Enter Email Address', 'id' => 'email', 'autocomplete' => 'off']) !!}

            @include('admin.common.errors', ['field' => 'email'])
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group{{ $errors->has('branch_name') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'branch_name', 'labelText' => 'Branch Name', 'isRequired' => true])
            {!! Form::text('branch_name', null, ['class' => 'form-control', 'placeholder' => 'Enter Branch Name', 'id' => 'branch_name']) !!}
            @include('admin.common.errors', ['field' => 'branch_name'])
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group{{ $errors->has('category_ids') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'category_ids', 'labelText' => 'Category', 'isRequired' => true])
            {!! Form::select("category_ids[]", $categories ?? array(), !empty($user['category_ids']) ? explode(",", $user['category_ids']) : null, ["class" => "form-control select2 w-100", "id" => "category_ids", "multiple" => "multiple", 'data-placeholder' => 'Please Select', "data-maximum-selection-length" => "3"]) !!}
            @include('admin.common.errors', ['field' => 'category_ids'])
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3" >
        <div class="password-div form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'password', 'labelText' => 'Password', 'isRequired' => empty($user) ? true : false])
            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Enter Password', 'id' => 'password']) !!}
            @include('admin.common.errors', ['field' => 'password'])
        </div>
    </div>
    <div class="col-md-3">
        <div class="password-div form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'password_confirmation', 'labelText' => 'Confirm Password', 'isRequired' => empty($user) ? true : false])

            {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm password', 'id' => 'password-confirm']) !!}

            @include('admin.common.errors', ['field' => 'password_confirmation'])
        </div>
    </div>

    <div class="col-md-3">
        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'status', 'labelText' => 'Status', 'isRequired' => false])
            
            @include('admin.common.active-inactive-buttons', [                
                'checkedKey' => isset($user) ? $user->status : 'active'
            ])
        </div>
    </div>
</div>
@section('jquery')
<script type="text/javascript">
</script>
@endsection
