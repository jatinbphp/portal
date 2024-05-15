{!! Form::hidden('redirects_to', URL::previous()) !!}
<div class="row">

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('linked_to_category') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'linked_to_category', 'labelText' => 'Category', 'isRequired' => true])

            {!! Form::select("linked_to_category[]", $categories, !empty($task['linked_to_category']) ? explode(",", $task['linked_to_category']) :null, ["class" => "form-control select2 w-100", "id" => "linked_to_category", "multiple" => "multiple", 'data-placeholder' => 'Please Select', "data-maximum-selection-length" => "3"]) !!}

            @include('admin.common.errors', ['field' => 'linked_to_category'])
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('name_of_task	') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'name_of_task', 'labelText' => 'Task Name', 'isRequired' => true])

            {!! Form::text('name_of_task', null, ['class' => 'form-control', 'placeholder' => 'Enter Task Name', 'id' => 'name_of_task']) !!}
            
            @include('admin.common.errors', ['field' => 'name_of_task'])
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
            @include('admin.common.label', ['field' => 'status', 'labelText' => 'Status', 'isRequired' => true])

            <div class="">
                @foreach (\App\Models\Task::$status as $key => $value)
                    @php $checked = !isset($task) && $key == 'active'?'checked':''; @endphp
                    <label>
                        {!! Form::radio('status', $key, null, ['class' => 'flat-red',$checked]) !!} <span style="margin-right: 10px">{{ $value }}</span>
                    </label>
                @endforeach
            </div>
        </div>
    </div>
</div>

