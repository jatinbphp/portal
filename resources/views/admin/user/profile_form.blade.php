@if(isset($user))
    @include('admin.common.password-alert')
@endif
<div class="row">
    <div class="col-md-3">
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'name', 'labelText' => 'Name', 'isRequired' => true])

            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name']) !!}
            
            @include('admin.common.errors', ['field' => 'name'])
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'email', 'labelText' => 'Email Address', 'isRequired' => true])

            {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'email']) !!}
            
            @include('admin.common.errors', ['field' => 'email'])
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'password', 'labelText' => 'Password', 'isRequired' => false])

            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Enter Password', 'id' => 'password']) !!}

            @include('admin.common.errors', ['field' => 'password'])
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'password_confirmation', 'labelText' => 'Confirm password', 'isRequired' => false])

            {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm password', 'id' => 'password-confirm']) !!}

            @include('admin.common.errors', ['field' => 'password_confirmation'])
        </div>
    </div>
</div>