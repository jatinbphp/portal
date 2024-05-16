{!! Form::hidden('redirects_to', URL::previous()) !!}
{!! Form::hidden('user_id', $employee->id ?? null, ['id' => 'user_id']) !!}
@if(isset($user))
    @include('admin.common.password-alert')
@endif
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Task Description</th>
            <th scope="col">Date & Time</th>
            <th scope="col">Comments</th>
        </tr>
    </thead>
    <tbody>
        @if(isset($tasks) && !empty($tasks))
            @foreach($tasks as $key => $value)
                <tr>
                    <th scope="row">{{ "#" . $key }} {!! Form::hidden('task_id[]', $value->id ?? null, ['id' => 'task_id_' . $key]) !!}</th>
                    <td>{{ $value->name ?? "-" }}</td>
                    <td>
                        {!! Form::input('datetime-local', 'datetime[]', date("Y-m-d H:i:s"), ['class' => 'form-control', 'placeholder' => 'Enter Date and Time', 'id' => 'datetime']) !!}
                        @if ($errors->has('datetime.' . $key))
                            <span class="text-danger">
                                <strong>{{ $errors->first('datetime.' . $key) }}</strong>
                            </span>
                        @endif
                    </td>
                    <td>
                        {!! Form::textarea('comment[]', null, ['class' => 'form-control', 'placeholder' => 'Enter Comment', 'id' => 'comment_' . $key, 'rows' => "2"]) !!}
                        @if ($errors->has('comment.' . $key))
                            <span class="text-danger">
                                <strong>{{ $errors->first('comment.' . $key) }}</strong>
                            </span>
                        @endif
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
@section('jquery')
<script type="text/javascript">
    $("input[type=datetime]").datepicker({
        dateFormat: 'Y-m-d H:i:s',
          onSelect: function(dateText, inst) {
            $(inst).val(dateText); 
          }
    });
</script>
@endsection
