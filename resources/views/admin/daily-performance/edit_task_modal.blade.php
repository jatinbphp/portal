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
                                        @include('admin.common.label', ['field' => 'date', 'labelText' => 'Date', 'isRequired' => true])

                                        {!! Form::text('date', !empty($daily_performance->datetime)?$daily_performance->datetime:null, ['class' => 'form-control', 'placeholder' => 'Select Date', 'id' => 'date']) !!}
                                        
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
    <button type="button" class="btn btn-sm btn-primary" id="updateButtondata"><i class="fa fa-check pr-1"></i> Update</button>
</div> 

<script>
   $(document).ready(function() {
    $('#updateButtondata').on('click', function() {
        
        var form = $('#TaskUpdateForm')[0];
        var formData = new FormData(form);

        $.ajax({
            url: '{{ route("daily-performance.update", $daily_performance->id ?? 0) }}', 
            type: 'Post',
            data: formData, 
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') 
            },
            success: function(response) {
                console.log(response); 
                if (response.status === 'success') {
                    location.reload(); 
                } else {
                    alert('Error: ' + response.message);
                }
            },
            error: function(response) {
                console.error(response);le
                var errors = response.responseJSON.errors;
                $.each(errors, function(key, value) {
                    alert(value); 
                });
            }
        });
    });
});

</script>

