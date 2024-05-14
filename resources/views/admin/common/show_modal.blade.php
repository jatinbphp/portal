<!-- Modal content -->
<div class="modal-header">
    <h5 class="modal-title" id="commonModalLabel">{{ ucwords(str_replace('_', ' ', $type)) }} Details</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-bordered">
                                <tbody>
                                    @foreach ($required_columns as $key)
                                        @if (array_key_exists($key, $section_info))
                                            <tr>
                                                <th style="width: 35%;">
                                                    @switch($key)
                                                        @case('created_at')
                                                            Date Created:
                                                            @break
                                                        @case('email')
                                                            Email Address:
                                                            @break
                                                        @case('phone')
                                                            Contact Number:
                                                            @break
                                                        @case('additional_phone')
                                                            Contact Number 2:
                                                            @break
                                                        @case('cp_name')
                                                            Contact Person Name:
                                                            @break
                                                        @case('cp_email')
                                                            Contact Person Email Address:
                                                            @break
                                                        @case('cp_phone')
                                                            Contact Person Phone:
                                                            @break
                                                        @case('company')
                                                        @case('service_provider')
                                                            {{ ucfirst(str_replace('_', ' ', $key)) }} Details:
                                                            @break
                                                        @case('branch')
                                                        @case('userBranches')
                                                            Branch Details:
                                                            @break
                                                        @case('truck')
                                                            Fleet Details:
                                                            @break
                                                        @case('driverTruckInfo')
                                                            Driver Fleet Info:
                                                            @break
                                                        @case('userCompanies')
                                                            Company Details:
                                                            @break
                                                        @case('trailer_datas')
                                                        @case('trailer')
                                                            Trailer Details:
                                                            @break
                                                        @case('breakdown_description')
                                                            Breakdown Description:
                                                            @break
                                                        @case('special_instruction')
                                                            Special Instruction:
                                                            @break
                                                        @case('account')
                                                            Company Details:
                                                            @break
                                                        @case('user')
                                                            Company User Details:
                                                            @break
                                                        @case('driver')
                                                            Driver Details:
                                                            @break
                                                        @case('reference_number')
                                                            Reference Number
                                                            @break
                                                        @case('wheelPostions')
                                                            Wheel Position
                                                            @break
                                                        @default
                                                            {{ ucwords(str_replace('_', ' ', $key)) }}:
                                                    @endswitch
                                                </th>
                                                <td>
                                                    @switch($key)
                                                        @case('image')
                                                            {!! renderImageColumn($section_info[$key]) !!}
                                                            @break
                                                        @case('created_at')
                                                            {!! formatDate($section_info[$key]) !!}
                                                            @break
                                                        @case('id')
                                                            {!! renderIdColumn($section_info[$key]) !!}
                                                            @break
                                                        @case('status')
                                                            {!! renderStatusColumn($section_info[$key]) !!}
                                                            @break
                                                        @case('role')
                                                            {{ ucwords(str_replace('_', ' ', $section_info[$key])) }}
                                                            @break
                                                        @case('original_price')
                                                            {{ env('CURRENCY') }}{{ number_format($section_info[$key], 2) }}
                                                            @break
                                                        @case('access_rights')
                                                            @if(!empty($section_info[$key]))
                                                                @foreach(json_decode($section_info[$key]) as $accessRight)
                                                                    <span class="badge badge-success">{{ ucfirst(str_replace("_", " ", $accessRight)) }}</span>
                                                                @endforeach
                                                            @endif
                                                            @break
                                                        @case('company')
                                                        @case('account')
                                                        @case('branch')
                                                        @case('user')
                                                        @case('service_provider')
                                                            @if(is_array($section_info[$key]))
                                                                <b>Name :</b> {{ $section_info[$key]['name'] }} <br>
                                                                <b>Email Address :</b> {{ $section_info[$key]['email'] }}
                                                            @else
                                                                <b>Name :</b> {{ $section_info[$key]->name }} <br>
                                                                <b>Email Address :</b> {{ $section_info[$key]->email }}
                                                            @endif
                                                            @break
                                                        @case('truck')
                                                            @if(is_array($section_info[$key]))
                                                                <b>Fleet Number :</b> {{ $section_info[$key]['fleet_number'] }} <br>
                                                                <b>Registration Number :</b> {{ $section_info[$key]['registration_number'] }} <br>
                                                            @else
                                                                <b>Fleet Number :</b> {{ $section_info[$key]->fleet_number }} <br>
                                                                <b>Registration Number :</b> {{ $section_info[$key]->registration_number }} <br>
                                                            @endif
                                                            @break
                                                        @case('driverTruckInfo')
                                                        @case('userCompanies')
                                                        @case('reference_number')
                                                        @case('wheelPostions')
                                                        @case('userBranches')
                                                            {{ $section_info[$key] }}
                                                            @break
                                                        @case('trailer')
                                                            @if(is_array($section_info[$key]))
                                                                <b>Trailer Number :</b> {{ $section_info[$key]['trailer_number'] }} <br>
                                                                <b>Registration Number :</b> {{ $section_info[$key]['registration_number'] }}
                                                            @else
                                                                <b>Trailer Number :</b> {{ $section_info[$key]->trailer_number }} <br>
                                                                <b>Registration Number :</b> {{ $section_info[$key]->registration_number }}
                                                            @endif
                                                            @break
                                                        @case('trailer_datas')
                                                            @if(!empty($section_info[$key]))
                                                                @foreach($section_info[$key] as $trailerInfo)
                                                                    <b>Trailer Number :</b> {{ $trailerInfo['trailer_number'] }} <br>
                                                                    <b>Registration Number :</b> {{ $trailerInfo['registration_number'] }} <br>
                                                                @endforeach
                                                            @endif
                                                            @break
                                                        @case('driver')
                                                            @if(is_array($section_info[$key]))
                                                                <b>Name :</b> {{ $section_info[$key]['driver_name'] }} <br>
                                                                <b>Contact Number :</b> {{ $section_info[$key]['phone'] }} <br>
                                                                <b>Tag Number :</b> {{ $section_info[$key]['tag_number'] }}
                                                            @else
                                                                <b>Name :</b> {{ $section_info[$key]->driver_name }} <br>
                                                                <b>Contact Number :</b> {{ $section_info[$key]->phone }} <br>
                                                                <b>Tag Number :</b> {{ $section_info[$key]->tag_number }}
                                                            @endif
                                                            @break
                                                        @default
                                                            {!! !empty($section_info[$key]) ? $section_info[$key] : '-' !!}
                                                    @endswitch
                                                </td>
                                            </tr>
                                        @endif
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="fa fa-times pr-1"></i></i> Close</button>
</div>

@php
function renderImageColumn($info) {

    if (!empty($info) && file_exists($info)) {
        return '<img src="' . url($info) . '" height="50">';
    } else {
        return '<img src="' . url('assets/admin/dist/img/no-image.png') . '" height="50">';
    }
}

function formatDate($info) {
    return date('Y-m-d H:i:s', strtotime($info));
}

function renderIdColumn($info) {
    return '#' . $info;
}

function renderStatusColumn($info) {
    $class = $info == 'active' ? 'success' : 'danger';
    return '<span class="badge badge-' . $class . '">' . ucfirst($info) . '</span>';
}
@endphp
