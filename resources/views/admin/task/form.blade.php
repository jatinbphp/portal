{!! Form::hidden('redirects_to', URL::previous()) !!}
<div class="row">

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('category_ids') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'category_ids', 'labelText' => 'Category', 'isRequired' => true])

            {!! Form::select("category_ids[]", $categories, !empty($task['category_ids']) ? explode(",", $task['category_ids']) :null, ["class" => "form-control select2 w-100", "id" => "category_ids", "multiple" => "multiple", 'data-placeholder' => 'Please Select']) !!}

            @include('admin.common.errors', ['field' => 'category_ids'])
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('name	') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'name', 'labelText' => 'Task Name', 'isRequired' => true])

            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter Task Name', 'id' => 'name']) !!}
            
            @include('admin.common.errors', ['field' => 'name'])
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'status', 'labelText' => 'Status', 'isRequired' => true])

            @include('admin.common.active-inactive-buttons', [                
                'checkedKey' => isset($task) ? $task->status : 'active'
            ])

        </div>
    </div>
</div>

