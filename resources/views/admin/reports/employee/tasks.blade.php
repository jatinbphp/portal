@if(isset($daily_performances) && !$daily_performances->isEmpty())
    <table class="table table table-hover table-bordered table-striped">
        <tbody>
            @foreach($daily_performances as $daily_performance)
                @if(isset($daily_performance->tasks) && !empty($daily_performance->tasks))
                    @foreach($daily_performance->tasks as $key => $value)
                        <tr>
                            <td width="30%">{{ $value->name ?? "-" }}</td>
                            <td width="30%">{{ isset($daily_performance->datetime) ? date('Y-m-d H:i', strtotime($daily_performance->datetime)) : "-" }}</td>
                            <td width="40%">{{ $daily_performance->comment }}</td>
                        </tr> 
                    @endforeach
                @endif
            @endforeach
        </tbody>
    </table>
@endif