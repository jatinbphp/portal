{!! Form::hidden('redirects_to', URL::previous()) !!}
@if(isset($user))
    @include('admin.common.password-alert')
@endif

@if($user_type == 'companies')
    @php $labelText = 'Select Companies'; @endphp
@elseif($user_type == 'service_providers')
    @php $labelText = 'Select Service Providers'; @endphp
@endif

@php
if(in_array($user_type, ['companies', 'service_providers'])){
    $companiesData = isset($companies) ? $companies : [];
    $branchesData = isset($branches) ? $branches : [];
    $branchesIds = isset($user) && isset($user['branch_ids']) ? json_decode($user['branch_ids']) : null;

    if(!empty(old('company_ids'))){
        $getUsrTyp = ($user_type == 'companies') ? 0 : 1;
        $branchesIds = null;

        $companiesData = getActiveCompaniesWithConditions(['user_type' => $getUsrTyp]); 

        if(!empty(old('company_ids'))){
            $branchesData = getActiveBranches(['user_type' => $getUsrTyp, 'account_id' => old('company_ids')]); 
        }
    }
}
@endphp

<div class="row">
    @if(in_array($user_type, ['companies', 'service_providers']))

        @if(in_array(Auth::user()->role,['companies']))
            <div class="col-md-12">
                <div class="form-group{{ $errors->has('company_ids') ? ' has-error' : '' }}">
                    @include('admin.common.label', ['field' => 'company_ids', 'labelText' => (Auth::user()->role == 'companies') ? 'Select Company' : 'Select Service Provider', 'isRequired' => true])

                    {!! Form::text('company_name', isset(Auth::user()->company) ? Auth::user()->company->full_name : null, ['class' => 'form-control', 'placeholder' => 'Company Name','readonly' => 'readonly']) !!}

                    {!! Form::hidden('company_ids', isset(Auth::user()->company) ? Auth::user()->company->id : null, ['class' => 'form-control', 'placeholder' => 'Name']) !!}

                    @include('admin.common.errors', ['field' => 'company_ids'])
                </div>
            </div>
        @else
            <div class="col-md-12">
                <div class="form-group{{ $errors->has('company_ids') ? ' has-error' : '' }}">
                    @include('admin.common.label', ['field' => 'company_ids', 'labelText' => $labelText, 'isRequired' => true])

                    {!! Form::select("company_ids", isset($companiesData) ? $companiesData : [], null, ["class" => "form-control select2", "id" => "company_ids", 'placeholder' => 'Please Select']) !!}

                    @include('admin.common.errors', ['field' => 'company_ids'])
                </div>
            </div>
        @endif

        <div class="col-md-12">
            <div class="form-group{{ $errors->has('branch_ids') ? ' has-error' : '' }}">
                @include('admin.common.label', ['field' => 'branch_ids', 'labelText' => 'Select Branch', 'isRequired' => true])

                {!! Form::select("branch_ids[]", isset($branchesData) ? $branchesData : [], $branchesIds, ["class" => "form-control select2", "id" => "branch_ids" ,"multiple" => "multiple", 'data-placeholder' => 'Please Select']) !!}
                

                @include('admin.common.errors', ['field' => 'branch_ids'])
            </div>
        </div>
    @endif

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

    @if(Auth::user()->role == 'super_admin')
        <div class="col-md-3">
            <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                @include('admin.common.label', ['field' => 'status', 'labelText' => 'Status', 'isRequired' => false])

                @include('admin.common.active-inactive-buttons', [                
                    'checkedKey' => isset($user) ? $user->status : 'active'
                ])
            </div>
        </div>
    @endif
</div>

<div class="row">
    <div class="col-md-3">
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'password', 'labelText' => 'Password', 'isRequired' => empty($user) ? true : false])

            {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Enter Password', 'id' => 'password']) !!}

            @include('admin.common.errors', ['field' => 'password'])
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'password_confirmation', 'labelText' => 'Confirm Password', 'isRequired' => empty($user) ? true : false])

            {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm password', 'id' => 'password-confirm']) !!}

            @include('admin.common.errors', ['field' => 'password_confirmation'])
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'image', 'labelText' => 'Image', 'isRequired' => false])

            @include('admin.common.file_upload', ['fieldName' => 'image', 'image' => isset($user['image']) ? $user['image'] : null])
        </div>
    </div>
</div>
@section('jquery')
<script type="text/javascript">
$(document).ready(function(){

    if($("#company_ids").val()==''){
        updateDropdowns(['branch_ids']);
    }

    //get branch
    $('#company_ids').change(function(){
        updateDropdowns(['branch_ids']);

        var accountId = $(this).val();
        if (accountId) {
            $.ajax({
                url: "{{ route('branches.by_company')}}",
                type: "POST",
                data: {
                    _token: '{{csrf_token()}}',
                    accountId : accountId,
                },
                success: function(response){                    
                    if (response && response.length > 0) {
                        response.forEach(function(branch) {
                            $('#branch_ids').append('<option value="' + branch.id + '">' + branch.full_name + '</option>');
                        });
                    }
                }
            });
        } 
    });
});
</script>
@endsection