<div class="row">
    @if(isset($category))
    <div class="col-md-3">
        <div class="form-group">
            @include('admin.common.label', ['field' => 'category', 'labelText' => 'Category', 'isRequired' => false])
            {!! Form::select("category", ['' => 'Please Select'] + ($category->toArray() ?? []), null, ["class" => "form-control select2", "id" => "category"]) !!}
        </div>
    </div>
    @endif

    @if(isset($employees))
    <div class="col-md-3">
        <div class="form-group">
            @include('admin.common.label', ['field' => 'employee', 'labelText' => 'Employee', 'isRequired' => false])
            {!! Form::select("user_id", ['' => 'Please Select'] + ($employees->toArray() ?? []), null, ["class" => "form-control select2", "id" => "employee"]) !!}
        </div>
    </div>
    @endif

    <div class="col-md-4">
        <div class="form-group">
            @include('admin.common.label', ['field' => 'daterange', 'labelText' => 'Date Range', 'isRequired' => false])
            {!! Form::text('daterange', null, ['class' => 'form-control', 'placeholder' => 'Please select']) !!}
        </div>
    </div>
    
    <div class="col-md-2" style="margin-top: 24px;">
        {!! Form::button('<i class="fa fa-times" aria-hidden="true"></i>', [
            'type' => 'button',
            'id' => 'clear-filter',
            'class' => 'btn btn-danger',
            'data-type' => $type ?? "",
            'onclick' => 'handleClear(event)'  
        ]) !!}
        
        {!! Form::button('<i class="fa fa-filter" aria-hidden="true"></i>', [
            'type' => 'button',
            'id' => 'apply-filter',
            'class' => 'btn btn-info',
            'data-type' => $type ?? "",
            'onclick' => 'handleFilter(event)'  
        ]) !!}
    </div>
</div>
