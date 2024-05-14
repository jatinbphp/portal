{!! Form::hidden('redirects_to', URL::previous()) !!}
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
            
            {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Enter Email Address', 'id' => 'email']) !!}

            @include('admin.common.errors', ['field' => 'email'])
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'phone', 'labelText' => 'Contact Number', 'isRequired' => true])

            {!! Form::number('phone', null, ['class' => 'form-control', 'placeholder' => 'Enter Contact Number', 'id' => 'phone']) !!}

            @include('admin.common.errors', ['field' => 'phone'])
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group{{ $errors->has('additional_phone') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'additional_phone', 'labelText' => 'Contact Number 2', 'isRequired' => false])

            {!! Form::number('additional_phone', null, ['class' => 'form-control', 'placeholder' => 'Enter Contact Number 2', 'id' => 'additional_phone']) !!}

            @include('admin.common.errors', ['field' => 'additional_phone'])
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group{{ $errors->has('cp_name') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'cp_name', 'labelText' => 'Contact Person Name', 'isRequired' => true])
            
            {!! Form::text('cp_name', null, ['class' => 'form-control', 'placeholder' => 'Enter Contact Person Name', 'id' => 'cp_name']) !!}

            @include('admin.common.errors', ['field' => 'cp_name'])
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group{{ $errors->has('cp_email') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'cp_email', 'labelText' => 'Contact Person Email Address', 'isRequired' => true])
            
            {!! Form::text('cp_email', null, ['class' => 'form-control', 'placeholder' => 'Enter Contact Person Email Address', 'id' => 'cp_email']) !!}

            @include('admin.common.errors', ['field' => 'cp_email'])
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group{{ $errors->has('cp_phone') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'cp_phone', 'labelText' => 'Contact Person Phone ', 'isRequired' => true])
            
            {!! Form::number('cp_phone', null, ['class' => 'form-control', 'placeholder' => 'Enter Contact Person Phone', 'id' => 'cp_phone']) !!}

            @include('admin.common.errors', ['field' => 'cp_phone'])
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'status', 'labelText' => 'Status', 'isRequired' => false])
            
            @include('admin.common.active-inactive-buttons', [                
                'checkedKey' => isset($account) ? $account->status : 'active'
            ])
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'address', 'labelText' => 'Address', 'isRequired' => true])
            
            {!! Form::text('address', null, ['class' => 'form-control', 'placeholder' => 'Enter Address', 'id' => 'address']) !!}

            @include('admin.common.errors', ['field' => 'address'])

            {{ Form::hidden('latitude', null, ['class' => 'latitude', 'id' => 'latitude']) }}

            {{ Form::hidden('longitude', null, ['class' => 'longitude', 'id' => 'longitude']) }}
        </div>
    </div>
    <div class="col-sm-12">
        <div id="map-canvas" style="overflow: hidden;height: 500px;position: relative;"></div>
    </div>
</div>
@section('jquery')
<script src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAP_API_KEY')}}&libraries=places&callback=initialize"
async defer></script>
@endsection