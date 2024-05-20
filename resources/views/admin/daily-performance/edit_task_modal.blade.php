<!-- Modal content -->
<div class="modal-header">
    <h5 class="modal-title" id="commonModalLabel">Edit {{$title}}</h5>
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
                        {!! Form::open([ 'id' => 'TaskUpdateForm', 'class' => 'form-horizontal','files'=>true]) !!}
                            
                            {!! Form::hidden('id', $daily_performance->id ?? null, ['id' => 'id']) !!}                         
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group{{ $errors->has('comment') ? ' has-error' : '' }}">
                                        @include('admin.common.label', ['field' => 'comment', 'labelText' => 'Comment', 'isRequired' => true])

                                        {!! Form::text('comment', !empty($daily_performance->comment)?$daily_performance->comment:null, ['class' => 'form-control', 'placeholder' => 'Enter Task comment', 'id' => 'comment']) !!}
                                        
                                        @include('admin.common.errors', ['field' => 'comment'])
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group{{ $errors->has('date') ? ' has-error' : '' }}">
                                        @include('admin.common.label', ['field' => 'date', 'labelText' => 'Date Created', 'isRequired' => true])

                                        {!! Form::input('datetime-local', 'datetime', $daily_performance->datetime ? date('Y-m-d\TH:i:s', strtotime($daily_performance->datetime)) : date('Y-m-d\TH:i'), ['class' => 'form-control', 'placeholder' => 'Enter Date and Time', 'id' => 'datetime']) !!}
                                        
                                        @include('admin.common.errors', ['field' => 'date'])
                                    </div>
                                </div>
                            </div>
                        {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal"><i class="fa fa-times pr-1"></i> Close</button>
    <button type="button" class="btn btn-sm btn-primary" id="updateButtondata" data-url="{{ url('admin/'.$section_name.'/'.$daily_performance->id) }}"><i class="fa fa-check pr-1"></i> Update</button>
</div> 

<script>
    $('#updateButtondata').on('click', function(event) {
        event.preventDefault();
        var form = $('#TaskUpdateForm')[0];
        var formData = new FormData(form);
        var url = $(this).attr("data-url");      
        
        $.ajax({
            url: url, 
            type: 'POST',
            data: formData, 
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
            },
            success: function(response) {
                console.log(response); 
                if (response.status === 'success') {
                    $('#commonModal').modal('hide'); 
                    refreshDataTable();
                    swal("Updated", "Daily peformance task data updated successfully!", "success");
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(response) {
                console.error(response); 
                var errors = response.responseJSON.errors;
                $.each(errors, function(key, value) {
                    alert(value); 
                });
            }
        });
    });

    function refreshDataTable() {
        $('#tasklistTable').DataTable().ajax.reload();
    }
</script>

