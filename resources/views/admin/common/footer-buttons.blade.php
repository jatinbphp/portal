<a href="{{ route($route) }}" class="btn btn-sm btn-default"><i class="fa fa-arrow-left pr-1"></i> Back</a>

@if($type=="update")
<button class="btn btn-sm btn-info float-right" type="submit"><i class="fa fa-edit pr-1"></i> Update</button>
@else
<button class="btn btn-sm btn-info float-right" type="submit"><i class="fa fa-save pr-1"></i> Save</button>
@endif