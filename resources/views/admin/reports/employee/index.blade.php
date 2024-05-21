@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper">

    @include('admin.common.header', [
        'menu' => $menu,
        'breadcrumb' => [
            ['route' => route('admin.dashboard'), 'title' => 'Dashboard']
        ],
        'active' => $menu
    ])

    <!-- Main content -->
    <section class="content">
        @include ('admin.common.error')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {!! Form::open(['url' => null, 'id' => 'employee-report-Form', 'class' => 'form-horizontal', 'files' => true]) !!}
                            @include('admin.reports.filters', ['type' => 'employee'])
                        {!! Form::close() !!}
                    </div>
                </div>
                <div class="card card-info card-outline">
                    <div class="card-header">
                        @include('admin.common.card-header', ['title' => 'Manage ' . $menu])
                    </div>
                    <div class="card-body table-responsive">
                        <input type="hidden" id="route_name" value="{{ route('reports.employees') }}">
                        <table id="employeesReportTable" class="table table-bordered datatable-dynamic">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>
                                        <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col" width="30%">Task Description</th>
                                                    <th scope="col" width="30%">Date of Entry</th>
                                                    <th scope="col" width="40%">Comments</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
@section('jquery')
<script type="text/javascript">
    
    var table = $('#employeesReportTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        bLengthChange: false, //hide number of record per page
        bFilter: false, // hide search bar
        lengthMenu: [100, 200, 300, 400, 500],
        ajax: {
                url: $("#route_name").val(),
                data: function (d) {
                    var formDataArray = $('#employee-report-Form').serializeArray();

                    var formData = {};
                    $.each(formDataArray, function(i, field){
                        formData[field.name] = field.value;
                    });
                    d = $.extend(d, formData);

                    return d;
                },
            },
        columns: [
            {
                data: 'id', width: '5%', name: 'id',
                render: function (data, type, row) {
                    return '#' + data; // Prepend '#' to the 'id' data
                }
            },
            {data: 'employee_category', name: 'employee_category', "width": "25%"},
            {data: 'action', "width": "70%", orderable: false},
        ],
    });

    function handleFilter(event){
       $('#employeesReportTable').DataTable().ajax.reload(null, false);
    }

    function handleClear(event){
        $(event.target).closest('form').find("input[type=text]").val("");
        $("#employee").val('').trigger('change')
        $('#employeesReportTable').DataTable().ajax.reload(null, false);
    }

</script>
@endsection

