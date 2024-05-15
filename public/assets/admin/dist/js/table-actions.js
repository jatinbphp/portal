$(function () {
    //Employees Table
    var employees_table = $('#employeesTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        lengthMenu: [ 100, 200, 300, 400, 500 ],
        ajax: $("#route_name").val(),
        columns: [
            {
                data: 'id', width: '10%', name: 'id',
                render: function(data, type, row) {
                    return '#' + data; // Prepend '#' to the 'id' data
                }
            },
            {data: 'name', name: 'name'},
            {data: 'email',  name: 'email'},
            {data: 'status', "width": "10%",  name: 'status', orderable: false},  
            {data: 'created_at', "width": "14%", name: 'created_at'},  
            {data: 'action', "width": "12%", orderable: false},                
        ],
        "order": [[0, "DESC"]]
    });

    //Category Table
    var categories_table = $('#categoryTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        lengthMenu: [ 100, 200, 300, 400, 500 ],
        ajax: $("#route_name").val(),
        columns: [
            {
                data: 'id', width: '10%', name: 'id',
                render: function(data, type, row) {
                    return '#' + data; // Prepend '#' to the 'id' data
                }
            },
            {data: 'name', name: 'name'},
            {data: 'status', "width": "10%",  name: 'status', orderable: false},
            {data: 'created_at', "width": "15%", name: 'created_at'},
            {data: 'action', "width": "12%",  name: 'action', orderable: false},
        ],
        "order": [[1, "ASC"]]
    });

    //Task Table
    var tasks_table = $('#taskTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        lengthMenu: [ 100, 200, 300, 400, 500 ],
        ajax: $("#route_name").val(),
        columns: [
            {
                data: 'id', width: '10%', name: 'id',
                render: function(data, type, row) {
                    return '#' + data; // Prepend '#' to the 'id' data
                }
            },
            {data: 'name_of_task', name: 'name_of_task'},
            {data: 'linked_to_category', name: 'linked_to_category',orderable: false},
            {data: 'status', "width": "10%",  name: 'status', orderable: false},
            {data: 'created_at', "width": "15%", name: 'created_at'},
            {data: 'action', "width": "12%",  name: 'action', orderable: false},
        ],
        "order": [[1, "ASC"]]
    });

    var sectionTableMap = {
        'categories_table': categories_table,
        'employees_table': employees_table,
        'tasks_table': tasks_table,
    };

    //Delete Record
    $('.datatable-dynamic tbody').on('click', '.deleteRecord', function (event) {
        event.preventDefault();
        var id = $(this).attr("data-id");
        var url = $(this).attr("data-url");
        var section = $(this).attr("data-section");

        swal({
            title: "Are you sure?",
            text: "You want to delete this record?",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: "No, cancel",
            closeOnConfirm: false,
            closeOnCancel: false
        },
        function(isConfirm) {
            if (isConfirm) {
                $.ajax({
                    url: url,
                    type: "DELETE",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                    success: function(data){

                        var table = sectionTableMap[section];
                        if (table) {
                            table.row('.selected').remove().draw(false);
                        }
                 
                        swal("Deleted", "Your data successfully deleted!", "success");
                    }
                });
            } else {
                swal("Cancelled", "Your data safe!", "error");
            }
        });
    });


    //Change Status
    $('.datatable-dynamic tbody').on('click', '.assign_unassign', function (event) {
        event.preventDefault();

        var clickedElement = $(this);
        var clickedElement = $(this);
        var type = clickedElement.attr("data-type");
        var url = clickedElement.attr('data-url');
        var id = clickedElement.attr("data-id");
        var table_name = clickedElement.attr("data-table_name");
        var section = clickedElement.attr("data-table_name");
        var l = Ladda.create(clickedElement[0]);

        if (type === 'unassign') {
            swal({
                title: "Are you sure?",
                text: "Certain functionalities will be affected by changing the status. Would you like to proceed?",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#DD6B55',
                confirmButtonText: 'Yes, Proceed',
                cancelButtonText: "No, cancel",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    l.start();
                    sendAjaxRequest();
                } else {
                    swal("Cancelled", "Your data safe!", "error");
                }
            });
        } else {
            sendAjaxRequest();
        }

        function sendAjaxRequest() {
            $.ajax({
                url: url,
                type: "post",
                data: {
                    'id': id,
                    'type': type,
                    'table_name': table_name,
                },
                headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                success: function(data){
                    l.stop();
                    if (type === 'unassign') {
                        $('#assign_remove_'+id).hide();
                        $('#assign_add_'+id).show();
                    } else {
                        $('#assign_remove_'+id).show();
                        $('#assign_add_'+id).hide();
                    }
                    var table = sectionTableMap[section];
                    if (table) {
                        table.row('.selected').remove().draw(false);
                    }

                    swal("Updated", "Your data successfully updated!", "success");
                }
            });
        }
    });

    //get Order Indo
    $('.datatable-dynamic tbody').on('click', '.view-info', function (event) {
        event.preventDefault();
        var url = $(this).attr('data-url');
        var id = $(this).attr("data-id");

        $.ajax({
            url: url,
            type: "GET",
            data: {
                'id': id,
            },
            headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
            success: function(data){
                $('#commonModal .modal-content').html(data);
                $('#commonModal').modal('show');
            }
        });
    });
});